<?php
if (!function_exists('bulan_indonesia')) {
  function bulan_indonesia($bulan)
  {
    $namaBulan = [
      1 => 'Januari',
      'Februari',
      'Maret',
      'April',
      'Mei',
      'Juni',
      'Juli',
      'Agustus',
      'September',
      'Oktober',
      'November',
      'Desember'
    ];

    $bulan = (int) $bulan;
    return $namaBulan[$bulan] ?? '';
  }
}

if (!function_exists('tanggal_indonesia')) {
  function tanggal_indonesia($tanggal)
  {
    if (empty($tanggal) || $tanggal === '0000-00-00') {
      return '-';
    }

    $timestamp = strtotime($tanggal);
    if ($timestamp === false) {
      return '-';
    }

    $hari = date('d', $timestamp);
    $bulan = bulan_indonesia(date('m', $timestamp));
    $tahun = date('Y', $timestamp);

    return $hari . ' ' . $bulan . ' ' . $tahun;
  }
}

$tglSkPendirianIndonesia = tanggal_indonesia($data->tanggal_sk_pendirian_pt ?? $data->tgl_sk_pendirian_pt ?? null);
$tglAkhirAptIndonesia = tanggal_indonesia($data->tanggal_akhir_apt ?? $data->tgl_akhir_apt ?? null);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">

  <style>
    @page {
      margin: 2.5cm 2.5cm 2.5cm 3cm;
    }

    body {
      font-family: "Times New Roman", serif;
      font-size: 12pt;
      line-height: 1.5;
      color: #000;
    }

    .center {
      text-align: center;
    }

    .justify {
      text-align: justify;
    }

    .bold {
      font-weight: bold;
    }

    .uppercase {
      text-transform: uppercase;
    }

    .page-break {
      page-break-after: always;
    }

    .logo {
      width: 160px;
      margin-bottom: 20px;
    }

    h1,
    h2,
    h3,
    h4 {
      margin: 0;
      padding: 0;
    }

    .judul-cover {
      margin-top: 120px;
      line-height: 1.8;
    }

    .judul-cover h1 {
      font-size: 22pt;
      font-weight: bold;
    }

    .judul-cover h2 {
      font-size: 18pt;
      font-weight: bold;
    }

    .tahun {
      margin-top: 420px;
      font-size: 16pt;
      font-weight: bold;
    }

    .section-title {
      font-size: 16pt;
      font-weight: bold;
      margin-top: 30px;
      margin-bottom: 20px;
      text-transform: uppercase;
    }

    .sub-title {
      font-size: 14pt;
      font-weight: bold;
      margin-top: 25px;
      margin-bottom: 10px;
      text-align: justify;
    }

    table.identitas {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table.identitas td {
      padding: 5px 0;
      vertical-align: top;
    }

    table.identitas td:first-child {
      width: 260px;
    }

    .isi {
      text-align: justify;
      margin-top: 10px;
    }

    .tautan {
      color: blue;
      text-decoration: underline;
      word-break: break-all;
    }

    .table-bukti {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }

    .table-bukti th,
    .table-bukti td {
      border: 1px solid #000;
      padding: 8px;
      vertical-align: top;
    }

    .table-bukti th {
      background: #f1f1f1;
      text-align: center;
    }

    /* .page-number {
      position: fixed;
      bottom: -1.5cm;
      left: 50%;
      transform: translateX(-50%);
      font-size: 10pt;
    }

    .page-number:before {
      content: counter(page);
    } */
  </style>
</head>

<body>

  <!-- COVER -->
  <div class="center">

    <img src="<?= base_url('uploads/logo_pt/' . $data->nama_logo) ?>" class="logo">

    <div class="judul-cover">
      <h1>LAPORAN IMPLEMENTASI SPMI</h1>
      <h2 class="uppercase"><?= $data->nama_pt; ?></h2>
    </div>

    <div class="tahun">
      TAHUN <?= substr($data->periode, 0, 4); ?> SEMESTER <?= substr($data->periode, 4, 1); ?>
    </div>
  </div>

  <div class="page-break"></div>

  <div class="page-number"></div>

  <!-- DAFTAR ISI -->
  <div class="section-title center">DAFTAR ISI</div>

  <table style="width:100%; margin-top:40px;">
    <tr>
      <td>DAFTAR ISI</td>
      <!-- <td align="right">2</td> -->
    </tr>
    <tr>
      <td>IDENTITAS PERGURUAN TINGGI</td>
      <!-- <td align="right">3</td> -->
    </tr>
    <tr>
      <td>BAB I PENDAHULUAN</td>
      <!-- <td align="right">4</td> -->
    </tr>
    <tr>
      <td>BAB II DIFERENSIASI MISI</td>
      <!-- <td align="right">5</td> -->
    </tr>
    <tr>
      <td>BAB III IMPLEMENTASI SPMI</td>
      <!-- <td align="right">6</td> -->
    </tr>
    <tr>
      <td>BAB IV PENUTUP</td>
      <!-- <td align="right">7</td> -->
    </tr>
  </table>

  <div class="page-break"></div>

  <!-- IDENTITAS -->
  <div class="section-title center">
    IDENTITAS PERGURUAN TINGGI
  </div>

  <table class="identitas">
    <tr>
      <td>Nama Perguruan Tinggi</td>
      <td width="10px">:</td>
      <td><?= $data->nama_pt; ?></td>
    </tr>

    <tr>
      <td>Alamat</td>
      <td>:</td>
      <td><?= $data->alamat; ?></td>
    </tr>

    <tr>
      <td>Tanggal SK Pendirian PT</td>
      <td>:</td>
      <td><?= $tglSkPendirianIndonesia; ?></td>
    </tr>

    <tr>
      <td>Pejabat Penandatangan</td>
      <td>:</td>
      <td><?= $data->pejabat_penandatangan; ?></td>
    </tr>

    <tr>
      <td>Tahun Pertama Kali Menerima Mahasiswa</td>
      <td>:</td>
      <td><?= $data->tahun_pertama_terima_mhs; ?></td>
    </tr>

    <tr>
      <td>Akreditasi Perguruan Tinggi</td>
      <td>:</td>
      <td><?= $data->akreditasi_pt; ?></td>
    </tr>

    <tr>
      <td>Tanggal Akhir APT</td>
      <td>:</td>
      <td><?= $tglAkhirAptIndonesia; ?></td>
    </tr>
  </table>

  <div class="page-break"></div>

  <!-- BAB I -->
  <div class="section-title center">
    BAB I<br>
    PENDAHULUAN
  </div>

  <div class="sub-title">
    1. Dasar Penyusunan
  </div>

  <div class="isi">
    <?= nl2br($data->dasar_penyusunan); ?>
  </div>

  <div class="sub-title">
    2. Mekanisme Kerja Penyusunan Laporan
  </div>

  <div class="isi">
    <?= nl2br($data->mekanisme_kerja_penyusunan_laporan); ?>
  </div>

  <div class="page-break"></div>

  <!-- BAB II -->
  <div class="section-title center">
    BAB II<br>
    DIFERENSIASI MISI
  </div>

  <div class="sub-title">
    Penetapan diferensiasi misi dan rencana strategis serta rencana pengembangan perguruan tinggi dalam mewujudkan diferensiasi misinya
  </div>

  <div class="isi">
    <?= nl2br($data->penetapan_diferensiasi); ?>
  </div>

  <div class="page-break"></div>

  <!-- BAB III -->
  <div class="section-title center">
    BAB III<br>
    IMPLEMENTASI SPMI
  </div>

  <!-- A -->
  <div class="sub-title">
    A. Sasaran Mutu Masukan
  </div>

  <div class="isi">
    <?= nl2br($data->sasaran_mutu_masukan); ?>
  </div>

  <p>
    <strong>Tautan Dokumen Pendukung :</strong><br>
    <a href="<?= $data->tautan_sasaran_mutu_masukan; ?>" class="tautan">
      <?= $data->tautan_sasaran_mutu_masukan; ?>
    </a>
  </p>

  <!-- B -->
  <div class="sub-title">
    B. Sasaran Mutu Proses
  </div>

  <div class="isi">
    <?= nl2br($data->sasaran_mutu_proses); ?>
  </div>

  <p>
    <strong>Tautan Dokumen Pendukung :</strong><br>
    <a href="<?= $data->tautan_sasaran_mutu_proses; ?>" class="tautan">
      <?= $data->tautan_sasaran_mutu_proses; ?>
    </a>
  </p>

  <!-- C -->
  <div class="sub-title">
    C. Sasaran Mutu Luaran
  </div>

  <div class="isi">
    <?= nl2br($data->sasaran_mutu_luaran); ?>
  </div>

  <p>
    <strong>Tautan Dokumen Pendukung :</strong><br>
    <a href="<?= $data->tautan_sasaran_mutu_luaran; ?>" class="tautan">
      <?= $data->tautan_sasaran_mutu_luaran; ?>
    </a>
  </p>

  <!-- D -->
  <div class="sub-title">
    D. Sasaran Mutu Dampak
  </div>

  <div class="isi">
    <?= nl2br($data->sasaran_mutu_dampak); ?>
  </div>

  <p>
    <strong>Tautan Dokumen Pendukung :</strong><br>
    <a href="<?= $data->tautan_sasaran_mutu_dampak; ?>" class="tautan">
      <?= $data->tautan_sasaran_mutu_dampak; ?>
    </a>
  </p>

  <div class="page-break"></div>

  <!-- BAB IV -->
  <div class="section-title center">
    BAB IV<br>
    PENUTUP
  </div>

  <div class="isi">
    <?= nl2br($data->narasi_bab4); ?>
  </div>

</body>

</html>