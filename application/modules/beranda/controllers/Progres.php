
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
    $this->load->model(['Periode_model', 'Penilaian_model']);
    date_default_timezone_set("Asia/Jakarta");

    if (!$this->session->userdata('username')) {
      $this->session->set_flashdata('error', 'Anda belum login.');
      redirect('login');
    }
    $this->only_for_roles(['2']);
  }

  public function index()
  {
    $data = [
      'master' => 'active',
      'progres' => 'active',
      'data_periode' => $this->Periode_model->get_all_data_periode(),
    ];

    $this->load->view("admin/master/progres/v_index", $data);
  }

  public function lihatProgres($enc_periode)
  {
    $periode        = safe_url_decrypt($enc_periode);
    $periode_dipilih = $this->Periode_model->get_periode_by_kode($periode);

    $data = [
      'master' => 'active',
      'progres' => 'active',
      'periode_dipilih' => $periode_dipilih,
      'jumlah_fasilitator' => count(array_unique(array_column($this->Penilaian_model->get_data_penilaian_by_periode($periode), 'fasilitator_id'))),
      'jumlah_validator' => count(array_unique(array_column($this->Penilaian_model->get_data_penilaian_by_periode($periode), 'validator_id'))),
      'jumlah_pt' => count(array_unique(array_column($this->Penilaian_model->get_data_penilaian_by_periode($periode), 'kode_pt'))),
      'progres_penilaian' => $this->Penilaian_model->get_data_penilaian_by_periode($periode),
    ];

    $data['jml_penilaian_validator'] = count(array_filter($this->Penilaian_model->get_data_penilaian_by_periode($periode), function ($item) {
      return isset($item->id_status_penilaian) && $item->id_status_penilaian == 2;
    }));
    $data['jml_revisi_validator'] = count(array_filter($this->Penilaian_model->get_data_penilaian_by_periode($periode), function ($item) {
      return isset($item->id_status_penilaian) && $item->id_status_penilaian == 3;
    }));
    $data['jml_valid'] = count(array_filter($this->Penilaian_model->get_data_penilaian_by_periode($periode), function ($item) {
      return isset($item->id_status_penilaian) && $item->id_status_penilaian == 4;
    }));
    $data['jml_belum_input'] = count(array_filter($this->Penilaian_model->get_data_penilaian_by_periode($periode), function ($item) {
      return !isset($item->id_status_penilaian) || $item->id_status_penilaian === null;
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
    $file_pdf = "Penilaian Tipologi_" . $data['nama_pt'] . "_" . $data['progres_penilaian']->periode . "_" . date('Y-m-d_H-i-s');
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
}
