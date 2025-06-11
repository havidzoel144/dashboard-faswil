<?php
defined('BASEPATH') or exit('No dirext script access allowed');

class Data_penjaminan_mutu extends CI_Model
{
    public function getTotalRecords($periode = null)
    {
        $this->db->select('*');
        $this->db->from('data_penjaminan_mutu a');
        if (!empty($periode)) {
            $this->db->group_start();
            $this->db->or_where('a.periode', $periode);
            $this->db->group_end();
        }
        $this->db->order_by("MID(kode_pt, 3, 2) = '10' DESC, MID(kode_pt, 3, 2) IN ('30', '31', '32') DESC");

        return $this->db->get()->num_rows();
    }

    public function getFilteredRecords($search, $columnSearch, $periode)
    {
        // Query untuk menghitung jumlah rekord hasil join dengan pencarian
        $this->db->select('*');
        $this->db->from('data_penjaminan_mutu a');
        $this->db->order_by("MID(kode_pt, 3, 2) = '10' DESC, MID(kode_pt, 3, 2) IN ('30', '31', '32') DESC");

        // Hanya tambahkan pencarian umum jika $search tidak kosong
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('a.kode_pt', $search);
            $this->db->or_like('a.nama_pt', $search);
            $this->db->group_end();
        }

        if (!empty($periode)) {
            $this->db->group_start();
            $this->db->or_where('a.periode', $periode);
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

    public function getData($start, $length, $search, $columnSearch, $order, $periode)
    {
        $this->db->select('a.*');
        $this->db->from('data_penjaminan_mutu a');
        // $this->db->order_by("MID(kode_pt, 3, 2) = '10' DESC, MID(kode_pt, 3, 2) IN ('30', '31', '32') DESC");
        $this->db->order_by("periode ASC, MID(kode_pt, 3, 2) = '10' DESC, MID(kode_pt, 3, 2) IN ('30', '31', '32') DESC");

        // Hanya tambahkan pencarian umum jika $search tidak kosong
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('a.kode_pt', $search);
            $this->db->or_like('a.nama_pt', $search);
            $this->db->group_end();
        }

        if (!empty($periode)) {
            $this->db->group_start();
            $this->db->or_where('a.periode', $periode);
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
        $columns = ["", "", "a.kode_pt", "a.nama_pt", "", "", "", "a.skor_total", "a.tipologi", "a.akreditasi_institusi", "a.presentase_prodi_terakreditasi"]; // Sesuaikan dengan urutan kolom di tabel Anda
        return $columns[$orderColumn] ?? null;
    }

    public function getDataPemutu($kode_pt)
    {
        // $this->db->select('a.periode, a.skor_total');
        $this->db->select('a.*');
        $this->db->from('data_penjaminan_mutu a');
        $this->db->where('a.kode_pt', $kode_pt);
        $this->db->order_by("a.periode ASC");
        return $this->db->get()->result();
    }
}
