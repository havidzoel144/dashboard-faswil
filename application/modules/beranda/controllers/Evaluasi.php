<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Evaluasi extends MX_Controller
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

    $this->only_for_roles([1, 2, 4, 5, 6]);
  }

  public function index()
  {
    $data = [
      'evaluasi_360' => 'active',
      'data_periode' => $this->Periode_model->get_all_data_periode(),
    ];

    $this->load->view("admin/master/evaluasi/v_index", $data);
  }

  public function detail($enc_periode)
  {
    $periode = safe_url_decrypt($enc_periode);
    $data = [
      'evaluasi_360' => 'active',
      'data_fasilitator' => $this->Penilaian_model->get_data_penilaian_by_periode($periode),
    ];

    $temp = new stdClass();

    foreach ($data['data_fasilitator'] as $row) {
      $temp->{$row->fasilitator_id} = (object)[
        'fasilitator_id'   => $row->fasilitator_id,
        'nama_fasilitator' => $row->nama_fasilitator,
        'keterangan'       => $row->keterangan,
      ];
    }

    $data['data_fasilitator'] = array_values((array)$temp);
    usort($data['data_fasilitator'], function ($a, $b) {
      return strcmp($a->nama_fasilitator, $b->nama_fasilitator);
    });

    $this->load->view("admin/master/evaluasi/v_detail", $data);
  }

  public function simpan()
  {
    $fasilitator_id = safe_url_decrypt($this->input->post('fasilitator_id'));
    $postPeriode = $this->input->post('periode');
    $periode = substr($postPeriode, 0, 4) . substr($postPeriode, 13, 1); // Format: 1 atau 2
    $rating = $this->input->post('rating');
    $evaluator_id = $this->session->userdata('user_id');
    $jenis_evaluasi = $this->input->post('jenis_evaluasi');

    $data = [
      'fasilitator_id' => $fasilitator_id,
      'periode' => $periode,
      'rating' => json_encode($rating),
      'evaluator_id' => $evaluator_id,
      'jenis_evaluasi' => $jenis_evaluasi,
      'created_at' => date('Y-m-d H:i:s'),
    ];

    // echo json_encode($data); // Debugging: Tampilkan data yang akan disimpan
    // exit;

    $this->db->insert('evaluasi', $data);
    $simpan = $this->db->affected_rows() > 0;

    if ($simpan) {
      $this->session->set_flashdata('success', 'Evaluasi berhasil disimpan.');
    } else {
      $this->session->set_flashdata('error', 'Gagal menyimpan evaluasi. Silakan coba lagi.');
    }

    redirect(base_url('admin/evaluasi-360/detail/') . safe_url_encrypt($periode));
  }
}
