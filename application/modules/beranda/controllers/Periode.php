<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Periode extends MX_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->library(['javascript']);
    $this->load->model('Periode_model');
    date_default_timezone_set("Asia/Jakarta");

    if (!$this->session->userdata('username')) {
      $this->session->set_flashdata('error', 'Anda belum login.');
      redirect(base_url('login'));
    }

    $this->only_for_roles([2]);
  }

  public function index()
  {
    $data = [
      'master' => 'active',
      'periode' => 'active',
      'data_periode' => $this->Periode_model->get_all_data_periode(),
    ];

    $this->load->view("admin/master/periode/v_index", $data);
  }

  public function simpanPeriode()
  {
    $this->form_validation->set_rules('kode', 'Kode Periode', 'required|is_unique[periode.kode]');
    $this->form_validation->set_rules('keterangan', 'keterangan', 'required');

    if ($this->form_validation->run() == FALSE) {
      // Jika validasi gagal
      $errors = $this->form_validation->error_array();

      // Custom kata-kata error
      $custom_errors = [];
      foreach ($errors as $field => $message) {
        switch ($field) {
          case 'keterangan':
            $custom_errors[] = 'Keterangan  harus diisi.';
            break;
          case 'kode':
            if (strpos($message, 'required') !== false) {
              $custom_errors[] = 'Periode harus diisi.';
            } elseif (strpos($message, 'unique') !== false) {
              $custom_errors[] = 'Periode sudah digunakan, silakan gunakan periode lain.';
            } else {
              $custom_errors[] = $message;
            }
            break;
          default:
            $custom_errors[] = $message; // default pesan
            break;
        }
      }

      $this->session->set_flashdata('error_validation', $custom_errors);
      redirect($_SERVER['HTTP_REFERER']);
    }

    // Ambil data dari POST
    $kode       = $this->input->post('kode');
    $keterangan = $this->input->post('keterangan');
    // $status     = $this->input->post('status') ? 1 : 0;
    $status     = 0;

    // Siapkan data untuk insert
    $periode_data = [
      'kode'     => $kode,
      'keterangan' => $keterangan,
      'status'   => $status,
    ];

    // Insert ke DB
    $periode_id = $this->Periode_model->insert_periode($periode_data);

    if (!$periode_id) {
      $this->session->set_flashdata('error', 'Gagal menyimpan data periode.');
      redirect($_SERVER['HTTP_REFERER']);
    }

    $this->session->set_flashdata('success', 'Periode berhasil disimpan.');
    redirect('admin/data-periode');
  }

  public function updatePeriode()
  {
    $this->form_validation->set_rules('keterangan', 'keterangan', 'required');

    if ($this->form_validation->run() == FALSE) {
      // Jika validasi gagal
      $errors = $this->form_validation->error_array();

      // Custom kata-kata error
      $custom_errors = [];
      foreach ($errors as $field => $message) {
        switch ($field) {
          case 'keterangan':
            $custom_errors[] = 'Keterangan  harus diisi.';
            break;
          default:
            $custom_errors[] = $message; // default pesan
            break;
        }
      }

      $this->session->set_flashdata('error_validation', $custom_errors);
      redirect($_SERVER['HTTP_REFERER']);
    }

    // Ambil data dari POST
    $kode       = $this->input->post('kode');
    $keterangan = $this->input->post('keterangan');

    // Siapkan data untuk insert
    $update_data = [
      'kode'     => $kode,
      'keterangan' => $keterangan,
    ];

    // Update data user (nama, email, status)
    $update = $this->Periode_model->update_periode($kode, $update_data);

    if ($update) {
      $this->session->set_flashdata('success', 'Data periode berhasil diperbarui.');
    } else {
      $this->session->set_flashdata('error', 'Gagal memperbarui data periode.');
    }

    redirect('admin/data-periode');  // Redirect setelah berhasil update
  }

  public function hapusPeriode($kode)
  {
    if (!$kode) {
      $this->session->set_flashdata('error', 'Periode tidak valid.');
      redirect('admin/data-periode');
    }

    // Cek apakah periode ada
    $periode = $this->Periode_model->get_periode_by_kode($kode);
    if (!$periode) {
      $this->session->set_flashdata('error', 'Periode tidak ditemukan.');
      redirect('admin/data-periode');
    }

    // Proses hapus user
    $delete = $this->Periode_model->delete_periode($kode);

    if ($delete) {
      $this->session->set_flashdata('success', 'Periode berhasil dihapus.');
    } else {
      $this->session->set_flashdata('error', 'Gagal menghapus periode.');
    }

    redirect('admin/data-periode');
  }

  public function updateStatusPeriode()
  {
    $kode = $this->input->post('kode');
    $status = $this->input->post('status');

    // Update status user di database
    $update = $this->Periode_model->update_status($kode, $status);

    if ($update) {
      echo json_encode(['success' => true]);
    } else {
      echo json_encode(['success' => false]);
    }
  }
}
