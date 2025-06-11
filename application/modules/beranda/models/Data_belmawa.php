<?php
defined('BASEPATH') or exit('No dirext script access allowed');

class Data_belmawa extends CI_Model
{
    public function getTotalRecords($tahun_akademik)
    {
        $this->db->select('*');
        $this->db->from('data_mbkm a');
        $this->db->where('a.id_smt', $tahun_akademik);
        $this->db->order_by("MID(kd_pt, 3, 2) = '10' DESC, MID(kd_pt, 3, 2) IN ('30', '31', '32') DESC");

        return $this->db->get()->num_rows();
    }

    public function getFilteredRecords($search, $columnSearch, $tahun_akademik)
    {
        // Query untuk menghitung jumlah rekord hasil join dengan pencarian
        $this->db->select('*');
        $this->db->from('data_mbkm a');
        $this->db->where('a.id_smt', $tahun_akademik);
        $this->db->order_by("MID(kd_pt, 3, 2) = '10' DESC, MID(kd_pt, 3, 2) IN ('30', '31', '32') DESC");

        // Hanya tambahkan pencarian umum jika $search tidak kosong
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('a.kd_pt', $search);
            $this->db->or_like('a.nm_pt', $search);
            $this->db->group_end();
        }

        // Tambahkan pencarian per kolom
        foreach ($columnSearch as $key => $value) {
            if (!empty($value)) {
                $this->db->like($key, $value);
            }
        }

        return $this->db->get()->num_rows();
    }

    public function getData($start, $length, $search, $columnSearch, $order, $tahun_akademik)
    {
        $this->db->select('a.*');
        $this->db->from('data_mbkm a');
        $this->db->where('a.id_smt', $tahun_akademik);
        $this->db->order_by("MID(kd_pt, 3, 2) = '10' DESC, MID(kd_pt, 3, 2) IN ('30', '31', '32') DESC");

        // Hanya tambahkan pencarian umum jika $search tidak kosong
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('a.kd_pt', $search);
            $this->db->or_like('a.nm_pt', $search);
            $this->db->group_end();
        }

        foreach ($columnSearch as $key => $value) {
            if (!empty($value)) {
                $this->db->like($key, $value);
            }
        }

        $this->db->limit($length, $start);

        // Menangani pengurutan
        if (!empty($order)) {
            $orderColumn    = $order[0]['column'];  // Index kolom
            $orderDir       = $order[0]['dir'];  // 'asc' atau 'desc'
            $this->db->order_by($this->getColumnOrderName($orderColumn), $orderDir);
        }

        return $this->db->get()->result();
    }

    // Fungsi untuk mendapatkan nama kolom berdasarkan index
    protected function getColumnOrderName($orderColumn)
    {
        $columns = ["", "a.kd_pt", "a.nm_pt", "a.jml_mhs_aktif", "a.jml_s1", "a.jml_d4", "a.jml_d3", "a.jml_d2", "a.jml_d1", "a.jml_mhs_mbkm", "a.presentase"]; // Sesuaikan dengan urutan kolom di tabel Anda
        return $columns[$orderColumn] ?? null;
    }

    public function grafik_data()
    {
        // Pertama, dapatkan daftar 'id_smt' yang diinginkan
        $this->db->select('a.id_smt');
        $this->db->from('data_mbkm AS a');
        $this->db->join('data_pt AS b', 'a.kd_pt = b.kode_pt', 'inner');
        $this->db->where("LEFT(a.id_smt, 4) > 2019");
        $this->db->group_by('a.id_smt');
        $this->db->having('SUM(a.jml_mhs_mbkm) > 0');
        $this->db->order_by('a.id_smt', 'DESC');
        $this->db->limit(7);
        $subquery_result = $this->db->get()->result_array();

        // Ekstrak 'id_smt' dari hasil subquery
        $id_smt_list = array_column($subquery_result, 'id_smt');

        // Query utama dengan daftar 'id_smt'
        $this->db->select('a.id_smt, SUM(a.jml_mhs_mbkm) AS jumlah, b.bentuk_pt');
        $this->db->from('data_mbkm AS a');
        $this->db->join('data_pt AS b', 'a.kd_pt = b.kode_pt', 'inner');

        if (!empty($id_smt_list)) {
            $this->db->where_in('a.id_smt', $id_smt_list);
        } else {
            // Mengembalikan array kosong jika subquery tidak mengembalikan hasil
            return [];
        }

        $this->db->group_by(array('a.id_smt', 'b.bentuk_pt'));
        $query = $this->db->get();
        return $query->result_array();
    }


    public function insert_kip_kuliah($data)
    {
        return $this->db->insert('data_kip_kuliah', $data);
    }

    public function delete_kip_kuliah($id)
    {
        // Pastikan ID yang akan dihapus ada di database
        $this->db->where('id', $id);
        return $this->db->delete('data_kip_kuliah'); // Hapus data dari tabel
    }

    // Fungsi untuk memperbarui data berdasarkan ID
    public function update_kip_kuliah($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('data_kip_kuliah', $data); // Update data di database
    }

    public function grafik_data_kip()
    {
        $this->db->select('a.*');
        $this->db->from('data_kip_kuliah AS a');
        $query = $this->db->get();
        return $query->result_array();
    }
}
