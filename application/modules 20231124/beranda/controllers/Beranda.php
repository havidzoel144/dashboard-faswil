<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Beranda extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        // Load library untuk memanipulasi view
        $this->load->library('javascript');
    }

    function index()
    {
        $data['pt'] = "active";

        // Data untuk chart
        $data['data'] = array(
            'universitas' => $this->db->query("SELECT * FROM data_pt WHERE MID(`kode_pt`,3,2)='10'")->num_rows(),
            'sekolah_tinggi' => $this->db->query("SELECT * FROM data_pt WHERE MID(`kode_pt`,3,2)IN('30','31','32')")->num_rows(),
            'politeknik' => $this->db->query("SELECT * FROM data_pt WHERE MID(`kode_pt`,3,2)IN('50')")->num_rows(),
            'institut' => $this->db->query("SELECT * FROM data_pt WHERE MID(`kode_pt`,3,2)IN('20')")->num_rows(),
            'akademik' => $this->db->query("SELECT * FROM data_pt WHERE MID(`kode_pt`,3,2)IN('40','41','42')")->num_rows(),
            'akademik_komunitas' => $this->db->query("SELECT * FROM data_pt WHERE MID(`kode_pt`,3,2)IN('60')")->num_rows()
        );


        $this->load->view("v_dashboard", $data);

        // $this->load->view("v_hor");
    }

    function data_pt()
    {
        $this->load->model('Data_pt');

        $list = $this->Data_pt->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $t) {
            $no++;
            $row = array();
            $row[] = '<center>' . $no . '</center>';
            $row[] = $t->kode_pt;
            $row[] = $t->nama_pt;
            $row[] = $t->status_pt;
            $row[] = $t->akreditasi_pt;
            $row[] = $t->bentuk_pt;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Data_pt->count_all(),
            "recordsFiltered" => $this->Data_pt->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function data_pt_baru()
    {
        $this->load->model('Data_pt_baru');

        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $search = $this->input->post('search')['value'];
        $order = $this->input->post('order');  // Menangkap data sorting

        $columnSearch = [
            'kode_pt' => $this->input->post('columns')[1]['search']['value'],
            'nama_pt' => $this->input->post('columns')[2]['search']['value'],
            'nm_status' => $this->input->post('columns')[3]['search']['value'],
            'akreditasi_pt' => $this->input->post('columns')[4]['search']['value']
        ];

        $totalRecords = $this->Data_pt_baru->getTotalRecords();
        $recordsFiltered = $this->Data_pt_baru->getFilteredRecords($search, $columnSearch);

        $data = $this->Data_pt_baru->getData($start, $length, $search, $columnSearch, $order);

        $response = [
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $recordsFiltered,
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
            'tp' => $this->db->query("SELECT * FROM data_dosen WHERE jabatan_no IN ('0','31')")->num_rows(),
        );

        $this->load->view("v_dosen", $data);
    }

    function data_dosen_lama()
    {
        $this->load->model('Data_dosen');

        $list = $this->Data_dosen->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $t) {
            $no++;
            $row = array();
            $row[] = '<center>' . $no . '</center>';
            $row[] = $t->nidn;
            $row[] = $t->nama;
            $row[] = $t->nm_pt;
            $row[] = $t->nm_prodi;
            $row[] = $t->nm_jabatan;
            $row[] = $t->bidang_ilmu;
            $row[] = '<center>' . $t->nm_stat_aktif . '</center>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Data_dosen->count_all(),
            "recordsFiltered" => $this->Data_dosen->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function data_dosen()
    {
        $this->load->model('Data_dosen_baru');

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
            'nm_jabatan' => $this->input->post('columns')[4]['search']['value'],
            'bidang_ilmu' => $this->input->post('columns')[5]['search']['value'],
        ];

        $totalRecords = $this->Data_dosen_baru->getTotalRecords();
        $recordsFiltered = $this->Data_dosen_baru->getFilteredRecords($search, $columnSearch);

        $data = $this->Data_dosen_baru->getData($start, $length, $search, $columnSearch, $order);

        $response = [
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ];

        echo json_encode($response);
    }

    function data_baru()
    {
        $d['a'] = $this->db->query('SELECT * FROM data_dosen limit 1000')->result();

        $this->load->view("data_baru", $d);
    }
}
