<?php
defined('BASEPATH') or exit('No direct script access allowed');

// require_once APPPATH . 'third_party/PhpSpreadsheetAutoload.php';
// require_once APPPATH . 'third_party/PhpSpreadsheetAutoload.php';

// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Admin extends MX_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->library(['javascript', 'upload']);
    $this->load->model(['Data_belmawa', 'User_model']);
    $this->load->helper('download'); // Load helper download untuk memudahkan proses download file
    date_default_timezone_set("Asia/Jakarta");

    if (!$this->session->userdata('username')) {
      $this->session->set_flashdata('error', 'Anda belum login.');
      redirect('login');
    }
  }

  /** ===============================
   *  KIP Kuliah
   *  =============================== */
  function data_kip_kuliah()
  {
    $this->only_for_roles(['1', '3']);

    $data = [
      'kip_kuliah' => 'active',
      'data_kip_kuliah' => $this->db->get('data_kip_kuliah')->result_array()
    ];

    $this->load->view('admin/v_kip_kuliah', $data);
  }

  public function simpan_kip_kuliah()
  {
    $this->only_for_roles(['1', '3']);

    $data = $this->input->post([
      'tahun',
      'kuota_reguler',
      'kuota_usulan'
    ]);

    $result = $this->Data_belmawa->insert_kip_kuliah($data);

    $this->session->set_flashdata(
      $result ? 'success' : 'error',
      $result ? 'Data berhasil disimpan.' : 'Gagal menyimpan data.'
    );

    redirect('admin/data-kip-kuliah');
  }

  public function update_kip_kuliah()
  {
    $this->only_for_roles(['1', '3']);

    $id = $this->input->post('id');
    $data = $this->input->post([
      'tahun',
      'kuota_reguler',
      'kuota_usulan'
    ]);

    $result = $this->Data_belmawa->update_kip_kuliah($id, $data);

    $this->session->set_flashdata(
      $result ? 'success' : 'error',
      $result ? 'Data berhasil diubah.' : 'Gagal mengubah data.'
    );

    redirect('admin/data-kip-kuliah');
  }

  public function hapus_kip_kuliah($id)
  {
    $this->only_for_roles(['1', '3']);

    $result = $this->Data_belmawa->delete_kip_kuliah($id);

    $this->session->set_flashdata(
      $result ? 'success' : 'error',
      $result ? 'Data berhasil dihapus.' : 'Gagal menghapus data.'
    );

    redirect('admin/data-kip-kuliah');
  }

  /** ===============================
   *  Penjaminan Mutu
   *  =============================== */
  function penjaminan_mutu()
  {
    $this->only_for_roles(['1', '2']);

    $data['pm'] = "active";
    if (!$this->session->userdata('username')) {
      $this->session->set_flashdata('error', 'Anda belum login.');
      redirect(base_url('login'));
    }
    $data['kode_nama_pt'] = $this->db->query("SELECT `kode_pt`, `nm_pt` FROM `data_prodi` GROUP BY `kode_pt`, `nm_pt` ORDER BY CASE WHEN LOCATE(' ', `nm_pt`) > 0 THEN LEFT(`nm_pt`, LOCATE(' ', `nm_pt`) - 1) ELSE `nm_pt` END DESC, CASE WHEN LOCATE(' ', `nm_pt`) > 0 THEN SUBSTRING(`nm_pt`, LOCATE(' ', `nm_pt`) + 1)ELSE '' END ASC")->result_array();

    // Ambil data periode dari tabel
    $periode_db = $this->db->query("SELECT `periode` FROM `data_penjaminan_mutu` GROUP BY `periode`")->result_array();

    // Inisialisasi array $data['periode']
    $data['periode'] = [];

    // Loop data hasil query dan tentukan bulan berdasarkan karakter terakhir
    foreach ($periode_db as $row) {
      $periode_value = $row['periode'];

      // Tentukan bulan berdasarkan digit terakhir dari periode
      $bulan = substr($periode_value, -1) == '1' ? 'Januari - Juni' : 'Juli - Desember';

      // Tambahkan data ke $data['periode']
      $data['periode'][] = [
        'bulan' => $bulan,
        'periode' => $periode_value,
      ];
    }

    // Dapatkan tahun saat ini
    $tahun_saat_ini = date('Y');

    // Tentukan periode yang seharusnya ada untuk tahun saat ini
    $periode_tahun_ini = [
      [
        'bulan' => 'Januari - Juni',
        'periode' => $tahun_saat_ini . '1',
      ],
      [
        'bulan' => 'Juli - Desember',
        'periode' => $tahun_saat_ini . '2',
      ]
    ];

    // Cek dan tambahkan periode untuk tahun saat ini jika belum ada
    foreach ($periode_tahun_ini as $periode) {
      $periode_values = array_column($data['periode'], 'periode');

      // Jika periode belum ada di $data['periode'], tambahkan
      if (!in_array($periode['periode'], $periode_values)) {
        $data['periode'][] = $periode;
      }
    }

    // Urutkan array berdasarkan 'periode' secara ascending
    usort($data['periode'], function ($a, $b) {
      return $a['periode'] <=> $b['periode'];
    });

    // Mendapatkan tahun saat ini
    $currentYear = date('Y');

    // Mendapatkan bulan saat ini (1-12)
    $currentMonth = date('n'); // Format 'n' memberikan bulan tanpa nol di depan

    // Menentukan periode: 1 untuk Januari-Juni, 2 untuk Juli-Desember
    $periodSuffix = ($currentMonth >= 1 && $currentMonth <= 6) ? '1' : '2';

    // Menggabungkan tahun dan periode
    $periode = $currentYear . $periodSuffix;

    $data['data_penjaminan_mutu'] = $this->db->query("SELECT * FROM `data_penjaminan_mutu`")->result_array();
    // $data['data'] = array(
    //   'tipologi_1' => $this->db->query("SELECT * FROM data_penjaminan_mutu WHERE tipologi = 'Tipologi 1' AND periode = '$periode'")->num_rows(),
    //   'tipologi_2' => $this->db->query("SELECT * FROM data_penjaminan_mutu WHERE tipologi = 'Tipologi 2' AND periode = '$periode'")->num_rows(),
    //   'tipologi_3' => $this->db->query("SELECT * FROM data_penjaminan_mutu WHERE tipologi = 'Tipologi 3' AND periode = '$periode'")->num_rows(),
    //   'tipologi_4' => $this->db->query("SELECT * FROM data_penjaminan_mutu WHERE tipologi = 'Tipologi 4' AND periode = '$periode'")->num_rows(),
    // );

    // $periode = $this->input->post('periode');
    $this->db->select_max('periode');
    $query        = $this->db->get('data_penjaminan_mutu');
    $periode_max  = $query->row_array(); // Ambil hasil sebagai array
    $prd          = $periode_max['periode'];

    // // Konversi hasil ke JSON dan kirim ke browser
    // echo json_encode($periode_max['periode']);
    // exit;

    $data['data'] = $this->db->query("SELECT COUNT(a.`tipologi`) AS jumlah_tipologi, a.`tipologi`, a.`periode`,(SELECT COUNT(*) FROM `data_penjaminan_mutu` AS b WHERE b.periode = '$prd') AS total_data, ROUND( ( COUNT(a.`tipologi`) / (SELECT COUNT(*) FROM `data_penjaminan_mutu` AS b WHERE b.periode = '$prd') * 100 ), 1) AS persentase FROM `data_penjaminan_mutu` AS a WHERE a.`periode` = '$prd' GROUP BY a.`tipologi`, a.`periode`;")->result();

    $this->load->view("admin/v_penjaminan_mutu", $data);
  }

  public function import_penjaminan_mutu()
  {
    $this->only_for_roles(['1', '2']);

    // echo json_encode($_FILES);exit;
    if (isset($_FILES['file_excel']['name'])) {
      $file_mimes = array('application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

      if (in_array($_FILES['file_excel']['type'], $file_mimes)) {
        $file = $_FILES['file_excel']['tmp_name'];

        // Load file excel menggunakan IOFactory dari PhpSpreadsheet
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $highestRow = $sheet->getHighestRow(); // Mendapatkan jumlah baris tertinggi

        // Ambil semua data dari tabel data_pt sekali di awal
        $data_pt = $this->db->select('kode_pt, akreditasi_pt')->get('data_pt')->result_array();

        // Buat array indexed by kode_pt untuk pencarian cepat
        $pt_data = array();
        foreach ($data_pt as $pt) {
          $pt_data[trim($pt['kode_pt'])] = $pt['akreditasi_pt'];
        }

        // Query untuk menghitung total prodi, prodi aktif, dan persentase prodi aktif
        $this->db->select('kode_pt');
        $this->db->select('nm_pt');
        $this->db->select('COUNT(nama_prodi) AS total_prodi');
        $this->db->select('COUNT(CASE WHEN nm_stat_prodi = "Aktif" THEN 1 END) AS prodi_aktif');
        $this->db->select('COUNT(CASE WHEN nm_stat_prodi = "Aktif" AND akreditasi_prodi <> "-" AND akreditasi_prodi <> "" AND akreditasi_prodi <> "Tidak Terakreditasi" THEN 1 END) AS prodi_aktif_terakreditasi');
        $this->db->select('FORMAT((COUNT(CASE WHEN nm_stat_prodi = "Aktif" AND akreditasi_prodi <> "-" AND akreditasi_prodi <> "" AND akreditasi_prodi <> "Tidak Terakreditasi" THEN 1 END) / 
                    COUNT(CASE WHEN nm_stat_prodi = "Aktif" THEN 1 END) * 100), 2) AS persentase_aktif_terakreditasi');
        $this->db->from('data_prodi');
        $this->db->group_by('kode_pt, nm_pt');

        // Eksekusi query dan dapatkan hasilnya
        $query = $this->db->get();
        $presentase = $query->result_array();

        // Buat array indexed by kode_pt untuk pencarian cepat
        $presentase_data = array();
        foreach ($presentase as $pres) {
          $presentase_data[trim($pres['kode_pt'])] = $pres['persentase_aktif_terakreditasi'];
        }

        // echo json_encode($presentase_data);exit;
        // Array untuk menyimpan data insert dan update
        $data_insert = [];
        $data_update = [];

        // Ambil periode dari input form
        $periode = $this->input->post('periode');

        // Ambil semua data yang sudah ada untuk kode_pt dan periode yang bersangkutan
        $existing_records = $this->db->select('kode_pt')
          ->where('periode', $periode)
          ->get('data_penjaminan_mutu')
          ->result_array();

        // Buat array untuk mempermudah pengecekan data yang sudah ada
        $existing_kode_pt = array_column($existing_records, 'kode_pt');

        // Looping setiap baris dari file Excel, mulai dari baris keempat untuk skip header
        for ($row = 4; $row <= $highestRow; $row++) {
          $kode_pt = trim($sheet->getCell('A' . $row)->getValue());
          $nama_pt = $sheet->getCell('B' . $row)->getValue();
          $skor_1a = $sheet->getCell('C' . $row)->getValue();
          $skor_1b = $sheet->getCell('D' . $row)->getValue();
          $skor_2 = $sheet->getCell('E' . $row)->getValue();
          $skor_1_bobot = $sheet->getCell('F' . $row)->getValue();
          $skor_2_bobot = $sheet->getCell('G' . $row)->getValue();
          $skor_total = $sheet->getCell('H' . $row)->getValue();
          $tipologi = $sheet->getCell('I' . $row)->getValue();

          // Ambil akreditasi_institusi dari array yang sudah di-index dengan kode_pt
          $akreditasi_institusi = isset($pt_data[$kode_pt]) ? $pt_data[$kode_pt] : '';
          $presentase_prodi_terakreditasi = isset($presentase_data[$kode_pt]) ? $presentase_data[$kode_pt] : '';
          $tgl_update = date('Y-m-d H:i:s');

          // Format skor agar memiliki 2 digit di belakang koma
          $skor_1a = number_format($skor_1a, 2, '.', ',');
          $skor_1b = number_format($skor_1b, 2, '.', ',');
          $skor_2 = number_format($skor_2, 2, '.', ',');
          $skor_1_bobot = number_format($skor_1_bobot, 2, '.', ',');
          $skor_2_bobot = number_format($skor_2_bobot, 2, '.', ',');
          $skor_total = number_format($skor_total, 2, '.', ',');

          // Data yang akan di-insert ke dalam database
          $data = array(
            'kode_pt' => trim($kode_pt),
            'nama_pt' => $nama_pt,
            'skor_1a' => $skor_1a,
            'skor_1b' => $skor_1b,
            'skor_2' => $skor_2,
            'skor_1_bobot' => $skor_1_bobot,
            'skor_2_bobot' => $skor_2_bobot,
            'skor_total' => $skor_total,
            'tipologi' => $tipologi,
            'akreditasi_institusi' => $akreditasi_institusi,
            'presentase_prodi_terakreditasi' => $presentase_prodi_terakreditasi,
            'periode' => $periode,
            'tgl_update' => $tgl_update,
          );

          // Cek apakah data sudah ada atau belum berdasarkan kode_pt dan periode
          if (in_array($kode_pt, $existing_kode_pt)) {
            // Jika data sudah ada, tambahkan ke array update
            $data_update[] = $data;
          } else {
            // Jika data belum ada, tambahkan ke array insert
            $data_insert[] = $data;
          }
        }

        // Lakukan batch insert untuk data baru
        if (!empty($data_insert)) {
          $this->db->insert_batch('data_penjaminan_mutu', $data_insert);
        }

        // Lakukan batch update untuk data yang sudah ada
        if (!empty($data_update)) {
          // Kita perlu menggunakan loop untuk update batch karena CI tidak mendukung update_batch dengan multiple where clause
          foreach ($data_update as $update_data) {
            $this->db->where('kode_pt', $update_data['kode_pt'])
              ->where('periode', $update_data['periode'])
              ->update('data_penjaminan_mutu', $update_data);
          }
        }

        // Set flashdata untuk pesan sukses
        $this->session->set_flashdata('success', 'Data berhasil diimport');
        redirect('admin/penjaminan-mutu');
      } else {
        $this->session->set_flashdata('error', 'File yang diupload bukan file Excel.');
        redirect('admin/penjaminan-mutu');
      }
    }
  }

  // Fungsi untuk mendownload template Excel
  public function download_template_penjaminan_mutu()
  {
    $this->only_for_roles(['1', '2']);

    $file_path = './uploads/template_penjaminan_mutu.xlsx'; // Path lengkap ke file template

    // Cek apakah file ada
    if (file_exists($file_path)) {
      // Menggunakan helper download CodeIgniter untuk memulai download
      force_download($file_path, NULL);
    } else {
      // Jika file tidak ditemukan, tampilkan pesan error atau alihkan kembali ke halaman sebelumnya
      $this->session->set_flashdata('error', 'Template file tidak ditemukan.');
      redirect('admin/penjaminan-mutu');
    }
  }

  // Fungsi untuk hapus data
  public function hapus_penjaminan_mutu()
  {
    $this->only_for_roles(['1', '2']);

    $periode = $this->input->post('periode');
    $this->db->delete('data_penjaminan_mutu', array('periode' => $periode));

    // Set pesan flashdata untuk notifikasi sukses
    $this->session->set_flashdata('success', 'Data berhasil dihapus.');

    // Redirect ke halaman penjaminan mutu
    redirect('admin/penjaminan-mutu');
  }

  function dashboard()
  {
    $data['dashboard'] = "active";
    $this->load->view("admin/v_index", $data);
  }

  public function ubahPassword()
  {
    $user_id = $this->input->post('user_id');
    $current_password = $this->input->post('current_password');
    $new_password = $this->input->post('new_password');
    $confirm_password = $this->input->post('confirm_password');

    // Validasi form
    $this->form_validation->set_rules('current_password', 'Password Saat Ini', 'required');
    $this->form_validation->set_rules('new_password', 'Password Baru', 'required|min_length[6]');
    $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[new_password]');

    if ($this->form_validation->run() == FALSE) {
      $errors = $this->form_validation->error_array();

      // Custom kata-kata error
      $custom_errors = [];
      foreach ($errors as $field => $message) {
        switch ($field) {
          case 'current_password':
            $custom_errors[] = 'Password saat ini wajib diisi dan benar.';
            break;
          case 'new_password':
            $custom_errors[] = 'Password baru minimal 6 karakter.';
            break;
          case 'confirm_password':
            $custom_errors[] = 'Konfirmasi password harus sama dengan password baru.';
            break;
          default:
            $custom_errors[] = $message; // default pesan
            break;
        }
      }

      $this->session->set_flashdata('error_validation', $custom_errors);
      redirect($_SERVER['HTTP_REFERER']);
    }

    // Cek password saat ini sesuai database via model
    $user = $this->User_model->check_current_password($user_id, $current_password);
    if (!$user) {
      $this->session->set_flashdata('error', 'Password saat ini salah.');
      redirect($_SERVER['HTTP_REFERER']);
    }

    // Update password via model
    $this->User_model->update_password($user_id, $new_password);

    $this->session->set_flashdata('success', 'Password berhasil diubah.');
    redirect($_SERVER['HTTP_REFERER']);
  }
}
