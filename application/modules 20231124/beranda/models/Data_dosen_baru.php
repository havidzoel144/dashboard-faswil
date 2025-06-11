<?php
defined('BASEPATH') or exit('No dirext script access allowed');

class Data_dosen_baru extends CI_Model
{
    public function getTotalRecords()
    {
        return $this->db->count_all('data_dosen');
    }

    public function getFilteredRecords($search, $columnSearch)
    {
        // Hanya tambahkan pencarian umum jika $search tidak kosong
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nidn', $search);
            $this->db->or_like('nama', $search);
            $this->db->or_like('nm_pt', $search);
            $this->db->or_like('nm_prodi', $search);
            $this->db->or_like('nm_jabatan', $search);
            $this->db->or_like('bidang_ilmu', $search);
            $this->db->group_end();
        }

        // Tambahkan pencarian per kolom
        foreach ($columnSearch as $key => $value) {
            if (!empty($value)) {
                $this->db->like($key, $value);
            }
        }

        return $this->db->count_all_results('data_dosen');
    }


    public function getData($start, $length, $search, $columnSearch, $order)
    {
        $this->db->select('*');
        $this->db->from('data_dosen');

        // Hanya tambahkan pencarian umum jika $search tidak kosong
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nidn', $search);
            $this->db->or_like('nama', $search);
            $this->db->or_like('nm_pt', $search);
            $this->db->or_like('nm_prodi', $search);
            $this->db->or_like('nm_jabatan', $search);
            $this->db->or_like('bidang_ilmu', $search);
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
    public function getColumnOrderName($orderColumn)
    {
        $columns = ["", "nidn", "nama", "nm_pt", "nm_prodi", "nm_jabatan", "bidang_ilmu", "nm_stat_aktif"]; // Sesuaikan dengan urutan kolom di tabel Anda
        return $columns[$orderColumn] ?? null;
    }
}
