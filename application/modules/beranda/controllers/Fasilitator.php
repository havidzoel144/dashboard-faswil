<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fasilitator extends MX_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->library(['javascript']);
    $this->load->model(['User_model', 'Periode_model', 'Penilaian_model']);
    date_default_timezone_set("Asia/Jakarta");

    if (!$this->session->userdata('username')) {
      $this->session->set_flashdata('error', 'Anda belum login.');
      redirect(base_url('login'));
    }

    $this->only_for_roles(['1', '2']);
    $this->periode_aktif = $this->Periode_model->get_active_periode();
  }

  public function index()
  {
    $data = [
      'master' => 'active',
      'fasilitator' => 'active',
      'data_periode' => $this->Periode_model->get_all_data_periode(),
    ];

    $this->load->view("admin/master/fasilitator/v_index", $data);
  }

  public function plottingFasilitator($enc_periode)
  {
    $periode        = safe_url_decrypt($enc_periode);
    $periode_dipilih = $this->Periode_model->get_periode_by_kode($periode);

    $data = [
      'master' => 'active',
      'fasilitator' => 'active',
      'periode_dipilih' => $periode_dipilih,
      'data_user_fasilitator' => $this->User_model->get_users_with_fasilitator_role(),
      'data_user_validator' => $this->User_model->get_users_with_validator_role(),
      'data_plotting_fasilitator' => $this->Penilaian_model->get_data_penilaian_by_periode($periode),
      // 'data_perguruan_tinggi' => $this->Penilaian_model->get_pt_not_plot($periode_dipilih->kode),
      'data_perguruan_tinggi' => $this->Penilaian_model->get_data_pt_for_select($periode_dipilih->kode),
    ];

    // echo json_encode($data['periode_dipilih']);exit;

    $this->load->view("admin/master/fasilitator/v_plotting", $data);
  }

  public function simpanPlottingFasilitator()
  {
    // echo json_encode($this->input->post());exit;
    // Pastikan ini hanya dipanggil dengan POST
    if ($this->input->method() !== 'post') {
      show_error('Metode tidak diizinkan', 405);
    }

    $id_fasilitator = $this->input->post('id_fasilitator', true);
    $id_validator = $this->input->post('id_validator', true);
    $kode_pts = $this->input->post('perguruan_tinggi');
    $nama_pts = $this->input->post('nama_pt');
    $periode = $this->input->post('periode');

    // Validasi
    if (!$id_fasilitator || empty($kode_pts) || empty($nama_pts) || empty($periode)) {
      $this->session->set_flashdata('error', 'Data tidak lengkap');
      if (!empty($_SERVER['HTTP_REFERER'])) {
        redirect($_SERVER['HTTP_REFERER']);
      } else {
        redirect('admin/plotting-fasilitator');
      }
    }

    // Insert data ke tabel penilaian_tipologi
    $this->db->trans_start();

    foreach ($kode_pts as $index => $kode_pt) {
      $nama_pt = isset($nama_pts[$index]) ? $nama_pts[$index] : '';

      $data_insert = [
        'fasilitator_id' => $id_fasilitator,
        'validator_id' => $id_validator,
        'kode_pt' => $kode_pt,
        'nama_pt' => $nama_pt,
        'periode' => $periode,
        'created_at' => date('Y-m-d H:i:s')
      ];

      $this->db->insert('penilaian_tipologi', $data_insert);
    }

    $this->db->trans_complete();

    if ($this->db->trans_status() === false) {
      $this->session->set_flashdata('error', 'Gagal menyimpan data plotting fasilitator');
    } else {
      $this->session->set_flashdata('success', 'Data plotting fasilitator berhasil disimpan');
    }

    if (!empty($_SERVER['HTTP_REFERER'])) {
      redirect($_SERVER['HTTP_REFERER']);
    } else {
      redirect('admin/plotting-fasilitator');
    }
  }

  public function hapusPlotting($enc_id)
  {
    $id = safe_url_decrypt($enc_id);
    if (!$id) {
      $this->session->set_flashdata('error', 'ID plotting tidak valid.');
      redirect($_SERVER['HTTP_REFERER']);
    }

    // Cek apakah penilaian ada
    $penilaian = $this->Penilaian_model->get_data_penilaian_by_id($id);
    if (!$penilaian) {
      $this->session->set_flashdata('error', 'ID plotting tidak ditemukan.');
      redirect($_SERVER['HTTP_REFERER']);
    }

    // Proses hapus user
    $delete = $this->Penilaian_model->delete_penilaian_by_id($id);

    if ($delete) {
      $this->session->set_flashdata('success', 'Plotting berhasil dihapus.');
    } else {
      $this->session->set_flashdata('error', 'Gagal menghapus plotting.');
    }

    redirect($_SERVER['HTTP_REFERER']);
  }
}
