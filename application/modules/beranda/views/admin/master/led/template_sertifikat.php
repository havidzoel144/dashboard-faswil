<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <style>
    @page {
      size: A4 landscape;
      margin: 0;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: 'Arial', sans-serif;
      color: #0a0a2a;
    }

    .cert-container {
      /* width: 297mm; */
      height: 182.05mm;
      padding: 10mm;
      box-sizing: border-box;
      position: relative;
      background-color: white;
      border: 15px solid #0a0a2a;
      /* Bingkai Biru Tua */
    }

    /* Aksen Sudut Oranye */
    .corner-top-left {
      position: absolute;
      top: 0;
      left: 0;
      width: 0;
      height: 0;
      border-top: 70px solid #f39c12;
      border-right: 70px solid transparent;
    }

    .corner-bottom-right {
      position: absolute;
      bottom: 0;
      right: 0;
      width: 0;
      height: 0;
      border-bottom: 70px solid #f39c12;
      border-left: 70px solid transparent;
    }

    .content {
      text-align: center;
      /* margin-top: 10mm; */
    }

    .logo {
      width: 70px;
      margin-bottom: 10px;
    }

    .header-text {
      text-transform: uppercase;
      font-weight: bold;
      margin: 0;
      font-size: 14pt;
    }

    .sub-header {
      font-size: 12pt;
      margin: 2px 0 15px 0;
    }

    .title-sertifikat {
      font-size: 36pt;
      font-weight: normal;
      letter-spacing: 4px;
      margin: 10px 0 0 0;
      color: #333;
    }

    .nomor-surat {
      font-size: 11pt;
      margin-bottom: 20px;
    }

    .label-diberikan {
      font-size: 14pt;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .nama-pt {
      font-family: 'Times New Roman', serif;
      font-size: 28pt;
      color: #c5a059;
      /* Warna Emas */
      text-transform: uppercase;
      margin: 10px 0;
    }

    .narasi {
      font-size: 12pt;
      margin: 10px 0;
      line-height: 1.4;
    }

    .tipologi-box {
      font-weight: bold;
      font-size: 13pt;
    }

    .table-skor {
      margin: 15px auto;
      width: 50%;
      border-collapse: collapse;
      text-align: left;
      font-size: 11pt;
    }

    .table-skor td {
      padding: 2px 5px;
    }

    .score-val {
      text-align: right;
      font-weight: bold;
    }

    .footer-sign {
      position: absolute;
      bottom: 5mm;
      left: 50%;
      transform: translateX(-50%);
      text-align: center;
      width: 300px;
    }

    .nama-pejabat {
      font-weight: bold;
      text-decoration: underline;
      margin: 0;
    }
  </style>
</head>

<body>
  <div class="cert-container">
    <div class="corner-top-left"></div>
    <div class="corner-bottom-right"></div>

    <div class="content">
      <!-- Link logo resmi Kemdikbud -->
      <img src="<?= base_url() ?>app-assets/images/logo/tut_wuri_handayani.png" class="logo">
      <p class="header-text">Kementerian Pendidikan Tinggi, Sains, dan Teknologi</p>
      <p class="sub-header">LEMBAGA LAYANAN PENDIDIKAN TINGGI WILAYAH III</p>

      <h1 class="title-sertifikat">SERTIFIKAT</h1>
      <p class="nomor-surat"><?php echo $nomor_sertifikat; ?></p>

      <p class="label-diberikan">DIBERIKAN KEPADA :</p>
      <h2 class="nama-pt">Sekolah Tinggi Manajemen Informatika dan Komputer Indo Daya Suvana</h2>

      <p class="narasi">
        Atas pencapaian implementasi penjaminan mutu internal tahun <?php echo $tahun; ?><br>
        memperoleh <span class="tipologi-box"><?php echo $tipologi; ?></span>
      </p>

      <table class="table-skor">
        <tr>
          <td>Sasaran mutu masukan</td>
          <td class="score-val"><?php echo round($skor_masukan, 0); ?></td>
        </tr>
        <tr>
          <td>Sasaran mutu proses</td>
          <td class="score-val"><?php echo round($skor_proses, 0); ?></td>
        </tr>
        <tr>
          <td>Sasaran mutu luaran</td>
          <td class="score-val"><?php echo round($skor_luaran, 0); ?></td>
        </tr>
        <tr>
          <td>Sasaran mutu dampak</td>
          <td class="score-val"><?php echo round($skor_dampak, 0); ?></td>
        </tr>
        <tr style="border-top: 1px solid #000;">
          <td style="font-weight:bold;">Skor Total :</td>
          <td class="score-val"><?php echo round($skor_total, 0); ?></td>
        </tr>
      </table>
    </div>

    <div class="footer-sign">
      <p style="margin-bottom: 2px;">Tanggal <?php echo $tanggal_cetak; ?></p>
      <p style="font-weight: bold; margin-top: 0;">Kepala LLDIKTI Wilayah III</p>
      <div style="height: 60px;"></div>
      <p class="nama-pejabat"><?php echo $nama_pejabat; ?></p>
      <p style="margin:0;">NIP. <?php echo $nip_pejabat; ?></p>
    </div>
  </div>
</body>

</html>