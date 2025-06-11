<?php
defined('BASEPATH') or exit('No dirext script access allowed');

class Data_pt_baru extends CI_Model
{
    public function getTotalRecords()
    {
        $this->db->select('COUNT(*) as total_records');
        $this->db->from('data_pt a');
        $this->db->join('ref_status b', 'a.status_pt = b.kd_status', 'inner');
        $this->db->order_by("MID(kode_pt, 3, 2) = '10' DESC, MID(kode_pt, 3, 2) IN ('30', '31', '32') DESC");

        $query = $this->db->get();

        $result = $query->row();
        $totalRecords = $result->total_records;

        return $totalRecords;
    }

    public function getFilteredRecords($search, $columnSearch)
    {
        // Query untuk menghitung jumlah rekord hasil join dengan pencarian
        $this->db->select('COUNT(*) as total_records');
        $this->db->from('data_pt a');
        $this->db->join('ref_status b', 'a.status_pt = b.kd_status', 'inner');
        $this->db->order_by("MID(kode_pt, 3, 2) = '10' DESC, MID(kode_pt, 3, 2) IN ('30', '31', '32') DESC");

        // Hanya tambahkan pencarian umum jika $search tidak kosong
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('a.kode_pt', $search);
            $this->db->or_like('a.nama_pt', $search);
            $this->db->or_like('b.nm_status', $search);
            $this->db->or_like('a.akreditasi_pt', $search);
            $this->db->group_end();
        }

        // Tambahkan pencarian per kolom
        foreach ($columnSearch as $key => $value) {
            if (!empty($value)) {
                $this->db->like($key, $value);
            }
        }

        $query = $this->db->get();

        $result = $query->row();
        $totalRecords = $result->total_records;

        return $totalRecords;
    }

    public function getData($start, $length, $search, $columnSearch, $order)
    {
        $this->db->select('a.*, b.nm_status');
        $this->db->from('data_pt a');
        $this->db->join('ref_status b', 'a.status_pt = b.kd_status');
        $this->db->order_by("MID(kode_pt, 3, 2) = '10' DESC, MID(kode_pt, 3, 2) IN ('30', '31', '32') DESC");

        // Hanya tambahkan pencarian umum jika $search tidak kosong
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('a.kode_pt', $search);
            $this->db->or_like('a.nama_pt', $search);
            $this->db->or_like('b.nm_status', $search);
            $this->db->or_like('a.akreditasi_pt', $search);
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

        return $this->db->get()->result_array();
    }

    // Fungsi untuk mendapatkan nama kolom berdasarkan index
    protected function getColumnOrderName($orderColumn)
    {
        $columns = ["", "a.kode_pt", "a.nama_pt", "b.nm_status", "a.akreditasi_pt"]; // Sesuaikan dengan urutan kolom di tabel Anda
        return $columns[$orderColumn] ?? null;
    }
}
