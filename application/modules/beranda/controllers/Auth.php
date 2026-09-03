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

  private function isAdminCanLoginAs()
  {
    $username = $this->session->userdata('username');
    // $roles = $this->session->userdata('roles');

    // if (!is_array($roles)) {
    //   return false;
    // }

    // foreach ($roles as $role) {
    //   if (
    //     isset($role['role_id']) &&
    //     in_array($role['role_id'], ['1'])
    //   ) {
    //     return true;
    //   }
    // }

    if ($username === 'admin-develop') {
      return true;
    }

    return false;
  }

  public function loginAs()
  {
    $user_id = safe_url_decrypt($this->input->post('user_id'));


    // Pastikan sudah login
    if (!$this->session->userdata('logged_in')) {
      redirect(base_url('login'));
    }

    // Jangan boleh impersonate lagi
    if ($this->session->userdata('login_as') === TRUE) {
      $this->session->set_flashdata(
        'error',
        'Anda sedang login sebagai user lain.'
      );

      redirect(base_url('admin/dashboard'));
    }

    if (!$this->isAdminCanLoginAs()) {
      show_error('Anda tidak memiliki hak untuk Login As.', 403);
    }

    // Ambil data user tujuan
    $user_data = $this->User_model->get_user_by_id_logged_in($user_id);

    if (!$user_data) {
      $this->session->set_flashdata(
        'error',
        'User tidak ditemukan.'
      );

      redirect($_SERVER['HTTP_REFERER'] ?? base_url('admin/user'));
    }

    // Pastikan user aktif
    if ($user_data['status'] == '0') {
      $this->session->set_flashdata(
        'error',
        'User tersebut tidak aktif.'
      );

      redirect($_SERVER['HTTP_REFERER'] ?? base_url('admin/user'));
    }

    // Simpan session admin asli
    $original_user = [
      'user_id'  => $this->session->userdata('user_id'),
      'nama'     => $this->session->userdata('nama'),
      'username' => $this->session->userdata('username'),
      'email'    => $this->session->userdata('email'),
      'roles'    => $this->session->userdata('roles'),
    ];

    // Ganti session dengan user tujuan
    $this->session->set_userdata([
      'user_id'       => $user_data['id'],
      'nama'          => $user_data['nama'],
      'username'      => $user_data['username'],
      'email'         => $user_data['email'],
      'roles'         => $user_data['roles'],
      'logged_in'     => TRUE,

      // Penanda bahwa sedang Login As
      'login_as'      => TRUE,
      'original_user' => $original_user,
    ]);

    $this->session->set_flashdata(
      'success-login',
      'Sekarang Anda login sebagai ' . $user_data['nama']
    );

    redirect(base_url('admin/dashboard'));
  }

  public function stopLoginAs()
  {
    if ($this->session->userdata('login_as') !== TRUE) {
      redirect(base_url('admin/dashboard'));
    }

    $original_user = $this->session->userdata('original_user');

    if (!$original_user) {
      // Kondisi abnormal, hapus session
      $this->session->sess_destroy();

      redirect(base_url('login'));
    }

    // Restore session admin
    $this->session->set_userdata([
      'user_id'  => $original_user['user_id'],
      'nama'     => $original_user['nama'],
      'username' => $original_user['username'],
      'email'    => $original_user['email'],
      'roles'    => $original_user['roles'],
      'logged_in' => TRUE,
    ]);

    // Hapus informasi impersonate
    $this->session->unset_userdata([
      'login_as',
      'original_user'
    ]);

    $this->session->set_flashdata(
      'success-login',
      'Anda kembali login sebagai ' . $original_user['nama']
    );

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
