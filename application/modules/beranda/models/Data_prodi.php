<?php
defined('BASEPATH') or exit('No dirext script access allowed');

class Data_prodi extends CI_Model
{
    public function getTotalRecords()
    {
        $this->db->select('*');
        $this->db->from('data_prodi a');
        // $this->db->join('ref_status b', 'a.status_pt = b.kd_status', 'inner');
        $this->db->order_by("MID(kode_pt, 3, 2) = '10' DESC, MID(kode_pt, 3, 2) IN ('30', '31', '32') DESC");

        return $this->db->get()->num_rows();
    }

    public function getFilteredRecords($search, $columnSearch, $columnSearchProgram, $columnSearchAkreditasi, $tanggal_awal, $tanggal_akhir)
    {
        // Query untuk menghitung jumlah rekord hasil join dengan pencarian
        $this->db->select('*');
        $this->db->from('data_prodi a');
        // $this->db->join('ref_status b', 'a.status_pt = b.kd_status', 'inner');
        $this->db->order_by("MID(kode_pt, 3, 2) = '10' DESC, MID(kode_pt, 3, 2) IN ('30', '31', '32') DESC");

        // Hanya tambahkan pencarian umum jika $search tidak kosong
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('a.kode_pt', $search);
            $this->db->or_like('a.nm_pt', $search);
            $this->db->or_like('a.kode_prodi', $search);
            $this->db->or_like('a.nama_prodi', $search);
            $this->db->or_like('a.program', $search);
            $this->db->or_like('a.nm_stat_prodi', $search);
            $this->db->or_like('a.smt_mulai', $search);
            $this->db->or_like('a.akreditasi_prodi', $search);
            $this->db->or_like('a.tgl_akhir_akred', $search);
            $this->db->group_end();
        }

        if (!empty($columnSearchProgram)) {
            $this->db->group_start();
            foreach ($columnSearchProgram as $program) {
                if ($program == "kosong") {
                    $this->db->or_where('a.program', "");
                } else {
                    $this->db->or_where('a.program', $program);
                }
            }
            $this->db->group_end();
        }

        if (!empty($columnSearchAkreditasi)) {
            $this->db->group_start();
            foreach ($columnSearchAkreditasi as $akreditasi) {
                if ($akreditasi == "kosong") {
                    $this->db->or_where('a.akreditasi_prodi', "");
                } else {
                    $this->db->or_where('a.akreditasi_prodi', $akreditasi);
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

    public function getData($start, $length, $search, $columnSearch, $order, $columnSearchProgram, $columnSearchAkreditasi, $tanggal_awal, $tanggal_akhir)
    {
        $this->db->select('a.*');
        $this->db->from('data_prodi a');
        // $this->db->join('ref_status b', 'a.status_pt = b.kd_status');
        $this->db->order_by("MID(kode_pt, 3, 2) = '10' DESC, MID(kode_pt, 3, 2) IN ('30', '31', '32') DESC");

        // Hanya tambahkan pencarian umum jika $search tidak kosong
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('a.kode_pt', $search);
            $this->db->or_like('a.nm_pt', $search);
            $this->db->or_like('a.kode_prodi', $search);
            $this->db->or_like('a.nama_prodi', $search);
            $this->db->or_like('a.program', $search);
            $this->db->or_like('a.nm_stat_prodi', $search);
            $this->db->or_like('a.smt_mulai', $search);
            $this->db->or_like('a.akreditasi_prodi', $search);
            $this->db->or_like('a.tgl_akhir_akred', $search);
            $this->db->group_end();
        }

        if (!empty($columnSearchProgram)) {
            $this->db->group_start();
            foreach ($columnSearchProgram as $program) {
                if ($program == "kosong") {
                    $this->db->or_where('a.program', "");
                } else {
                    $this->db->or_where('a.program', $program);
                }
            }
            $this->db->group_end();
        }

        if (!empty($columnSearchAkreditasi)) {
            $this->db->group_start();
            foreach ($columnSearchAkreditasi as $akreditasi) {
                if ($akreditasi == "kosong") {
                    $this->db->or_where('a.akreditasi_prodi', "");
                } else {
                    $this->db->or_where('a.akreditasi_prodi', $akreditasi);
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
        $columns = ["", "a.kode_pt", "a.nm_pt", "a.kode_prodi", "a.nama_prodi", "a.program", "a.nm_stat_prodi", "a.smt_mulai", "a.akreditasi_prodi", "a.tgl_akhir_akred"]; // Sesuaikan dengan urutan kolom di tabel Anda
        return $columns[$orderColumn] ?? null;
    }
}
