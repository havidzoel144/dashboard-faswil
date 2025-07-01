<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MX_Controller
{
  function __construct()
  {
    parent::__construct();
    // Load library untuk memanipulasi view
    $this->load->library('javascript');
    // Load model user
    $this->load->model('User_model');
  }

  function index()
  {
    if ($this->session->userdata('username')) {
      $this->session->set_flashdata('success-login', 'Anda sudah login');
      redirect(base_url('admin/dashboard'));
      // redirect(base_url('admin/data-kip-kuliah'));
    }

    $this->load->view("v_login");
  }

  public function postLogin()
  {
    // Ambil data dari form
    $username = $this->input->post('username');
    $password = $this->input->post('password');

    // Validasi input (harus diisi)
    if (empty($username) || empty($password)) {
      $this->session->set_flashdata('error', 'Username dan Password harus diisi.');
      redirect(base_url('login'));
    }

    // Cek login
    $user_data = $this->User_model->check_login($username, $password);

    if (!$user_data) {
      $this->session->set_flashdata('error', 'Username atau password salah.');
      redirect(base_url('login'));
    }

    if ($user_data['status'] == '0') {
      $this->session->set_flashdata('error', 'Akun anda tidak aktif, silakan hubungi admin.');
      redirect(base_url('login'));
    }

    // Siapkan data session, roles disimpan sebagai array
    $userdata = [
      'user_id' => $user_data['user_id'],
      'nama' => $user_data['nama'],
      'username' => $user_data['username'],
      'email' => $user_data['email'],
      'roles' => $user_data['roles'], // array roles
      'logged_in' => TRUE
    ];

    $this->session->set_userdata($userdata);
    $this->session->set_flashdata('success-login', 'Anda berhasil login');

    redirect(base_url('admin/dashboard'));
  }

  public function logout()
  {
    // Set flashdata sebelum session dihancurkan
    $this->session->set_flashdata('success', 'Anda berhasil logout.');

    // Hancurkan seluruh sesi (termasuk userdata)
    $this->session->sess_destroy();
    // $this->session->unset_userdata(array('user_id', 'username', 'role', 'logged_in'));

    // Redirect ke halaman login
    redirect(base_url());
  }
}
