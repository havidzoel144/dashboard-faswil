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

  public function get_data_periode_by_fasilitator($fasilitator_id)
  {
    $this->db->select('p.*');
    $this->db->from('periode p');
    $this->db->join('penilaian_tipologi pt', 'p.kode = pt.periode');
    $this->db->where('pt.fasilitator_id', $fasilitator_id);
    $this->db->group_by('p.kode');
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
  public function insert_periode($data)
  {
    return $this->db->insert('periode', $data);
  }

  // Method untuk update data user
  public function update_periode($kode, $update_data)
  {
    $this->db->where('kode', $kode);
    return $this->db->update('periode', $update_data); // Update data user di tabel 'users'
  }

  public function get_periode_by_kode($kode)
  {
    return $this->db->get_where('periode', ['kode' => $kode])->row();
  }

  public function delete_periode($kode)
  {
    // Hapus data periode yang terkait
    return $this->db->delete('periode', ['kode' => $kode]);
  }

  public function update_status($kode, $status)
  {
    // Step 1: Set semua status jadi 0
    $this->db->update('periode', ['status' => 0]);

    $this->db->where('kode', $kode);
    return $this->db->update('periode', ['status' => $status]);
  }
}
