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

        // Data untuk chart
        $data['data'] = array(
            'universitas' => $this->db->query("SELECT * FROM data_pt WHERE MID(`kode_pt`,3,2)='10'")->num_rows(),
            'sekolah_tinggi' => $this->db->query("SELECT * FROM data_pt WHERE MID(`kode_pt`,3,2)IN('30','31','32')")->num_rows(),
            'politeknik' => $this->db->query("SELECT * FROM data_pt WHERE MID(`kode_pt`,3,2)IN('50')")->num_rows(),
            'institut' => $this->db->query("SELECT * FROM data_pt WHERE MID(`kode_pt`,3,2)IN('20')")->num_rows(),
            'akademik' => $this->db->query("SELECT * FROM data_pt WHERE MID(`kode_pt`,3,2)IN('40','41','42')")->num_rows(),
            'akademik_komunitas' => $this->db->query("SELECT * FROM data_pt WHERE MID(`kode_pt`,3,2)IN('60')")->num_rows()
        );

        $data['akreditasi_pt'] = $this->db->query("SELECT `akreditasi_pt` FROM `data_pt`GROUP BY `akreditasi_pt` ORDER BY `akreditasi_pt` DESC")->result_array();

        $data['tg'] = $this->db->query("SELECT tgl_update FROM data_pt")->row();

        $this->load->view("v_prodi", $data);
    }

    function data_pt_ok()
    {
        $this->load->model('Data_pt_ok');

        $draw   = $this->input->post('draw');
        $start  = $this->input->post('start');
        $length = $this->input->post('length');
        $search = $this->input->post('search')['value'];
        $order  = $this->input->post('order');  // Menangkap data sorting

        $columnSearch = [
            'kode_pt' => $this->input->post('columns')[1]['search']['value'],
            'nama_pt' => $this->input->post('columns')[2]['search']['value'],
            'nm_status' => $this->input->post('columns')[3]['search']['value'],
            // 'akreditasi_pt' => $this->input->post('columns')[4]['search']['value']
        ];

        $columnSearchAkreditasi = $this->input->post('columns')[4]['search']['value'];

        $list = $this->Data_pt_ok->getData($start, $length, $search, $columnSearch, $order, $columnSearchAkreditasi);
        $data = array();
        $no   = $start;
        foreach ($list as $t) {
            $no++;
            $row = array();

            $row[] = $no;
            $row[] = $t->kode_pt;
            $row[] = $t->nama_pt;
            $row[] = $t->nm_status;
            $row[] = $t->akreditasi_pt;

            $data[] = $row;
        }

        $response = [
            'draw' => intval($draw),
            'recordsTotal' => $this->Data_pt_ok->getTotalRecords(),
            'recordsFiltered' => $this->Data_pt_ok->getFilteredRecords($search, $columnSearch, $columnSearchAkreditasi),
            'data' => $data,
        ];

        echo json_encode($response);
    }

    function dosen()
    {
        $data['dosen'] = "active";

        // Data untuk chart
        $data['isi'] = array(
            'gb' => $this->db->query("SELECT * FROM data_dosen WHERE jabatan_no IN ('50','51')")->num_rows(),
            'lk' => $this->db->query("SELECT * FROM data_dosen WHERE jabatan_no IN ('46','47','48')")->num_rows(),
            'l' => $this->db->query("SELECT * FROM data_dosen WHERE jabatan_no IN ('43','44')")->num_rows(),
            'aa' => $this->db->query("SELECT * FROM data_dosen WHERE jabatan_no IN ('40','41')")->num_rows(),
            'tp' => $this->db->query("SELECT * FROM data_dosen WHERE jabatan_no IS NULL || jabatan_no IN ('0','31')")->num_rows(),
        );

        $data['dos'] = $this->db->query("SELECT tgl_update FROM data_dosen GROUP BY tgl_update")->row();

        $this->load->view("v_dosen", $data);
    }

    public function data_dosen()
    {
        $this->load->model('Data_dosen');

        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $search = $this->input->post('search')['value'];
        $order = $this->input->post('order');  // Menangkap data sorting

        $columnSearch = [
            'nidn' => $this->input->post('columns')[0]['search']['value'],
            'nama' => $this->input->post('columns')[1]['search']['value'],
            'nm_pt' => $this->input->post('columns')[2]['search']['value'],
            'nm_prodi' => $this->input->post('columns')[3]['search']['value'],
            // 'nm_jabatan' => $this->input->post('columns')[4]['search']['value'],
            'bidang_ilmu' => $this->input->post('columns')[5]['search']['value'],
            'nm_stat_aktif' => $this->input->post('columns')[6]['search']['value'],
        ];

        $columnSearchJafung = $this->input->post('columns')[4]['search']['value'];

        $list = $this->Data_dosen->getData($start, $length, $search, $columnSearch, $order, $columnSearchJafung);
        $data = array();
        $no   = $start;
        foreach ($list as $t) {
            $no++;
            $row = array();

            $row[] = $no;
            $row[] = $t->nidn;
            $row[] = $t->nama;
            $row[] = $t->nm_pt;
            $row[] = $t->nm_prodi;
            $row[] = $t->nm_jabatan;
            $row[] = $t->bidang_ilmu;
            $row[] = $t->nm_stat_aktif;

            $data[] = $row;
        }

        $response = [
            'draw' => intval($draw),
            'recordsTotal' => $this->Data_dosen->getTotalRecords(),
            'recordsFiltered' => $this->Data_dosen->getFilteredRecords($search, $columnSearch, $columnSearchJafung),
            'data' => $data,
        ];

        echo json_encode($response);
    }
}
