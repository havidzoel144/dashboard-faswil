<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjaminan_mutu extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        // Load library untuk memanipulasi view
        $this->load->library('javascript');
        $this->load->model('Data_penjaminan_mutu');
    }

    function index()
    {
        $data['pm'] = "active";
        $data['kode_nama_pt'] = $this->db->query("SELECT `kode_pt`, `nm_pt` FROM `data_prodi` GROUP BY `kode_pt`, `nm_pt` ORDER BY CASE WHEN LOCATE(' ', `nm_pt`) > 0 THEN LEFT(`nm_pt`, LOCATE(' ', `nm_pt`) - 1) ELSE `nm_pt` END DESC, CASE WHEN LOCATE(' ', `nm_pt`) > 0 THEN SUBSTRING(`nm_pt`, LOCATE(' ', `nm_pt`) + 1)ELSE '' END ASC")->result_array();

        $data['data_penjaminan_mutu'] = $this->db->query("SELECT * FROM `data_penjaminan_mutu`")->result_array();
        $data['tg'] = $this->db->query("SELECT tgl_update FROM data_penjaminan_mutu")->row();

        // $data['data'] = array(
        //     'tipologi_1' => $this->db->query("SELECT * FROM data_penjaminan_mutu WHERE tipologi = 'Tipologi 1' AND periode = $this->getPeriode()")->num_rows(),
        //     'tipologi_2' => $this->db->query("SELECT * FROM data_penjaminan_mutu WHERE tipologi = 'Tipologi 2' AND periode = $this->getPeriode()")->num_rows(),
        //     'tipologi_3' => $this->db->query("SELECT * FROM data_penjaminan_mutu WHERE tipologi = 'Tipologi 3' AND periode = $this->getPeriode()")->num_rows(),
        //     'tipologi_4' => $this->db->query("SELECT * FROM data_penjaminan_mutu WHERE tipologi = 'Tipologi 4' AND periode = $this->getPeriode()")->num_rows(),
        // );

        $this->db->select_max('periode');
        $query = $this->db->get('data_penjaminan_mutu');
        $periode_max = $query->row_array(); // Ambil hasil sebagai array
        $prd = $periode_max['periode'];

        $data['data'] = $this->db->query("SELECT COUNT(a.`tipologi`) AS jumlah_tipologi, a.`tipologi`, a.`periode`,(SELECT COUNT(*) FROM `data_penjaminan_mutu` AS b WHERE b.periode = '$prd') AS total_data, ROUND( ( COUNT(a.`tipologi`) / (SELECT COUNT(*) FROM `data_penjaminan_mutu` AS b WHERE b.periode = '$prd') * 100 ), 1) AS persentase FROM `data_penjaminan_mutu` AS a WHERE a.`periode` = '$prd' GROUP BY a.`tipologi`, a.`periode`;")->result();

        $data['tg'] = $this->db->query("SELECT tgl_update FROM data_pt")->row();

        $this->load->view("v_penjaminan_mutu", $data);
    }

    function data_penjaminan_mutu()
    {
        $referer = $this->input->server('HTTP_REFERER');
        // Cek apakah referer berasal dari halaman yang diizinkan
        if (strpos($referer, base_url()) !== false) {
            $this->load->model('Data_penjaminan_mutu');

            $draw   = $this->input->post('draw');
            $start  = $this->input->post('start');
            $length = $this->input->post('length');
            $search = $this->input->post('search')['value'];
            $order  = $this->input->post('order');  // Menangkap data sorting

            $columnSearch = [
                'kode_pt' => $this->input->post('columns')[1]['search']['value'],
                'nama_pt' => $this->input->post('columns')[2]['search']['value'],
            ];

            // $periode = $this->input->post('periode');
            $this->db->select_max('periode');
            $query = $this->db->get('data_penjaminan_mutu');
            $periode_max = $query->row_array(); // Ambil hasil sebagai array
            $periode = $periode_max['periode'];

            // Konversi hasil ke JSON dan kirim ke browser
            // echo json_encode($periode);
            // exit;

            // $list = $this->Data_penjaminan_mutu->getData($start, $length, $search, $columnSearch, $order, $periode);
            $list = $this->Data_penjaminan_mutu->getData($start, $length, $search, $columnSearch, $order);
            $data = array();
            $no   = $start;
            foreach ($list as $t) {
                $no++;
                $row = array();

                $row[] = '<center>' . $no;
                $periode_post = substr($t->periode, -1, 1) == '1' ? substr($t->periode, 0, 4) . ' Periode 1' : substr($t->periode, 0, 4) . ' Periode 2';
                $row[] = '<center>' . $periode_post . '</center>';
                $row[] = '<center>' . $t->kode_pt . '</center>';
                $row[] = $t->nama_pt;
                $row[] = '<center>' . $t->skor_1a . '</center>';
                $row[] = '<center>' . $t->skor_1b . '</center>';
                $row[] = '<center>' . $t->skor_2 . '</center>';
                $row[] = '<center>' . $t->skor_total . '</center>';
                $row[] = '<center>' . $t->tipologi . '</center>';
                $row[] = '<center>' . $t->akreditasi_institusi . '</center>';
                $row[] = '<center>' . $t->presentase_prodi_terakreditasi . '</center>';

                $data[] = $row;
            }

            $response = [
                'draw' => intval($draw),
                'recordsTotal' => $this->Data_penjaminan_mutu->getTotalRecords($periode),
                'recordsFiltered' => $this->Data_penjaminan_mutu->getFilteredRecords($search, $columnSearch, $periode),
                'data' => $data,
                'csrfHash' => $this->security->get_csrf_hash() // ← penting
            ];

            echo json_encode($response);
        } else {
            echo "access denied";
        }
    }

    public function get_data_pt()
    {
        // Pastikan ini adalah permintaan AJAX
        if ($this->input->is_ajax_request()) {
            $kode_pt = $this->input->post('kode_pt'); // Ambil data POST

            $data_pemutu = $this->Data_penjaminan_mutu->getDataPemutu($kode_pt);

            // Format respons JSON
            if (!empty($data_pemutu)) {
                echo json_encode([
                    'success' => true,
                    'data' => $data_pemutu,
                    'csrfHash' => $this->security->get_csrf_hash() // ← penting
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Data tidak ditemukan.',
                    'csrfHash' => $this->security->get_csrf_hash() // ← pastikan tetap dikirim
                ]);
            }
        } else {
            // Jika bukan AJAX, tampilkan halaman error
            show_error('Permintaan tidak valid', 400);
        }
    }

    public function getPeriode()
    {
        // Mendapatkan tahun saat ini
        $currentYear = date('Y');

        // Mendapatkan bulan saat ini (1-12, Januari = 1)
        $currentMonth = date('n'); // Fungsi 'n' menghasilkan bulan dalam format 1-12

        // Menentukan periode: 1 untuk Januari-Juni, 2 untuk Juli-November
        $periodSuffix = ($currentMonth >= 1 && $currentMonth <= 6) ? '1' : '2';

        // Menentukan nilai periode
        $periode = $currentYear . $periodSuffix;
        return $periode;
    }
}
