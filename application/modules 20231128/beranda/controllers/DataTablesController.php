<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DataTablesController extends MX_Controller
{
    public function index()
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

        $this->load->view("data_tables", $data);
    }

    public function data()
    {
        $this->load->model('DataModel');

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
        ];

        $totalRecords = $this->DataModel->getTotalRecords();
        $recordsFiltered = $this->DataModel->getFilteredRecords($search, $columnSearch);

        $data = $this->DataModel->getData($start, $length, $search, $columnSearch, $order);

        $response = [
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ];

        echo json_encode($response);
    }
}
