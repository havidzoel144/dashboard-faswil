<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penilaian extends MX_Controller
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

    $this->only_for_roles(['4']);
  }

  public function index()
  {
    $fasilitator_id = $this->session->userdata('user_id');
    $data = [
      'penilaian' => 'active',
      'data_pt_binaan' => $this->Penilaian_model->get_data_penilaian_by_fasilitator($fasilitator_id),
      'data_periode' => $this->Periode_model->get_active_periode(),
    ];

    // echo json_encode($data['data_pt_binaan']);exit;

    $this->load->view("admin/master/penilaian/v_index", $data);
  }

  public function inputSkor($enc_fasilitator_id, $enc_kode_pt, $enc_periode)
  {
    $fasilitator_id = safe_url_decrypt($enc_fasilitator_id);
    $kode_pt        = safe_url_decrypt($enc_kode_pt);
    $periode        = safe_url_decrypt($enc_periode);

    $data = [
      'penilaian' => 'active',
    ];

    $this->load->view("admin/master/penilaian/v_input_skor", $data);
  }

  public function simpanSkor()
  {
    // Misal data dikirim lewat POST atau JSON
    $post = $this->input->post(); // atau json_decode($this->input->raw_input_stream, true)

    $kode_pt = $post['kode_pt'];
    $fasilitator_id = $this->session->userdata('user_id'); // Contoh ambil dari session
    $periode = $this->Periode_model->get_active_periode(); // Contoh, bisa juga dari input


    $skor_1_bobot = (($post['skor_1a'] + (2 * $post['skor_1b'])) / 3) * 2.22;
    $skor_2_bobot = $post['skor_2'] * 2.78;
    $skor_total = $skor_1_bobot + $skor_2_bobot;
    $tipologi = $this->get_tipologi($skor_total);

    // Data yang akan diupdate
    $data = [
      'skor_1a' => $post['skor_1a'],
      'catatan_1a' => $post['catatan_1a'],
      'skor_1b' => $post['skor_1b'],
      'catatan_1b' => $post['catatan_1b'],
      'skor_2' => $post['skor_2'],
      'catatan_2' => $post['catatan_2'],
      'catatan_keseluruhan' => $post['catatan_keseluruhan'],
      'skor_1_bobot' => $skor_1_bobot,
      'skor_2_bobot' => $skor_2_bobot,
      'skor_total' => $skor_total,
      'tipologi' => $tipologi,
      'updated_at' => date('Y-m-d H:i:s') // optional timestamp
    ];

    // echo $kode_pt;exit;
    $update = $this->Penilaian_model->update_penilaian($kode_pt, $fasilitator_id, $periode->kode, $data);

    if ($update) {
      $this->session->set_flashdata('success', 'Data berhasil diperbarui');
      redirect('admin/penilaian-tipologi');
    } else {
      $this->session->set_flashdata('error', 'Gagal memperbarui data');
    }
  }

  function get_tipologi($nilai_terbobot)
  {
    if ($nilai_terbobot > 17.5 && $nilai_terbobot <= 20) {
      return "Tipologi 1";
    } elseif ($nilai_terbobot > 15 && $nilai_terbobot <= 17.5) {
      return "Tipologi 2";
    } elseif ($nilai_terbobot >= 10 && $nilai_terbobot <= 15) {
      return "Tipologi 3";
    } elseif ($nilai_terbobot < 10) {
      return "Tipologi 4";
    } else {
      return null; // nilai tidak valid atau di luar jangkauan
    }
  }
}
