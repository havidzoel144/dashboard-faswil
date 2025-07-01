<?= $this->load->view('admin/v_header') ?>

<style>
    .custom-table {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(86, 59, 255, 0.08);
        background: #fff;
    }

    .custom-table thead tr {
        background: linear-gradient(90deg, #563BFF 0%, #6A82FB 100%);
    }

    .custom-table th,
    .custom-table td {
        vertical-align: middle !important;
        text-align: center;
        border: none;
    }

    .custom-table th {
        color: #fff;
        font-weight: 600;
        letter-spacing: 0.5px;
        font-size: 1.05em;
    }

    .custom-table tbody tr {
        transition: background 0.2s;
    }

    .custom-table tbody tr:hover {
        background: #f4f7ff;
    }

    .catatan-label {
        color: #563BFF;
        font-weight: 600;
    }

    .catatan-short {
        color: #333;
    }

    .lihat-link {
        color: #6A82FB !important;
        font-weight: 500 !important;
        text-decoration: underline !important;
        cursor: pointer !important;
    }

    .modal-content {
        border-radius: 10px;
    }

    .modal-header {
        background: linear-gradient(90deg, #563BFF 0%, #6A82FB 100%);
        color: #fff;
        border-radius: 10px 10px 0 0;
    }

    .modal-title {
        font-weight: 600;
        color: #fff;
    }

    .close {
        color: #fff;
        opacity: 1;
    }

    .custom-header-gradient {
        background: linear-gradient(90deg, #563BFF 0%, #6A82FB 100%);
        /* fallback for old browsers */
        background-repeat: no-repeat;
    }
</style>

<?= $this->load->view('admin/v_menu') ?>

<!-- BEGIN: Content-->
<div class="app-content content center-layout">
    <!-- untuk tidak full layar -->
    <!-- <div class="app-content content center-layout"> -->
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>

        <!-- Basic Horizontal Timeline -->
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <?php
                    if (substr($da->periode, 4, 1) == "1") {
                        $isi_periode = substr($da->periode, 0, 4) . ' Periode 1';
                    } else {
                        $isi_periode = substr($da->periode, 0, 4) . ' Periode 2';
                    }
                    ?>
                    <div class="card-header text-center" style="background: linear-gradient(90deg, #563BFF 0%, #6A82FB 100%); color: #fff; border-radius: 16px 16px 0 0; box-shadow: 0 4px 16px rgba(86,59,255,0.10); padding: 32px 24px 24px 24px; position: relative;">
                        <h4 class="card-title" id="heading-buttons1" style="color: #fff; font-weight: 700; letter-spacing: 1.5px; margin-bottom: 18px; font-size: 2rem; display: flex; align-items: center; justify-content: center;">
                            <i class="fa fa-check-circle" style="color: #ffd700; margin-right: 12px; font-size: 2rem;"></i>
                            Riwayat Validasi
                        </h4>
                        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 24px; margin-bottom: 8px;">
                            <div style="font-size: 1.15em; display: flex; align-items: center; gap: 8px;">
                                <i class="fa fa-calendar" style="color: #fff; font-size: 1.2em;"></i>
                                <span><b><?= $isi_periode ?></b></span>
                            </div>
                            <div style="font-size: 1.15em; display: flex; align-items: center; gap: 8px;">
                                <i class="fa fa-user" style="color: #fff; font-size: 1.2em;"></i>
                                <span>Fasilitator: <b><?= $da->nama ?></b></span>
                            </div>
                            <div style="font-size: 1.15em; display: flex; align-items: center; gap: 8px;">
                                <i class="fa fa-university" style="color: #fff; font-size: 1.2em;"></i>
                                <span>PT: <b><?= $da->nama_pt ?> (<?= $da->kode_pt ?>)</b></span>
                            </div>
                        </div>
                        <a class="heading-elements-toggle" style="color: #fff; position: absolute; top: 18px; right: 24px;"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    </div>

                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                        <tr style="background-color: #563BFF; color: #ffffff">
                                            <th class="text-center">#</th>
                                            <th class="text-center">Skor/<br>validasi 1a</th>
                                            <th class="text-center">Skor/<br>validasi 1b</th>
                                            <th class="text-center">Skor/<br>validasi 2</th>
                                            <th class="text-center" style="width: 25%;">Catatan <br>Fasilitator</th>
                                            <th class="text-center" style="width: 25%;">Catatan <br>Validator</th>
                                            <th class="text-center" style="width: 25%;">Catatan <br>Keseluruhan</th>
                                            <th class="text-center">Status <br>Validasi</th>
                                            <th class="text-center" style="width: 15%;">Tanggal & Waktu <br> Validasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($val as $v) { ?>
                                            <tr>
                                                <td class="text-center" style="font-size:1.05em;"><?= $no++ ?></td>
                                                <td class="text-center" style="font-size:1.05em;">
                                                    <span class="badge badge-primary" style="font-size:1em;"><?= $v->skor_1a ?></span>
                                                    <br>
                                                    <span class="badge <?= ($v->cek_1a == 1) ? 'badge-success' : 'badge-danger' ?>" style="font-size:1em;">
                                                        <?= ($v->cek_1a == 1) ? 'Valid' : 'Tidak Valid' ?>
                                                    </span>
                                                </td>
                                                <td class="text-center" style="font-size:1.05em;">
                                                    <span class="badge badge-primary" style="font-size:1em;"><?= $v->skor_1b ?></span>
                                                    <br>
                                                    <span class="badge <?= ($v->cek_1b == 1) ? 'badge-success' : 'badge-danger' ?>" style="font-size:1em;">
                                                        <?= ($v->cek_1b == 1) ? 'Valid' : 'Tidak Valid' ?>
                                                    </span>
                                                </td>
                                                <td class="text-center" style="font-size:1.05em;">
                                                    <span class="badge badge-primary" style="font-size:1em;"><?= $v->skor_2 ?></span>
                                                    <br>
                                                    <span class="badge <?= ($v->cek_2 == 1) ? 'badge-success' : 'badge-danger' ?>" style="font-size:1em;">
                                                        <?= ($v->cek_2 == 1) ? 'Valid' : 'Tidak Valid' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php
                                                    // Helper function to render catatan, defined outside the loop to avoid redeclaration
                                                    if (!function_exists('renderCatatanFasilitator')) {
                                                        function renderCatatanFasilitator($label, $value, $id)
                                                        {
                                                            $escapedValue = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                                                            if (mb_strlen($value) > 100) {
                                                                $short = mb_substr($value, 0, 100) . '...';
                                                                return "<span class=\"catatan-label\">{$label}:</span> <span class=\"catatan-short\">{$short}</span> <a class=\"lihat-link\" data-toggle=\"modal\" data-target=\"#modalCatatanFasilitator{$id}{$label}\">[lihat selengkapnya]</a>
                                                                <div class=\"modal fade\" id=\"modalCatatanFasilitator{$id}{$label}\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"modalLabelFasilitator{$id}{$label}\" aria-hidden=\"true\">
                                                                    <div class=\"modal-dialog\" role=\"document\">
                                                                        <div class=\"modal-content\">
                                                                            <div class=\"modal-header\">
                                                                                <h5 class=\"modal-title\" id=\"modalLabelFasilitator{$id}{$label}\">Catatan {$label}</h5>
                                                                                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                                                                    <span aria-hidden=\"true\">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class=\"modal-body\" style=\"white-space: pre-wrap;\">{$escapedValue}</div>
                                                                        </div>
                                                                    </div>
                                                                </div><br>";
                                                            } else {
                                                                return "<span class=\"catatan-label\">{$label}:</span> {$escapedValue}<br>";
                                                            }
                                                        }
                                                    }
                                                    echo renderCatatanFasilitator('1a', $v->catatan_1a, $v->id);
                                                    echo "<br>";
                                                    echo renderCatatanFasilitator('1b', $v->catatan_1b, $v->id);
                                                    echo "<br>";
                                                    echo renderCatatanFasilitator('2', $v->catatan_2, $v->id);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    // Helper function to truncate and show modal for validator notes
                                                    if (!function_exists('renderCatatanValidator')) {
                                                        function renderCatatanValidator($label, $value, $id)
                                                        {
                                                            $escapedValue = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                                                            if (mb_strlen($value) > 100) {
                                                                $short = mb_substr($value, 0, 100) . '...';
                                                                return "<span class=\"catatan-label\">{$label}:</span> <span class=\"catatan-short\">{$short}</span> <a class=\"lihat-link\" data-toggle=\"modal\" data-target=\"#modalCatatanValidator{$id}{$label}\">[lihat selengkapnya]</a>
                                                                <div class=\"modal fade\" id=\"modalCatatanValidator{$id}{$label}\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"modalLabelValidator{$id}{$label}\" aria-hidden=\"true\">
                                                                    <div class=\"modal-dialog\" role=\"document\">
                                                                        <div class=\"modal-content\">
                                                                            <div class=\"modal-header\">
                                                                                <h5 class=\"modal-title\" id=\"modalLabelValidator{$id}{$label}\">Catatan Validator {$label}</h5>
                                                                                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                                                                    <span aria-hidden=\"true\">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class=\"modal-body\" style=\"white-space: pre-wrap;\">{$escapedValue}</div>
                                                                        </div>
                                                                    </div>
                                                                </div><br>";
                                                            } else {
                                                                return "<span class=\"catatan-label\">{$label}:</span> {$escapedValue}<br>";
                                                            }
                                                        }
                                                    }
                                                    echo renderCatatanValidator('1a', $v->catatan_1a_validator, $v->id);
                                                    echo "<br>";
                                                    echo renderCatatanValidator('1b', $v->catatan_1b_validator, $v->id);
                                                    echo "<br>";
                                                    echo renderCatatanValidator('2', $v->catatan_2_validator, $v->id);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    // Helper function to truncate and show modal for overall notes
                                                    if (!function_exists('renderCatatanKeseluruhan')) {
                                                        function renderCatatanKeseluruhan($label, $value, $id)
                                                        {
                                                            $escapedValue = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                                                            if (mb_strlen($value) > 100) {
                                                                $short = mb_substr($value, 0, 100) . '...';
                                                                return "<span class=\"catatan-label\">{$label}:</span> <span class=\"catatan-short\">{$short}</span> <a class=\"lihat-link\" data-toggle=\"modal\" data-target=\"#modalCatatanKeseluruhan{$id}{$label}\">[lihat selengkapnya]</a>
                                                                <div class=\"modal fade\" id=\"modalCatatanKeseluruhan{$id}{$label}\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"modalLabelKeseluruhan{$id}{$label}\" aria-hidden=\"true\">
                                                                    <div class=\"modal-dialog\" role=\"document\">
                                                                        <div class=\"modal-content\">
                                                                            <div class=\"modal-header\">
                                                                                <h5 class=\"modal-title\" id=\"modalLabelKeseluruhan{$id}{$label}\">Catatan Keseluruhan {$label}</h5>
                                                                                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
                                                                                    <span aria-hidden=\"true\">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class=\"modal-body\" style=\"white-space: pre-wrap;\">{$escapedValue}</div>
                                                                        </div>
                                                                    </div>
                                                                </div><br>";
                                                            } else {
                                                                return "<span class=\"catatan-label\">{$label}:</span> {$escapedValue}<br>";
                                                            }
                                                        }
                                                    }
                                                    echo renderCatatanKeseluruhan('Fasilitator', $v->catatan_keseluruhan, $v->id);
                                                    echo "<br>";
                                                    echo renderCatatanKeseluruhan('Validator', $v->catatan_keseluruhan_validator, $v->id);
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                    // Pilih warna badge berdasarkan id_status_penilaian
                                                    $badgeClass = 'badge-secondary';
                                                    switch ($v->id_status_penilaian) {
                                                        case 4: // Valid
                                                            $badgeClass = 'badge-success';
                                                            break;
                                                        case 3: // Revisi Validator
                                                            $badgeClass = 'badge-danger';
                                                            break;
                                                        case 2: // Penilaian Validator
                                                            $badgeClass = 'badge-warning';
                                                            break;
                                                    }
                                                    ?>
                                                    <span class="badge <?= $badgeClass ?>" style="font-size:1em; padding: 8px 16px; border-radius: 18px; letter-spacing: 0.5px;">
                                                        <?= htmlspecialchars($v->nm_status, ENT_QUOTES, 'UTF-8') ?>
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <span style="font-size:0.98em; color:#6A82FB;">
                                                        <i class="fa fa-calendar"></i> <?= date('d M Y', strtotime($v->created_at)) ?>
                                                    </span>
                                                    <br>
                                                    <span style="font-size:0.98em; color:#6A82FB;">
                                                        <i class="fa fa-clock-o"></i> <?= date('H:i:s', strtotime($v->created_at)) ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Basic Horizontal Timeline -->
    </div>
</div>
</div>
<!-- END: Content-->

<?= $this->load->view('admin/v_footer') ?>

<!-- BEGIN: Page Vendor JS-->
<script src="<?= base_url() ?>app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Page JS-->
<script src="<?= base_url() ?>app-assets/js/scripts/tables/datatables/datatable-basic.js"></script>
<!-- END: Page JS-->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js" integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>