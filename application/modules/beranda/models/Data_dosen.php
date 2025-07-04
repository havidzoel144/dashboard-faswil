<?php
defined('BASEPATH') or exit('No dirext script access allowed');

class Data_dosen extends CI_Model
{
    public function getTotalRecords()
    {
        $this->db->select('*');
        $this->db->from('data_dosen');

        return $this->db->get()->num_rows();
    }

    public function getFilteredRecords($search, $columnSearch, $kode_pt, $columnSearchJafung, $nm_stat_aktif)
    {
        // Query untuk menghitung jumlah rekord hasil join dengan pencarian
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
            $this->db->or_like('nm_stat_aktif', $search);
            $this->db->group_end();
        }

        // if (!empty($columnSearchJafung)) {
        //     if ($columnSearchJafung == "Tenaga Pengajar") {
        //         $this->db->where('nm_jabatan', null);
        //     } else if ($columnSearchJafung != "-") {
        //         $this->db->where('nm_jabatan', $columnSearchJafung);
        //     }
        // }

        if (!empty($columnSearchJafung)) {
            $this->db->group_start();
            foreach ($columnSearchJafung as $jabatan) {
                if ($jabatan == "kosong") {
                    $this->db->or_where('nm_jabatan', null);
                } else {
                    $this->db->or_where('nm_jabatan', $jabatan);
                }
            }
            $this->db->group_end();
        }

        if (!empty($nm_stat_aktif)) {
            $this->db->group_start();
            foreach ($nm_stat_aktif as $status) {
                if ($status == "kosong") {
                    $this->db->or_where('nm_stat_aktif', null);
                } else {
                    $this->db->or_where('nm_stat_aktif', $status);
                }
            }
            $this->db->group_end();
        }

        if (!empty($kode_pt)) {
            $this->db->where('kode_pt = "' . $kode_pt . '"');
        }
        // if (!empty($nm_stat_aktif)) {
        //     $this->db->where('nm_stat_aktif = "' . $nm_stat_aktif . '"');
        // }

        // Tambahkan pencarian per kolom
        foreach ($columnSearch as $key => $value) {
            if (!empty($value)) {
                $this->db->like($key, $value);
            }
        }

        return $this->db->get()->num_rows();
    }

    public function getData($start, $length, $search, $columnSearch, $order, $kode_pt, $columnSearchJafung, $nm_stat_aktif)
    {
        // Query untuk menghitung jumlah rekord hasil join dengan pencarian
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
            $this->db->or_like('nm_stat_aktif', $search);
            $this->db->group_end();
        }

        // if (!empty($columnSearchJafung)) {
        //     if ($columnSearchJafung == "Tenaga Pengajar") {
        //         $this->db->where('nm_jabatan', null);
        //     } else if ($columnSearchJafung != "-") {
        //         $this->db->where('nm_jabatan', $columnSearchJafung);
        //     }
        // }

        if (!empty($columnSearchJafung)) {
            $this->db->group_start();
            foreach ($columnSearchJafung as $jabatan) {
                if ($jabatan == "kosong") {
                    $this->db->or_where('nm_jabatan', null);
                } else {
                    $this->db->or_where('nm_jabatan', $jabatan);
                }
            }
            $this->db->group_end();
        }

        if (!empty($nm_stat_aktif)) {
            $this->db->group_start();
            foreach ($nm_stat_aktif as $status) {
                if ($status == "kosong") {
                    $this->db->or_where('nm_stat_aktif', null);
                } else {
                    $this->db->or_where('nm_stat_aktif', $status);
                }
            }
            $this->db->group_end();
        }

        if (!empty($kode_pt)) {
            $this->db->where('kode_pt = "' . $kode_pt . '"');
        }
        // if (!empty($nm_stat_aktif)) {
        //     $this->db->where('nm_stat_aktif = "' . $nm_stat_aktif . '"');
        // }

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
        $columns = ["", "nidn", "nama", "nm_pt", "nm_prodi", "nm_jabatan", "bidang_ilmu", "nm_stat_aktif"]; // Sesuaikan dengan urutan kolom di tabel Anda
        return $columns[$orderColumn] ?? null;
    }
}
