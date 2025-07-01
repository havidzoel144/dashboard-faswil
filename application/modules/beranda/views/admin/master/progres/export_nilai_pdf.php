<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= $nama_pt; ?>/</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
  <div class="container">
    <div class="panel panel-primary">
      <div class="panel-heading text-center">
        <h3 class="panel-title text-uppercase">Detail Penilaian Tipologi</h3>
      </div>
      <div class="panel-body">
        <table class="table table-striped table-bordered">
          <tbody>
            <style>
              .table th {
                text-transform: uppercase;
                background-color: #f5f5f5;
                color: #333;
                vertical-align: middle !important;
                font-weight: bold;
              }

              .table td {
                background-color: #fff;
                vertical-align: middle !important;
              }

              .panel-primary {
                border-color: #337ab7;
                box-shadow: 0 2px 8px rgba(51, 122, 183, 0.1);
              }

              .panel-heading {
                background: linear-gradient(90deg, #337ab7 0%, #5bc0de 100%);
                color: #fff !important;
                border-bottom: 2px solid #286090;
              }

              .label {
                font-size: 13px;
                padding: 6px 12px;
                border-radius: 12px;
              }

              .table-striped>tbody>tr:nth-of-type(odd)>td,
              .table-striped>tbody>tr:nth-of-type(odd)>th {
                background-color: #f9f9f9;
              }

              .success th,
              .success td {
                background-color: #dff0d8 !important;
              }

              .info th,
              .info td {
                background-color: #d9edf7 !important;
              }

              .primary th,
              .primary td {
                background-color: #bce8f1 !important;
              }
            </style>
            <tr>
              <th>KODE PT</th>
              <td><?= htmlspecialchars($progres_penilaian->kode_pt); ?></td>
            </tr>
            <tr>
              <th style="width: 35%;">NAMA PT</th>
              <td><?= htmlspecialchars($progres_penilaian->nama_pt); ?></td>
            </tr>
            <tr>
              <th>PERIODE</th>
              <td><?= htmlspecialchars($progres_penilaian->keterangan); ?></td>
            </tr>
            <tr class="info">
              <th>SKOR 1A</th>
              <td><?= htmlspecialchars($progres_penilaian->skor_1a); ?></td>
            </tr>
            <tr class="info">
              <th>SKOR 1B</th>
              <td><?= htmlspecialchars($progres_penilaian->skor_1b); ?></td>
            </tr>
            <tr class="info">
              <th>SKOR 2</th>
              <td><?= htmlspecialchars($progres_penilaian->skor_2); ?></td>
            </tr>
            <tr class="primary">
              <th>SKOR 1 BOBOT</th>
              <td><?= htmlspecialchars($progres_penilaian->skor_1_bobot); ?></td>
            </tr>
            <tr class="primary">
              <th>SKOR 2 BOBOT</th>
              <td><?= htmlspecialchars($progres_penilaian->skor_2_bobot); ?></td>
            </tr>
            <tr class="primary">
              <th>SKOR TOTAL</th>
              <td><?= htmlspecialchars($progres_penilaian->skor_total); ?></td>
            </tr>
            <tr>
              <th>CATATAN 1A</th>
              <td><?= nl2br(htmlspecialchars($progres_penilaian->catatan_1a)); ?></td>
            </tr>
            <tr>
              <th>CATATAN 1B</th>
              <td><?= nl2br(htmlspecialchars($progres_penilaian->catatan_1b)); ?></td>
            </tr>
            <tr>
              <th>CATATAN 2</th>
              <td><?= nl2br(htmlspecialchars($progres_penilaian->catatan_2)); ?></td>
            </tr>
            <tr>
              <th>CATATAN KESELURUHAN</th>
              <td><?= nl2br(htmlspecialchars($progres_penilaian->catatan_keseluruhan)); ?></td>
            </tr>
            <tr class="success">
              <th>CATATAN 1A VALIDATOR</th>
              <td><?= nl2br(htmlspecialchars($progres_penilaian->catatan_1a_validator)); ?></td>
            </tr>
            <tr class="success">
              <th>CATATAN 1B VALIDATOR</th>
              <td><?= nl2br(htmlspecialchars($progres_penilaian->catatan_1b_validator)); ?></td>
            </tr>
            <tr class="success">
              <th>CATATAN 2 VALIDATOR</th>
              <td><?= nl2br(htmlspecialchars($progres_penilaian->catatan_2_validator)); ?></td>
            </tr>
            <tr class="success">
              <th>CATATAN KESELURUHAN VALIDATOR</th>
              <td><?= nl2br(htmlspecialchars($progres_penilaian->catatan_keseluruhan_validator)); ?></td>
            </tr>
            <tr>
              <th>TIPOLOGI</th>
              <td><?= htmlspecialchars($progres_penilaian->tipologi); ?></td>
            </tr>
            <tr>
              <th>NAMA FASILITATOR</th>
              <td><?= htmlspecialchars($progres_penilaian->nama_fasilitator); ?></td>
            </tr>
            <tr>
              <th>NAMA VALIDATOR</th>
              <td><?= htmlspecialchars($progres_penilaian->nama_validator); ?></td>
            </tr>
            <tr>
              <th>STATUS</th>
              <td>
                <?php
                if (isset($progres_penilaian->id_status)) {
                  if ($progres_penilaian->id_status == '1') {
                    echo '<span class="label label-success">' . strtoupper($progres_penilaian->nm_status) . '</span>';
                  } elseif ($progres_penilaian->id_status == '2') {
                    echo '<span class="label label-warning">' . strtoupper($progres_penilaian->nm_status) . '</span>';
                  } elseif ($progres_penilaian->id_status == '3') {
                    echo '<span class="label label-danger">' . strtoupper($progres_penilaian->nm_status) . '</span>';
                  } elseif ($progres_penilaian->id_status == '4') {
                    echo '<span class="label label-success">' . strtoupper($progres_penilaian->nm_status) . '</span>';
                  }
                }
                ?>
              </td>
            </tr>
            <tr>
              <th>TANGGAL CETAK</th>
              <td>
                <?php
                date_default_timezone_set('Asia/Jakarta');
                echo date('d-m-Y H:i:s');
                ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>

</html>