<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pt extends MX_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->library(['javascript']);
    $this->load->model(['Periode_model']);
    date_default_timezone_set("Asia/Jakarta");

    if (!$this->session->userdata('username')) {
      $this->session->set_flashdata('error', 'Anda belum login.');
      redirect(base_url('login'));
    }

    $this->only_for_roles([6]);
  }

  public function uploadLed()
  {
    $kode_pt = explode('_', $this->session->userdata('username'))[0]; //Ambil kode PT saja
    $data = [
      'upload_led' => 'active',
      'data_periode' => $this->db->select('p.*, pt.kode_pt, pt.file_led, pt.tgl_upload_led')
        ->from('periode as p')
        ->join('penilaian_tipologi as pt', 'p.kode = pt.periode AND pt.kode_pt = ' . $this->db->escape($kode_pt), 'left')
        ->order_by('p.kode', 'ASC')
        ->get()->result_array(),
    ];

    $this->load->view("admin/master/led/v_index", $data);
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
}
