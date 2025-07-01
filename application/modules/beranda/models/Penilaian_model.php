<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penilaian_model extends CI_Model
{

  public function get_all_data_penilaian()
  {
    // Cari user berdasarkan username
    $this->db->select('pt.*, uf.nama as nama_fasilitator, uv.nama as nama_validator, p.keterangan');
    $this->db->from('penilaian_tipologi pt');
    $this->db->join('users uf', 'uf.id = pt.fasilitator_id', 'left');
    $this->db->join('users uv', 'uv.id = pt.validator_id', 'left');
    $this->db->join('periode p', 'p.kode = pt.periode', 'left');
    $query = $this->db->get();
    return $query->result();
  }

  public function get_pt_not_plot($periode_aktif)
  {
    // Buat subquery (ambil kode_pt yang sudah ada di periode ini)
    $subquery = $this->db->select('kode_pt')
      ->from('penilaian_tipologi')
      ->where('periode', $periode_aktif)
      ->get_compiled_select();

    $this->db->select('dpt.kode_pt, dpt.nama_pt');
    $this->db->from('data_pt AS dpt');
    $this->db->where("dpt.kode_pt NOT IN ($subquery)", null, false);

    $query = $this->db->get();
    return $query->result();
  }

  public function get_data_pt_for_select($periode_aktif)
  {
    // Ambil semua PT
    $this->db->select('kode_pt, nama_pt');
    $query_all = $this->db->get('data_pt');
    $all_pts = $query_all->result(); // Sudah berupa array of objects

    // Ambil kode_pt yang sudah diplot
    $this->db->select('kode_pt');
    $this->db->from('penilaian_tipologi');
    $this->db->where('periode', $periode_aktif);
    $query_plotted = $this->db->get();
    $plotted_pts = array_column($query_plotted->result_array(), 'kode_pt'); // tetap array biasa

    // Susun hasil sebagai object
    $output = [];
    foreach ($all_pts as $pt) {
      $is_plotted = in_array($pt->kode_pt, $plotted_pts);

      $row = new stdClass();
      $row->kode_pt = $pt->kode_pt;
      $row->nama_pt = $is_plotted
        ? $pt->nama_pt . ' (Sudah diplot ke fasilitator lain)'
        : $pt->nama_pt;
      $row->disabled = $is_plotted;

      $output[] = $row;
    }

    // Return dalam bentuk JSON
    // header('Content-Type: application/json');
    return $output;
  }

  public function get_data_penilaian_by_fasilitator($fasilitator_id, $periode)
  {
    // Cari user berdasarkan username
    $this->db->select('pt.*, uf.nama as nama_fasilitator, uv.nama as nama_validator, p.keterangan, sp.nm_status');
    $this->db->from('penilaian_tipologi pt');
    $this->db->join('users uf', 'uf.id = pt.fasilitator_id', 'left');
    $this->db->join('users uv', 'uv.id = pt.validator_id', 'left');
    $this->db->join('periode p', 'p.kode = pt.periode', 'left');
    $this->db->join('status_penilaian sp', 'sp.id_status = pt.id_status_penilaian', 'left');
    $this->db->where('pt.fasilitator_id', $fasilitator_id);
    $this->db->where('pt.periode', $periode);
    $query = $this->db->get();
    return $query->result();
  }

  // public function update_penilaian($kode_pt, $fasilitator_id, $periode, $data)
  public function update_penilaian($id_penilaian_tipologi, $data)
  {
    // $this->db->where('kode_pt', $kode_pt);
    // $this->db->where('fasilitator_id', $fasilitator_id);
    // $this->db->where('periode', $periode);
    $this->db->where('id_penilaian_tipologi', $id_penilaian_tipologi);
    $this->db->update('penilaian_tipologi', $data);
  }

  public function get_data_penilaian_by_periode($periode)
  {
    // Cari user berdasarkan username
    $this->db->select('pt.*, uf.nama as nama_fasilitator, uv.nama as nama_validator, p.keterangan, sp.nm_status');
    $this->db->from('penilaian_tipologi pt');
    $this->db->join('users uf', 'uf.id = pt.fasilitator_id', 'left');
    $this->db->join('users uv', 'uv.id = pt.validator_id', 'left');
    $this->db->join('periode p', 'p.kode = pt.periode', 'left');
    $this->db->join('status_penilaian sp', 'sp.id_status = pt.id_status_penilaian', 'left');
    $this->db->where('pt.periode', $periode);
    $query = $this->db->get();
    return $query->result();
  }

  // public function getPenilaian($kode_pt, $fasilitator_id, $periode)
  public function getPenilaian($id_penilaian_tipologi)
  {
    $this->db->select('pt.*, uf.nama as nama_fasilitator, uv.nama as nama_validator, p.keterangan');
    $this->db->from('penilaian_tipologi pt');
    $this->db->join('users uf', 'uf.id = pt.fasilitator_id', 'left');
    $this->db->join('users uv', 'uv.id = pt.validator_id', 'left');
    $this->db->join('periode p', 'p.kode = pt.periode', 'left');
    // $this->db->where('pt.periode', $periode);
    // $this->db->where('pt.kode_pt', $kode_pt);
    // $this->db->where('pt.fasilitator_id', $fasilitator_id);
    $this->db->where('pt.id_penilaian_tipologi', $id_penilaian_tipologi);
    $query = $this->db->get();
    return $query->row();
  }

  public function get_data_penilaian_by_id($id)
  {
    $this->db->select('pt.*, uf.nama as nama_fasilitator, uv.nama as nama_validator, p.keterangan, sp.id_status, sp.nm_status');
    $this->db->from('penilaian_tipologi pt');
    $this->db->join('users uf', 'uf.id = pt.fasilitator_id', 'left');
    $this->db->join('users uv', 'uv.id = pt.validator_id', 'left');
    $this->db->join('periode p', 'p.kode = pt.periode', 'left');
    $this->db->join('status_penilaian sp', 'sp.id_status = pt.id_status_penilaian', 'left');
    $this->db->where('pt.id_penilaian_tipologi', $id);
    $query = $this->db->get();
    return $query->row();
  }

  public function delete_penilaian_by_id($id)
  {
    return $this->db->delete('penilaian_tipologi', ['id_penilaian_tipologi' => $id]);
  }
}
