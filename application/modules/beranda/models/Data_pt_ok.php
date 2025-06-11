<?php
defined('BASEPATH') or exit('No dirext script access allowed');

class Data_pt_ok extends CI_Model
{
    public function getTotalRecords()
    {
        $this->db->select('*');
        $this->db->from('data_pt a');
        $this->db->join('ref_status b', 'a.status_pt = b.kd_status', 'inner');
        $this->db->order_by("MID(kode_pt, 3, 2) = '10' DESC, MID(kode_pt, 3, 2) IN ('30', '31', '32') DESC");

        return $this->db->get()->num_rows();
    }

    public function getFilteredRecords($search, $columnSearch, $columnSearchAkreditasi, $tanggal_awal, $tanggal_akhir)
    {
        // Query untuk menghitung jumlah rekord hasil join dengan pencarian
        $this->db->select('*');
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

        // if (!empty($columnSearchAkreditasi)) {
        //     if ($columnSearchAkreditasi == "kosong") {
        //         $this->db->where('a.akreditasi_pt', "");
        //     } else if ($columnSearchAkreditasi != "-") {
        //         $this->db->where('a.akreditasi_pt', $columnSearchAkreditasi);
        //     }
        // }

        if (!empty($columnSearchAkreditasi)) {
            $this->db->group_start();
            foreach ($columnSearchAkreditasi as $akreditasi) {
                if ($akreditasi == "kosong") {
                    $this->db->or_where('a.akreditasi_pt', "");
                } else {
                    $this->db->or_where('a.akreditasi_pt', $akreditasi);
                }
            }
            $this->db->group_end();
        }

        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $this->db->where('a.tgl_akhir_akred BETWEEN "' . $tanggal_awal . '" AND "' . $tanggal_akhir . '"');
        }

        // Tambahkan pencarian per kolom
        foreach ($columnSearch as $key => $value) {
            if (!empty($value)) {
                $this->db->like($key, $value);
            }
        }

        return $this->db->get()->num_rows();
    }

    public function getData($start, $length, $search, $columnSearch, $order, $columnSearchAkreditasi, $tanggal_awal, $tanggal_akhir)
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

        // if (!empty($columnSearchAkreditasi)) {
        //     if ($columnSearchAkreditasi == "kosong") {
        //         $this->db->where('a.akreditasi_pt', "");
        //     } else if ($columnSearchAkreditasi != "-") {
        //         $this->db->where('a.akreditasi_pt', $columnSearchAkreditasi);
        //     }
        // }

        if (!empty($columnSearchAkreditasi)) {
            $this->db->group_start();
            foreach ($columnSearchAkreditasi as $akreditasi) {
                if ($akreditasi == "kosong") {
                    $this->db->or_where('a.akreditasi_pt', "");
                } else {
                    $this->db->or_where('a.akreditasi_pt', $akreditasi);
                }
            }
            $this->db->group_end();
        }

        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $this->db->where('a.tgl_akhir_akred BETWEEN "' . $tanggal_awal . '" AND "' . $tanggal_akhir . '"');
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
        $columns = ["", "a.kode_pt", "a.nama_pt", "b.nm_status", "a.akreditasi_pt", "a.tgl_akhir_akred"]; // Sesuaikan dengan urutan kolom di tabel Anda
        return $columns[$orderColumn] ?? null;
    }

    public function get_all_data_pt()
    {
        $this->db->select('pt.kode_pt, pt.nama_pt');
        $this->db->from('data_pt pt');
        $query = $this->db->get();
        return $query->result();
    }
}
