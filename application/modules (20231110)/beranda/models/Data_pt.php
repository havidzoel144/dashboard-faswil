<?php
defined('BASEPATH') or exit('No dirext script access allowed');
class Data_pt extends CI_Model
{
    var $column_order = array("kode_pt", "nama_pt", "status_pt", "akreditasi_pt", "bentuk_pt"); //field yang ada di table database
    var $column_search = array("kode_pt", "nama_pt", "status_pt", "akreditasi_pt", "bentuk_pt"); //field yang diizinkan untuk pencarian harus menggunakan nama field pada table di database

    private function _get_datatables_query()
    {
        $this->db->select('*');
        $this->db->from('data_pt');
        $this->db->order_by('nama_pt', 'ASC');

        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->select('*');
        $this->db->from('data_pt');
        $this->db->order_by('nama_pt', 'ASC');

        return $this->db->count_all_results();
    }
}
