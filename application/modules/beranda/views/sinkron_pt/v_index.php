<?= $this->load->view('admin/v_header') ?>

<?= $this->load->view('admin/v_menu') ?>

<!-- BEGIN: Content-->
<!-- <div class="app-content content center-layout"> untuk tidak full layar -->
<div class="app-content content">
    <!-- untuk full layar -->
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Basic Horizontal Timeline -->
            <div class="row">
                <div class="container col-xl-11">

                    <div class="card">
                        <div class="card-header">

                            <h4 class="card-title text-center" style="font-size: 1.5rem; font-weight: bold; color: #563BFF; width:100%;">
                                <i class="fa fa-university mr-1" style="color:#ff9800;"></i>
                                Data Awal <span style="color:#ff9800;">Perguruan Tinggi</span>
                                <br>
                                <small style="color:#888;">Daftar perguruan tinggi yang akan disinkronisasi</small>
                            </h4>

                            <div class="d-flex justify-content-center mt-1">
                                <button type="button" class="btn btn-dark mr-2 waves-effect waves-light" data-toggle="modal" data-backdrop="false" data-target="#import_data"> <i class="fa fa-upload mr-1"></i>Import Data</button>

                                <!-- AWAL IMPORT DATA -->
                                <div class="modal fade text-left" id="import_data" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel4">IMPORT DATA PT AWAL</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <?php echo form_open_multipart(base_url('import_pt_awal'), array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'form-import-data')); ?>

                                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

                                            <div class="modal-body">
                                                <fieldset class="form-group">
                                                    <label for="import">Upload File</label>
                                                    <input type="file" required class="form-control-file" id="exampleInputFile" name="file_excel" accept=".xlsx, .xls">
                                                    <small class="form-text text-muted">
                                                        Format file: <strong>.xlsx</strong> (maksimal 2 MB)
                                                    </small>
                                                </fieldset>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary" id="import-data">Import</button>
                                                <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Tutup</button>
                                            </div>
                                            <?php echo form_close(); ?>

                                            <!-- Pastikan jQuery sudah dimuat sebelum script ini -->
                                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                            <script>
                                                $(document).ready(function() {
                                                    $('#form-import-data').on('submit', function(e) {
                                                        if (!confirm('Anda yakin? karena data yang sudah ada akan dihapus permanen dan diganti dengan data yang Anda Upload. ')) {
                                                            e.preventDefault();
                                                        }
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>
                                <!-- AKHIR  IMPORT DATA -->

                                <a href="<?= base_url('uploads/template_data_pt_awal.xlsx') ?>" class="btn btn-success waves-effect waves-light"><i class="fa fa-download mr-1"></i>Download Template</a>
                            </div>

                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <div class="table-responsive">

                                    <form class="form form-horizontal">
                                        <div class="form-body">
                                            <table class="table table-striped table-bordered zero-configuration" style="width:99%;">
                                                <thead>
                                                    <tr style="background-color: #563BFF; color: #ffffff">
                                                        <th width='10px'>NO</th>
                                                        <th width='50px'>Kode PT</th>
                                                        <th>Nama PT</th>
                                                        <th class="text-center" width='150px'>created_at</th>
                                                        <th class="text-center" width='150px'>updated_at</th>
                                                        <th class="text-center">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $mor = 1;
                                                    foreach ($pt_awal as $a) {
                                                    ?>
                                                        <tr>
                                                            <td class="text-center"><?= $mor++ ?></td>
                                                            <td class="text-center"><?= $a->kd_pt ?></td>
                                                            <td><?= $a->nm_pt ?></td>
                                                            <td class="text-center"><?= $a->created_at ?></td>
                                                            <td class="text-center"><?= $a->updated_at ?></td>
                                                            <td></td>
                                                        </tr>
                                                    <?php  } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title text-center" style="font-size:1.5rem; font-weight:bold; color:#563BFF; width:100%;">
                                <i class="fa fa-database mr-1" style="color:#ff9800;"></i>
                                Sinkron Data <span style="color:#ff9800;">PT Tahap 1</span>
                                <br>
                                <small style="color:#888;">Mendapatkan data <b>status</b> &amp; <b>bentuk</b> Perguruan Tinggi</small>
                            </h4>

                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <div class="table-responsive">

                                    <form class="form form-horizontal">
                                        <div class="form-body">
                                            <table id="dataTables" class="table table-striped table-bordered" style="width: 99%;">
                                                <thead>
                                                    <tr style="background-color: #563BFF; color: #ffffff">
                                                        <th>NO</th>
                                                        <th class="text-center">Jumlah Awal</th>
                                                        <th class="text-center">Jumlah <br>Belum Proses</th>
                                                        <th class="text-center">Jumlah Proses</th>
                                                        <th class="text-center">Jumlah <br>Tidak Ditemukan <br> API PDDIKTI</th>
                                                        <th class="text-center">Progress<br>Penarikan<br>Data</th>
                                                        <th>created_at</th>
                                                        <th>updated_at</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no_periode = 1;
                                                    foreach ($rekap as $r) {
                                                        $jml_belum_proses = $r->jml_awal - ($r->jml_proses + $r->jml_tidak_ada);

                                                        $percent         = ($r->jml_proses > 0) ? number_format((($r->jml_proses + $r->jml_tidak_ada) / $r->jml_awal) * 100, 2) : '0.00';
                                                    ?>
                                                        <tr>
                                                            <td><?= $no_periode++ ?></td>
                                                            <td class="text-center">
                                                                <font style="font-size: 20px;font-weight: bold; color: black;"><?= $r->jml_awal ?></font>
                                                            </td>
                                                            <td class="text-center">
                                                                <a href="<?= base_url() ?>beranda/SinkronPt/belum_tahap1">
                                                                    <font style="font-size: 20px;font-weight: bold; color: red;"> <?= $jml_belum_proses ?> </font>
                                                                </a>
                                                            </td>
                                                            <td class="text-center">
                                                                <a href="<?= base_url() ?>beranda/SinkronPt/proses_tahap1">
                                                                    <font style="font-size: 20px;font-weight: bold;"> <?= $r->jml_proses ?> </font>
                                                                </a>
                                                            </td>
                                                            <td class="text-center">
                                                                <a href="<?= base_url() ?>beranda/SinkronPt/tidak_tahap1">
                                                                    <font style="font-size: 20px;font-weight: bold; color: red;"> <?= $r->jml_tidak_ada ?> </font>
                                                                </a>
                                                            </td>
                                                            <td class="text-center">
                                                                <?= $percent ?> %
                                                            </td>
                                                            <td><?= $r->created_at ?></td>
                                                            <td><?= $r->updated_at ?></td>
                                                            <td>
                                                                <?php if ($jml_belum_proses == 0) { ?>
                                                                    <a href="<?= base_url('beranda/SinkronPt/kosongkan/' . $r->jenis) ?>" onclick="return confirm('Anda yakin ingin mengosongkan data riwayat PT ?')" class="btn btn-danger btn-sm">
                                                                        <i class="fa fa-trash"></i> Kosongkan Riwayat PT Tahap 1
                                                                    </a>
                                                                    <?php
                                                                } else {
                                                                    if ($r->status_progress == 'berhenti') {
                                                                    ?>
                                                                        <a href="<?= base_url('beranda/SinkronPt/proses_batch_start') ?>" class="btn btn-info btn-sm process-btn">
                                                                            <i class="fa fa-forward"></i> Proses Data PT Tahap 1
                                                                        </a>
                                                                    <?php } else { ?>
                                                                        <button class="btn btn-primary btn-sm">
                                                                            <i class="fa fa-clock-o"></i> sedang proses penarikan data PT Tahap 1
                                                                        </button>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                    <?php  } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                    <br>
                    <br>

                    <?php if ($jml_belum_proses == 0) { ?>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Sinkron Data PT Tahap 2 (mendapatkan data akreditasi PT)</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">

                                        <form class="form form-horizontal">
                                            <div class="form-body">
                                                <table id="dataTables" class="table table-striped table-bordered" style="width: 99%;">
                                                    <thead>
                                                        <tr style="background-color: #563BFF; color: #ffffff">
                                                            <th>NO</th>
                                                            <th class="text-center">Jumlah Awal</th>
                                                            <th class="text-center">Jumlah <br>Belum Proses</th>
                                                            <th class="text-center">Jumlah Proses</th>
                                                            <th class="text-center">Jumlah <br>Tidak Ditemukan <br> API PDDIKTI</th>
                                                            <th class="text-center">Progress<br>Penarikan<br>Data</th>
                                                            <th>created_at</th>
                                                            <th>updated_at</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $nom = 1;
                                                        foreach ($rekap_t2 as $r2) {
                                                            $jml_belum_proses = $r2->jml_awal - ($r2->jml_proses + $r2->jml_tidak_ada);

                                                            $percent         = ($r2->jml_proses > 0) ? number_format((($r2->jml_proses + $r2->jml_tidak_ada) / $r2->jml_awal) * 100, 2) : '0.00';
                                                        ?>
                                                            <tr>
                                                                <td><?= $nom++ ?></td>
                                                                <td class="text-center">
                                                                    <font style="font-size: 20px;font-weight: bold; color: black;"><?= $r2->jml_awal ?></font>
                                                                </td>
                                                                <td class="text-center">
                                                                    <a href="<?= base_url() ?>beranda/SinkronPt/belum_tahap2">
                                                                        <font style="font-size: 20px;font-weight: bold; color: red;"> <?= $jml_belum_proses ?> </font>
                                                                    </a>
                                                                </td>
                                                                <td class="text-center">
                                                                    <a href="<?= base_url() ?>beranda/SinkronPt/proses_tahap2">
                                                                        <font style="font-size: 20px;font-weight: bold;"> <?= $r2->jml_proses ?> </font>
                                                                    </a>
                                                                </td>
                                                                <td class="text-center">
                                                                    <a href="<?= base_url() ?>beranda/SinkronPt/tidak_tahap2">
                                                                        <font style="font-size: 20px;font-weight: bold; color: red;"> <?= $r2->jml_tidak_ada ?> </font>
                                                                    </a>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?= $percent ?> %
                                                                </td>
                                                                <td><?= $r2->created_at ?></td>
                                                                <td><?= $r2->updated_at ?></td>
                                                                <td>
                                                                    <?php if ($jml_belum_proses == 0) { ?>
                                                                        <a href="<?= base_url('beranda/SinkronPt/kosongkan/' . $r2->jenis) ?>" onclick="return confirm('Anda yakin ingin mengosongkan data riwayat PT ?')" class="btn btn-danger btn-sm">
                                                                            <i class="fa fa-trash"></i> Kosongkan Riwayat PT Tahap 2
                                                                        </a>
                                                                        <?php
                                                                    } else {
                                                                        if ($r2->status_progress == 'berhenti') {
                                                                        ?>
                                                                            <a href="<?= base_url('beranda/SinkronPt/proses_batch_start_tahap2') ?>" class="btn btn-info btn-sm process-btn">
                                                                                <i class="fa fa-forward"></i> Proses Data PT Tahap 2
                                                                            </a>
                                                                        <?php } else { ?>
                                                                            <button class="btn btn-primary btn-sm">
                                                                                <i class="fa fa-clock-o"></i> sedang proses penarikan data PT Tahap 2 ...
                                                                            </button>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                        <?php  } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->

<?= $this->load->view('v_footer.php') ?>

<!-- BEGIN: Page Vendor JS-->
<script src="<?= base_url() ?>app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
<script src="<?= base_url() ?>app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Page JS-->
<script src="<?= base_url() ?>app-assets/js/scripts/tables/datatables/datatable-basic.js"></script>

<!-- Modal Loading -->
<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="background:rgba(255,255,255,0.95);box-shadow:0 8px 24px rgba(0,0,0,.2);border-radius:20px;">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="loadingModalLabel" style="font-weight:700;color:#1967d2;">
                    <i class="fa fa-hourglass-half mr-2 swing"></i>
                    Mohon Bersabar...
                </h5>
            </div>

            <div class="modal-body text-center">
                <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                    <span class="sr-only">Loading...</span>
                </div>

                <!-- PROGRESS BAR -->
                <div class="progress" style="height:25px;border-radius:10px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info"
                        id="progressBarBatch"
                        role="progressbar"
                        style="width:0%;font-size:16px;font-weight:600;"
                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>

                <!-- TOMBOL CANCEL -->
                <button class="btn btn-danger btn-sm mt-3" id="cancelBatchBtn" style="display:none;">
                    <i class="fa fa-times"></i> Batalkan Proses
                </button>

                <div style="margin-top:8px;margin-bottom:12px;font-size:18px;">
                    <span id="loadingStatusText">Data sedang diproses, harap tunggu...</span>
                </div>

                <div id="loadingLog" class="mb-2 p-2"
                    style="font-size:14px;color:#444;max-height:250px;overflow:auto;background:rgba(240,240,240,0.85);border-radius:10px;display:none"></div>

                <div id="motivasiText" style="font-size:13px;color:#888;">
                    <em>"Kesabaran adalah kunci menuju data yang rapi."</em>
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <small style="color:#aaa;">&copy; Data API PDDIKTI</small>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes swing {
        20% {
            transform: rotate(15deg);
        }

        40% {
            transform: rotate(-10deg);
        }

        60% {
            transform: rotate(5deg);
        }

        80% {
            transform: rotate(-5deg);
        }

        100% {
            transform: rotate(0deg);
        }
    }

    .swing {
        display: inline-block;
        animation: swing 2s infinite;
    }
</style>
<!-- Modal Loading -->

<script>
    $(document).ready(function() {
        var currentProgressId = null;
        var jobUrl = '';
        var progressUrl = '';
        var resultUrl = '';
        var isBatchCancelled = false;

        // Motivasi random
        var motivasiList = [
            "Kesabaran adalah kunci menuju data yang rapi.",
            "Bersabar itu solusi, apalagi sambil ngopi.",
            "Sedang menghubungkan data, mohon doa restu.",
            "Proses cepat? Sudah pasti, asalkan jaringan lancar.",
            "Sambil menunggu, boleh atur playlist musik favorit."
        ];
        var idx = Math.floor(Math.random() * motivasiList.length);
        $('#motivasiText').text(motivasiList[idx]);

        var startBatchUrl = ""; // Tambahkan di paling atas, global

        $(".process-btn").on("click", function(e) {
            e.preventDefault();

            if (!confirm("Proses semua data ? Proses bisa makan waktu lama.")) return false;

            $('#loadingModal').modal({
                backdrop: 'static',
                keyboard: false
            });

            $("#loadingStatusText").text("Data sedang diproses, harap tunggu...");
            $("#loadingLog").hide().html("");
            $("#progressBarBatch").css("width", "0%").attr("aria-valuenow", 0).text("0%");

            $("#cancelBatchBtn").show();
            isBatchCancelled = false; // Reset

            startBatchUrl = $(this).attr("href"); // SIMPAN HREF YANG BENAR

            // console.log(startBatchUrl);
            // return;

            // Mulai batch baru (hanya sekali)
            $.post(startBatchUrl, function(res) {
                if (res.status === 'ok') {
                    $("#loadingLog").show().html("<i>Proses penarikan data dimulai...</i>");

                    currentProgressId = res.progress_id;
                    jobUrl = res.job_url;
                    progressUrl = res.progress_url;
                    resultUrl = res.result_url;
                    jenisProgress = res.jenis;

                    // LANGSUNG JALANKAN proses_batch_job untuk chunk pertama!
                    $.post(jobUrl, function(chunkRes) {
                        runBatchLoop();
                    }, 'json');

                } else {
                    $("#loadingLog").show().html("<div class='alert alert-danger'>proses penarikan data gagal dimulai, silakan refresh halaman dan coba lagi</div>");
                }
            }, 'json');

        });

        $("#cancelBatchBtn").on("click", function() {
            if (!currentProgressId) return;
            if (!confirm("Batalkan proses batch ini?")) return;

            isBatchCancelled = true;
            $("#cancelBatchBtn").prop('disabled', true).text('Membatalkan...');
            $("#loadingStatusText").text("Membatalkan proses, harap tunggu...");

            $.post('<?= base_url("beranda/SinkronPt/cancel_batch") ?>', {
                progress_id: currentProgressId,
                jenis: jenisProgress
            }, function(res) {
                $("#loadingStatusText").text("Proses telah dibatalkan.");
                $("#loadingLog").show().append("<div class='alert alert-warning mt-2'>Batch dibatalkan oleh pengguna.</div>");
                setTimeout(function() {
                    window.location.href = resultUrl;
                }, 1800);
            }, 'json');
        });

        var pollingCounter = 0;

        function runBatchLoop() {
            if (isBatchCancelled) return; // STOP polling jika batch dibatalkan

            // Step 1: polling status progress dulu
            $.get(progressUrl, function(prog) {
                pollingCounter++;

                $("#loadingLog").show().html(prog.logs.replace(/\n/g, "<br>"));

                // Stop polling jika sudah terlalu lama
                if (pollingCounter > 50) {
                    $("#loadingStatusText").text("Gagal menghubungkan API PDDIKTI, proses dibatalkan.");
                    $("#loadingLog").show().append("<div class='alert alert-danger mt-2'>Koneksi ke API gagal atau server tidak merespon.<br>Silakan cek koneksi internet atau ulangi proses nanti.</div>");
                    setTimeout(function() {
                        window.location.href = resultUrl;
                    }, 3000);
                    return; // <-- HENTIKAN polling di sini
                }

                if (prog.finished) {
                    if (prog.selisih > 0) {
                        // -----> TRIGGER batch baru (proses_batch_start) <-----
                        $("#progressBarBatch").css("width", prog.percent + "%")
                            .attr("aria-valuenow", prog.percent)
                            .text(prog.percent + "%");

                        $("#loadingStatusText").html(
                            "Proses penarikan data <b>" + prog.label + "</b> sedang berlangsung.<br>Diproses: <b>" + prog.processed + "</b> / <b>" + prog.total + "</b> &mdash; (" + prog.percent + "%)"
                        );

                        // Bikin batch baru:
                        $.post(startBatchUrl, function(res) {
                            if (res.status === 'ok') {
                                // Update ke progressId baru dan URL baru!
                                currentProgressId = res.progress_id;
                                jobUrl = res.job_url;
                                progressUrl = res.progress_url;
                                resultUrl = res.result_url;

                                // Langsung eksekusi batch chunk pertama di progress_id baru!
                                $.post(jobUrl, function(chunkRes) {
                                    pollingCounter = 0;
                                    setTimeout(runBatchLoop, 1200);
                                }, 'json');

                            } else {
                                $("#loadingLog").show().append("<div class='alert alert-danger'>Batch gagal diulang. Coba lagi nanti.</div>");
                                setTimeout(function() {
                                    window.location.href = resultUrl;
                                }, 3000);
                            }
                        }, 'json');
                    } else {
                        $("#progressBarBatch").css("width", prog.percent + "%")
                            .attr("aria-valuenow", prog.percent)
                            .text(prog.percent + "%");

                        $("#loadingStatusText").text("Proses selesai, mengalihkan...");
                        setTimeout(function() {
                            window.location.href = resultUrl;
                        }, 1500);
                    }
                } else {
                    // Jika belum finished, polling lagi
                    setTimeout(runBatchLoop, 1200);
                }
            }, 'json')
        }

    });
</script>