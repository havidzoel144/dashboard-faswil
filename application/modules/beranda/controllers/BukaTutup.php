<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BukaTutup extends MX_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->library(['javascript']);
    $this->load->model('User_model');
    date_default_timezone_set("Asia/Jakarta");

    if (!$this->session->userdata('username')) {
      $this->session->set_flashdata('error', 'Anda belum login.');
      redirect(base_url('login'));
    }

    $this->only_for_roles([1, 2]);
  }

  public function index()
  {
    $data = [
      'master' => 'active',
      'BukaTutup' => 'active',
      'data_buka_tutup' => $this->db->query("SELECT * FROM buka_tutup")->result(),
      'data_role' => $this->db->query("SELECT * FROM `roles`")->result()
    ];

    $this->load->view("admin/master/buka_tutup/v_index", $data);
  }

  function simpanBukaTutup()
  {
    $id         = $this->input->post('id');

    $tglmulai   = $this->input->post('xtglmulai');
    $xjambk     = $this->input->post('xbkjam');
    $xmenitbk   = $this->input->post('xbkmenit');
    $xdetikbk   = $this->input->post('xbkdetik');
    $jambuka    = $xjambk . $xmenitbk . $xdetikbk;

    $tgltutup   = $this->input->post('xtgltutup');
    $jamttp     = $this->input->post('xttpjam');
    $menittp    = $this->input->post('xttpmenit');
    $dtikttp    = $this->input->post('xttpdetik');
    $jamtutup   = $jamttp . $menittp . $dtikttp;

    $ket = $this->input->post('xketerangan', true);

    $tgl_update = date("y-m-d H:i:s");

    // Memulai transaksi
    $this->db->trans_start();

    $data = array(
      'mulai_tgl' => $tglmulai,
      'mulai_waktu' => $jambuka,
      'akhir_tgl' => $tgltutup,
      'akhir_waktu' => $jamtutup,
      'pesan' => $ket,
      'tgl_update' => $tgl_update
    );

    $this->db->where('id', $id);
    $this->db->update('buka_tutup', $data);

    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE) {
      // Jika terjadi kesalahan, rollback
      $this->db->trans_rollback();
      $this->session->set_flashdata('error', 'Gagal memperbarui data buka tutup.');
    } else {
      // Jika berhasil, commit
      $this->db->trans_commit();
      $this->session->set_flashdata('success', 'Data buka tutup berhasil diperbarui.');
    }

    redirect(base_url() . 'admin/buka-tutup');
  }
}
