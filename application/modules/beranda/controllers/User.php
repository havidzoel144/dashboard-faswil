<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MX_Controller
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

    $this->only_for_roles(['1']);
  }

  public function index()
  {
    $data = [
      'master' => 'active',
      'user' => 'active',
      'data_user' => $this->User_model->get_users_with_roles(),
      'data_role' => $this->db->query("SELECT * FROM `roles`")->result()
    ];

    $this->load->view("admin/master/user/v_index", $data);
  }

  public function simpanUser()
  {
    // Validasi akses
    $this->only_for_roles(['1']); // misal hanya admin superuser

    // Validasi sederhana
    // if (empty($nama) || empty($username) || empty($email) || empty($role)) {
    //   $this->session->set_flashdata('error', 'Mohon lengkapi semua field.');
    //   redirect('admin/data-user'); // ganti sesuai route kamu
    // }

    $this->form_validation->set_rules('nama', 'Nama User', 'required');
    $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('role_id[]', 'Role User', 'required'); // note: role_id[] karena multiple select

    if ($this->form_validation->run() == FALSE) {
      // Jika validasi gagal
      $errors = $this->form_validation->error_array();

      // Custom kata-kata error
      $custom_errors = [];
      foreach ($errors as $field => $message) {
        switch ($field) {
          case 'nama':
            $custom_errors[] = 'Nama User harus diisi.';
            break;
          case 'username':
            if (strpos($message, 'required') !== false) {
              $custom_errors[] = 'Username harus diisi.';
            } elseif (strpos($message, 'unique') !== false) {
              $custom_errors[] = 'Username sudah digunakan, silakan gunakan username lain.';
            } else {
              $custom_errors[] = $message;
            }
            break;
          case 'email':
            $custom_errors[] = 'Email harus diisi.';
            break;
          case 'role_id[]':
            $custom_errors[] = 'Role beluh dipilih.';
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
    $nama     = $this->input->post('nama');
    $username = $this->input->post('username');
    $email    = $this->input->post('email');
    $role_ids     = $this->input->post('role_id');
    $status   = $this->input->post('status') ? 1 : 0;
    $default_password = password_hash('admin123', PASSWORD_DEFAULT);

    // Siapkan data untuk insert
    $user_data = [
      'nama'     => $nama,
      'username' => $username,
      'email'    => $email,
      'password' => $default_password,
      'status'   => $status,
      'created_at' => date('Y-m-d H:i:s')
    ];

    // Insert ke DB
    $user_id = $this->User_model->insert_user($user_data);

    if (!$user_id) {
      $this->session->set_flashdata('error', 'Gagal menyimpan data user.');
      redirect($_SERVER['HTTP_REFERER']);
    }

    // Simpan multiple roles ke tabel pivot (misal user_roles)
    foreach ($role_ids as $role_id) {
      $this->User_model->insert_user_role($user_id, $role_id);
    }

    $this->session->set_flashdata('success', 'User berhasil disimpan.');
    redirect('admin/data-user');
  }

  public function updateUser()
  {
    // Validasi form
    $this->form_validation->set_rules('nama', 'Nama User', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('role_id[]', 'Role', 'required'); // role_id adalah array

    if ($this->form_validation->run() == FALSE) {
      // Jika validasi gagal
      $errors = $this->form_validation->error_array();

      // Custom kata-kata error
      $custom_errors = [];
      foreach ($errors as $field => $message) {
        switch ($field) {
          case 'nama':
            $custom_errors[] = 'Nama User harus diisi.';
            break;
          case 'email':
            $custom_errors[] = 'Email harus diisi.';
            break;
          case 'role_id[]':
            $custom_errors[] = 'Role belum dipilih.';
            break;
          default:
            $custom_errors[] = $message; // default pesan
            break;
        }
      }

      $this->session->set_flashdata('error_validation', $custom_errors);
      redirect($_SERVER['HTTP_REFERER']);
    }

    // Ambil data dari form
    $user_id = $this->input->post('id');
    $nama = $this->input->post('nama');
    $email = $this->input->post('email');
    $role_ids = $this->input->post('role_id'); // role_id yang bisa banyak
    $status = $this->input->post('status') == '1' ? 1 : 0;  // Status aktif (1) atau non-aktif (0)

    // Update data user di model
    $update_data = [
      'nama' => $nama,
      'email' => $email,
      'status' => $status
    ];

    // Update data user (nama, email, status)
    $update = $this->User_model->update_user($user_id, $update_data);

    if ($update) {
      // Hapus semua role lama user
      $this->User_model->delete_user_roles($user_id);

      // Insert role baru berdasarkan role_id yang dipilih
      foreach ($role_ids as $role_id) {
        $this->User_model->insert_user_role($user_id, $role_id);
      }

      $this->session->set_flashdata('success', 'Data user berhasil diperbarui.');
    } else {
      $this->session->set_flashdata('error', 'Gagal memperbarui data user.');
    }

    redirect('admin/data-user');  // Redirect setelah berhasil update
  }

  public function hapusUser($user_id)
  {
    if (!$user_id) {
      $this->session->set_flashdata('error', 'ID user tidak valid.');
      redirect('admin/data-user');
    }

    // Cek apakah user ada
    $user = $this->User_model->get_user_by_id($user_id);
    if (!$user) {
      $this->session->set_flashdata('error', 'User tidak ditemukan.');
      redirect('admin/data-user');
    }

    // Proses hapus user
    $delete = $this->User_model->delete_user($user_id);

    if ($delete) {
      $this->session->set_flashdata('success', 'User berhasil dihapus.');
    } else {
      $this->session->set_flashdata('error', 'Gagal menghapus user.');
    }

    redirect('admin/data-user');
  }

  public function resetPassword($user_id)
  {
    // Cek apakah user_id valid
    if (empty($user_id)) {
      $this->session->set_flashdata('error', 'ID user tidak valid.');
      redirect('admin/data-user');
    }

    // Load model user
    $user = $this->User_model->get_user_by_id($user_id);

    if (!$user) {
      $this->session->set_flashdata('error', 'User tidak ditemukan.');
      redirect('admin/data-user');
    }

    // Reset password (misalnya set password default)
    $new_password = 'admin123'; // atau bisa generate password baru

    // Update password user
    $update = $this->User_model->update_password($user_id, $new_password);

    if ($update) {
      $this->session->set_flashdata('success', 'Password berhasil direset.');
    } else {
      $this->session->set_flashdata('error', 'Gagal mereset password.');
    }

    redirect('admin/data-user');
  }

  public function updateStatusUser()
  {
    $user_id = $this->input->post('user_id');
    $status = $this->input->post('status');

    // Update status user di database
    $update = $this->User_model->update_status($user_id, $status);

    if ($update) {
      echo json_encode(['success' => true]);
    } else {
      echo json_encode(['success' => false]);
    }
  }
}
