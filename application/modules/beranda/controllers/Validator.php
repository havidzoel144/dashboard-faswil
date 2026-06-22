<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpWord\TemplateProcessor;

class Validator extends MX_Controller
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

    $this->only_for_roles(['5']);
  }

  public function index()
  {
    $user_id                = $this->session->userdata('user_id');
    $data['cek_penilaian']  = 'active';
    $val                    = $this->db->query("SELECT
                                                  *
                                                FROM
                                                  `penilaian_tipologi` a
                                                JOIN periode b ON a.periode = b.kode
                                                WHERE a.`validator_id`='$user_id'
                                                -- AND a.`id_status_penilaian` IN('1','2','3','4','5')
                                                GROUP BY a.`periode`
                                                ORDER BY a.periode DESC")->result();
    foreach ($val as $v) {
      // Ambil jumlah data pt 
      $v->jml_pt = $this->db->query("SELECT
                                        kode_pt
                                      FROM
                                        penilaian_tipologi
                                      WHERE `validator_id` = '$user_id'
                                        AND `periode` = '$v->periode'
                                        -- AND `id_status_penilaian` IN('1','2','3','4','5')
                                      GROUP BY `kode_pt`")->num_rows();
      // Ambil jumlah data menunggu approval admin
      $v->jml_menunggu_approval_admin = $this->db->query("SELECT
                                            kode_pt
                                          FROM
                                            penilaian_tipologi
                                          WHERE `validator_id` = '$user_id'
                                            AND `periode` = '$v->periode'
                                            AND `id_status_penilaian` ='6'
                                          GROUP BY `kode_pt`")->num_rows();
      // Ambil jumlah data draft validator
      $v->jml_draft = $this->db->query("SELECT
                                            kode_pt
                                          FROM
                                            penilaian_tipologi
                                          WHERE `validator_id` = '$user_id'
                                            AND `periode` = '$v->periode'
                                            AND `id_status_penilaian` ='5'
                                          GROUP BY `kode_pt`")->num_rows();
      // Ambil jumlah data valid
      $v->jml_valid = $this->db->query("SELECT
                                            kode_pt
                                          FROM
                                            penilaian_tipologi
                                          WHERE `validator_id` = '$user_id'
                                            AND `periode` = '$v->periode'
                                            AND `id_status_penilaian` ='4'
                                          GROUP BY `kode_pt`")->num_rows();

      // Ambil jumlah data revisi
      $v->jml_revisi = $this->db->query("SELECT
                                            kode_pt
                                          FROM
                                            penilaian_tipologi
                                          WHERE `validator_id` = '$user_id'
                                            AND `periode` = '$v->periode'
                                            AND `id_status_penilaian` ='3'
                                          GROUP BY `kode_pt`")->num_rows();

      // Ambil jumlah data belum validasi
      $v->jml_blm_validasi = $this->db->query("SELECT
                                            kode_pt
                                          FROM
                                            penilaian_tipologi
                                          WHERE `validator_id` = '$user_id'
                                            AND `periode` = '$v->periode'
                                            AND `id_status_penilaian` ='2'
                                          GROUP BY `kode_pt`")->num_rows();
      // Ambil jumlah input faswil
      $v->jml_input_faswil = $this->db->query("SELECT
                                            kode_pt
                                          FROM
                                            penilaian_tipologi
                                          WHERE `validator_id` = '$user_id'
                                            AND `periode` = '$v->periode'
                                            AND `id_status_penilaian` ='1'
                                          GROUP BY `kode_pt`")->num_rows();
      // Ambil jumlah faswil belum input
      $v->jml_faswil_belum_input = $this->db->query("SELECT
                                            kode_pt
                                          FROM
                                            penilaian_tipologi
                                          WHERE `validator_id` = '$user_id'
                                            AND `periode` = '$v->periode'
                                            AND `id_status_penilaian` IS NULL
                                          GROUP BY `kode_pt`")->num_rows();
    }

    // Lempar data ke view
    $data['val'] = $val;

    $this->load->view("admin/master/validator/index", $data);
  }

  public function penilaian_validator($periode_encrypt)
  {
    $periode          = safe_url_decrypt($periode_encrypt);
    $user_id          = $this->session->userdata('user_id');

    $data['periode']        = $periode;
    $data['validator_id']   = $user_id;
    $data['cek_penilaian']  = 'active';

    $bk           = $this->db->query("SELECT * FROM `buka_tutup` WHERE `id` = '2'")->row();
    $data['dabk'] = $bk;
    $current_date = date('Y-m-d');
    $current_time = date('H:i:s');
    $data['bt']   = $bk;

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

    // Query dasar
    $query = $this->db->query("SELECT
                                a.*,
                                b.`nm_status`,
                                c.`nama`,
                                d.keterangan
                              FROM
                                penilaian_tipologi a
                                LEFT JOIN `status_penilaian` b
                                  ON a.`id_status_penilaian` = b.`id_status`
                                JOIN `users` c
                                  ON a.`fasilitator_id` = c.`id`
                                JOIN `periode` d
                                  ON a.`periode` = d.`kode`
                              WHERE a.`validator_id` = '$user_id'
                                AND a.`periode` = '$periode' 
                                -- AND a.`id_status_penilaian` IN('2','3','4','5')
                                ORDER BY a.`id_penilaian_tipologi` ASC");

    // Ambil satu baris data penilaian
    $data['fas'] = $query->row();

    // Ambil semua data penilaian
    $data['data_pt_binaan_result'] = $query->result();

    $this->load->view("admin/master/validator/v_penilaian_validator", $data);
  }

  function simpan_validasi()
  {
    $user_id                = $this->session->userdata('user_id');
    $periode                = $this->input->post('periode');

    // Ambil data dari POST
    $id_penilaian_tipologi         = $this->input->post("id_penilaian_tipologi", true);
    $cek_1                         = $this->input->post("cek_1", true);
    $cek_2                         = $this->input->post("cek_2", true);
    $cek_3                         = $this->input->post("cek_3", true);
    $cek_4                         = $this->input->post("cek_4", true);
    $catatan_1_validator           = $this->input->post("catatan_1_validator", true);
    $catatan_2_validator           = $this->input->post("catatan_2_validator", true);
    $catatan_3_validator           = $this->input->post("catatan_3_validator", true);
    $catatan_4_validator           = $this->input->post("catatan_4_validator", true);
    $catatan_keseluruhan_validator = $this->input->post("catatan_keseluruhan_validator", true);
    $id_status_penilaian           = 5; // default draft validator

    // Mulai transaksi database
    $this->db->trans_start();

    // Siapkan data untuk disimpan
    $data = [
      'cek_1' => $cek_1,
      'cek_2' => $cek_2,
      'cek_3' => $cek_3,
      // 'cek_4' => $cek_4,
      'cek_4' => '1', // Asumsikan cek_4 selalu 1 karena tidak ada input dari validator
      'catatan_1_validator' => $catatan_1_validator,
      'catatan_2_validator' => $catatan_2_validator,
      'catatan_3_validator' => $catatan_3_validator,
      'catatan_4_validator' => $catatan_4_validator,
      'catatan_keseluruhan_validator' => $catatan_keseluruhan_validator,
      'id_status_penilaian' => $id_status_penilaian,
      'updated_at' => date('Y-m-d H:i:s')
    ];
    $this->db->where('id_penilaian_tipologi', $id_penilaian_tipologi);
    $this->db->update('penilaian_tipologi', $data);

    $data_penilaian = $this->db->get_where('penilaian_tipologi', ['id_penilaian_tipologi' => $id_penilaian_tipologi])->row();

    $this->db->insert('rwy_penilaian_validator', [
      'cek_1' => $data_penilaian->cek_1,
      'cek_2' => $data_penilaian->cek_2,
      'cek_3' => $data_penilaian->cek_3,
      'cek_4' => $data_penilaian->cek_4,
      'catatan_1' => $data_penilaian->catatan_1,
      'catatan_2' => $data_penilaian->catatan_2,
      'catatan_3' => $data_penilaian->catatan_3,
      'catatan_4' => $data_penilaian->catatan_4,
      'catatan_keseluruhan' => $data_penilaian->catatan_keseluruhan,
      'id_penilaian_tipologi' => $data_penilaian->id_penilaian_tipologi,
      'id_status_penilaian' => $data_penilaian->id_status_penilaian,
      'validator_id' => $user_id,
      'catatan_1_validator' => $data_penilaian->catatan_1_validator,
      'catatan_2_validator' => $data_penilaian->catatan_2_validator,
      'catatan_3_validator' => $data_penilaian->catatan_3_validator,
      'catatan_4_validator' => $data_penilaian->catatan_4_validator,
      'catatan_keseluruhan_validator' => $data_penilaian->catatan_keseluruhan_validator,
      'skor_1' => $data_penilaian->skor_1,
      'skor_2' => $data_penilaian->skor_2,
      'skor_3' => $data_penilaian->skor_3,
      'skor_4' => $data_penilaian->skor_4,
      'skor_total' => $data_penilaian->skor_total
    ]);

    // Selesaikan transaksi database
    $this->db->trans_complete();

    if ($this->db->trans_status() === TRUE) {
      $this->session->set_flashdata('success', 'Validasi berhasil disimpan.');
    } else {
      $this->session->set_flashdata('error', 'Gagal menyimpan validasi.');
    }

    redirect('penilaian-validator/' . safe_url_encrypt($periode));
  }

  public function rwy_validator($id_penilaian_topologi_encrypt)
  {
    $id_penilaian_topologi  = safe_url_decrypt($id_penilaian_topologi_encrypt);
    $user_id                = $this->session->userdata('user_id');
    $data['cek_penilaian'] = 'active';

    $val = $this->db->query("SELECT
                                a.*,
                                b.`periode`,
                                b.`nama_pt`,
                                b.`kode_pt`,
                                c.`nama`,
                                d.`nm_status`
                              FROM
                                `rwy_penilaian_validator` a
                                JOIN `penilaian_tipologi` b
                                  ON a.`id_penilaian_tipologi` = b.`id_penilaian_tipologi`
                                JOIN `users` c
                                  ON b.`fasilitator_id` = c.`id`
                                JOIN `status_penilaian` d
                                  ON a.`id_status_penilaian` = d.`id_status`
                              WHERE a.`id_penilaian_tipologi` = '$id_penilaian_topologi'
                                AND b.`validator_id` = '$user_id'
                                ORDER BY a.`created_at` DESC");

    $data['da']   = $val->row();
    $data['val']  = $val->result();

    // echo json_encode($data);exit;

    $this->load->view("admin/master/validator/v_rwy_validator", $data);
  }

  public function kirim_nilai($enc_periode, $enc_id = 'semua')
  {
    $periode = safe_url_decrypt($enc_periode);
    $id_penilaian = safe_url_decrypt($enc_id);
    $validator_id = $this->session->userdata('user_id');

    $kirim_nilai = $this->Penilaian_model->prosesNilai($periode, $id_penilaian, $validator_id);

    if ($kirim_nilai) {
      $this->session->set_flashdata('success', 'Data berhasil diproses');
    } else {
      $this->session->set_flashdata('error', 'Gagal memproses nilai');
    }

    if (!empty($_SERVER['HTTP_REFERER'])) {
      redirect($_SERVER['HTTP_REFERER']);
    } else {
      redirect('admin/penilaian-tipologi');
    }
  }

  public function ubah_status_penilaian($enc_id_penilaian)
  {
    $id_penilaian = safe_url_decrypt($enc_id_penilaian);
    $ubah_status_penilaian = $this->Penilaian_model->ubahStatusPenilaian($id_penilaian, 'valid');

    if ($ubah_status_penilaian) {
      $this->session->set_flashdata('success', 'Proses berhasil, menunggu approval dari admin');
    } else {
      $this->session->set_flashdata('error', 'Proses gagal');
    }

    if (!empty($_SERVER['HTTP_REFERER'])) {
      redirect($_SERVER['HTTP_REFERER']);
    } else {
      redirect('admin/penilaian-tipologi');
    }
  }

  public function getDataPenilaian($enc_id_penilaian)
  {
    $id_penilaian = safe_url_decrypt($enc_id_penilaian);
    $penilaian = $this->Penilaian_model->get_data_penilaian_by_id($id_penilaian);

    if ($penilaian) {
      echo json_encode(['status' => 'success', 'data' => $penilaian]);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Data penilaian tidak ditemukan']);
    }
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
      $enc_id_form_led = safe_url_encrypt($form_led->id);

      if (!empty($hasil)) {
        echo json_encode([
          'success' => true,
          'data' => $hasil,
          'persentase_prodi' => $persentase_prodi,
          'skoring_prodi' => $skoring_prodi,
          'csrfHash' => $this->security->get_csrf_hash(), // ← penting
          'form_led' => $form_led,
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
