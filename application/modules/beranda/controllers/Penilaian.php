<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpWord\TemplateProcessor;

class Penilaian extends MX_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->library(['javascript', 'Skoring_akreditasi']);
    $this->load->model(['Periode_model', 'Penilaian_model']);
    date_default_timezone_set("Asia/Jakarta");

    if (!$this->session->userdata('username')) {
      $this->session->set_flashdata('error', 'Anda belum login.');
      redirect(base_url('login'));
    }

    $this->only_for_roles(['4']);
  }

  public function index()
  {
    $fasilitator_id = $this->session->userdata('user_id');
    $data = [
      'penilaian' => 'active',
      'data_periode' => $this->Periode_model->get_data_periode_by_fasilitator($fasilitator_id),
    ];

    // echo json_encode($data['data_periode']);exit;

    $this->load->view("admin/master/penilaian/v_index", $data);
  }

  public function inputSkor($enc_periode)
  {
    $periode        = safe_url_decrypt($enc_periode);
    $periode_dipilih = $this->Periode_model->get_periode_by_kode($periode);
    $fasilitator_id = $this->session->userdata('user_id');

    $data = [
      'penilaian' => 'active',
      'periode_dipilih' => $periode_dipilih,
      'data_pt_binaan' => $this->Penilaian_model->get_data_penilaian_by_fasilitator($fasilitator_id, $periode),
    ];

    if ($data['data_pt_binaan'] == null) {
      $this->session->set_flashdata('info', 'Tidak ada data pada periode ' . $periode . '.');
      redirect('admin/penilaian-tipologi');
    }

    $bk = $this->db->query("SELECT * FROM `buka_tutup` WHERE `id` = '1'")->row();
    $data['dabk'] = $bk;
    $current_date = date('Y-m-d');
    $current_time = date('H:i:s');
    $data['bt'] = $bk;

    // Cek tanggal dan waktu sekaligus
    if (
      ($current_date < $bk->mulai_tgl || $current_date > $bk->akhir_tgl) ||
      (
        isset($bk->mulai_jam) && isset($bk->akhir_jam) &&
        (
          ($current_date == $bk->mulai_tgl && $current_time < $bk->mulai_jam) ||
          ($current_date == $bk->akhir_tgl && $current_time > $bk->akhir_jam)
        )
      )
    ) {
      $data['buka_tutup'] = "tutup"; // Tidak dalam periode buka tutup
    }

    // echo json_encode($data['data_pt_binaan']);exit;

    $this->load->view("admin/master/penilaian/v_penilaian", $data);
  }

  public function getPenilaian()
  {
    if ($this->input->is_ajax_request()) {
      $id_penilaian_tipologi = $this->input->post('id_penilaian_tipologi');
      $hasil = $this->Penilaian_model->getPenilaian($id_penilaian_tipologi);
      $kode_pt = $hasil->kode_pt;
      $persentase_prodi = $this->Penilaian_model->statistikProdi($kode_pt);
      $skoring_prodi = $this->skoring_akreditasi->hitung([
        'jumlah_prodi_aktif' => $persentase_prodi['total_prodi_aktif'],
        'prodi_terakreditasi' => $persentase_prodi['prodi_terakreditasi'],
        'persentase_unggul_atau_a' => $persentase_prodi['persentase_unggul_atau_a'],
        'jenis_pt' => 'PTS'
      ]);
      $form_led = $this->db->query("SELECT * FROM form_led WHERE id_penilaian_tipologi = '$id_penilaian_tipologi'")->row();
      $enc_id_penilaian_tipologi = safe_url_encrypt($form_led->id_penilaian_tipologi);
      $enc_id_form_led = safe_url_encrypt($form_led->id);

      if (!empty($hasil)) {
        echo json_encode([
          'success' => true,
          'data' => $hasil,
          'persentase_prodi' => $persentase_prodi,
          'skoring_prodi' => $skoring_prodi,
          'csrfHash' => $this->security->get_csrf_hash(), // ← penting
          'form_led' => $form_led,
          'enc_id_penilaian_tipologi' => $enc_id_penilaian_tipologi,
          'enc_id_form_led' => $enc_id_form_led
        ]);
      } else {
        echo json_encode([
          'success' => false,
          'message' => 'Data tidak ditemukan.',
          'csrfHash' => $this->security->get_csrf_hash() // ← pastikan tetap dikirim
        ]);
      }
    } else {
      // Jika bukan AJAX, tampilkan halaman error
      show_error('Permintaan tidak valid', 400);
    }
  }

  public function simpanSkor()
  {
    // Misal data dikirim lewat POST atau JSON
    $post = $this->input->post(); // atau json_decode($this->input->raw_input_stream, true)
    // $kode_pt = $post['kode_pt'];
    $fasilitator_id = $this->session->userdata('user_id'); // Contoh ambil dari session
    // $periode = $this->Periode_model->get_active_periode(); // Contoh, bisa juga dari input
    $id_penilaian_tipologi = $post['id_penilaian_tipologi'];
    $kode_pt = $post['kode_pt'];
    $persentase_prodi = $this->Penilaian_model->statistikProdi($kode_pt);
    $skoring_prodi = $this->skoring_akreditasi->hitung([
      'jumlah_prodi_aktif' => $persentase_prodi['total_prodi_aktif'],
      'prodi_terakreditasi' => $persentase_prodi['prodi_terakreditasi'],
      'persentase_unggul_atau_a' => $persentase_prodi['persentase_unggul_atau_a'],
      'jenis_pt' => 'PTS'
    ]);

    $skor_total = $post['skor_1'] + $post['skor_2'] + $post['skor_3'] + $skoring_prodi['skor'];
    $tipologi = $this->get_tipologi($skor_total);

    // Mulai transaksi database
    $this->db->trans_start();

    // Data yang akan diupdate
    $data = [
      'id_status_penilaian' => 1,
      'skor_1' => $post['skor_1'],
      'catatan_1' => $post['catatan_1'],
      'skor_2' => $post['skor_2'],
      'catatan_2' => $post['catatan_2'],
      'skor_3' => $post['skor_3'],
      'catatan_3' => $post['catatan_3'],
      'skor_4' => $skoring_prodi['skor'],
      'catatan_4' => $post['catatan_4'],
      'catatan_keseluruhan' => $post['catatan_keseluruhan'],
      // 'link_detail_penilaian' => $post['link_detail_penilaian'],
      'skor_total' => $skor_total,
      'tipologi' => $tipologi,
      'updated_at' => date('Y-m-d H:i:s') // optional timestamp
    ];

    // echo gettype($id_penilaian_tipologi);exit;
    // $update = $this->Penilaian_model->update_penilaian($kode_pt, $fasilitator_id, $periode->kode, $data);
    // $$this->Penilaian_model->update_penilaian($id_penilaian_tipologi, $data);
    $this->db->where('id_penilaian_tipologi', $id_penilaian_tipologi);
    $this->db->update('penilaian_tipologi', $data);

    $this->db->insert('rwy_penilaian_fasilitator', [
      'id_penilaian_tipologi' => $id_penilaian_tipologi,
      'id_status_penilaian' => 1,
      'fasilitator_id' => $fasilitator_id,
      'skor_1' => $post['skor_1'],
      'skor_2' => $post['skor_2'],
      'skor_3' => $post['skor_3'],
      'skor_4' => $skoring_prodi['skor'],
      'skor_total' => $skor_total,
      'catatan_1' => $post['catatan_1'],
      'catatan_2' => $post['catatan_2'],
      'catatan_3' => $post['catatan_3'],
      'catatan_4' => $post['catatan_4'],
      'catatan_keseluruhan' => $post['catatan_keseluruhan'],
    ]);

    $this->db->trans_complete();

    if ($this->db->trans_status() === TRUE) {
      $this->session->set_flashdata('success', 'Data berhasil diperbarui');
      // redirect('admin/penilaian-tipologi');
      if (!empty($_SERVER['HTTP_REFERER'])) {
        redirect($_SERVER['HTTP_REFERER']);
      } else {
        redirect('default_controller'); // fallback jika tidak ada referer
      }
    } else {
      $this->session->set_flashdata('error', 'Gagal memperbarui data');
    }
  }

  function get_tipologi($nilai_terbobot)
  {
    if ($nilai_terbobot == 8.0) {
      return "Tipologi 1";
    } elseif ($nilai_terbobot >= 6.0 && $nilai_terbobot <= 7.5) {
      return "Tipologi 2";
    } elseif ($nilai_terbobot >= 4.0 && $nilai_terbobot <= 5.5) {
      return "Tipologi 3";
    } elseif ($nilai_terbobot < 4.0) {
      return "Tipologi 4";
    } else {
      return null; // nilai tidak valid atau di luar jangkauan
    }
  }

  public function riwayatPenilaian($enc_id_penilaian_topologi)
  {
    $id_penilaian_topologi  = safe_url_decrypt($enc_id_penilaian_topologi);
    $user_id                = $this->session->userdata('user_id');
    $data['penilaian'] = 'active';

    $val = $this->db->query("SELECT
                                a.*,
                                b.`periode`,
                                b.`nama_pt`,
                                b.`kode_pt`,
                                c.`nama`,
                                d.`nm_status`
                              FROM
                                `rwy_penilaian_fasilitator` a
                                JOIN `penilaian_tipologi` b
                                  ON a.`id_penilaian_tipologi` = b.`id_penilaian_tipologi`
                                JOIN `users` c
                                  ON b.`fasilitator_id` = c.`id`
                                JOIN `status_penilaian` d
                                  ON a.`id_status_penilaian` = d.`id_status`
                              WHERE a.`id_penilaian_tipologi` = '$id_penilaian_topologi'
                                AND b.`fasilitator_id` = '$user_id'
                                ORDER BY a.`created_at` DESC");

    $data['da']   = $val->row();
    $data['val']  = $val->result();

    // echo json_encode($data);exit;

    $this->load->view("admin/master/penilaian/v_riwayat_penilaian", $data);
  }

  public function kirimNilai($enc_periode, $enc_id = 'semua')
  {
    $periode = safe_url_decrypt($enc_periode);
    $id_penilaian = safe_url_decrypt($enc_id);
    $fasilitator_id = $this->session->userdata('user_id');

    $kirim_nilai = $this->Penilaian_model->kirimNilai($periode, $id_penilaian, $fasilitator_id);

    if ($kirim_nilai) {
      $this->session->set_flashdata('success', 'Data berhasil dikirim ke validator');
    } else {
      $this->session->set_flashdata('error', 'Gagal mengirim nilai');
    }

    if (!empty($_SERVER['HTTP_REFERER'])) {
      redirect($_SERVER['HTTP_REFERER']);
    } else {
      redirect('admin/penilaian-tipologi');
    }
  }

  public function persentaseProdi()
  {
    $kode_pt = "031065";
    $data = $this->Penilaian_model->statistikProdi($kode_pt);
    // echo json_encode($data);

    $hasil = $this->skoring_akreditasi->hitung([
      'jumlah_prodi_aktif' => $data['total_prodi_aktif'],
      'prodi_terakreditasi' => $data['prodi_terakreditasi'],
      // 'prodi_terakreditasi' => $data['total_prodi_aktif'], // untuk testing semua prodi terakreditasi
      'persentase_unggul_atau_a' => $data['persentase_unggul_atau_a'],
      'jenis_pt' => 'PTS'
    ]);

    echo '<pre>';
    print_r($hasil);
  }

  public function lihatFileMindmap($enc_id_form_led)
  {
    $id_form_led = safe_url_decrypt($enc_id_form_led);
    $form_led = $this->db->get_where('form_led', ['id' => $id_form_led])->row_array();
    if (!$form_led || empty($form_led['nama_file'])) {
      $this->session->set_flashdata('error', 'File mindmap tidak ditemukan.');
      redirect(base_url('admin/pt/pengisian-led'));
      return;
    }

    $file_url = base_url('uploads/mindmap_pt/' . $form_led['nama_file']);
    header('Content-Type: ' . mime_content_type(FCPATH . 'uploads/mindmap_pt/' . $form_led['nama_file']));
    header('Content-Disposition: inline; filename="' . $form_led['nama_file'] . '"');
    readfile(FCPATH . 'uploads/mindmap_pt/' . $form_led['nama_file']);
    exit;
  }

  public function unduhLaporanLedWord($enc_id_penilaian_tipologi)
  {
    $id_penilaian_tipologi = safe_url_decrypt($enc_id_penilaian_tipologi);

    $data_db = $this->db->select('fl.*, pt.periode, pt.nama_pt, lp.nama_logo')
      ->from('form_led as fl')
      ->join('penilaian_tipologi as pt', 'fl.id_penilaian_tipologi = pt.id_penilaian_tipologi')
      ->join('logo_pt as lp', 'lp.kode_pt = pt.kode_pt', 'left')
      ->where('fl.id_penilaian_tipologi', $id_penilaian_tipologi)
      ->get()
      ->row();

    if (!$data_db) {
      $this->session->set_flashdata('error', 'Data tidak ditemukan.');
      redirect($_SERVER['HTTP_REFERER'] ?? base_url());
      exit;
    }

    $kode_pt = $data_db->kode_pt;
    $persentase_prodi = $this->Penilaian_model->statistikProdi($kode_pt);

    $template_path = FCPATH . 'uploads/template_laporan_led.docx'; // path template
    $templateProcessor = new TemplateProcessor($template_path);

    // Jika $persentase_prodi adalah array, convert dulu ke string
    $persentase_prodi_text = '';

    if (is_array($persentase_prodi)) {
      foreach ($persentase_prodi as $prodi => $nilai) {
        $persentase_prodi_text .= $prodi . ': ' . $nilai . "%\n";
      }
    }

    // Ganti placeholder dengan data nyata
    $templateProcessor->setValue('nama_pt_cover', strtoupper($data_db->nama_pt));
    $templateProcessor->setValue('nama_pt', $data_db->nama_pt);
    $templateProcessor->setValue('tahun', substr($data_db->periode, 0, 4));
    $templateProcessor->setValue('periode', substr($data_db->periode, 4, 1));
    $templateProcessor->setValue('alamat', $data_db->alamat);
    $templateProcessor->setValue('semester', substr($data_db->periode, 4, 1));
    $templateProcessor->setValue('tgl_sk_pendirian_pt', $data_db->tgl_sk_pendirian_pt == '0000-00-00' ? $data_db->tgl_sk_pendirian_pt : format_tanggal_indonesia($data_db->tgl_sk_pendirian_pt));
    $templateProcessor->setValue('akreditasi_pt', $data_db->akreditasi_pt);
    $templateProcessor->setValue('tgl_akhir_apt', $data_db->tgl_akhir_apt == '0000-00-00' ? $data_db->tgl_akhir_apt : format_tanggal_indonesia($data_db->tgl_akhir_apt));
    $templateProcessor->setValue('dasar_penyusunan', $data_db->dasar_penyusunan);
    $templateProcessor->setValue('mekanisme_kerja_penyusunan_laporan', $data_db->mekanisme_kerja_penyusunan_laporan);
    $templateProcessor->setValue('penetapan_diferensiasi', $data_db->penetapan_diferensiasi);
    $templateProcessor->setValue('sasaran_mutu_masukan', $data_db->sasaran_mutu_masukan);
    $templateProcessor->setValue('tautan_sasaran_mutu_masukan', $data_db->tautan_sasaran_mutu_masukan);
    $templateProcessor->setValue('sasaran_mutu_proses', $data_db->sasaran_mutu_proses);
    $templateProcessor->setValue('tautan_sasaran_mutu_proses', $data_db->tautan_sasaran_mutu_proses);
    $templateProcessor->setValue('sasaran_mutu_luaran', $data_db->sasaran_mutu_luaran);
    $templateProcessor->setValue('tautan_sasaran_mutu_luaran', $data_db->tautan_sasaran_mutu_luaran);
    $templateProcessor->setValue('sasaran_mutu_dampak', $data_db->sasaran_mutu_dampak);
    $templateProcessor->setValue('total_prodi_aktif', $persentase_prodi['total_prodi_aktif'] ?? 0);
    $templateProcessor->setValue('prodi_terakreditasi', $persentase_prodi['prodi_terakreditasi'] ?? 0);
    $templateProcessor->setValue('prodi_unggul_atau_a', $persentase_prodi['prodi_unggul_atau_a'] ?? 0);
    $templateProcessor->setValue('persentase_unggul_atau_a', number_format($persentase_prodi['persentase_unggul_atau_a'], 2, ',', '.') ?? 0);
    $templateProcessor->setValue('narasi_bab4', $data_db->narasi_bab4);

    // Jika mau, bisa juga ganti gambar/logo
    if (!empty($data_db->nama_logo)) {
      $templateProcessor->setImageValue('logo_pt', [
        'path' => FCPATH . 'uploads/logo_pt/' . $data_db->nama_logo,
        'width' => 150,
        'height' => 150,
        'ratio' => true
      ]);
    } else {
      // Jika tidak ada logo, bisa set placeholder dengan gambar default atau kosong
      $templateProcessor->setImageValue('logo_pt', [
        'path' => FCPATH . 'uploads/logo_pt/default.jpg', // pastikan ada gambar default ini
        'width' => 150,
        'height' => 150,
        'ratio' => true
      ]);
    }

    $file_word = 'Laporan_Implementasi_SPMI_' . $data_db->nama_pt . '_' . $data_db->periode . '_' . date('Y-m-d_H-i-s') . '.docx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    header('Content-Disposition: attachment; filename="' . $file_word . '"');
    header('Cache-Control: max-age=0');

    $templateProcessor->saveAs('php://output');
  }
}
