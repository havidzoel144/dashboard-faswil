<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Belmawa extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        // Load library untuk memanipulasi view
        $this->load->library('javascript');
    }

    function index()
    {
        $this->load->model('Data_belmawa');
        // echo  $tahun_akademik =  $this->cekTahunAkademik($this->getTahunAkademik());exit;
        $data['belmawa'] = "active";
        $data['kode_nama_pt'] = $this->db->query("SELECT `kode_pt`, `nm_pt` FROM `data_prodi` GROUP BY `kode_pt`, `nm_pt` ORDER BY CASE WHEN LOCATE(' ', `nm_pt`) > 0 THEN LEFT(`nm_pt`, LOCATE(' ', `nm_pt`) - 1) ELSE `nm_pt` END DESC, CASE WHEN LOCATE(' ', `nm_pt`) > 0 THEN SUBSTRING(`nm_pt`, LOCATE(' ', `nm_pt`) + 1)ELSE '' END ASC")->result_array();
        $data['grafik_data'] = $this->Data_belmawa->grafik_data();
        $data['grafik_data_kip'] = $this->Data_belmawa->grafik_data_kip();
        $data['data_kip_kuliah'] = $this->db->query("SELECT * FROM `data_kip_kuliah`")->result_array();

        // echo json_encode($data['grafik_data_kip']);exit;
        $data['tg'] = $this->db->query("SELECT tgl_update FROM data_mbkm")->row();

        $this->load->view("v_belmawa", $data);
    }

    function belmawa_new()
    {
        $this->load->model('Data_belmawa');
        // echo  $tahun_akademik =  $this->cekTahunAkademik($this->getTahunAkademik());exit;
        $data['belmawa'] = "active";
        $data['kode_nama_pt'] = $this->db->query("SELECT `kode_pt`, `nm_pt` FROM `data_prodi` GROUP BY `kode_pt`, `nm_pt` ORDER BY CASE WHEN LOCATE(' ', `nm_pt`) > 0 THEN LEFT(`nm_pt`, LOCATE(' ', `nm_pt`) - 1) ELSE `nm_pt` END DESC, CASE WHEN LOCATE(' ', `nm_pt`) > 0 THEN SUBSTRING(`nm_pt`, LOCATE(' ', `nm_pt`) + 1)ELSE '' END ASC")->result_array();
        $data['grafik_data'] = $this->Data_belmawa->grafik_data();
        $data['grafik_data_kip'] = $this->Data_belmawa->grafik_data_kip();
        $data['data_kip_kuliah'] = $this->db->query("SELECT * FROM `data_kip_kuliah`")->result_array();

        // echo json_encode($data['grafik_data_kip']);exit;
        $data['tg'] = $this->db->query("SELECT tgl_update FROM data_mbkm")->row();

        $this->load->view("v_belmawa_new", $data);
    }

    function getTahunAkademik()
    {
        // Mendapatkan tanggal hari ini
        $today = new DateTime();

        // Mendapatkan bulan dan tahun dari tanggal hari ini
        $bulan = (int)$today->format('m');
        $tahun = (int)$today->format('Y');

        // Logika untuk menentukan semester dan tahun akademik
        if ($bulan >= 9) {
            // Semester ganjil (September - Februari)
            $semester = 1;
        } elseif ($bulan >= 3 && $bulan <= 8) {
            // Semester genap (Maret - Agustus), menggunakan tahun akademik sebelumnya
            $semester = 2;
            $tahun--;
        } else {
            // Jika bulan Januari atau Februari, masih semester ganjil tapi menggunakan tahun sebelumnya
            $semester = 1;
            $tahun--;
        }

        // Menghasilkan kode tahun akademik
        $tahunAkademik = $tahun . $semester;

        return $tahunAkademik;
    }

    function cekTahunAkademik($tahunAkademik)
    {
        // Loop untuk mengurangi tahun akademik jika jml_mhs_mbkm = 0
        while (true) {
            // Query untuk mendapatkan sum(jml_mhs_mbkm) berdasarkan id_smt (tahunAkademik)
            $this->db->select_sum('jml_mhs_mbkm');
            $this->db->where('id_smt', $tahunAkademik);
            $query = $this->db->get('data_mbkm');

            // Mendapatkan hasil sum(jml_mhs_mbkm)
            $result = $query->row();

            // Jika sum(jml_mhs_mbkm) > 0, berhenti dan return tahunAkademik
            if ($result && $result->jml_mhs_mbkm > 0) {
                return $tahunAkademik;
            }

            // Jika sum(jml_mhs_mbkm) = 0, kurangi tahun akademiknya
            // Ambil tahun dan semester dari tahunAkademik saat ini
            $tahun = (int)substr($tahunAkademik, 0, 4); // Mengambil 4 digit pertama sebagai tahun
            $semester = (int)substr($tahunAkademik, 4, 1); // Mengambil digit ke-5 sebagai semester

            // Logika perubahan tahun dan semester
            if ($semester == 1) {
                // Jika semester 1, ubah jadi semester 2 tahun sebelumnya
                $semester = 2;
                $tahun--;
            } else {
                // Jika semester 2, ubah jadi semester 1 tahun yang sama
                $semester = 1;
            }

            // Update tahunAkademik dengan tahun dan semester yang baru
            $tahunAkademik = $tahun . $semester;
        }
    }

    function data_belmawa()
    {
        $this->load->model('Data_belmawa');

        $referer = $this->input->server('HTTP_REFERER');
        // Cek apakah referer berasal dari halaman yang diizinkan
        if (strpos($referer, base_url()) !== false) {
            $tahun_akademik =  $this->cekTahunAkademik($this->getTahunAkademik());

            $draw   = $this->input->post('draw');
            $start  = $this->input->post('start');
            $length = $this->input->post('length');
            $search = $this->input->post('search')['value'];
            $order  = $this->input->post('order');  // Menangkap data sorting

            $columnSearch = [
                'kd_pt' => $this->input->post('columns')[1]['search']['value']
            ];

            $list = $this->Data_belmawa->getData($start, $length, $search, $columnSearch, $order, $tahun_akademik);
            $data = array();
            $no   = $start;
            foreach ($list as $t) {
                $no++;
                $row = array();
                $row[] = '<center>' . $no . '</center>';
                $row[] = $t->kd_pt;
                $row[] = $t->nm_pt;
                $row[] = '<center>' . $t->jml_mhs_aktif . '</center>';
                $row[] = '<center>' . $t->jml_s1 . '</center>';
                $row[] = '<center>' . $t->jml_d4 . '</center>';
                $row[] = '<center>' . $t->jml_d3 . '</center>';
                $row[] = '<center>' . $t->jml_d2 . '</center>';
                $row[] = '<center>' . $t->jml_d1 . '</center>';
                $row[] = '<center>' . $t->jml_mhs_mbkm . '</center>';
                $row[] = '<center>' . $t->presentase . '</center>';

                $data[] = $row;
            }

            $response = [
                'draw' => intval($draw),
                'recordsTotal' => $this->Data_belmawa->getTotalRecords($tahun_akademik),
                'recordsFiltered' => $this->Data_belmawa->getFilteredRecords($search, $columnSearch, $tahun_akademik),
                'data' => $data,
                'csrfHash' => $this->security->get_csrf_hash() // ← penting
            ];

            echo json_encode($response);
        } else {
            echo "access denied";
        }
    }
}
