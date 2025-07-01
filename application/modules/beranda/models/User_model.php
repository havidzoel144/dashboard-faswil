<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

  public function user_all()
  {
    // Cari user berdasarkan username
    $this->db->select('u.id AS user_id, u.nama, u.username, u.email,  u.password, u.status, ur.role_id, r.nama_role');
    $this->db->from('users u');
    $this->db->join('user_roles ur', 'u.id = ur.user_id');
    $this->db->join('roles r', 'ur.role_id = r.id');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function get_users_with_roles($allowed_ids_array)
  {
    $this->db->select('u.id, u.nama, u.username, u.email, u.status, GROUP_CONCAT(r.id ORDER BY r.id ASC SEPARATOR ", ") as role_id, GROUP_CONCAT(r.nama_role SEPARATOR ", ") as roles');
    $this->db->from('users u');
    $this->db->join('user_roles ur', 'u.id = ur.user_id', 'left');
    $this->db->join('roles r', 'ur.role_id = r.id', 'left');
    $this->db->where('ur.role_id IN ' . $allowed_ids_array); // $allowed_ids sudah dalam format string (1,2,3,...)
    $this->db->group_by('u.id');
    $query = $this->db->get();
    return $query->result();
  }

  public function check_login($username, $password)
  {
    // Cari user by username
    $this->db->select('id, nama, username, email, password, status');
    $this->db->from('users');
    $this->db->where('username', $username);
    $user_query = $this->db->get();

    if ($user_query->num_rows() != 1) {
      return false;
    }

    $user = $user_query->row();

    // Verifikasi password
    if (!password_verify($password, $user->password)) {
      return false;
    }

    // Ambil semua role user
    $this->db->select('r.id AS role_id, r.nama_role');
    $this->db->from('user_roles ur');
    $this->db->join('roles r', 'ur.role_id = r.id');
    $this->db->where('ur.user_id', $user->id);
    $roles = $this->db->get()->result();

    return [
      'user_id' => $user->id,
      'nama' => $user->nama,
      'username' => $user->username,
      'email' => $user->email,
      'status' => $user->status,
      'roles' => $roles
    ];
  }

  // Insert user baru dan return ID
  public function insert_user($data)
  {
    $this->db->insert('users', $data);
    return $this->db->insert_id();
  }

  // Insert relasi user-role ke tabel pivot user_roles
  public function insert_user_role($user_id, $role_id)
  {
    return $this->db->insert('user_roles', [
      'user_id' => $user_id,
      'role_id' => $role_id
    ]);
  }

  // Method untuk update data user
  public function update_user($user_id, $update_data)
  {
    $this->db->where('id', $user_id);
    return $this->db->update('users', $update_data); // Update data user di tabel 'users'
  }

  public function delete_user_roles($user_id)
  {
    $this->db->where('user_id', $user_id);
    return $this->db->delete('user_roles');  // Hapus semua role lama di user_roles
  }

  // Cek user dan password saat ini, return user object atau false
  public function check_current_password($user_id, $current_password)
  {
    $user = $this->db->get_where('users', ['id' => $user_id])->row();

    if ($user && password_verify($current_password, $user->password)) {
      return $user;
    }
    return false;
  }

  // Update password baru user
  public function update_password($user_id, $new_password)
  {
    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    $this->db->where('id', $user_id);
    return $this->db->update('users', ['password' => $password_hash]);
  }

  public function get_user_by_id($user_id)
  {
    return $this->db->get_where('users', ['id' => $user_id])->row();
  }

  public function delete_user($user_id)
  { // Hapus data user_roles yang terkait
    $this->db->where('user_id', $user_id);
    $this->db->delete('user_roles');

    return $this->db->delete('users', ['id' => $user_id]);
  }

  public function update_status($user_id, $status)
  {
    $this->db->where('id', $user_id);
    return $this->db->update('users', ['status' => $status]);
  }

  public function get_users_with_fasilitator_role()
  {
    $this->db->select('u.id, u.nama, u.username, u.email, u.status, GROUP_CONCAT(r.id ORDER BY r.id ASC SEPARATOR ", ") as role_id, GROUP_CONCAT(r.nama_role SEPARATOR ", ") as roles');
    $this->db->from('users u');
    $this->db->join('user_roles ur', 'u.id = ur.user_id', 'left');
    $this->db->join('roles r', 'ur.role_id = r.id', 'left');

    // Tambahkan subquery EXISTS untuk memastikan user punya role_id=4
    $this->db->where('EXISTS (SELECT 1 FROM user_roles WHERE user_id = u.id AND role_id = 4)', null, false);
    // $this->db->where('u.status', '1');

    $this->db->group_by('u.id');
    $query = $this->db->get();
    return $query->result();
  }

  public function get_users_with_validator_role()
  {
    $this->db->select('u.id, u.nama, u.username, u.email, u.status, GROUP_CONCAT(r.id ORDER BY r.id ASC SEPARATOR ", ") as role_id, GROUP_CONCAT(r.nama_role SEPARATOR ", ") as roles');
    $this->db->from('users u');
    $this->db->join('user_roles ur', 'u.id = ur.user_id', 'left');
    $this->db->join('roles r', 'ur.role_id = r.id', 'left');

    // Tambahkan subquery EXISTS untuk memastikan user punya role_id=5
    $this->db->where('EXISTS (SELECT 1 FROM user_roles WHERE user_id = u.id AND role_id = 5)', null, false);
    // $this->db->where('u.status', '1');

    $this->db->group_by('u.id');
    $query = $this->db->get();
    return $query->result();
  }
}
