<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Laporan Penilaian Tipologi <?= htmlspecialchars($progres_penilaian->nama_pt); ?></title>

  <style>
    body {
      font-family: DejaVu Sans, Arial, sans-serif;
      font-size: 12px;
      color: #333;
    }

    .header {
      text-align: center;
      border-bottom: 3px solid #337ab7;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }

    .header h2 {
      margin: 0;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .header small {
      color: #777;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    .table th {
      text-align: left;
      width: 35%;
      background: #f2f2f2;
      padding: 8px;
      border: 1px solid #ddd;
      text-transform: uppercase;
      font-size: 11px;
    }

    .table td {
      padding: 8px;
      border: 1px solid #ddd;
    }

    .section-title {
      background: #337ab7;
      color: #fff;
      padding: 6px 10px;
      font-weight: bold;
      margin-top: 20px;
      margin-bottom: 0;
    }

    .status {
      padding: 5px 10px;
      border-radius: 4px;
      color: #fff;
      font-size: 11px;
      font-weight: bold;
      display: inline-block;
    }

    .status-valid {
      background: #28a745;
    }

    .status-revisi {
      background: #dc3545;
    }

    .status-proses {
      background: #f0ad4e;
    }

    .footer {
      margin-top: 40px;
      font-size: 11px;
      text-align: right;
      color: #666;
    }
  </style>
</head>

<body>
  <div class="header">
    <h2>Laporan Penilaian Tipologi</h2>
    <small>Sistem Penilaian Tipologi Perguruan Tinggi</small>
  </div>

  <div class="section-title">Informasi Perguruan Tinggi</div>
  <table class="table">
    <tr>
      <th>Kode PT</th>
      <td><?= htmlspecialchars($progres_penilaian->kode_pt); ?></td>
    </tr>
    <tr>
      <th>Nama PT</th>
      <td><?= htmlspecialchars($progres_penilaian->nama_pt); ?></td>
    </tr>
    <tr>
      <th>Periode</th>
      <td><?= htmlspecialchars($progres_penilaian->keterangan); ?></td>
    </tr>
    <tr>
      <th>Tipologi</th>
      <td><?= htmlspecialchars($progres_penilaian->tipologi); ?></td>
    </tr>
    <tr>
      <th>Nama Fasilitator</th>
      <td><?= htmlspecialchars($progres_penilaian->nama_fasilitator); ?></td>
    </tr>
    <tr>
      <th>Nama Validator</th>
      <td><?= htmlspecialchars($progres_penilaian->nama_validator); ?></td>
    </tr>
  </table>

  <div class="section-title">Hasil Penilaian</div>

  <table class="table">
    <tr>
      <th>Skor Total</th>
      <td><strong><?= htmlspecialchars($progres_penilaian->skor_total); ?></strong></td>
    </tr>
    <tr>
      <th>Status</th>
      <td>
        <?php
        $status_class = "status-proses";

        if ($progres_penilaian->id_status == 1 || $progres_penilaian->id_status == 4) {
          $status_class = "status-valid";
        }

        if ($progres_penilaian->id_status == 3) {
          $status_class = "status-revisi";
        }
        ?>
        <span class="status <?= $status_class ?>">
          <?= strtoupper($progres_penilaian->nm_status); ?>
        </span>
      </td>
    </tr>
    <tr>
      <th>Catatan Keseluruhan</th>
      <td><?= nl2br(htmlspecialchars($progres_penilaian->catatan_keseluruhan)); ?></td>
    </tr>
  </table>

  <div class="footer">
    Dicetak pada :
    <?php
    date_default_timezone_set('Asia/Jakarta');
    echo date('d-m-Y H:i:s');
    ?>
  </div>
</body>

</html>