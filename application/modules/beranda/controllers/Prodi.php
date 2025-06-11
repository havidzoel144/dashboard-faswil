<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Prodi extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        // Load library untuk memanipulasi view
        $this->load->library('javascript');
    }

    function index()
    {
        $data['prodi'] = "active";
        $data['kode_nama_pt'] = $this->db->query("SELECT `kode_pt`, `nm_pt` FROM `data_prodi` GROUP BY `kode_pt`, `nm_pt` ORDER BY CASE WHEN LOCATE(' ', `nm_pt`) > 0 THEN LEFT(`nm_pt`, LOCATE(' ', `nm_pt`) - 1) ELSE `nm_pt` END DESC, CASE WHEN LOCATE(' ', `nm_pt`) > 0 THEN SUBSTRING(`nm_pt`, LOCATE(' ', `nm_pt`) + 1)ELSE '' END ASC")->result_array();
        $data['kode_nama_prodi'] = $this->db->query("SELECT `kode_prodi`, `nama_prodi` FROM `data_prodi`GROUP BY `kode_prodi` ORDER BY `kode_prodi` DESC")->result_array();
        $data['program'] = $this->db->query("SELECT `program` FROM `data_prodi`GROUP BY `program` ORDER BY `program` ASC")->result_array();
        $data['akreditasi_prodi'] = $this->db->query("SELECT `akreditasi_prodi` FROM `data_prodi`GROUP BY `akreditasi_prodi` ORDER BY `akreditasi_prodi` ASC")->result_array();
        $data['tg'] = $this->db->query("SELECT tgl_update FROM data_prodi")->row();

        $this->load->view("v_prodi", $data);
    }

    function data_prodi()
    {
        $referer = $this->input->server('HTTP_REFERER');
        // Cek apakah referer berasal dari halaman yang diizinkan
        if (strpos($referer, base_url()) !== false) {
            $this->load->model('Data_prodi');

            $draw   = $this->input->post('draw');
            $start  = $this->input->post('start');
            $length = $this->input->post('length');
            $search = $this->input->post('search')['value'];
            $order  = $this->input->post('order');  // Menangkap data sorting

            $columnSearch = [
                'kode_pt' => $this->input->post('columns')[1]['search']['value'],
                'nm_pt' => $this->input->post('columns')[2]['search']['value'],
                'kode_prodi' => $this->input->post('columns')[3]['search']['value'],
                'nama_prodi' => $this->input->post('columns')[4]['search']['value'],
                // 'smt_mulai' => $this->input->post('columns')[7]['search']['value'],
                // 'akreditasi_pt' => $this->input->post('columns')[4]['search']['value']
            ];

            // $columnSearchProgram = $this->input->post('columns')[4]['search']['value'];
            $columnSearchProgram = $this->input->post('program');
            $columnSearchAkreditasi = $this->input->post('akreditasi_prodi');
            $tanggal_awal = $this->input->post('tanggal_awal');
            $tanggal_akhir = $this->input->post('tanggal_akhir');

            $list = $this->Data_prodi->getData($start, $length, $search, $columnSearch, $order, $columnSearchProgram, $columnSearchAkreditasi, $tanggal_awal, $tanggal_akhir);
            $data = array();
            $no   = $start;
            foreach ($list as $t) {
                $no++;
                $row = array();

                $row[] = $no;
                $row[] = $t->kode_pt;
                $row[] = $t->nm_pt;
                $row[] = $t->kode_prodi;
                $row[] = $t->nama_prodi;
                $row[] = $t->program;
                $row[] = $t->nm_stat_prodi;
                $row[] = $t->smt_mulai;
                $row[] = $t->akreditasi_prodi;
                $tgl_akhir_akre = $t->tgl_akhir_akred == '0000-00-00' ? '-' : $t->tgl_akhir_akred;
                $row[] = $tgl_akhir_akre;

                $data[] = $row;
            }

            $response = [
                'draw' => intval($draw),
                'recordsTotal' => $this->Data_prodi->getTotalRecords(),
                'recordsFiltered' => $this->Data_prodi->getFilteredRecords($search, $columnSearch, $columnSearchProgram, $columnSearchAkreditasi, $tanggal_awal, $tanggal_akhir),
                'data' => $data,
                'csrfHash' => $this->security->get_csrf_hash() // ← penting
            ];

            echo json_encode($response);
        } else {
            echo "access denied";
        }
    }
}
