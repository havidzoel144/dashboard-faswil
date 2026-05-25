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
      $kode_pt = trim($pt->kode_pt); // Hapus spasi di awal/akhir
      $is_plotted = in_array($kode_pt, $plotted_pts);

      $row = new stdClass();
      $row->kode_pt = $kode_pt;
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
    $this->db->order_by('pt.id_penilaian_tipologi', 'ASC');
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

  public function kirimNilai($periode, $id_penilaian, $fasilitator_id)
  {
    // Update status_penilaian menjadi 2 untuk penilaian_tipologi yang statusnya 1 pada periode dan fasilitator ini
    $this->db->where('periode', $periode);
    if ($id_penilaian !== 'semua') {
      $this->db->where('id_penilaian_tipologi', $id_penilaian);
    }
    $this->db->where('fasilitator_id', $fasilitator_id);
    $this->db->where('id_status_penilaian', '1');
    return $this->db->update('penilaian_tipologi', ['id_status_penilaian' => 2]);
  }

  public function prosesNilai($periode, $id_penilaian, $validator_id)
  {
    $this->db->select('id_penilaian_tipologi, cek_1, cek_2, cek_3, cek_4');
    $this->db->from('penilaian_tipologi');
    $this->db->where('periode', $periode);
    $this->db->where('validator_id', $validator_id);
    $this->db->where('id_status_penilaian', 5);

    if ($id_penilaian !== 'semua') {
      $this->db->where('id_penilaian_tipologi', $id_penilaian);
    }

    $query = $this->db->get();
    $rows = $query->result();

    if (!$rows) {
      return false;
    }

    $this->db->trans_begin();

    foreach ($rows as $row) {

      if ($row->cek_1 == "0" || $row->cek_2 == "0" || $row->cek_3 == "0" || $row->cek_4 == "0") {
        $status = 3; // revisi validator
      } else {
        $status = 4; // valid
      }

      $riwayatValidasi = $this->db->select('*')
        ->from('rwy_penilaian_validator')
        ->where('id_penilaian_tipologi', $row->id_penilaian_tipologi)
        ->order_by('id_rwy_pen_val', 'DESC')->limit(1)->get()->row();

      if ($riwayatValidasi) {
        $this->db->where('id_rwy_pen_val', $riwayatValidasi->id_rwy_pen_val);
        $this->db->update('rwy_penilaian_validator', [
          'id_status_penilaian' => $status
        ]);
      }

      $this->db->where('id_penilaian_tipologi', $row->id_penilaian_tipologi);
      $this->db->update('penilaian_tipologi', [
        'id_status_penilaian' => $status
      ]);
    }

    if ($this->db->trans_status() === false) {
      $this->db->trans_rollback();
      return false;
    }

    $this->db->trans_commit();

    return true;
  }

  public function publish_penilaian_by_periode($periode)
  {
    // Ambil semua data dari tabel data_pt sekali di awal
    $data_pt = $this->db->select('kode_pt, akreditasi_pt')->get('data_pt')->result_array();

    // Buat array indexed by kode_pt untuk pencarian cepat
    $pt_data = array();
    foreach ($data_pt as $pt) {
      $pt_data[trim($pt['kode_pt'])] = $pt['akreditasi_pt'];
    }

    // Query untuk menghitung total prodi, prodi aktif, dan persentase prodi aktif terakreditasi
    $this->db->select('kode_pt');
    $this->db->select('nm_pt');
    $this->db->select('COUNT(nama_prodi) AS total_prodi');
    $this->db->select('COUNT(CASE WHEN nm_stat_prodi = "Aktif" THEN 1 END) AS prodi_aktif');
    $this->db->select('COUNT(CASE WHEN nm_stat_prodi = "Aktif" AND akreditasi_prodi <> "-" AND akreditasi_prodi <> "" AND akreditasi_prodi <> "Tidak Terakreditasi" THEN 1 END) AS prodi_aktif_terakreditasi');
    $this->db->select('FORMAT((COUNT(CASE WHEN nm_stat_prodi = "Aktif" AND akreditasi_prodi <> "-" AND akreditasi_prodi <> "" AND akreditasi_prodi <> "Tidak Terakreditasi" THEN 1 END) / 
        COUNT(CASE WHEN nm_stat_prodi = "Aktif" THEN 1 END) * 100), 2) AS persentase_aktif_terakreditasi');
    $this->db->from('data_prodi');
    $this->db->group_by('kode_pt, nm_pt');

    // Eksekusi query dan dapatkan hasilnya
    $query = $this->db->get();
    $presentase = $query->result_array();

    // Buat array indexed by kode_pt untuk pencarian cepat
    $presentase_data = array();
    foreach ($presentase as $pres) {
      $presentase_data[trim($pres['kode_pt'])] = $pres['persentase_aktif_terakreditasi'];
    }

    // Ambil data penilaian
    $data = $this->db->select('periode, kode_pt, nama_pt, skor_1, skor_2, skor_3, skor_4, skor_total, tipologi')
      ->from('penilaian_tipologi')
      ->where('periode', $periode)
      ->get()
      ->result_array();

    // Tambahkan akreditasi_institusi dan presentase_prodi_terakreditasi ke setiap data penilaian
    foreach ($data as &$row) {
      $kode_pt = trim($row['kode_pt']);
      $row['akreditasi_institusi'] = isset($pt_data[$kode_pt]) ? $pt_data[$kode_pt] : null;
      $row['presentase_prodi_terakreditasi'] = isset($presentase_data[$kode_pt]) ? $presentase_data[$kode_pt] : null;
    }
    unset($row);

    // Proses insert/update ke tabel data_penjaminan_mutu
    $this->db->trans_start();
    foreach ($data as $row) {
      $where = [
        'periode' => $row['periode'],
        'kode_pt' => $row['kode_pt']
      ];
      $existing = $this->db->get_where('data_penjaminan_mutu', $where)->row();

      $data_mutu = [
        'periode' => $row['periode'],
        'kode_pt' => $row['kode_pt'],
        'nama_pt' => $row['nama_pt'],
        'skor_1' => $row['skor_1'],
        'skor_2' => $row['skor_2'],
        'skor_3' => $row['skor_3'],
        'skor_4' => $row['skor_4'],
        'skor_total' => $row['skor_total'],
        'tipologi' => $row['tipologi'],
        'akreditasi_institusi' => $row['akreditasi_institusi'],
        'presentase_prodi_terakreditasi' => $row['presentase_prodi_terakreditasi'],
        'tgl_update' => date('Y-m-d H:i:s'),
      ];

      if ($existing) {
        $this->db->where($where)->update('data_penjaminan_mutu', $data_mutu);
      } else {
        $this->db->insert('data_penjaminan_mutu', $data_mutu);
      }
    }
    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      return false;
    }
    return true;
  }

  public function publish_penilaian_by_pt($periode, $penilaian_id, $kode_pt)
  {
    // Ambil semua data dari tabel data_pt sekali di awal
    $data_pt = $this->db->select('kode_pt, akreditasi_pt')->where('kode_pt', $kode_pt)->get('data_pt')->result_array();

    // Buat array indexed by kode_pt untuk pencarian cepat
    $pt_data = array();
    foreach ($data_pt as $pt) {
      $pt_data[trim($pt['kode_pt'])] = $pt['akreditasi_pt'];
    }

    // Query untuk menghitung total prodi, prodi aktif, dan persentase prodi aktif terakreditasi
    $this->db->select('kode_pt');
    $this->db->select('nm_pt');
    $this->db->select('COUNT(nama_prodi) AS total_prodi');
    $this->db->select('COUNT(CASE WHEN nm_stat_prodi = "Aktif" THEN 1 END) AS prodi_aktif');
    $this->db->select('COUNT(CASE WHEN nm_stat_prodi = "Aktif" AND akreditasi_prodi <> "-" AND akreditasi_prodi <> "" AND akreditasi_prodi <> "Tidak Terakreditasi" THEN 1 END) AS prodi_aktif_terakreditasi');
    $this->db->select('FORMAT((COUNT(CASE WHEN nm_stat_prodi = "Aktif" AND akreditasi_prodi <> "-" AND akreditasi_prodi <> "" AND akreditasi_prodi <> "Tidak Terakreditasi" THEN 1 END) / 
        COUNT(CASE WHEN nm_stat_prodi = "Aktif" THEN 1 END) * 100), 2) AS persentase_aktif_terakreditasi');
    $this->db->from('data_prodi');
    $this->db->where('kode_pt', $kode_pt);
    $this->db->group_by('kode_pt, nm_pt');

    // Eksekusi query dan dapatkan hasilnya
    $query = $this->db->get();
    $presentase = $query->result_array();

    // Buat array indexed by kode_pt untuk pencarian cepat
    $presentase_data = array();
    foreach ($presentase as $pres) {
      $presentase_data[trim($pres['kode_pt'])] = $pres['persentase_aktif_terakreditasi'];
    }

    // Ambil data penilaian
    $data = $this->db->select('periode, kode_pt, nama_pt, skor_1, skor_2, skor_3, skor_4, skor_total, tipologi')
      ->from('penilaian_tipologi')
      ->where('periode', $periode)
      ->where('id_penilaian_tipologi', $penilaian_id)
      ->where('kode_pt', $kode_pt)
      ->get()
      ->result_array();

    // Tambahkan akreditasi_institusi dan presentase_prodi_terakreditasi ke setiap data penilaian
    foreach ($data as &$row) {
      $kode_pt = trim($row['kode_pt']);
      $row['akreditasi_institusi'] = isset($pt_data[$kode_pt]) ? $pt_data[$kode_pt] : null;
      $row['presentase_prodi_terakreditasi'] = isset($presentase_data[$kode_pt]) ? $presentase_data[$kode_pt] : null;
    }
    unset($row);

    // Proses insert/update ke tabel data_penjaminan_mutu
    $this->db->trans_start();
    foreach ($data as $row) {
      $where = [
        'periode' => $row['periode'],
        'kode_pt' => $row['kode_pt']
      ];
      $existing = $this->db->get_where('data_penjaminan_mutu', $where)->row();

      $data_mutu = [
        'periode' => $row['periode'],
        'kode_pt' => $row['kode_pt'],
        'nama_pt' => $row['nama_pt'],
        'skor_1' => $row['skor_1'],
        'skor_2' => $row['skor_2'],
        'skor_3' => $row['skor_3'],
        'skor_4' => $row['skor_4'],
        'skor_total' => $row['skor_total'],
        'tipologi' => $row['tipologi'],
        'akreditasi_institusi' => $row['akreditasi_institusi'],
        'presentase_prodi_terakreditasi' => $row['presentase_prodi_terakreditasi'],
        'tgl_update' => date('Y-m-d H:i:s'),
      ];

      if ($existing) {
        $this->db->where($where)->update('data_penjaminan_mutu', $data_mutu);
      } else {
        $this->db->insert('data_penjaminan_mutu', $data_mutu);
      }
    }
    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      return false;
    }
    return true;
  }

  public function ubahStatusPenilaian($id_penilaian, $status_penilaian = null)
  {
    // Update status_penilaian menjadi 4 untuk penilaian_tipologi yang statusnya 6 pada periode dan validator ini ATAU 
    // Update status_penilaian menjadi 6 untuk penilaian_tipologi yang statusnya 5 pada periode dan validator ini 
    $this->db->where('id_penilaian_tipologi', $id_penilaian);
    if ($status_penilaian === 'valid') {
      $this->db->where('id_status_penilaian', '4');
      return $this->db->update('penilaian_tipologi', ['id_status_penilaian' => 6]);
    } else if ($status_penilaian === 'menunggu') {
      $this->db->where('id_status_penilaian', '6');
      return $this->db->update('penilaian_tipologi', ['id_status_penilaian' => 5]);
    }
  }

  public function updateFaswilValidator($tipe, $periode, $id_awal, $id_pengganti, $perguruan_tinggi)
  {
    if ($tipe === 'fasilitator') {
      // Cek apakah ada fasilitator dengan id_awal di periode tersebut
      $check = $this->db->where('periode', $periode)
        ->where('fasilitator_id', $id_awal)
        ->get('penilaian_tipologi')
        ->num_rows();

      if ($check === 0) {
        echo json_encode([
          'status' => 'error',
          'message' => 'Fasilitator tidak diplotting pada periode ini.'
        ]);
        // return false;
      }

      $data = [
        'fasilitator_id' => $id_pengganti
      ];

      if (!empty($perguruan_tinggi)) {
        $this->db->where_in('kode_pt', $perguruan_tinggi);
      }

      $this->db->where('periode', $periode);
      $this->db->where('fasilitator_id', $id_awal);
      return $this->db->update('penilaian_tipologi', $data);
    } else if ($tipe === 'validator') {
      // Cek apakah ada validator dengan id_awal di periode tersebut
      $check = $this->db->where('periode', $periode)
        ->where('validator_id', $id_awal)
        ->get('penilaian_tipologi')
        ->num_rows();

      if ($check === 0) {
        echo json_encode([
          'status' => 'error',
          'message' => 'Validator tidak diplotting pada periode ini.'
        ]);
        // return false;
      }

      $data = [
        'validator_id' => $id_pengganti
      ];

      if (!empty($perguruan_tinggi)) {
        $this->db->where_in('kode_pt', $perguruan_tinggi);
      }

      $this->db->where('periode', $periode);
      $this->db->where('validator_id', $id_awal);
      return $this->db->update('penilaian_tipologi', $data);
    }
  }

  public function getPtBinaanFasilitatorByPeriode($periode, $fasilitator_id)
  {
    $this->db->select('kode_pt, nama_pt');
    $this->db->from('penilaian_tipologi');
    $this->db->where('periode', $periode);
    $this->db->where('fasilitator_id', $fasilitator_id);
    $this->db->order_by('nama_pt', 'ASC');
    return $query = $this->db->get()->result_array();
    // return array_column($query->result_array(), 'kode_pt');
  }

  public function getPtBinaanValidatorByPeriode($periode, $validator_id)
  {
    $this->db->select('kode_pt, nama_pt');
    $this->db->from('penilaian_tipologi');
    $this->db->where('periode', $periode);
    $this->db->where('validator_id', $validator_id);
    $this->db->order_by('nama_pt', 'ASC');
    return $query = $this->db->get()->result_array();
    // return array_column($query->result_array(), 'kode_pt');
  }

  public function is_penilaian_published($periode)
  {
    $query = $this->db
      ->select('kode_pt')
      ->from('data_penjaminan_mutu_30')
      ->where('periode', $periode)
      ->get()
      ->result_array();

    return array_column($query, 'kode_pt');
  }
  
  public function statistikProdi($kode_pt)
  {
    $this->db->select('kode_pt');
    $this->db->select('nm_pt');
    $this->db->select('tgl_update');
    $this->db->select('COUNT(CASE WHEN nm_stat_prodi = "Aktif" THEN 1 END) AS total_prodi_aktif');
    $this->db->select('COUNT(CASE WHEN nm_stat_prodi = "Aktif" AND akreditasi_prodi <> "-" AND akreditasi_prodi <> "" AND akreditasi_prodi <> "Tidak Terakreditasi" THEN 1 END) AS prodi_terakreditasi');
    $this->db->select('COUNT(CASE WHEN nm_stat_prodi = "Aktif" AND (akreditasi_prodi = "Unggul" OR akreditasi_prodi = "A") THEN 1 END) AS prodi_unggul_atau_a');

    $this->db->select('(COUNT(CASE WHEN nm_stat_prodi = "Aktif" AND (akreditasi_prodi = "Unggul" OR akreditasi_prodi = "A") THEN 1 END) / COUNT(CASE WHEN nm_stat_prodi = "Aktif" THEN 1 END)) * 100 AS persentase_unggul_atau_a');

    $this->db->from('data_prodi');
    $this->db->where('kode_pt', $kode_pt);

    $data = $this->db->get()->row_array();
    return $data;
  }
}
