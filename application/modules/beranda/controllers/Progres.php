
<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load package composer
// require 'vendor/autoload.php';

//deklarasi package yang ingin digunakan
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Progres extends MX_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->library(['javascript']);
    $this->load->model(['Periode_model', 'Penilaian_model', 'Penilaian30_model']);
    date_default_timezone_set("Asia/Jakarta");

    if (!$this->session->userdata('username')) {
      $this->session->set_flashdata('error', 'Anda belum login.');
      redirect('login');
    }
    $this->only_for_roles(['2']);
  }

  public function index()
  {
    $upload_path = FCPATH . 'uploads' . DIRECTORY_SEPARATOR;
    $template_file = null;
    $date_modified = null;

    if (is_dir($upload_path)) {
      $template_path = $upload_path . 'template_led.docx';
      if (file_exists($template_path)) {
        $template_file = base_url('uploads/template_led.docx');
        $date_modified = date('Y-m-d H:i:s', filemtime($template_path));
      }
    }

    $data = [
      'master' => 'active',
      'progres' => 'active',
      'data_periode' => $this->Periode_model->get_all_data_periode(),
      'template_file' => $template_file,
      'date_modified' => $date_modified,
    ];

    $this->load->view("admin/master/progres/v_index", $data);
  }

  public function lihatProgres($enc_periode)
  {
    $periode        = safe_url_decrypt($enc_periode);
    $periode_dipilih = $this->Periode_model->get_periode_by_kode($periode);

    if (substr($periode, 0, 4) > '2025') :
      $modelPenilaian = $this->Penilaian_model;
    else :
      $modelPenilaian = $this->Penilaian30_model;
    endif;

    $data = [
      'master' => 'active',
      'progres' => 'active',
      'periode_dipilih' => $periode_dipilih,
      'jumlah_fasilitator' => count(array_unique(array_column($modelPenilaian->get_data_penilaian_by_periode($periode), 'fasilitator_id'))),
      'jumlah_validator' => count(array_unique(array_column($modelPenilaian->get_data_penilaian_by_periode($periode), 'validator_id'))),
      'jumlah_pt' => count(array_unique(array_column($modelPenilaian->get_data_penilaian_by_periode($periode), 'kode_pt'))),
      'progres_penilaian' => $modelPenilaian->get_data_penilaian_by_periode($periode),
      'buka_tutup' => $this->db->query("SELECT * FROM buka_tutup")->result(),
      'penilaian_sudah_dipublikasikan' => $modelPenilaian->is_penilaian_published($periode),
    ];

    $data['jml_draft'] = count(array_filter($modelPenilaian->get_data_penilaian_by_periode($periode), function ($item) {
      return isset($item->id_status_penilaian) && $item->id_status_penilaian == 1;
    }));
    $data['jml_penilaian_validator'] = count(array_filter($modelPenilaian->get_data_penilaian_by_periode($periode), function ($item) {
      return isset($item->id_status_penilaian) && $item->id_status_penilaian == 2;
    }));
    $data['jml_revisi_validator'] = count(array_filter($modelPenilaian->get_data_penilaian_by_periode($periode), function ($item) {
      return isset($item->id_status_penilaian) && $item->id_status_penilaian == 3;
    }));
    $data['jml_valid'] = count(array_filter($modelPenilaian->get_data_penilaian_by_periode($periode), function ($item) {
      return isset($item->id_status_penilaian) && $item->id_status_penilaian == 4;
    }));
    $data['jml_belum_input'] = count(array_filter($modelPenilaian->get_data_penilaian_by_periode($periode), function ($item) {
      return !isset($item->id_status_penilaian) || $item->id_status_penilaian === null;
    }));
    $data['jml_draft_validator'] = count(array_filter($modelPenilaian->get_data_penilaian_by_periode($periode), function ($item) {
      return isset($item->id_status_penilaian) && $item->id_status_penilaian == 5;
    }));
    $data['jml_menunggu_approval_admin'] = count(array_filter($modelPenilaian->get_data_penilaian_by_periode($periode), function ($item) {
      return isset($item->id_status_penilaian) && $item->id_status_penilaian == 6;
    }));

    // echo json_encode($data);exit;

    $this->load->view("admin/master/progres/v_lihat_progres", $data);
  }

  public function exportNilaiPdf($enc_id_penilaian_topologi)
  {
    $id_penilaian_topologi = safe_url_decrypt($enc_id_penilaian_topologi);
    $data = [
      'progres_penilaian' => $this->Penilaian_model->get_data_penilaian_by_id($id_penilaian_topologi),
    ];
    $data['nama_pt'] = $data['progres_penilaian']->nama_pt;

    // echo json_encode($data['progres_penilaian']);exit;
    // return $this->load->view('admin/master/progres/export_nilai_pdf', $data);

    $this->load->library('pdfgenerator');
    $file_pdf = "Hasil Review Eksternal LLDikti Wilayah III_" . $data['nama_pt'] . "_" . $data['progres_penilaian']->periode . "_" . date('Y-m-d_H-i-s');
    $paper = 'A4';
    $orientation = "portrait";
    $html = $this->load->view('admin/master/progres/export_nilai_pdf', $data, true);
    $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
  }

  public function exportNilaiPdf30($enc_id_penilaian_topologi)
  {
    $id_penilaian_topologi = safe_url_decrypt($enc_id_penilaian_topologi);
    $data = [
      'progres_penilaian' => $this->Penilaian30_model->get_data_penilaian_by_id($id_penilaian_topologi),
    ];
    $data['nama_pt'] = $data['progres_penilaian']->nama_pt;

    $this->load->library('pdfgenerator');
    $file_pdf = "Hasil Review Eksternal LLDikti Wilayah III_" . $data['nama_pt'] . "_" . $data['progres_penilaian']->periode . "_" . date('Y-m-d_H-i-s');
    $paper = 'A4';
    $orientation = "portrait";
    $html = $this->load->view('admin/master/progres/export_nilai_pdf', $data, true);
    $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
  }

  public function exportNilaiExcel($enc_periode)
  {
    $periode = safe_url_decrypt($enc_periode);
    $data_penilaian = $this->Penilaian_model->get_data_penilaian_by_periode($periode);

    // echo json_encode($data_penilaian);exit;

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set judul di baris 1
    $sheet->setCellValue('A1', 'Rekap Penilaian Tipologi Periode ' . $periode);
    // Merge judul dari A1 sampai V1
    $sheet->mergeCells('A1:V1');
    // Style judul: bold, font size 14, center
    $sheet->getStyle('A1:V1')->applyFromArray([
      'font' => ['bold' => true, 'size' => 14],
      'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
      ]
    ]);
    // Baris 2 dikosongkan (tidak perlu diisi)

    // Set Header Kolom di baris 3
    $sheet->setCellValue('A3', 'KODE PT');
    $sheet->setCellValue('B3', 'NAMA PT');
    $sheet->setCellValue('C3', 'PERIODE');
    $sheet->setCellValue('D3', 'SKOR 1');
    $sheet->setCellValue('E3', 'SKOR 2');
    $sheet->setCellValue('F3', 'SKOR 3');
    $sheet->setCellValue('G3', 'SKOR 4');
    $sheet->setCellValue('H3', 'SKOR TOTAL');
    $sheet->setCellValue('I3', 'CATATAN 1');
    $sheet->setCellValue('J3', 'CATATAN 2');
    $sheet->setCellValue('K3', 'CATATAN 3');
    $sheet->setCellValue('L3', 'CATATAN 4');
    $sheet->setCellValue('M3', 'CATATAN KESELURUHAN');
    $sheet->setCellValue('N3', 'CATATAN 1 VALIDATOR');
    $sheet->setCellValue('O3', 'CATATAN 2 VALIDATOR');
    $sheet->setCellValue('P3', 'CATATAN 3 VALIDATOR');
    $sheet->setCellValue('Q3', 'CATATAN 4 VALIDATOR');
    $sheet->setCellValue('R3', 'CATATAN KESELURUHAN VALIDATOR');
    $sheet->setCellValue('S3', 'TIPOLOGI');
    $sheet->setCellValue('T3', 'FASILITATOR');
    $sheet->setCellValue('U3', 'VALIDATOR');
    $sheet->setCellValue('V3', 'STATUS');

    // Set lebar kolom otomatis, kecuali kolom catatan (I-R) diberikan lebar fix
    $catatanColumns = ['I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R'];
    foreach (range('A', 'V') as $col) {
      if (in_array($col, $catatanColumns)) {
        $sheet->getColumnDimension($col)->setWidth(30); // lebar fix, bisa diubah sesuai kebutuhan
      } else {
        $sheet->getColumnDimension($col)->setAutoSize(true);
      }
    }

    // Set wrap text untuk kolom catatan (I-R) di semua baris
    for ($col = 'I'; $col <= 'R'; $col++) {
      $sheet->getStyle($col . '1:' . $col . '1048576')->getAlignment()->setWrapText(true);
    }

    // Set style header: bold, middle center (baris 3)
    $headerStyle = [
      'font' => ['bold' => true],
      'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
      ]
    ];
    $sheet->getStyle('A3:V3')->applyFromArray($headerStyle);

    // Hitung jumlah baris data
    $dataCount = count($data_penilaian);
    $lastRow = $dataCount + 3;

    // Set border untuk semua sel yang terisi data (header dan data)
    $borderStyle = [
      'borders' => [
        'allBorders' => [
          'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => 'FF000000'],
        ],
      ],
    ];
    $sheet->getStyle('A3:V' . $lastRow)->applyFromArray($borderStyle);

    // Set align center untuk kolom tertentu (A, C, D, E, F, G, H, S, V)
    $centerColumns = ['A', 'C', 'D', 'E', 'F', 'G', 'H', 'S', 'V'];
    foreach ($centerColumns as $col) {
      $sheet->getStyle($col . '4:' . $col . $lastRow)
        ->getAlignment()
        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    }

    // Set align middle (vertical center) untuk semua isi value (A4:V$lastRow)
    $sheet->getStyle('A4:V' . $lastRow)
      ->getAlignment()
      ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

    // Isi data mulai baris 4
    $row = 4;
    foreach ($data_penilaian as $item) {
      $sheet->setCellValue('A' . $row, $item->kode_pt);
      $sheet->setCellValue('B' . $row, $item->nama_pt);
      $sheet->setCellValue('C' . $row, $item->periode);
      $sheet->setCellValueExplicit('D' . $row, number_format((float)($item->skor_1 ?? 0), 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
      $sheet->setCellValueExplicit('E' . $row, number_format((float)($item->skor_2 ?? 0), 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
      $sheet->setCellValueExplicit('F' . $row, number_format((float)($item->skor_3 ?? 0), 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
      $sheet->setCellValueExplicit('G' . $row, number_format((float)($item->skor_4 ?? 0), 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
      $sheet->setCellValueExplicit('H' . $row, number_format((float)($item->skor_total ?? 0), 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
      $sheet->setCellValue('I' . $row, $item->catatan_1);
      $sheet->setCellValue('J' . $row, $item->catatan_2);
      $sheet->setCellValue('K' . $row, $item->catatan_3);
      $sheet->setCellValue('L' . $row, $item->catatan_4);
      $sheet->setCellValue('M' . $row, $item->catatan_keseluruhan);
      $sheet->setCellValue('N' . $row, $item->catatan_1_validator);
      $sheet->setCellValue('O' . $row, $item->catatan_2_validator);
      $sheet->setCellValue('P' . $row, $item->catatan_3_validator);
      $sheet->setCellValue('Q' . $row, $item->catatan_4_validator);
      $sheet->setCellValue('R' . $row, $item->catatan_keseluruhan_validator);
      $sheet->setCellValue('S' . $row, $item->tipologi);
      $sheet->setCellValue('T' . $row, $item->nama_fasilitator);
      $sheet->setCellValue('U' . $row, $item->nama_validator);
      $sheet->setCellValue('V' . $row, $item->nm_status);
      $row++;
    }

    // Rename sheet (max 31 chars)
    $sheetTitle = 'Penilaian Tipologi ' . $periode;
    $sheet->setTitle(substr($sheetTitle, 0, 31));
    $sheet->setSelectedCell('A1');

    // Export file
    $writer = new Xlsx($spreadsheet);
    $filename = 'Rekap Penilaian Tipologi Periode ' . $periode . '_' . date('Y-m-d_H-i-s') . '.xlsx';

    // Cegah output lain mencemari file
    if (ob_get_length()) ob_end_clean();

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit;
  }

  public function exportNilaiExcel30($enc_periode)
  {
    $periode = safe_url_decrypt($enc_periode);
    $data_penilaian = $this->Penilaian30_model->get_data_penilaian_by_periode($periode);

    // echo json_encode($data_penilaian);exit;

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set judul di baris 1
    $sheet->setCellValue('A1', 'Rekap Penilaian Tipologi Periode ' . $periode);
    // Merge judul dari A1 sampai U1
    $sheet->mergeCells('A1:U1');
    // Style judul: bold, font size 14, center
    $sheet->getStyle('A1:U1')->applyFromArray([
      'font' => ['bold' => true, 'size' => 14],
      'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
      ]
    ]);
    // Baris 2 dikosongkan (tidak perlu diisi)

    // Set Header Kolom di baris 3
    $sheet->setCellValue('A3', 'KODE PT');
    $sheet->setCellValue('B3', 'NAMA PT');
    $sheet->setCellValue('C3', 'PERIODE');
    $sheet->setCellValue('D3', 'SKOR 1A');
    $sheet->setCellValue('E3', 'SKOR 1B');
    $sheet->setCellValue('F3', 'SKOR 2');
    $sheet->setCellValue('G3', 'SKOR 1 BOBOT');
    $sheet->setCellValue('H3', 'SKOR 2 BOBOT');
    $sheet->setCellValue('I3', 'SKOR TOTAL');
    $sheet->setCellValue('J3', 'CATATAN 1A');
    $sheet->setCellValue('K3', 'CATATAN 1B');
    $sheet->setCellValue('L3', 'CATATAN 2');
    $sheet->setCellValue('M3', 'CATATAN KESELURUHAN');
    $sheet->setCellValue('N3', 'CATATAN 1A VALIDATOR');
    $sheet->setCellValue('O3', 'CATATAN 1B VALIDATOR');
    $sheet->setCellValue('P3', 'CATATAN 2 VALIDATOR');
    $sheet->setCellValue('Q3', 'CATATAN KESELURUHAN VALIDATOR');
    $sheet->setCellValue('R3', 'TIPOLOGI');
    $sheet->setCellValue('S3', 'FASILITATOR');
    $sheet->setCellValue('T3', 'VALIDATOR');
    $sheet->setCellValue('U3', 'STATUS');

    // Set lebar kolom otomatis, kecuali kolom catatan (J-Q) diberikan lebar fix
    $catatanColumns = ['J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q'];
    foreach (range('A', 'U') as $col) {
      if (in_array($col, $catatanColumns)) {
        $sheet->getColumnDimension($col)->setWidth(30); // lebar fix, bisa diubah sesuai kebutuhan
      } else {
        $sheet->getColumnDimension($col)->setAutoSize(true);
      }
    }

    // Set wrap text untuk kolom catatan (J-Q) di semua baris
    for ($col = 'J'; $col <= 'Q'; $col++) {
      $sheet->getStyle($col . '1:' . $col . '1048576')->getAlignment()->setWrapText(true);
    }

    // Set style header: bold, middle center (baris 3)
    $headerStyle = [
      'font' => ['bold' => true],
      'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
      ]
    ];
    $sheet->getStyle('A3:U3')->applyFromArray($headerStyle);

    // Hitung jumlah baris data
    $dataCount = count($data_penilaian);
    $lastRow = $dataCount + 3;

    // Set border untuk semua sel yang terisi data (header dan data)
    $borderStyle = [
      'borders' => [
        'allBorders' => [
          'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => 'FF000000'],
        ],
      ],
    ];
    $sheet->getStyle('A3:U' . $lastRow)->applyFromArray($borderStyle);

    // Set align center untuk kolom tertentu (A, C, D, E, F, G, H, I, R, U)
    $centerColumns = ['A', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'R', 'U'];
    foreach ($centerColumns as $col) {
      $sheet->getStyle($col . '4:' . $col . $lastRow)
        ->getAlignment()
        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    }

    // Set align middle (vertical center) untuk semua isi value (A4:U$lastRow)
    $sheet->getStyle('A4:U' . $lastRow)
      ->getAlignment()
      ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

    // Isi data mulai baris 4
    $row = 4;
    foreach ($data_penilaian as $item) {
      $sheet->setCellValue('A' . $row, $item->kode_pt);
      $sheet->setCellValue('B' . $row, $item->nama_pt);
      $sheet->setCellValue('C' . $row, $item->periode);
      $sheet->setCellValueExplicit('D' . $row, number_format((float)($item->skor_1a ?? 0), 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
      $sheet->setCellValueExplicit('E' . $row, number_format((float)($item->skor_1b ?? 0), 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
      $sheet->setCellValueExplicit('F' . $row, number_format((float)($item->skor_2 ?? 0), 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
      $sheet->setCellValueExplicit('G' . $row, number_format((float)($item->skor_1_bobot ?? 0), 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
      $sheet->setCellValueExplicit('H' . $row, number_format((float)($item->skor_2_bobot ?? 0), 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
      $sheet->setCellValueExplicit('I' . $row, number_format((float)($item->skor_total ?? 0), 2, '.', ''), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
      $sheet->setCellValue('J' . $row, $item->catatan_1a);
      $sheet->setCellValue('K' . $row, $item->catatan_1b);
      $sheet->setCellValue('L' . $row, $item->catatan_2);
      $sheet->setCellValue('M' . $row, $item->catatan_keseluruhan);
      $sheet->setCellValue('N' . $row, $item->catatan_1a_validator);
      $sheet->setCellValue('O' . $row, $item->catatan_1b_validator);
      $sheet->setCellValue('P' . $row, $item->catatan_2_validator);
      $sheet->setCellValue('Q' . $row, $item->catatan_keseluruhan_validator);
      $sheet->setCellValue('R' . $row, $item->tipologi);
      $sheet->setCellValue('S' . $row, $item->nama_fasilitator);
      $sheet->setCellValue('T' . $row, $item->nama_validator);
      $sheet->setCellValue('U' . $row, $item->nm_status);
      $row++;
    }

    // Rename sheet (max 31 chars)
    $sheetTitle = 'Penilaian Tipologi ' . $periode;
    $sheet->setTitle(substr($sheetTitle, 0, 31));
    $sheet->setSelectedCell('A1');

    // Export file
    $writer = new Xlsx($spreadsheet);
    $filename = 'Rekap Penilaian Tipologi Periode ' . $periode . '_' . date('Y-m-d_H-i-s') . '.xlsx';

    // Cegah output lain mencemari file
    if (ob_get_length()) ob_end_clean();

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit;
  }

  public function publishPenilaian()
  {
    $periode = safe_url_decrypt($this->input->post('periode'));

    $data = $this->Penilaian_model->publish_penilaian_by_periode($periode);
    if (!$data) {
      $this->session->set_flashdata('error', 'Penilaian gagal dipublikasikan.');
      redirect('beranda/progres');
    }
    $this->session->set_flashdata('success', 'Penilaian berhasil dipublikasikan.');
    redirect('beranda/progres');
  }

  public function publishPenilaianPt()
  {
    if (!$this->input->is_ajax_request()) {
      show_error('Akses tidak diizinkan.', 403);
      return;
    }

    $periode = safe_url_decrypt($this->input->post('periode'));
    $penilaian_id = safe_url_decrypt($this->input->post('penilaian_id'));
    $kode_pt = safe_url_decrypt($this->input->post('kode_pt'));

    if (!$periode || !$penilaian_id || !$kode_pt) {
      echo json_encode([
        'status' => 'error',
        'message' => 'Data tidak valid.'
      ]);
      return;
    }

    $success = $this->Penilaian_model->publish_penilaian_by_pt($periode, $penilaian_id, $kode_pt);

    if ($success) {
      echo json_encode([
        'status' => 'success',
        'message' => 'Penilaian berhasil dipublikasikan.'
      ]);
    } else {
      echo json_encode([
        'status' => 'error',
        'message' => 'Penilaian gagal dipublikasikan.'
      ]);
    }
  }

  public function ubahStatusPenilaian($enc_id_penilaian)
  {
    $id_penilaian = safe_url_decrypt($enc_id_penilaian);
    $ubah_status_penilaian = $this->Penilaian_model->ubahStatusPenilaian($id_penilaian, 'menunggu');

    if ($ubah_status_penilaian) {
      $this->session->set_flashdata('success', 'Proses berhasil, status diubah menjadi Draft Validator');
    } else {
      $this->session->set_flashdata('error', 'Proses gagal');
    }

    if (!empty($_SERVER['HTTP_REFERER'])) {
      redirect($_SERVER['HTTP_REFERER']);
    } else {
      redirect('admin/penilaian-tipologi');
    }
  }

  public function getFaswilValidator()
  {
    if (!$this->input->is_ajax_request()) {
      show_error('Akses tidak diizinkan.', 403);
      return;
    }

    $periode = safe_url_decrypt($this->input->post('periode'));
    $all_fasilitators = $this->db->select('users.id, users.nama')->from('users')->join('user_roles', 'users.id = user_roles.user_id')->where('user_roles.role_id', 4)->get()->result();
    $all_validators = $this->db->select('users.id, users.nama')->from('users')->join('user_roles', 'users.id = user_roles.user_id')->where('user_roles.role_id', 5)->get()->result();

    if ($periode) {
      echo json_encode([
        'status' => 'success',
        'all_fasilitators' => $all_fasilitators,
        'all_validators' => $all_validators,
        'enc_periode' => safe_url_encrypt($periode),
      ]);
    } else {
      echo json_encode([
        'status' => 'error',
        'message' => 'Data tidak ditemukan.'
      ]);
    }
  }

  public function getPtBinaanFasilitator()
  {
    $periode = safe_url_decrypt($this->input->post('periode'));
    $id_fasilitator = $this->input->post('idFasilitator');
    $data = $this->Penilaian_model->getPtBinaanFasilitatorByPeriode($periode, $id_fasilitator);
    echo json_encode([
      'status' => 'success',
      'data' => $data,
    ]);
  }

  public function getPtBinaanValidator()
  {
    $periode = safe_url_decrypt($this->input->post('periode'));
    $id_validator = $this->input->post('idValidator');
    $data = $this->Penilaian_model->getPtBinaanValidatorByPeriode($periode, $id_validator);
    echo json_encode([
      'status' => 'success',
      'data' => $data,
      'periode' => $periode,
      'id_validator' => $id_validator,
    ]);
  }

  public function updateFaswilValidator()
  {
    if (!$this->input->is_ajax_request()) {
      show_error('Akses tidak diizinkan.', 403);
      return;
    }

    $tipe = $this->input->post('tipe');
    $periode = safe_url_decrypt($this->input->post('periode'));
    if ($tipe === 'fasilitator') {
      $id_awal = $this->input->post('idFasilitator');
      $id_pengganti = $this->input->post('idFasilitatorPengganti');
      $perguruan_tinggi = $this->input->post('PTFaswil');
    } else if ($tipe === 'validator') {
      $id_awal = $this->input->post('idValidator');
      $id_pengganti = $this->input->post('idValidatorPengganti');
      $perguruan_tinggi = $this->input->post('PTValidator');
    } else {
      echo json_encode([
        'status' => 'error',
        'message' => 'Tipe tidak valid.'
      ]);
      return;
    }

    if (!$periode || !$id_awal || !$id_pengganti) {
      echo json_encode([
        'status' => 'error',
        'message' => 'Data tidak valid.'
      ]);
      return;
    }

    $update = $this->Penilaian_model->updateFaswilValidator($tipe, $periode, $id_awal, $id_pengganti, $perguruan_tinggi);

    if ($update) {
      echo json_encode([
        'status' => 'success',
        'message' => ucfirst($tipe) . ' berhasil diperbarui.'
      ]);
    } else {
      echo json_encode([
        'status' => 'error',
        'message' => 'Gagal memperbarui ' . ucfirst($tipe) . '.'
      ]);
    }
  }
}
