<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Periode_model extends CI_Model
{

  public function get_all_data_periode()
  {
    $this->db->select('*');
    $this->db->from('periode p');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function get_active_periode()
  {
    $this->db->select('*');
    $this->db->from('periode p');
    $this->db->where('p.status', '1');
    $query = $this->db->get();
    return $query->row();
  }

  // Insert user baru dan return ID
  public function insert_user($data)
  {
    $this->db->insert('users', $data);
    return $this->db->insert_id();
  }

  // Method untuk update data user
  public function update_user($user_id, $update_data)
  {
    $this->db->where('id', $user_id);
    return $this->db->update('users', $update_data); // Update data user di tabel 'users'
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
}
