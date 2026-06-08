<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\Word2007;
use PhpOffice\PhpWord\TemplateProcessor;

class Pt extends MX_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->library(['javascript']);
    $this->load->model(['Periode_model', 'Penilaian_model']);
    date_default_timezone_set("Asia/Jakarta");

    if (!$this->session->userdata('username')) {
      $this->session->set_flashdata('error', 'Anda belum login.');
      redirect(base_url('login'));
    }

    $this->only_for_roles([6]);
  }

  public function pengisianLed()
  {
    $kode_pt = explode('_', $this->session->userdata('username'))[0]; //Ambil kode PT saja
    $data_penjaminan_mutu = $this->db->get_where('data_penjaminan_mutu', ['kode_pt' => $kode_pt])->result_array();
    $logo_pt = $this->db->get_where('logo_pt', ['kode_pt' => $kode_pt])->row_array();
    $data = [
      'pengisian_led' => 'active',
      'judul' => 'Pengisian Laporan Implementasi SPMI',
      'data_periode' => $this->db->select('p.*, pt.kode_pt, pt.file_led, pt.tgl_upload_led, pt.id_status_penilaian, dpm.periode as periode_dpm, fl.status as status_led, fl.id_penilaian_tipologi,')
        ->from('periode as p')
        ->join('penilaian_tipologi as pt', 'p.kode = pt.periode AND pt.kode_pt = ' . $this->db->escape($kode_pt), 'left')
        ->join('data_penjaminan_mutu as dpm', 'dpm.kode_pt = pt.kode_pt AND dpm.periode = p.kode', 'left')
        ->join('form_led as fl', 'pt.id_penilaian_tipologi = fl.id_penilaian_tipologi', 'left')
        ->where('p.status', '1')
        ->order_by('p.kode', 'ASC')
        ->get()->result_array(),
      // 'data_penjaminan_mutu' => $data_penjaminan_mutu,
      'logo_pt' => $logo_pt,
    ];

    // echo json_encode($data);
    // exit;
    $this->load->view("admin/master/led/v_index", $data);
  }

  public function uploadLed()
  {
    $kode_pt = explode('_', $this->session->userdata('username'))[0]; //Ambil kode PT saja
    $data = [
      'upload_led' => 'active',
      'judul' => 'Upload LED',
      'data_periode' => $this->db->select('p.*, pt.kode_pt, pt.file_led, pt.tgl_upload_led')
        ->from('periode as p')
        ->join('penilaian_tipologi as pt', 'p.kode = pt.periode AND pt.kode_pt = ' . $this->db->escape($kode_pt), 'left')
        ->order_by('p.kode', 'ASC')
        ->get()->result_array(),
    ];

    $this->load->view("admin/master/led/v_index_upload", $data);
  }

  public function simpanUploadLed()
  {
    $periode = $this->input->post('kode_periode');
    $kode_pt = explode('_', $this->session->userdata('username'))[0]; // Ambil kode PT saja
    $nama_pt = $this->db->get_where('data_pt', ['kode_pt' => $kode_pt])->row_array()['nama_pt'];

    if (empty($periode)) {
      $this->session->set_flashdata('error', 'Periode wajib dipilih.');
      redirect(base_url('beranda/pt/upload-led'));
      return;
    }

    if (!isset($_FILES['file_led']) || empty($_FILES['file_led']['name'])) {
      $this->session->set_flashdata('error', 'File LED wajib diupload.');
      redirect(base_url('beranda/pt/upload-led'));
      return;
    }

    $upload_path = FCPATH . 'uploads/led/' . $periode . '/';
    if (!is_dir($upload_path)) {
      mkdir($upload_path, 0777, true);
    }

    $config['upload_path'] = $upload_path;
    $config['allowed_types'] = 'pdf|doc|docx';
    $config['max_size'] = 2048; // 2 MB
    $config['file_ext_tolower'] = true;
    $config['remove_spaces'] = true;
    $config['file_name'] = 'LED_' . $periode . '_' . $kode_pt . '_' . $nama_pt . '_' . time();

    $this->load->library('upload');
    $this->upload->initialize($config);

    if (!$this->upload->do_upload('file_led')) {
      $this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));
      redirect(base_url('admin/pt/upload-led'));
      return;
    }

    $upload_data = $this->upload->data();
    $file_led = $upload_data['file_name'];

    $existing = $this->db->get_where('penilaian_tipologi', [
      'kode_pt' => $kode_pt,
      'periode' => $periode,
    ])->row_array();

    if (!empty($existing['file_led'])) {
      $old_file = $upload_path . $existing['file_led'];
      if (file_exists($old_file)) {
        @unlink($old_file);
      }
    }

    $data_save = [
      'file_led' => $file_led,
    ];

    $this->db->where('kode_pt', $kode_pt)
      ->where('periode', $periode)
      ->update('penilaian_tipologi', $data_save);

    $this->session->set_flashdata('success', 'File LED berhasil diupload.');
    redirect(base_url('admin/pt/upload-led'));
  }

  public function lihatFileLed($kode_pt, $periode)
  {
    if (empty($kode_pt) || empty($periode) || $kode_pt != explode('_', $this->session->userdata('username'))[0]) {
      $this->session->set_flashdata('error', 'Kode PT dan periode tidak valid.');
      redirect('admin/pt/upload-led');
      return;
    }

    $row = $this->db->get_where('penilaian_tipologi', [
      'kode_pt' => $kode_pt,
      'periode' => $periode,
    ])->row_array();

    if (!$row || empty($row['file_led'])) {
      $this->session->set_flashdata('error', 'File LED tidak ditemukan.');
      redirect('admin/pt/upload-led');
      return;
    }

    $file_name = $row['file_led'];
    $file_url  = base_url('uploads/led/' . $periode . '/' . $file_name);

    $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $data = [
      'file_url'  => $file_url,
      'file_name' => $file_name,
      'ext'       => $ext
    ];

    $this->load->view('admin/master/led/preview_led', $data);
  }

  public function hapusUploadLed()
  {
    $kode_pt = $this->input->get('kode_pt');
    $periode = $this->input->get('periode');

    if (empty($kode_pt) || empty($periode) || $kode_pt != explode('_', $this->session->userdata('username'))[0]) {
      $this->session->set_flashdata('error', 'Kode PT dan periode tidak valid.');
      redirect(base_url('admin/pt/upload-led'));
      return;
    }

    $upload_path = FCPATH . 'uploads/led/' . $periode . '/';
    $existing = $this->db->get_where('penilaian_tipologi', [
      'kode_pt' => $kode_pt,
      'periode' => $periode,
    ])->row_array();

    if (!empty($existing['file_led'])) {
      $old_file = $upload_path . $existing['file_led'];
      if (file_exists($old_file)) {
        @unlink($old_file);
      }
    }

    $data_save = [
      'file_led' => null,
      'tgl_upload_led' => null,
    ];

    $this->db->where('kode_pt', $kode_pt)
      ->where('periode', $periode)
      ->update('penilaian_tipologi', $data_save);

    $this->session->set_flashdata('success', 'File LED berhasil dihapus.');
    redirect(base_url('admin/pt/upload-led'));
  }

  public function kirimUploadLedPermanen()
  {
    $kode_pt = $this->input->get('kode_pt');
    $periode = $this->input->get('periode');

    if (empty($kode_pt) || empty($periode) || $kode_pt != explode('_', $this->session->userdata('username'))[0]) {
      $this->session->set_flashdata('error', 'Kode PT dan periode tidak valid.');
      redirect(base_url('admin/pt/upload-led'));
      return;
    }

    $data_save = [
      'tgl_upload_led' => date('Y-m-d H:i:s'),
    ];

    $this->db->where('kode_pt', $kode_pt)
      ->where('periode', $periode)
      ->update('penilaian_tipologi', $data_save);

    $this->session->set_flashdata('success', 'File LED berhasil dikirim permanen.');
    redirect(base_url('admin/pt/upload-led'));
  }

  public function formPengisianLed($enc_periode)
  {
    $kode_pt = explode('_', $this->session->userdata('username'))[0]; //Ambil kode PT saja
    $periode = safe_url_decrypt($enc_periode);
    $buka_tutup_pengisian = $this->db->get_where('buka_tutup', ['jenis' => 'Pengisian Laporan Implementasi SPMI'])->row_array();
    $penilaian_tipologi = $this->db->get_where('penilaian_tipologi', [
      'kode_pt' => $kode_pt,
      'periode' => $periode,
    ])->row_array();

    $form_led = $this->db->from('form_led as a')->join('penilaian_tipologi as b', 'a.id_penilaian_tipologi = b.id_penilaian_tipologi')->where('b.kode_pt', $kode_pt)->where('b.periode', $periode)->get()->row_array();
    $persentase_prodi = $this->Penilaian_model->statistikProdi($kode_pt);
    $identias_pt = $this->db->get_where('data_pt', ['kode_pt' => $kode_pt])->row_array();

    // echo json_encode($penilaian_tipologi); // Debugging: Tampilkan data form_led
    // exit;

    if ($form_led == null) {
      $data_insert = [
        'id_penilaian_tipologi' => $penilaian_tipologi['id_penilaian_tipologi'],
        'kode_pt' => $penilaian_tipologi['kode_pt'],
        'nama_pt' => $penilaian_tipologi['nama_pt'],
        'alamat' => $identias_pt['alamat_jalan'] ?? 'Belum diisi',
        'tgl_sk_pendirian_pt' => $identias_pt['tgl_sk_pendirian'] ?? '0000-00-00',
        'akreditasi_pt' => $identias_pt['akreditasi_pt'] ?? 'Belum diisi',
        'tgl_akhir_apt' => $identias_pt['tgl_akhir_akred'] ?? '0000-00-00',
        'created_at' => date('Y-m-d H:i:s'),
      ];
      $this->db->insert('form_led', $data_insert);
    } else {
      if ($form_led['status'] == '0') {
        $data_update = [
          'kode_pt' => $penilaian_tipologi['kode_pt'],
          'nama_pt' => $penilaian_tipologi['nama_pt'],
          'alamat' => $identias_pt['alamat_jalan'] ?? 'Belum diisi',
          'tgl_sk_pendirian_pt' => $identias_pt['tgl_sk_pendirian'] ?? '0000-00-00',
          'akreditasi_pt' => $identias_pt['akreditasi_pt'] ?? 'Belum diisi',
          'tgl_akhir_apt' => $identias_pt['tgl_akhir_akred'] ?? '0000-00-00',
        ];
        $this->db->where('id', $form_led['id'])->update('form_led', $data_update);
      }
    }
    $form_led = $this->db->from('form_led as a')->join('penilaian_tipologi as b', 'a.id_penilaian_tipologi = b.id_penilaian_tipologi')->where('b.kode_pt', $kode_pt)->where('b.periode', $periode)->get()->row_array();

    $data = [
      'pengisian_led' => 'active',
      'judul' => 'Form Pengisian Laporan Implementasi SPMI',
      'kode_pt' => $kode_pt,
      'periode' => $periode,
      'penilaian_tipologi' => $penilaian_tipologi,
      'persentase_prodi' => $persentase_prodi,
      'identitas_pt' => $identias_pt,
      'form_led' => $form_led,
      'buka_tutup_pengisian' => $buka_tutup_pengisian,
    ];

    $this->load->view("admin/master/led/v_form_pengisian_led", $data);
  }

  public function simpanLed()
  {
    $changed_field = $this->input->post('changed_field');
    $changed_value = $this->input->post('changed_value');
    $id_penilaian_tipologi = safe_url_decrypt($this->input->post('id_penilaian_tipologi'));
    if (empty($id_penilaian_tipologi) || empty($changed_field)) {
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'status' => false,
          'message' => 'Data update tidak valid.',
        ]));
      return;
    }

    // ==============================
    // WHITELIST FIELD
    // ==============================
    $allowed_fields = [
      // identitas
      'alamat',
      'tgl_sk_pendirian_pt',
      'pejabat_penandatangan',
      'tahun_pertama_terima_mhs',
      // bab 1
      'dasar_penyusunan',
      'mekanisme_kerja_penyusunan_laporan',
      // bab 2
      'penetapan_diferensiasi',
      // indikator
      'sasaran_mutu_masukan',
      'sasaran_mutu_proses',
      'sasaran_mutu_luaran',
      'sasaran_mutu_dampak',
      // tautan bukti
      'tautan_sasaran_mutu_masukan',
      'tautan_sasaran_mutu_proses',
      'tautan_sasaran_mutu_luaran',
      'tautan_sasaran_mutu_dampak',
      // bab 4
      'narasi_bab4'
    ];

    // Cegah update field liar
    if (!in_array($changed_field, $allowed_fields)) {
      return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'status' => false,
          'message' => 'Field tidak diizinkan.'
        ]));
    }

    // ==============================
    // VALIDASI BATAS KATA
    // ==============================
    $word_limits = [
      // bab 1
      'dasar_penyusunan' => 200,
      'mekanisme_kerja_penyusunan_laporan' => 200,
      // bab 2
      'penetapan_diferensiasi' => 500,
      // indikator
      'sasaran_mutu_masukan' => 1000,
      'sasaran_mutu_proses' => 1000,
      'sasaran_mutu_luaran' => 1000,
      'sasaran_mutu_dampak' => 1000,
      // bab 4
      'narasi_bab4' => 500
    ];
    // Jika field termasuk field narasi
    if (isset($word_limits[$changed_field])) {
      $total_words = $this->countWords($changed_value);
      if ($total_words > $word_limits[$changed_field]) {
        return $this->output
          ->set_content_type('application/json')
          ->set_output(json_encode([
            'status' => false,
            'message' => 'Maksimal ' . $word_limits[$changed_field] . ' kata.',
            'total_words' => $total_words
          ]));
      }
    }

    // ==============================
    // CEK DATA EXISTING
    // ==============================
    $existing = $this->db->get_where('form_led', [
      'id_penilaian_tipologi' => $id_penilaian_tipologi,
    ])->row_array();

    if ($existing) {
      $update = $this->db->where('id_penilaian_tipologi', $id_penilaian_tipologi)
        ->update('form_led', [$changed_field => $changed_value]);
    } else {
      $data_insert = [
        'id_penilaian_tipologi' => $id_penilaian_tipologi,
        $changed_field => $changed_value,
      ];
      $update = $this->db->insert('form_led', $data_insert);
    }
    $post = $this->input->post(NULL, TRUE);

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode([
        'status' => true,
        'message' => 'Data sudah disimpan otomatis.',
      ]));
  }

  private function countWords($text)
  {
    $text = trim(strip_tags($text));
    if ($text === '') {
      return 0;
    }
    $words = preg_split('/\s+/', $text);
    return count($words);
  }

  public function simpanPermanen()
  {
    $periode = safe_url_decrypt($this->input->post('periode'));
    $kode_pt = safe_url_decrypt($this->input->post('kode_pt'));

    if (empty($periode) || empty($kode_pt) || $kode_pt != explode('_', $this->session->userdata('username'))[0]) {
      $this->session->set_flashdata('error', 'Kode PT dan periode tidak valid.');
      redirect(base_url('admin/pt/form-pengisian-led'));
      return;
    }

    $form_led = $this->db->get_where('form_led', [
      'kode_pt' => $kode_pt,
      'id_penilaian_tipologi' => $this->db->get_where('penilaian_tipologi', ['kode_pt' => $kode_pt, 'periode' => $periode])->row_array()['id_penilaian_tipologi']
    ])->row_array();

    $null_fields = array_keys(array_filter($form_led, function ($v, $k) {
      if (in_array($k, ['akreditasi_pt', 'tgl_akhir_apt', 'tgl_sk_pendirian_pt', 'alamat', 'pejabat_penandatangan', 'tahun_pertama_terima_mhs', 'tautan_sasaran_mutu_dampak', 'created_at', 'updated_at', 'status'], true)) {
        return false;
      }
      return is_null($v) || $v === '' || $v === '0' || $v === 0 || $v === '0000-00-00';
    }, ARRAY_FILTER_USE_BOTH));

    if (!empty($null_fields)) {
      $field_labels = [
        'id_penilaian_tipologi' => 'ID Penilaian Tipologi',
        'nama_file' => 'Upload File Mind Map',
      ];

      $readable_fields = array_map(function ($field) use ($field_labels) {
        if (isset($field_labels[$field])) {
          return $field_labels[$field];
        }
        return ucwords(str_replace('_', ' ', $field));
      }, $null_fields);

      $this->session->set_flashdata('error', 'Tidak dapat disimpan permanen. Pastikan semua data sudah diisi. Field yang belum diisi: ' . implode(', ', $readable_fields));
      redirect(base_url('admin/pt/form-pengisian-led/' . safe_url_encrypt($periode)));
      return;
    }

    $data_update = [
      'status'     => '1',
      'updated_at' => date('Y-m-d H:i:s'),
    ];

    $this->db->where('id_penilaian_tipologi', $form_led['id_penilaian_tipologi'])
      ->update('form_led', $data_update);

    $pesan = $this->input->post('is_permanen') === '1' ? 'Laporan Implementasi SPMI berhasil disimpan permanen.' : 'Laporan Implementasi SPMI berhasil disimpan sebagai draft.';

    $this->session->set_flashdata('success', $pesan);
    redirect(base_url('admin/pt/form-pengisian-led/' . safe_url_encrypt($periode)));
  }

  public function simpanLedLama()
  {
    $periode = safe_url_decrypt($this->input->post('periode'));
    $kode_pt = safe_url_decrypt($this->input->post('kode_pt'));

    if (empty($periode) || empty($kode_pt) || $kode_pt != explode('_', $this->session->userdata('username'))[0]) {
      $this->session->set_flashdata('error', 'Kode PT dan periode tidak valid.');
      redirect(base_url('admin/pt/form-pengisian-led'));
      return;
    }

    $data_update = [
      'narasi_1' => $this->input->post('narasi_1'),
      'bukti_1' => $this->input->post('bukti_1'),
      'narasi_2' => $this->input->post('narasi_2'),
      'bukti_2' => $this->input->post('bukti_2'),
      'narasi_3' => $this->input->post('narasi_3'),
      'bukti_3' => $this->input->post('bukti_3'),
      'narasi_4' => $this->input->post('narasi_4'),
      'bukti_4' => $this->input->post('bukti_4'),
      'status_led' => $this->input->post('is_permanen'),
    ];

    $this->db->where('kode_pt', $kode_pt)
      ->where('periode', $periode)
      ->update('penilaian_tipologi', $data_update);

    $pesan = $this->input->post('is_permanen') === '1' ? 'LED berhasil disimpan permanen.' : 'LED berhasil disimpan sebagai draft.';

    $this->session->set_flashdata('success', $pesan);
    redirect(base_url('admin/pt/form-pengisian-led/' . safe_url_encrypt($periode)));
  }

  public function unduhLaporanLed($enc_id_penilaian_tipologi)
  {
    $id_penilaian_tipologi = safe_url_decrypt($enc_id_penilaian_tipologi);
    $kode_pt = explode('_', $this->session->userdata('username'))[0]; // Ambil kode PT saja

    $data_db = $this->db->select('fl.*, pt.periode, lp.nama_logo')
      ->from('form_led as fl')
      ->join('penilaian_tipologi as pt', 'fl.id_penilaian_tipologi = pt.id_penilaian_tipologi')
      ->join('logo_pt as lp', 'lp.kode_pt = pt.kode_pt', 'left')
      ->where('fl.id_penilaian_tipologi', $id_penilaian_tipologi)
      ->where('fl.kode_pt', $kode_pt)
      ->get()
      ->row();
    $persentase_prodi = $this->Penilaian_model->statistikProdi($kode_pt);

    if (!$data_db) {
      $this->session->set_flashdata('error', 'Data LED tidak ditemukan untuk periode ini.');
      redirect(base_url('admin/pt/pengisian-led'));
      return;
    }

    // Logika untuk generate PDF laporan LED
    // Contoh: Load library PDF, siapkan data, dan render view template PDF
    // Kemudian output PDF ke browser atau simpan di server
    // ...

    // Contoh sederhana (ganti dengan implementasi sebenarnya):
    $this->load->library('pdfgenerator');
    $file_pdf = "Laporan_LED_" . $data_db->nama_pt . "_" . $data_db->periode . "_" . date('Y-m-d_H-i-s');
    $paper = 'A4';
    $orientation = "portrait";
    $html = $this->load->view('admin/master/led/template_laporan_led', ['data' => $data_db, 'persentase_prodi' => $persentase_prodi], true);
    $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
  }

  public function unduhLaporanLedWord($enc_id_penilaian_tipologi)
  {
    // $phpWord = new PhpWord();
    // $section = $phpWord->addSection();
    // $section->addText('Hello World !');

    // $writer = new Word2007($phpWord);

    // $filename = 'simple';

    // header('Content-Type: application/msword');
    // header('Content-Disposition: attachment;filename="' . $filename . '.docx"');
    // header('Cache-Control: max-age=0');

    // $writer->save('php://output');

    $id_penilaian_tipologi = safe_url_decrypt($enc_id_penilaian_tipologi);
    $kode_pt = explode('_', $this->session->userdata('username'))[0];

    $data_db = $this->db->select('fl.*, pt.periode, pt.nama_pt, lp.nama_logo')
      ->from('form_led as fl')
      ->join('penilaian_tipologi as pt', 'fl.id_penilaian_tipologi = pt.id_penilaian_tipologi')
      ->join('logo_pt as lp', 'lp.kode_pt = pt.kode_pt', 'left')
      ->where('fl.id_penilaian_tipologi', $id_penilaian_tipologi)
      ->where('fl.kode_pt', $kode_pt)
      ->get()
      ->row();

    $persentase_prodi = $this->Penilaian_model->statistikProdi($kode_pt);

    if (!$data_db) {
      $this->session->set_flashdata('error', 'Data LED tidak ditemukan untuk periode ini.');
      redirect(base_url('admin/pt/pengisian-led'));
      return;
    }

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

    $file_word = 'Laporan_LED_' . $data_db->nama_pt . '_' . $data_db->periode . '_' . date('Y-m-d_H-i-s') . '.docx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    header('Content-Disposition: attachment; filename="' . $file_word . '"');
    header('Cache-Control: max-age=0');

    $templateProcessor->saveAs('php://output');
  }

  public function unduhSertifikat($enc_periode)
  {
    // return $this->load->view("admin/master/led/template_sertifikat");
    // 1. Ambil data dari database (asumsi menggunakan model)
    $kode_pt = explode('_', $this->session->userdata('username'))[0]; // Ambil kode PT saja
    $periode = safe_url_decrypt($enc_periode);
    $data_db = $this->db->get_where('data_penjaminan_mutu', [
      'kode_pt' => $kode_pt,
      'periode' => $periode,
    ])->row();

    // 2. Siapkan data untuk View
    $data['nama_pt']          = $data_db->nama_pt;
    $data['tipologi']         = $data_db->tipologi;
    $data['skor_masukan']     = $data_db->skor_1;
    $data['skor_proses']      = $data_db->skor_2;
    $data['skor_luaran']      = $data_db->skor_3;
    $data['skor_dampak']      = $data_db->skor_4;
    $data['skor_total']       = $data_db->skor_total;
    $data['nomor_sertifikat'] = "Nomor Sertifikat"; // Ganti dengan logika generate nomor sertifikat jika ada
    $data['tahun']            = "Tahun"; // Ganti dengan logika ambil tahun dari periode atau data lain jika ada
    $data['tanggal_cetak']    = "Tanggal Cetak"; // Ganti dengan logika ambil tanggal cetak saat ini atau dari data lain jika ada
    $data['nama_pejabat']     = "Dr. Henri Tambunan, SE., M.A";
    $data['nip_pejabat']      = "196811261994031001";

    // 3. Generate PDF (Contoh menggunakan pdfgenerator)
    $this->load->library('pdfgenerator');
    $file_pdf = "Sertifikat-" . $data['nama_pt'] . "_" . $data['tahun'] . "_" . date('Y-m-d_H-i-s');
    $paper = 'A4';
    $orientation = "landscape";
    $html = $this->load->view('admin/master/led/template_sertifikat', $data, true);
    $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
  }

  public function uploadLogo()
  {
    $kode_pt = explode('_', $this->session->userdata('username'))[0]; // Ambil kode PT saja

    if (!isset($_FILES['file_logo']) || empty($_FILES['file_logo']['name'])) {
      $this->session->set_flashdata('error', 'File logo wajib diupload.');
      redirect(base_url('admin/pt/upload-logo'));
      return;
    }

    $upload_path = FCPATH . 'uploads/logo_pt/';
    if (!is_dir($upload_path)) {
      mkdir($upload_path, 0777, true);
    }

    $config['upload_path'] = $upload_path;
    $config['allowed_types'] = 'png|jpg|jpeg|svg';
    $config['max_size'] = 2048; // 2 MB
    $config['file_ext_tolower'] = true;
    $config['remove_spaces'] = true;
    $config['file_name'] = 'Logo_' . $kode_pt . '_' . time();

    $this->load->library('upload');
    $this->upload->initialize($config);

    $original_ext = strtolower(pathinfo($_FILES['file_logo']['name'], PATHINFO_EXTENSION));
    $file_logo = $config['file_name'] . '.' . $original_ext;

    try {
      $existing = $this->db->get_where('logo_pt', [
        'kode_pt' => $kode_pt,
      ])->row_array();

      $this->db->trans_begin();

      $data_save = [
        'nama_logo' => $file_logo,
      ];

      if (!empty($existing)) {
        $this->db->where('kode_pt', $kode_pt)->update('logo_pt', $data_save);
      } else {
        $data_save['kode_pt'] = $kode_pt;
        $this->db->insert('logo_pt', $data_save);
      }

      if ($this->db->trans_status() === FALSE) {
        throw new Exception('Gagal menyimpan data logo ke database.');
      }

      $this->db->trans_commit();
    } catch (Exception $e) {
      if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
      }
      $this->session->set_flashdata('error', $e->getMessage());
      redirect(base_url('admin/pt/pengisian-led'));
      return;
    }

    if (!$this->upload->do_upload('file_logo')) {
      // Kembalikan nilai DB ke data lama jika upload gagal
      if (!empty($existing)) {
        $this->db->where('kode_pt', $kode_pt)->update('logo_pt', [
          'nama_logo' => $existing['nama_logo'],
        ]);
      } else {
        $this->db->where('kode_pt', $kode_pt)->delete('logo_pt');
      }

      $this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));
      redirect(base_url('admin/pt/pengisian-led'));
      return;
    }

    if (!empty($existing['nama_logo'])) {
      $old_file = $upload_path . $existing['nama_logo'];
      if (file_exists($old_file)) {
        @unlink($old_file);
      }
    }

    $this->session->set_flashdata('success', 'File logo berhasil diupload.');
    redirect(base_url('admin/pt/pengisian-led'));
  }

  public function logo($enc_nama_logo)
  {
    $nama_logo = safe_url_decrypt($enc_nama_logo);
    $file_path = FCPATH . 'uploads/logo_pt/' . $nama_logo;
    if (file_exists($file_path)) {
      header('Content-Type: ' . mime_content_type($file_path));
      readfile($file_path);
      exit;
    }
    // Jika logo tidak ditemukan, tampilkan placeholder atau kirim response 404
    header("HTTP/1.0 404 Not Found");
    echo "Logo tidak ditemukan.";
    exit;
  }

  public function uploadMindmap()
  {
    if (!$this->input->is_ajax_request()) {
      show_error('Permintaan tidak valid', 400);
      return;
    }

    $id_form_led = safe_url_decrypt($this->input->post('id_form_led'));
    if (empty($id_form_led) || $id_form_led == 'undefined') {
      return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'status' => false,
          'message' => 'ID Form LED tidak valid.',
        ]));
    }

    if (!isset($_FILES['file_mindmap']) || empty($_FILES['file_mindmap']['name'])) {
      return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'status' => false,
          'message' => 'File mindmap wajib diupload.',
        ]));
    }

    $kode_pt = explode('_', $this->session->userdata('username'))[0];
    $upload_path = FCPATH . 'uploads/mindmap_pt/';
    if (!is_dir($upload_path)) {
      mkdir($upload_path, 0777, true);
    }

    $config['upload_path'] = $upload_path;
    $config['allowed_types'] = 'png|jpg|jpeg';
    $config['max_size'] = 2048;
    $config['file_ext_tolower'] = true;
    $config['remove_spaces'] = true;
    $config['file_name'] = 'Mindmap_' . $kode_pt . '_' . time();

    $this->load->library('upload');
    $this->upload->initialize($config);

    if (!$this->upload->do_upload('file_mindmap')) {
      return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'status' => false,
          'message' => strip_tags($this->upload->display_errors()),
        ]));
    }

    $upload_data = $this->upload->data();
    $file_mindmap = $upload_data['file_name'];

    $existing = $this->db->get_where('form_led', [
      'id' => $id_form_led,
    ])->row_array();

    $this->db->trans_begin();

    $data_save = [
      'nama_file' => $file_mindmap,
    ];

    if (!empty($existing)) {
      $this->db->where('id', $id_form_led)->update('form_led', $data_save);
    } else {
      return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'status' => false,
          'message' => 'Data Form LED tidak ditemukan.',
        ]));
    }

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      @unlink($upload_path . $file_mindmap);

      return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'status' => false,
          'message' => 'Gagal menyimpan data mindmap ke database.',
        ]));
    }

    $this->db->trans_commit();

    if (!empty($existing['nama_file'])) {
      $old_file = $upload_path . $existing['nama_file'];
      if (file_exists($old_file)) {
        @unlink($old_file);
      }
    }

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode([
        'status' => true,
        'message' => 'File mindmap berhasil diupload.',
        'nama_file' => $file_mindmap,
      ]));
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
}
