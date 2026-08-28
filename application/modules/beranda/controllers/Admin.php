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
    $this->load->model(['Data_belmawa', 'User_model', 'Periode_model', 'Penilaian_model']);
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
    $this->only_for_roles(['1', '2', '6']);

    $data['pm'] = "active";
    if (!$this->session->userdata('username')) {
      $this->session->set_flashdata('error', 'Anda belum login.');
      redirect(base_url('login'));
    }

    $data['kode_nama_pt'] = $this->db->query("SELECT `kode_pt`, `nm_pt` FROM `data_prodi` GROUP BY `kode_pt`, `nm_pt` ORDER BY CASE WHEN LOCATE(' ', `nm_pt`) > 0 THEN LEFT(`nm_pt`, LOCATE(' ', `nm_pt`) - 1) ELSE `nm_pt` END DESC, CASE WHEN LOCATE(' ', `nm_pt`) > 0 THEN SUBSTRING(`nm_pt`, LOCATE(' ', `nm_pt`) + 1) ELSE '' END ASC")->result_array();

    $kode_pt = explode('_', $this->session->userdata('username'))[0]; //Ambil kode PT saja
    $data['data_penjaminan_mutu'] = $this->db->query("SELECT * FROM `data_penjaminan_mutu`")->result_array();
    // $data['data'] = array(
    //   'tipologi_1' => $this->db->query("SELECT * FROM data_penjaminan_mutu WHERE tipologi = 'Tipologi 1' AND periode = '$periode'")->num_rows(),
    //   'tipologi_2' => $this->db->query("SELECT * FROM data_penjaminan_mutu WHERE tipologi = 'Tipologi 2' AND periode = '$periode'")->num_rows(),
    //   'tipologi_3' => $this->db->query("SELECT * FROM data_penjaminan_mutu WHERE tipologi = 'Tipologi 3' AND periode = '$periode'")->num_rows(),
    //   'tipologi_4' => $this->db->query("SELECT * FROM data_penjaminan_mutu WHERE tipologi = 'Tipologi 4' AND periode = '$periode'")->num_rows(),
    // );

    $labels_result = $this->db->query("SELECT `periode`, `skor_total`, `tipologi` FROM `data_penjaminan_mutu` WHERE `kode_pt` = '$kode_pt' GROUP BY `periode` ORDER BY `periode` ASC")->result_array();
    $data['labels'] = array_column($labels_result, 'periode');
    $data['tipologi'] = array_column($labels_result, 'tipologi');
    $data['capaian_pt'] = array_column($labels_result, 'skor_total');
    $bentuk_pt_self = $this->db->query("SELECT `bentuk_pt` FROM `data_pt` WHERE `kode_pt` = '$kode_pt'")->row_array();

    $skor_nol = [];
    foreach ($data['labels'] as $item) {
      $rows = $this->db->query("SELECT a.* FROM `data_penjaminan_mutu` AS a WHERE a.`periode` = '$item' AND a.`kode_pt` = '$kode_pt'")->result_array();

      $skor_nol[$item] = [];
      foreach ($rows as $row) {
        $skor_1 = $row['skor_1'] !== null ? (float)$row['skor_1'] : 0;
        $skor_2 = $row['skor_2'] !== null ? (float)$row['skor_2'] : 0;
        $skor_3 = $row['skor_3'] !== null ? (float)$row['skor_3'] : 0;
        $skor_4 = $row['skor_4'] !== null ? (float)$row['skor_4'] : 0;
        if ($skor_1 == 0.0 || $skor_2 == 0.0 || $skor_3 == 0.0 || $skor_4 == 0.0) {
          $skor_nol[$item][] = true; // Tambahkan true jika ada skor yang bernilai nol
        }
      }
    }

    $skor_per_periode = [];
    $nama_per_periode = [];
    $rata_rata_per_periode = [];
    foreach ($data['labels'] as $item) {
      $rows = $this->db->query("SELECT a.`nama_pt`, a.`skor_1`, a.`skor_2`, a.`skor_3`, a.`skor_4`, a.`skor_total`, b.`bentuk_pt` FROM `data_penjaminan_mutu` AS a JOIN `data_pt` AS b ON a.`kode_pt` = b.`kode_pt` WHERE a.`periode` = '$item' AND b.`bentuk_pt` = '{$bentuk_pt_self['bentuk_pt']}' AND a.`kode_pt` != '$kode_pt'")->result_array();

      $periode_total_skor = 0;
      $periode_jumlah_pt = 0;
      $skor_per_periode[$item] = [];
      $nama_per_periode[$item] = [];
      foreach ($rows as $row) {
        $skor_value = $row['skor_total'] !== null ? (float)$row['skor_total'] : 0;
        $skor_per_periode[$item][] = $skor_value;
        $nama_per_periode[$item][] = $row['nama_pt'];
        $periode_total_skor += $skor_value;
        $periode_jumlah_pt++;
      }

      $rata_rata_per_periode[] = $periode_jumlah_pt > 0 ? round($periode_total_skor / $periode_jumlah_pt, 1) : 0;
    }

    $data['rata_rata_per_periode'] = $rata_rata_per_periode;
    $data['skor_nol'] = $skor_nol;
    $data['bentuk_pt_self'] = $bentuk_pt_self['bentuk_pt'];

    // echo json_encode([
    //   'labels' => $data['labels'],
    //   'capaian_pt' => $data['capaian_pt'],
    //   'rata_rata_per_periode' => $rata_rata_per_periode,
    //   'skor_per_periode' => $skor_per_periode,
    //   'nama_per_periode' => $nama_per_periode,
    //   'skor_nol' => $skor_nol,
    // ]);
    // exit;
    // $data['labels'] = ['1/2026', '2/2026', '1/2027', '2/2027', '1/2028', '2/2028', '1/2029', '2/2029'];
    // $data['capaian_pt'] = [2, 4, 8, 6, 7, 8, 8, 8];
    // $data['rata_nasional'] = [3, 4, 5, 5, 6, 7, 7, 8];

    // echo json_encode($data);
    // exit;

    $this->load->view("admin/v_penjaminan_mutu", $data);
  }

  function penjaminan_mutu_30()
  {
    $this->only_for_roles(['1', '2', '6']);

    $data['pm_30'] = "active";
    if (!$this->session->userdata('username')) {
      $this->session->set_flashdata('error', 'Anda belum login.');
      redirect(base_url('login'));
    }

    $query_kode_nama_pt = "SELECT `kode_pt`, `nm_pt` FROM `data_prodi`";

    if (has_role(['6'])) {
      $kode_pt = explode('_', $this->session->userdata('username'))[0]; // Ambil kode PT saja
      $query_kode_nama_pt .= " WHERE `kode_pt` = " . $this->db->escape($kode_pt);
    }

    $query_kode_nama_pt .= " GROUP BY `kode_pt`, `nm_pt`
      ORDER BY
        CASE WHEN LOCATE(' ', `nm_pt`) > 0 THEN LEFT(`nm_pt`, LOCATE(' ', `nm_pt`) - 1) ELSE `nm_pt` END DESC,
        CASE WHEN LOCATE(' ', `nm_pt`) > 0 THEN SUBSTRING(`nm_pt`, LOCATE(' ', `nm_pt`) + 1) ELSE '' END ASC";

    $data['kode_nama_pt'] = $this->db->query($query_kode_nama_pt)->result_array();

    // Ambil data periode dari tabel
    $periode_db = $this->db->query("SELECT `periode` FROM `data_penjaminan_mutu_30` GROUP BY `periode`")->result_array();

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

    // $data['data_penjaminan_mutu'] = $this->db->query("SELECT * FROM `data_penjaminan_mutu_30`")->result_array();

    // $periode = $this->input->post('periode');
    $this->db->select_max('periode');
    $query        = $this->db->get('data_penjaminan_mutu_30');
    $periode_max  = $query->row_array(); // Ambil hasil sebagai array
    $prd          = $periode_max['periode'];

    $query = $this->db->query("SELECT COUNT(a.`tipologi`) AS jumlah_tipologi, a.`tipologi`, a.`periode`,(SELECT COUNT(*) FROM `data_penjaminan_mutu_30` AS b WHERE b.periode = a.periode) AS total_data, ROUND( ( COUNT(a.`tipologi`) / (SELECT COUNT(*) FROM `data_penjaminan_mutu_30` AS b) * 100 ), 1) AS persentase FROM `data_penjaminan_mutu_30` AS a GROUP BY a.`periode`, a.`tipologi`;")->result_array();

    $grouped = [];

    foreach ($query as $row) {
      $periode = $row['periode'];

      if (!isset($grouped[$periode])) {
        $grouped[$periode] = [];
      }

      $grouped[$periode][] = [
        'jumlah_tipologi' => $row['jumlah_tipologi'],
        'tipologi'        => $row['tipologi'],
        'total_data'      => $row['total_data'],
        'persentase'      => $row['persentase'],
      ];
    }

    $data['data'] = $grouped;

    $this->load->view("admin/v_penjaminan_mutu_30", $data);
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
    $periode = $this->Periode_model->get_active_periode();


    $data = [
      'dashboard' => "active",
      'periode_aktif' => $periode,
      'progres_penilaian' => $this->Penilaian_model->get_data_penilaian_by_periode($periode->kode),
      'jumlah_fasilitator' => count(array_unique(array_column($this->Penilaian_model->get_data_penilaian_by_periode($periode->kode), 'fasilitator_id'))),
      'jumlah_validator' => count(array_unique(array_column($this->Penilaian_model->get_data_penilaian_by_periode($periode->kode), 'validator_id'))),
      'jumlah_pt' => count(array_unique(array_column($this->Penilaian_model->get_data_penilaian_by_periode($periode->kode), 'kode_pt'))),
    ];

    $data['jml_draft'] = count(array_filter($this->Penilaian_model->get_data_penilaian_by_periode($periode->kode), function ($item) {
      return isset($item->id_status_penilaian) && $item->id_status_penilaian == 1;
    }));
    $data['jml_penilaian_validator'] = count(array_filter($this->Penilaian_model->get_data_penilaian_by_periode($periode->kode), function ($item) {
      return isset($item->id_status_penilaian) && $item->id_status_penilaian == 2;
    }));
    $data['jml_revisi_validator'] = count(array_filter($this->Penilaian_model->get_data_penilaian_by_periode($periode->kode), function ($item) {
      return isset($item->id_status_penilaian) && $item->id_status_penilaian == 3;
    }));
    $data['jml_valid'] = count(array_filter($this->Penilaian_model->get_data_penilaian_by_periode($periode->kode), function ($item) {
      return isset($item->id_status_penilaian) && $item->id_status_penilaian == 4;
    }));
    $data['jml_belum_input'] = count(array_filter($this->Penilaian_model->get_data_penilaian_by_periode($periode->kode), function ($item) {
      return !isset($item->id_status_penilaian) || $item->id_status_penilaian === null;
    }));
    $data['jml_draft_validator'] = count(array_filter($this->Penilaian_model->get_data_penilaian_by_periode($periode->kode), function ($item) {
      return isset($item->id_status_penilaian) && $item->id_status_penilaian == 5;
    }));
    $data['jml_menunggu_approval_admin'] = count(array_filter($this->Penilaian_model->get_data_penilaian_by_periode($periode->kode), function ($item) {
      return isset($item->id_status_penilaian) && $item->id_status_penilaian == 6;
    }));

    // echo json_encode(($data['penilaian_tipologi']));exit;
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

  public function uploadTemplateLed()
  {
    $this->only_for_roles(['2']);

    $config['upload_path'] = './uploads/';
    $config['allowed_types'] = 'doc|docx';
    $config['max_size'] = 2048; // Maksimal ukuran file dalam KB
    $config['file_name'] = 'template_led';
    $config['overwrite'] = true;

    $this->upload->initialize($config);

    if (!$this->upload->do_upload('file_template_led')) {
      $error = $this->upload->display_errors();
      $this->session->set_flashdata('error', 'Gagal mengupload file: ' . $error);
      redirect($_SERVER['HTTP_REFERER']);
    } else {
      $data = $this->upload->data();
      $file_path = 'uploads/' . $data['file_name'];

      // Simpan path file ke database jika diperlukan
      // Contoh: $this->db->insert('template_led', ['file_path' => $file_path]);

      $this->session->set_flashdata('success', 'File berhasil diupload: ' . basename($file_path));
      redirect($_SERVER['HTTP_REFERER']);
    }
  }

  public function get_penjaminan_mutu_pt()
  {
    $this->only_for_roles(['1', '2']);

    if (!$this->input->is_ajax_request()) {
      show_error('Invalid request', 400);
    }

    $kode_pt = $this->input->get('kode_pt', true);

    if (!$kode_pt) {
      return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'status' => false,
          'message' => 'Kode PT kosong'
        ]));
    }

    // =====================================
    // LABEL & CAPAIAN PT
    // =====================================
    $labels_result = $this->db->query("
        SELECT periode, skor_total
        FROM data_penjaminan_mutu
        WHERE kode_pt = '$kode_pt'
        GROUP BY periode
        ORDER BY periode ASC
    ")->result_array();

    $labels = array_column($labels_result, 'periode');
    $capaian_pt = array_column($labels_result, 'skor_total');

    // =====================================
    // NAMA PT
    // =====================================
    $pt = $this->db
      ->where('kode_pt', $kode_pt)
      ->get('data_pt')
      ->row_array();

    $nama_pt = $pt ? $pt['nama_pt'] : '';

    // =====================================
    // BENTUK PT
    // =====================================
    $bentuk_pt_self = $this->db->query("
        SELECT bentuk_pt
        FROM data_pt
        WHERE kode_pt = '$kode_pt'
    ")->row_array();

    // =====================================
    // SKOR NOL
    // =====================================
    $skor_nol = [];

    foreach ($labels as $item) {

      $rows = $this->db->query("
            SELECT *
            FROM data_penjaminan_mutu
            WHERE periode = '$item'
            AND kode_pt = '$kode_pt'
        ")->result_array();

      $skor_nol[$item] = [];

      foreach ($rows as $row) {

        $skor_1 = (float)$row['skor_1'];
        $skor_2 = (float)$row['skor_2'];
        $skor_3 = (float)$row['skor_3'];
        $skor_4 = (float)$row['skor_4'];

        if (
          $skor_1 == 0 ||
          $skor_2 == 0 ||
          $skor_3 == 0 ||
          $skor_4 == 0
        ) {
          $skor_nol[$item][] = true;
        }
      }
    }

    // =====================================
    // RATA NASIONAL
    // =====================================
    $rata_rata_per_periode = [];

    foreach ($labels as $item) {

      $rows = $this->db->query("
            SELECT a.skor_total
            FROM data_penjaminan_mutu a
            JOIN data_pt b
            ON a.kode_pt = b.kode_pt
            WHERE a.periode = '$item'
            AND b.bentuk_pt = '{$bentuk_pt_self['bentuk_pt']}'
            AND a.kode_pt != '$kode_pt'
        ")->result_array();

      $total = 0;
      $jumlah = 0;

      foreach ($rows as $row) {
        $total += (float)$row['skor_total'];
        $jumlah++;
      }

      $rata_rata_per_periode[] =
        $jumlah > 0
        ? round($total / $jumlah, 1)
        : 0;
    }

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode([
        'status' => true,
        'nama_pt' => $nama_pt,
        'labels' => $labels,
        'capaian_pt' => $capaian_pt,
        'rata_rata_per_periode' => $rata_rata_per_periode,
        'skor_nol' => $skor_nol
      ]));
  }

  public function verifikasi_dan_validasi_implementasi_spmi()
  {
    $this->only_for_roles(['1', '2', '4', '6']);
    $data['verifikasi'] = "active";

    // Tampil halaman verifikasi dan validasi implementasi SPMI
    return $this->load->view('admin/v_verifikasi_validasi_implementasi_spmi', $data);
  }

  public function peringatan_dini_akreditasi()
  {
    $this->only_for_roles(['1', '2', '6']);
    $data['peringatan_dini'] = "active";

    // daftar PT untuk dropdown
    $data['list_pt'] = $this->db
      ->order_by('nama_pt')
      ->get('data_pt')
      ->result();

    // default PT
    if (has_role(['6'])) {
      $data['kode_pt'] = explode('_', $this->session->userdata('username'))[0]; // Ambil kode PT saja
    } else {
      $data['kode_pt'] = $this->input->get('kode_pt') ?? '';
    }

    // echo json_encode($data);exit;

    // $kode_pt = explode('_', $this->session->userdata('username'))[0]; // Ambil kode PT saja
    // $data['data_pt'] = $this->db->query("SELECT * FROM `data_pt` WHERE `kode_pt` = '$kode_pt'")->row();
    // $data['data_prodi'] = $this->db->query("SELECT * FROM `data_prodi` WHERE `kode_pt` = '$kode_pt'")->result();

    // $today = new DateTime();
    // $batas_6_bulan = (clone $today)->modify('+6 months');
    // $batas_12_bulan = (clone $today)->modify('+12 months');

    // $data['kategori_akreditasi'] = [
    //   'kurang_dari_6_bulan' => 0,
    //   'antara_6_sampai_12_bulan' => 0,
    //   'lebih_dari_12_bulan' => 0
    // ];

    // foreach ($data['data_prodi'] as $prodi) {
    //   if (empty($prodi->tgl_akhir_akred) || $prodi->tgl_akhir_akred === '0000-00-00') {
    //     continue;
    //   }

    //   try {
    //     $tgl_akhir_akred = new DateTime($prodi->tgl_akhir_akred);
    //   } catch (Exception $e) {
    //     continue;
    //   }

    //   if ($tgl_akhir_akred < $batas_6_bulan) {
    //     $data['kategori_akreditasi']['kurang_dari_6_bulan']++;
    //   } elseif ($tgl_akhir_akred <= $batas_12_bulan) {
    //     $data['kategori_akreditasi']['antara_6_sampai_12_bulan']++;
    //   } else {
    //     $data['kategori_akreditasi']['lebih_dari_12_bulan']++;
    //   }
    // }

    // $data['penjaminan_mutu'] = $this->db->query("SELECT * FROM `data_penjaminan_mutu` WHERE `kode_pt` = '$kode_pt' ORDER BY `periode` DESC LIMIT 1")->row();
    // $data['statistik'] = $this->Penilaian_model->statistikProdi($kode_pt);
    // $data['jumlah_dosen_per_prodi'] = $this->db->query("SELECT `kode_prodi`, `nm_prodi`, COUNT(*) AS jumlah_dosen FROM `data_dosen` WHERE `kode_pt` = '$kode_pt' GROUP BY `kode_prodi`")->result_array();

    // $data['jja_dosen'] = $this->db->query("SELECT 
    //   COUNT(*) AS jumlah_semua_dosen,
    //   SUM(CASE WHEN `nm_jabatan` IS NULL OR TRIM(`nm_jabatan`) = '' THEN 1 ELSE 0 END) AS jumlah_nm_jabatan_kosong,
    //   SUM(CASE WHEN `nm_jabatan` IS NOT NULL AND TRIM(`nm_jabatan`) <> '' THEN 1 ELSE 0 END) AS jumlah_nm_jabatan_terisi,
    //   ROUND(
    //     (SUM(CASE WHEN `nm_jabatan` IS NOT NULL AND TRIM(`nm_jabatan`) <> '' THEN 1 ELSE 0 END) / NULLIF(COUNT(*), 0)) * 100,
    //     2
    //   ) AS persentase_nm_jabatan_terisi
    //   FROM `data_dosen`
    //   WHERE `kode_pt` = '$kode_pt'")->row();

    // echo json_encode($data);exit;

    // Tambah 1 prodi sampel dengan jumlah dosen kurang dari 5
    // $data['jumlah_dosen_per_prodi'][] = [
    //   'kode_prodi' => 'SAMPLE001',
    //   'nm_prodi' => 'Program Studi Sampel',
    //   'jumlah_dosen' => 3
    // ];

    // $data['prodi_dosen_kurang_dari_5'] = array_filter($data['jumlah_dosen_per_prodi'], function ($prodi) {
    //   return $prodi['jumlah_dosen'] < 5;
    // });

    // Tampil halaman peringatan dini akreditasi
    return $this->load->view('admin/v_peringatan_dini_akreditasi', $data);
  }

  public function get_peringatan_dini_akreditasi($kode_pt = null)
  {
    $this->only_for_roles(['1', '2', '6']);
    $kode_pt = $kode_pt ?: $this->input->get('kode_pt');

    if (empty($kode_pt)) {
      echo json_encode([
        'status' => false,
        'message' => 'Kode PT kosong'
      ]);
      return;
    }

    $data_pt = $this->db->query("SELECT * FROM `data_pt` WHERE `kode_pt` = '$kode_pt'")->row();

    if (!$data_pt) {
      echo json_encode([
        'status' => false,
        'message' => 'Data PT tidak ditemukan'
      ]);
      return;
    }

    $data_prodi = $this->db->query("SELECT * FROM `data_prodi` WHERE `kode_pt` = '$kode_pt'")->result();

    $today = new DateTime();
    $batas_6_bulan = (clone $today)->modify('+6 months');
    $batas_12_bulan = (clone $today)->modify('+12 months');

    $kategori_akreditasi = [
      'kurang_dari_6_bulan' => 0,
      'antara_6_sampai_12_bulan' => 0,
      'lebih_dari_12_bulan' => 0,
      'tidak_dikenali' => 0
    ];

    foreach ($data_prodi as $prodi) {
      if (empty($prodi->tgl_akhir_akred) || $prodi->tgl_akhir_akred === '0000-00-00') {
        $kategori_akreditasi['tidak_dikenali']++;
        continue;
      }

      try {
        $tgl_akhir_akred = new DateTime($prodi->tgl_akhir_akred);
      } catch (Exception $e) {
        $kategori_akreditasi['tidak_dikenali']++;
        continue;
      }

      if ($tgl_akhir_akred < $batas_6_bulan) {
        $kategori_akreditasi['kurang_dari_6_bulan']++;
      } elseif ($tgl_akhir_akred <= $batas_12_bulan) {
        $kategori_akreditasi['antara_6_sampai_12_bulan']++;
      } else {
        $kategori_akreditasi['lebih_dari_12_bulan']++;
      }
    }

    $penjaminan_mutu = $this->db->query("SELECT * FROM `data_penjaminan_mutu` WHERE `kode_pt` = '$kode_pt' ORDER BY `periode` DESC LIMIT 1")->row();
    $statistik = $this->Penilaian_model->statistikProdi($kode_pt);
    $jumlah_dosen_per_prodi = $this->db->query("SELECT `kode_prodi`, `nm_prodi`, COUNT(*) AS jumlah_dosen FROM `data_dosen` WHERE `kode_pt` = '$kode_pt' GROUP BY `kode_prodi`")->result_array();

    $jja_dosen = $this->db->query("SELECT 
      COUNT(*) AS jumlah_semua_dosen,
      SUM(CASE WHEN `nm_jabatan` IS NULL OR TRIM(`nm_jabatan`) = '' THEN 1 ELSE 0 END) AS jumlah_nm_jabatan_kosong,
      SUM(CASE WHEN `nm_jabatan` IS NOT NULL AND TRIM(`nm_jabatan`) <> '' THEN 1 ELSE 0 END) AS jumlah_nm_jabatan_terisi,
      ROUND(
        (SUM(CASE WHEN `nm_jabatan` IS NOT NULL AND TRIM(`nm_jabatan`) <> '' THEN 1 ELSE 0 END) / NULLIF(COUNT(*), 0)) * 100,
        2
      ) AS persentase_nm_jabatan_terisi
      FROM `data_dosen`
      WHERE `kode_pt` = '$kode_pt'")->row();

    // Tambah 1 prodi sampel dengan jumlah dosen kurang dari 5
    // $jumlah_dosen_per_prodi[] = [
    //   'kode_prodi' => 'SAMPLE001',
    //   'nm_prodi' => 'Program Studi Sampel',
    //   'jumlah_dosen' => 3
    // ];

    $prodi_dosen_kurang_dari_5 = array_filter($jumlah_dosen_per_prodi, function ($prodi) {
      return $prodi['jumlah_dosen'] < 5;
    });

    // SPMI yang dikembangkan oleh PT
    $skor_indikaotor_1 = isset($penjaminan_mutu->skor_1) ? (float) $penjaminan_mutu->skor_1 : 0;
    $status_spmi = $skor_indikaotor_1 > 0 ? "Memenuhi" : "Tidak Memenuhi";
    $badge_class_indikator_1 = $skor_indikaotor_1 > 0 ? "badge-soft-green" : "badge-soft-red";

    // Implementasi SPMI melalui siklus PPEPP
    $skor_indikaotor_2 = isset($penjaminan_mutu->skor_2) ? (float) $penjaminan_mutu->skor_2 : 0;
    $status_ppepp = $skor_indikaotor_2 > 0 ? "Memenuhi" : "Tidak Memenuhi";
    $badge_class_indikator_2 = $skor_indikaotor_2 > 0 ? "badge-soft-green" : "badge-soft-red";

    // PT memperoleh pengakuan atas mutu akademik yang dicapainya, berupa akreditasi program studi dari LAM/BAN-PT
    $persentase_prodi_terakreditasi = isset($statistik['persentase_prodi_terakreditasi']) ? $statistik['persentase_prodi_terakreditasi'] : 0;
    $persentase_prodi_terakreditasi_tampil = ((float) $persentase_prodi_terakreditasi == floor((float) $persentase_prodi_terakreditasi))
      ? (int) $persentase_prodi_terakreditasi
      : rtrim(rtrim(number_format((float) $persentase_prodi_terakreditasi, 2, ',', '.'), '0'), ',');
    $status_akre_prodi = (float) $persentase_prodi_terakreditasi == 100 ? "Memenuhi" : "Tidak Memenuhi";
    $badge_class_indikator_4 = (float) $persentase_prodi_terakreditasi == 100 ? "badge-soft-green" : "badge-soft-red";

    // Perguruan Tinggi memiliki kecukupan dosen untuk setiap program studi
    $dosen_tidak_cukup = $prodi_dosen_kurang_dari_5;
    $status_jumlah_dosen = $dosen_tidak_cukup === null || !empty($dosen_tidak_cukup) ? "Tidak Memenuhi" : "Memenuhi";
    $badge_class_jumlah_dosen = $dosen_tidak_cukup === null || !empty($dosen_tidak_cukup) ? "badge-soft-red" : "badge-soft-green";
    $label_jumlah_dosen = $dosen_tidak_cukup === null || !empty($dosen_tidak_cukup) ? "Ada Prodi dengan Jumlah Dosen Kurang" : "Semua Prodi Memiliki Jumlah Dosen Cukup";

    // Perguruan Tinggi memiliki dosen tetap dengan jabatan akademik
    $persentase_jja_dosen = isset($jja_dosen->persentase_nm_jabatan_terisi) ? (float) $jja_dosen->persentase_nm_jabatan_terisi : 0;
    $bentuk_pt = isset($data_pt->bentuk_pt) ? $data_pt->bentuk_pt : '';

    if (!empty($data_pt->tgl_sk_pendirian) && $data_pt->tgl_sk_pendirian !== '0000-00-00') {
      try {
        $tgl_sk_pendirian_pt = new DateTime($data_pt->tgl_sk_pendirian);
        $batas_2_tahun_pt = (clone $today)->modify('-2 years');

        if ($tgl_sk_pendirian_pt >= $batas_2_tahun_pt) {
          $status_jja_dosen = "Memenuhi (PT berusia < 2 tahun)";
          $badge_class_jja_dosen = "badge-soft-green";
        } else {
          if ($bentuk_pt == 'Universitas' || $bentuk_pt == 'Institut') {
            $status_jja_dosen = $persentase_jja_dosen >= 60 ? "Memenuhi" : "Tidak Memenuhi";
            $badge_class_jja_dosen = $persentase_jja_dosen >= 60 ? "badge-soft-green" : "badge-soft-red";
          } elseif ($bentuk_pt == 'Sekolah Tinggi') {
            $status_jja_dosen = $persentase_jja_dosen >= 30 ? "Memenuhi" : "Tidak Memenuhi";
            $badge_class_jja_dosen = $persentase_jja_dosen >= 30 ? "badge-soft-green" : "badge-soft-red";
          } elseif ($bentuk_pt == 'Akademi' || $bentuk_pt == 'Politeknik' || $bentuk_pt == 'Akademi Komunitas') {
            $status_jja_dosen = $persentase_jja_dosen >= 45 ? "Memenuhi" : "Tidak Memenuhi";
            $badge_class_jja_dosen = $persentase_jja_dosen >= 45 ? "badge-soft-green" : "badge-soft-red";
          } else {
            $status_jja_dosen = "Bentuk PT tidak dikenali";
            $badge_class_jja_dosen = "badge-soft-red";
          }
        }
      } catch (Exception $e) {
      }
    }

    $label_jja_dosen = "Dosen dengan Jabatan Akademik: {$persentase_jja_dosen}%";

    $perlu_perhatian = ($status_spmi == "Tidak Memenuhi" ? 1 : 0)
      + ($status_ppepp == "Tidak Memenuhi" ? 1 : 0)
      + ($status_akre_prodi == "Tidak Memenuhi" ? 1 : 0)
      + ($status_jumlah_dosen == "Tidak Memenuhi" ? 1 : 0)
      + (($status_jja_dosen == "Tidak Memenuhi" || $status_jja_dosen == "Bentuk PT tidak dikenali") ? 1 : 0);

    $indikator_penjaminan_mutu = [
      'indikator_1' => [
        'skor' => $skor_indikaotor_1,
        'status' => $status_spmi,
        'badge_class' => $badge_class_indikator_1,
      ],
      'indikator_2' => [
        'skor' => $skor_indikaotor_2,
        'status' => $status_ppepp,
        'badge_class' => $badge_class_indikator_2,
      ],
      'indikator_4' => [
        'persentase_prodi_terakreditasi' => $persentase_prodi_terakreditasi,
        'persentase_prodi_terakreditasi_tampil' => $persentase_prodi_terakreditasi_tampil,
        'status' => $status_akre_prodi,
        'badge_class' => $badge_class_indikator_4,
      ],
      'jumlah_dosen_per_prodi' => [
        'status' => $status_jumlah_dosen,
        'badge_class' => $badge_class_jumlah_dosen,
        'label' => $label_jumlah_dosen,
      ],
      'jja_dosen' => [
        'persentase' => $persentase_jja_dosen,
        'status' => $status_jja_dosen,
        'badge_class' => $badge_class_jja_dosen,
        'label' => $label_jja_dosen,
      ],
      'perlu_perhatian' => $perlu_perhatian,
    ];

    echo json_encode([
      'status' => true,
      'data_pt' => $data_pt,
      'tgl_akhir_akred' => $data_pt->tgl_akhir_akred == '0000-00-00' ? $data_pt->tgl_akhir_akred : format_tanggal_indonesia($data_pt->tgl_akhir_akred),
      'kategori_akreditasi' => $kategori_akreditasi,
      'penjaminan_mutu' => $penjaminan_mutu,
      'statistik' => $statistik,
      'jja_dosen' => $jja_dosen,
      'prodi_dosen_kurang_dari_5' => $prodi_dosen_kurang_dari_5,
      'indikator_penjaminan_mutu' => $indikator_penjaminan_mutu,
      'data_prodi' => $data_prodi
    ]);
  }

  public function pantau_potensi_unggul()
  {
    $this->only_for_roles(['1', '2']);
    $data['pantau_potensi_unggul'] = "active";

    // daftar PT untuk dropdown
    $data['list_pt'] = $this->db
      ->order_by('nama_pt')
      ->get('data_pt')
      ->result();

    // Tampil halaman pantau potensi unggul
    return $this->load->view('admin/v_pantau_potensi_unggul', $data);
  }

  public function get_pantau_potensi_unggul($kode_pt = null)
  {
    $this->only_for_roles(['1', '2', '6']);
    $kode_pt = $kode_pt ?: $this->input->get('kode_pt');

    if (empty($kode_pt)) {
      echo json_encode([
        'status' => false,
        'message' => 'Kode PT kosong'
      ]);
      return;
    }

    $data_pt = $this->db->query("SELECT * FROM `data_pt` WHERE `kode_pt` = '$kode_pt'")->row();

    if (!$data_pt) {
      echo json_encode([
        'status' => false,
        'message' => 'Data PT tidak ditemukan'
      ]);
      return;
    }

    $data_prodi = $this->db->query("SELECT * FROM `data_prodi` WHERE `kode_pt` = '$kode_pt'")->result();

    $today = new DateTime();
    $batas_6_bulan = (clone $today)->modify('+6 months');
    $batas_12_bulan = (clone $today)->modify('+12 months');

    $kategori_akreditasi = [
      'kurang_dari_6_bulan' => 0,
      'antara_6_sampai_12_bulan' => 0,
      'lebih_dari_12_bulan' => 0,
      'tidak_dikenali' => 0
    ];

    foreach ($data_prodi as $prodi) {
      if (empty($prodi->tgl_akhir_akred) || $prodi->tgl_akhir_akred === '0000-00-00') {
        $kategori_akreditasi['tidak_dikenali']++;
        continue;
      }

      try {
        $tgl_akhir_akred = new DateTime($prodi->tgl_akhir_akred);
      } catch (Exception $e) {
        $kategori_akreditasi['tidak_dikenali']++;
        continue;
      }

      if ($tgl_akhir_akred < $batas_6_bulan) {
        $kategori_akreditasi['kurang_dari_6_bulan']++;
      } elseif ($tgl_akhir_akred <= $batas_12_bulan) {
        $kategori_akreditasi['antara_6_sampai_12_bulan']++;
      } else {
        $kategori_akreditasi['lebih_dari_12_bulan']++;
      }
    }

    $penjaminan_mutu = $this->db->query("SELECT * FROM `data_penjaminan_mutu` WHERE `kode_pt` = '$kode_pt' ORDER BY `periode` DESC LIMIT 1")->row();
    $statistik = $this->Penilaian_model->statistikProdi($kode_pt);
    $jumlah_dosen_per_prodi = $this->db->query("SELECT `kode_prodi`, `nm_prodi`, COUNT(*) AS jumlah_dosen FROM `data_dosen` WHERE `kode_pt` = '$kode_pt' GROUP BY `kode_prodi`")->result_array();

    $jja_dosen = $this->db->query("SELECT 
      COUNT(*) AS jumlah_semua_dosen,
      SUM(CASE WHEN TRIM(`nm_jabatan`) NOT IN ('Lektor Kepala', 'Guru Besar', 'Profesor') OR `nm_jabatan` IS NULL THEN 1 ELSE 0 END) AS jumlah_jabatan_tidak_lk_atau_gb,
      SUM(CASE WHEN TRIM(`nm_jabatan`) IN ('Lektor Kepala') THEN 1 ELSE 0 END) AS jumlah_jabatan_lk,
      SUM(CASE WHEN TRIM(`nm_jabatan`) IN ('Guru Besar', 'Profesor') THEN 1 ELSE 0 END) AS jumlah_jabatan_gb,
      SUM(CASE WHEN TRIM(`nm_jabatan`) IN ('Lektor Kepala', 'Guru Besar', 'Profesor') THEN 1 ELSE 0 END) AS jumlah_jabatan_lk_atau_gb,
      ROUND(
        (SUM(CASE WHEN TRIM(`nm_jabatan`) IN ('Lektor Kepala') THEN 1 ELSE 0 END) / NULLIF(COUNT(*), 0)) * 100,
        2
      ) AS persentase_jabatan_lk,
      ROUND(
        (SUM(CASE WHEN TRIM(`nm_jabatan`) IN ('Guru Besar', 'Profesor') THEN 1 ELSE 0 END) / NULLIF(COUNT(*), 0)) * 100,
        2
      ) AS persentase_jabatan_gb,
      ROUND(
        (SUM(CASE WHEN TRIM(`nm_jabatan`) IN ('Lektor Kepala', 'Guru Besar', 'Profesor') THEN 1 ELSE 0 END) / NULLIF(COUNT(*), 0)) * 100,
        2
      ) AS persentase_jabatan_lk_atau_gb
      FROM `data_dosen`
      WHERE `kode_pt` = ?", [$kode_pt])->row();

    // Tambah 1 prodi sampel dengan jumlah dosen kurang dari 5
    // $jumlah_dosen_per_prodi[] = [
    //   'kode_prodi' => 'SAMPLE001',
    //   'nm_prodi' => 'Program Studi Sampel',
    //   'jumlah_dosen' => 3
    // ];

    $prodi_dosen_kurang_dari_5 = array_filter($jumlah_dosen_per_prodi, function ($prodi) {
      return $prodi['jumlah_dosen'] < 5;
    });

    // SPMI yang dikembangkan oleh PT
    $skor_spmi = isset($penjaminan_mutu->skor_1) ? (float) $penjaminan_mutu->skor_1 : 0;
    $status_spmi = $skor_spmi == 2 ? '<span class="badge-terpenuhi">&#10003; Terpenuhi</span>' : '<span class="badge-belum">&#128711; Belum Terpenuhi</span>';
    $keterangan_spmi = $skor_spmi == 2 ? "<span style='color:#15803d;font-size:11px;'>Dokumen SPMI lengkap dan sah.</span>" : "<span style='color:#dc2626;font-size:11px;'>Dokumen SPMI tidak lengkap atau tidak sah.</span>";

    // Implementasi SPMI melalui siklus PPEPP
    $skor_ppepp = isset($penjaminan_mutu->skor_2) ? (float) $penjaminan_mutu->skor_2 : 0;
    $status_ppepp = $skor_ppepp == 2 ? '<span class="badge-terpenuhi">&#10003; Terpenuhi</span>' : '<span class="badge-belum">&#128711; Belum Terpenuhi</span>';
    $keterangan_ppepp = $skor_ppepp == 2 ? "<span style='color:#15803d;font-size:11px;'>Implementasi telah berjalan efektif.</span>" : "<span style='color:#dc2626;font-size:11px;'>Implementasi belum berjalan efektif.</span>";

    // PT memperoleh pengakuan atas mutu akademik yang dicapainya, berupa akreditasi program studi dari LAM/BAN-PT
    $persentase_prodi_terakreditasi = isset($statistik['persentase_prodi_terakreditasi']) ? $statistik['persentase_prodi_terakreditasi'] : 0;
    $persentase_prodi_terakreditasi_tampil = ((float) $persentase_prodi_terakreditasi == floor((float) $persentase_prodi_terakreditasi))
      ? (int) $persentase_prodi_terakreditasi
      : rtrim(rtrim(number_format((float) $persentase_prodi_terakreditasi, 2, ',', '.'), '0'), ',');
    $status_akre_prodi = (float) $persentase_prodi_terakreditasi >= 70 ? '<span class="badge-terpenuhi">&#10003; Terpenuhi</span>' : (((float) $persentase_prodi_terakreditasi >= 40 && (float) $persentase_prodi_terakreditasi <= 69) ? '<span class="badge-perlu">&#9888; Perlu Peningkatan</span>' : '<span class="badge-belum">&#128711; Belum Terpenuhi</span>');
    $keterangan_akre_prodi = $statistik['prodi_terakreditasi'] . " dari " . $statistik['total_prodi_aktif'] . " prodi terakreditasi.";

    // Perguruan Tinggi memiliki kecukupan dosen untuk setiap program studi
    $dosen_tidak_cukup = $prodi_dosen_kurang_dari_5;
    $status_jumlah_dosen = $dosen_tidak_cukup === null || !empty($dosen_tidak_cukup) ? "Belum Terpenuhi" : "Terpenuhi";
    $badge_class_jumlah_dosen = $dosen_tidak_cukup === null || !empty($dosen_tidak_cukup) ? "badge-soft-red" : "badge-soft-green";
    $label_jumlah_dosen = $dosen_tidak_cukup === null || !empty($dosen_tidak_cukup) ? "Ada Prodi dengan Jumlah Dosen Kurang" : "Semua Prodi Memiliki Jumlah Dosen Cukup";

    // Perguruan Tinggi memiliki dosen tetap dengan jabatan akademik Lektor Kepala atau Guru Besar
    $persentase_jabatan_lk_atau_gb = isset($jja_dosen->persentase_jabatan_lk_atau_gb) ? (float) $jja_dosen->persentase_jabatan_lk_atau_gb : 0;
    $persentase_jabatan_lk_atau_gb_tampil = ((float) $persentase_jabatan_lk_atau_gb == floor((float) $persentase_jabatan_lk_atau_gb))
      ? (int) $persentase_jabatan_lk_atau_gb
      : rtrim(rtrim(number_format((float) $persentase_jabatan_lk_atau_gb, 2, ',', '.'), '0'), ',');
    $bentuk_pt = isset($data_pt->bentuk_pt) ? $data_pt->bentuk_pt : '';

    if ($bentuk_pt == 'Universitas' || $bentuk_pt == 'Institut' || $bentuk_pt == 'Sekolah Tinggi') {
      $status_jabatan_lk_atau_gb = $persentase_jabatan_lk_atau_gb >= 10 ? '<span class="badge-terpenuhi">&#10003; Terpenuhi</span>' : '<span class="badge-belum">&#128711; Belum Terpenuhi</span>';
    } elseif ($bentuk_pt == 'Akademi' || $bentuk_pt == 'Politeknik' || $bentuk_pt == 'Akademi Komunitas') {
      $status_jabatan_lk_atau_gb = $persentase_jabatan_lk_atau_gb >= 7.5 ? '<span class="badge-terpenuhi">&#10003; Terpenuhi</span>' : '<span class="badge-belum">&#128711; Belum Terpenuhi</span>';
    } else {
      $status_jabatan_lk_atau_gb = "Bentuk PT tidak dikenali";
    }

    $keterangan_jabatan_lk_atau_gb = "{$jja_dosen->jumlah_jabatan_lk} Lektor Kepala ({$jja_dosen->persentase_jabatan_lk}%), {$jja_dosen->jumlah_jabatan_gb} Guru Besar ({$jja_dosen->persentase_jabatan_gb}%).";

    $perlu_perhatian = ($status_spmi == "Belum Terpenuhi" ? 1 : 0)
      + ($status_ppepp == "Belum Terpenuhi" ? 1 : 0)
      + ($status_akre_prodi == "Belum Terpenuhi" ? 1 : 0)
      + ($status_jumlah_dosen == "Belum Terpenuhi" ? 1 : 0)
      + (($status_jabatan_lk_atau_gb == "Belum Terpenuhi" || $status_jabatan_lk_atau_gb == "Bentuk PT tidak dikenali") ? 1 : 0);

    $indikator_penjaminan_mutu = [
      'spmi' => [
        'skor' => $skor_spmi,
        'status' => $status_spmi,
        'keterangan' => $keterangan_spmi,
      ],
      'ppepp' => [
        'skor' => $skor_ppepp,
        'status' => $status_ppepp,
        'keterangan' => $keterangan_ppepp,
      ],
      'akreditasi_prodi' => [
        'persentase_prodi_terakreditasi' => $persentase_prodi_terakreditasi,
        'persentase_prodi_terakreditasi_tampil' => $persentase_prodi_terakreditasi_tampil,
        'status' => $status_akre_prodi,
        'keterangan' => $keterangan_akre_prodi,
      ],
      'jumlah_dosen_per_prodi' => [
        'status' => $status_jumlah_dosen,
        'badge_class' => $badge_class_jumlah_dosen,
        'label' => $label_jumlah_dosen,
      ],
      'jja_dosen_lk_atau_gb' => [
        'persentase_jabatan_lk_atau_gb' => $persentase_jabatan_lk_atau_gb,
        'persentase_jabatan_lk_atau_gb_tampil' => $persentase_jabatan_lk_atau_gb_tampil,
        'status' => $status_jabatan_lk_atau_gb,
        'keterangan' => $keterangan_jabatan_lk_atau_gb,
      ],
      'perlu_perhatian' => $perlu_perhatian,
    ];

    echo json_encode([
      'status' => true,
      'data_pt' => $data_pt,
      'tgl_mulai_akred' => $data_pt->tgl_mulai_akred == '0000-00-00' ? $data_pt->tgl_mulai_akred : format_tanggal_indonesia($data_pt->tgl_mulai_akred),
      'tgl_akhir_akred' => $data_pt->tgl_akhir_akred == '0000-00-00' ? $data_pt->tgl_akhir_akred : format_tanggal_indonesia($data_pt->tgl_akhir_akred),
      'kategori_akreditasi' => $kategori_akreditasi,
      'penjaminan_mutu' => $penjaminan_mutu,
      'statistik' => $statistik,
      'jja_dosen' => $jja_dosen,
      'prodi_dosen_kurang_dari_5' => $prodi_dosen_kurang_dari_5,
      'indikator_penjaminan_mutu' => $indikator_penjaminan_mutu,
      'data_prodi' => $data_prodi
    ]);
  }

  public function pembelajaran_mandiri_penjaminan_mutu()
  {
    $this->only_for_roles(['1', '2', '4', '6']);
    $data['pembelajaran_mandiri'] = "active";

    // Tampil halaman pembelajaran mandiri penjaminan mutu
    return $this->load->view('admin/v_pembelajaran_mandiri_penjaminan_mutu', $data);
  }

  public function informasi_kegiatan()
  {
    $this->only_for_roles(['1', '2', '4', '6']);
    $data['informasi_kegiatan'] = "active";
    $data['kegiatan'] = $this->db->order_by('tanggal_mulai', 'ASC')->limit(4)->get('kegiatan')->result();

    // Tampil halaman informasi kegiatan
    return $this->load->view('admin/v_informasi_kegiatan', $data);
  }

  public function jejaring_dan_narahubung_penjaminan_mutu()
  {
    $this->only_for_roles(['1', '2', '6']);
    $data['jejaring_narahubung'] = "active";

    // Tampil halaman jejaring dan narahubung penjaminan mutu
    return $this->load->view('admin/v_jejaring_narahubung_penjaminan_mutu', $data);
  }

  public function coba_ui_baru()
  {
    // echo "UI baru berhasil diaktifkan. Silakan cek halaman berikutnya.";
    // exit;
    if (!has_role(['1', '2', '6'])) {
      show_404();
    }

    $this->session->set_userdata('ui_template', 'baru');

    redirect($_SERVER['HTTP_REFERER']);
  }

  public function kembali_ke_ui_lama()
  {
    if (!has_role(['1', '2'])) {
      show_404();
    }

    $this->session->set_userdata('ui_template', 'lama');

    redirect($_SERVER['HTTP_REFERER']);
  }
}
