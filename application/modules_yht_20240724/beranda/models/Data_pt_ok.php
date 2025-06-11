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

    public function getFilteredRecords($search, $columnSearch, $columnSearchAkreditasi)
    {
        $this->db->select("IF(a.akreditasi_pt = '', '(-)', a.akreditasi_pt) AS akreditasi_pt, 
                           a.bentuk_pt, 
                           a.kode_pt, 
                           a.nama_pt, 
                           a.status_pt, 
                           a.tgl_update, 
                           a.tgl_akhir_akred,
                           b.nm_status");
        $this->db->from('data_pt a');
        $this->db->join('ref_status b', 'a.status_pt = b.kd_status', 'inner');
        $this->db->order_by("MID(kode_pt, 3, 2) = '10' DESC, MID(kode_pt, 3, 2) IN ('30', '31', '32') DESC");

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('a.kode_pt', $search);
            $this->db->or_like('a.nama_pt', $search);
            $this->db->or_like('b.nm_status', $search);
            $this->db->or_like('a.akreditasi_pt', $search);
            $this->db->group_end();
        }

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

        foreach ($columnSearch as $key => $value) {
            if (!empty($value)) {
                $this->db->like($key, $value);
            }
        }

        return $this->db->get()->num_rows();
    }

    public function getData($start, $length, $search, $columnSearch, $order, $columnSearchAkreditasi)
    {
        $this->db->select("IF(a.akreditasi_pt = '', '(-)', a.akreditasi_pt) AS akreditasi_pt, 
                           a.bentuk_pt, 
                           a.kode_pt, 
                           a.nama_pt, 
                           a.status_pt, 
                           a.tgl_update,
                           a.tgl_akhir_akred, 
                           b.nm_status");
        $this->db->from('data_pt a');
        $this->db->join('ref_status b', 'a.status_pt = b.kd_status');
        $this->db->order_by("MID(kode_pt, 3, 2) = '10' DESC, MID(kode_pt, 3, 2) IN ('30', '31', '32') DESC");

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('a.kode_pt', $search);
            $this->db->or_like('a.nama_pt', $search);
            $this->db->or_like('b.nm_status', $search);
            $this->db->or_like('a.akreditasi_pt', $search);
            $this->db->group_end();
        }

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

        foreach ($columnSearch as $key => $value) {
            if (!empty($value)) {
                $this->db->like($key, $value);
            }
        }

        $this->db->limit($length, $start);

        if (!empty($order)) {
            $orderColumn = $order[0]['column'];
            $orderDir = $order[0]['dir'];
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
}
