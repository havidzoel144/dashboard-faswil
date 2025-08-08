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
                                Data <span style="color:#ff9800;">Perguruan Tinggi</span>
                                <br>
                                <small style="color:#888;">Daftar perguruan tinggi yang akan ditarik data prodinya bersumber dari tarikan data pt tahap 1 yang berhasil diproses</small>
                            </h4>

                            <div class="d-flex justify-content-center mt-1">
                                <a href="<?= base_url('beranda/sinkronprodi/proses_ulang') ?>" onclick="return confirm('Anda yakin ingin memproses ulang data prodi ?')" class="btn btn-primary waves-effect waves-light"><i class="ft ft-repeat"></i> Proses Ulang</a>
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
                                                        <th width='10px'>No</th>
                                                        <th width='50px'>Kode PT</th>
                                                        <th>Nama PT</th>
                                                        <th class="text-center" width='150px'>updated_at</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $mor = 1;
                                                    foreach ($data_awal as $a) {
                                                    ?>
                                                        <tr>
                                                            <td class="text-center"><?= $mor++ ?></td>
                                                            <td class="text-center"><?= $a->kode_pt ?></td>
                                                            <td><?= $a->nama_pt ?></td>
                                                            <td class="text-center"><?= $a->updated_at ?></td>
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
                                Sinkron Data <span style="color:#ff9800;">Prodi Tahap 1</span>
                                <br>
                                <small style="color:#888;">Mendapatkan data <b>status</b> &amp; <b>semester mulai</b> program studi</small>
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
                                                        <th class="text-center">Jumlah awal PT <br>yang diproses</th>
                                                        <th class="text-center">Jumlah PT <br>Belum Proses</th>
                                                        <th class="text-center">Jumlah PT<br>Berhasil Proses</th>
                                                        <th class="text-center">Jumlah PT<br>Tidak Ditemukan Data Prodi<br>dari API PDDIKTI</th>
                                                        <th class="text-center">Jumlah Prodi<br>dari API PDDIKTI</th>
                                                        <th class="text-center">Progress<br>Penarikan<br>Data</th>
                                                        <th class="text-center">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($rekap as $r) {
                                                        $jml_belum_proses   = $r->jml_awal - ($r->jml_proses + $r->jml_tidak_ada);
                                                        $percent            = ($r->jml_proses > 0) ? number_format((($r->jml_proses + $r->jml_tidak_ada) / $r->jml_awal) * 100, 2) : '0.00';
                                                    ?>
                                                        <tr>
                                                            <td class="text-center">
                                                                <font style="font-size: 20px;font-weight: bold; color: black;"><?= $r->jml_awal ?></font>
                                                            </td>
                                                            <td class="text-center">
                                                                <!-- Tombol untuk membuka modal -->
                                                                <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalBelumTahap1">
                                                                    <font style="font-size: 20px;font-weight: bold; color: red;"> <?= $jml_belum_proses ?> </font>
                                                                </button>

                                                                <!-- Modal Belum Proses Tahap 1 -->
                                                                <div class="modal fade text-left" id="modalBelumTahap1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                                                    <div class="modal-dialog modal-lg" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title" id="myModalLabel1">Daftar PT Belum Proses Tahap 1</h4>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="table-responsive">
                                                                                    <table class="table table-striped table-bordered zero-configuration" style="width:99%;">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>Nomor</th>
                                                                                                <th>Kode PT</th>
                                                                                                <th>Nama PT</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <?php $no = 1;
                                                                                            foreach ($belum_t1 as $pt) { ?>
                                                                                                <tr>
                                                                                                    <td><?= $no++ ?></td>
                                                                                                    <td><?= $pt->kode_pt ?></td>
                                                                                                    <td><?= $pt->nama_pt ?></td>
                                                                                                </tr>
                                                                                            <?php } ?>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <!-- Tombol untuk membuka modal -->
                                                                <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalProsesTahap1">
                                                                    <font style="font-size: 20px;font-weight: bold; color: #563BFF;"> <?= $r->jml_proses ?> </font>
                                                                </button>

                                                                <!-- Modal berhasil Proses Tahap 1 -->
                                                                <div class="modal fade text-left" id="modalProsesTahap1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                                                    <div class="modal-dialog modal-lg" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title" id="myModalLabel1">Daftar PT Berhasil Diproses Tahap 1</h4>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="table-responsive">
                                                                                    <table class="table table-striped table-bordered zero-configuration" style="width:99%;">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>Nomor</th>
                                                                                                <th>Kode PT</th>
                                                                                                <th>Nama PT</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <?php $no = 1;
                                                                                            foreach ($proses_t1 as $pt) { ?>
                                                                                                <tr>
                                                                                                    <td><?= $no++ ?></td>
                                                                                                    <td><?= $pt->kode_pt ?></td>
                                                                                                    <td><?= $pt->nama_pt ?></td>
                                                                                                </tr>
                                                                                            <?php } ?>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <!-- Tombol untuk membuka modal -->
                                                                <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalTidakTahap1">
                                                                    <font style="font-size: 20px;font-weight: bold; color:red;"> <?= $r->jml_tidak_ada ?> </font>
                                                                </button>

                                                                <!-- Modal Tidak Ada Tahap 1 -->
                                                                <div class="modal fade text-left" id="modalTidakTahap1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                                                    <div class="modal-dialog modal-lg" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title" id="myModalLabel1">Daftar PT Tidak Ada pada API PDDIKTI Tahap 1</h4>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="table-responsive">
                                                                                    <table class="table table-striped table-bordered zero-configuration" style="width:99%;">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>Nomor</th>
                                                                                                <th>Kode PT</th>
                                                                                                <th>Nama PT</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <?php $no = 1;
                                                                                            foreach ($tidak_t1 as $pt) { ?>
                                                                                                <tr>
                                                                                                    <td><?= $no++ ?></td>
                                                                                                    <td><?= $pt->kode_pt ?></td>
                                                                                                    <td><?= $pt->nama_pt ?></td>
                                                                                                </tr>
                                                                                            <?php } ?>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <!-- Tombol untuk membuka modal -->
                                                                <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalProdiTahap1">
                                                                    <font style="font-size: 20px;font-weight: bold; color:blueviolet;"> <?= $r->jml_prodi ?> </font>
                                                                </button>

                                                                <!-- Modal prodi yang berhasil ditarik Tahap 1 -->
                                                                <div class="modal fade text-left" id="modalProdiTahap1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                                                    <div class="modal-dialog modal-xl" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title" id="myModalLabel1">Daftar Prodi yang berhasil ditarik dari API PDDIKTI Tahap 1</h4>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="table-responsive">
                                                                                    <table class="table table-striped table-bordered zero-configuration" style="width:99%;">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>No.</th>
                                                                                                <th>Id Prodi</th>
                                                                                                <th>Kode PT</th>
                                                                                                <th>Nama PT</th>
                                                                                                <th>Kode Prodi</th>
                                                                                                <th>Nama Prodi</th>
                                                                                                <th>Program</th>
                                                                                                <th>Status</th>
                                                                                                <th>Nama Status</th>
                                                                                                <th>Semester Mulai</th>
                                                                                                <th>Updated at</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <?php $nop = 1;
                                                                                            foreach ($prodi_t1 as $pd) { ?>
                                                                                                <tr>
                                                                                                    <td><?= $nop++ ?></td>
                                                                                                    <td><?= $pd->id_prodi ?></td>
                                                                                                    <td><?= $pd->kode_pt ?></td>
                                                                                                    <td><?= $pd->nm_pt ?></td>
                                                                                                    <td><?= $pd->kode_prodi ?></td>
                                                                                                    <td><?= $pd->nama_prodi ?></td>
                                                                                                    <td><?= $pd->program ?></td>
                                                                                                    <td><?= $pd->status_prodi ?></td>
                                                                                                    <td><?= $pd->nm_stat_prodi ?></td>
                                                                                                    <td><?= $pd->smt_mulai ?></td>
                                                                                                    <td><?= $pd->updated_at ?></td>
                                                                                                </tr>
                                                                                            <?php } ?>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="progress" style="height: 22px; border-radius: 8px; background: #eee;">

                                                                    <?php if ($percent == "100.00") {
                                                                        $war = "info";
                                                                    } else {
                                                                        $war = "danger";
                                                                    } ?>
                                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-<?= $war ?>"
                                                                        role="progressbar"
                                                                        style="width: <?= $percent ?>%; font-size: 15px; font-weight: 600; color: #fff; border-radius: 8px;"
                                                                        aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100">
                                                                        <?= $percent ?> %
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php if ($jml_belum_proses == 0) { ?>
                                                                    <span class="badge badge-success" style="font-size:1rem;padding:10px 18px;border-radius:18px;box-shadow:0 2px 8px rgba(244, 244, 244, 0.12);">
                                                                        <i class="fa fa-check-circle mr-1" style="font-size:1.3rem;color:#28a745;animation: tada 1s;"></i>
                                                                        <span style="font-weight:800;color:white;">Penarikan Data Prodi Tahap 1 Selesai!</span>
                                                                    </span>
                                                                    <style>
                                                                        @keyframes tada {
                                                                            0% {
                                                                                transform: scale(1);
                                                                            }

                                                                            10%,
                                                                            20% {
                                                                                transform: scale(0.9) rotate(-3deg);
                                                                            }

                                                                            30%,
                                                                            50%,
                                                                            70%,
                                                                            90% {
                                                                                transform: scale(1.1) rotate(3deg);
                                                                            }

                                                                            40%,
                                                                            60%,
                                                                            80% {
                                                                                transform: scale(1.1) rotate(-3deg);
                                                                            }

                                                                            100% {
                                                                                transform: scale(1);
                                                                            }
                                                                        }
                                                                    </style>
                                                                    <?php
                                                                } else {
                                                                    if ($r->status_progress == 'berhenti') {
                                                                    ?>
                                                                        <a href="<?= base_url('beranda/SinkronProdi/proses_batch_start') ?>" class="btn btn-info btn-md process-btn">
                                                                            <i class="fa fa-forward"></i> Proses Data Prodi Tahap 1
                                                                        </a>
                                                                    <?php } else { ?>
                                                                        <button class="btn btn-primary btn-md" style="background: linear-gradient(90deg,#563BFF 60%,#ff9800 100%);color:#fff;font-weight:700;box-shadow:0 2px 8px rgba(86,59,255,0.15);border-radius:18px;padding:12px 22px;animation: pulseBtn 1.2s infinite;">
                                                                            <i class="fa fa-spinner fa-spin mr-1"></i>
                                                                            <span style="font-size:1.1rem;">Sedang proses penarikan data prodi tahap 1...</span>
                                                                        </button>
                                                                        <style>
                                                                            @keyframes pulseBtn {
                                                                                0% {
                                                                                    box-shadow: 0 0 0 0 rgba(86, 59, 255, 0.25);
                                                                                }

                                                                                70% {
                                                                                    box-shadow: 0 0 0 10px rgba(255, 152, 0, 0);
                                                                                }

                                                                                100% {
                                                                                    box-shadow: 0 0 0 0 rgba(86, 59, 255, 0.25);
                                                                                }
                                                                            }
                                                                        </style>
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

                    <?php if ($jml_belum_proses == 0) { ?>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title text-center" style="font-size:1.5rem; font-weight:bold; color:#563BFF; width:100%;">
                                    <i class="fa fa-database mr-1" style="color:#ff9800;"></i>
                                    Sinkron Data <span style="color:#ff9800;">PT Tahap 2</span>
                                    <br>
                                    <small style="color:#888;">Mendapatkan data <b>akreditasi</b> Perguruan Tinggi</small>
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
                                                            <th class="text-center">Jumlah Semua Prodi<br>dari Tahap 1</th>
                                                            <th class="text-center">Jumlah Semua Prodi<br>Belum Proses</th>
                                                            <th class="text-center">Jumlah Semua Prodi<br>Berhasil Proses</th>
                                                            <th class="text-center">Jumlah Semua Prodi<br>Tidak Ditemukan <br> Data Akreditasi <br> dari API PDDIKTI</th>
                                                            <th class="text-center">Jumlah Prodi Aktif <br> / Ditampilkan</th>
                                                            <th class="text-center">Progress<br>Penarikan<br>Data</th>
                                                            <th class="text-center">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $nom = 1;
                                                        foreach ($rekap_t2 as $r2) {
                                                            $jml_belum_proses = $r2->jml_awal - ($r2->jml_proses + $r2->jml_tidak_ada);

                                                            $percent    = ($r2->jml_proses > 0) ? number_format((($r2->jml_proses + $r2->jml_tidak_ada) / $r2->jml_awal) * 100, 2) : '0.00';
                                                        ?>
                                                            <tr>
                                                                <td><?= $nom++ ?></td>
                                                                <td class="text-center">
                                                                    <font style="font-size: 20px;font-weight: bold; color: black;"><?= $r2->jml_awal ?></font>
                                                                </td>
                                                                <td class="text-center">
                                                                    <!-- Tombol untuk membuka modal -->
                                                                    <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalBelumTahap2">
                                                                        <font style="font-size: 20px;font-weight: bold; color: red;"> <?= $jml_belum_proses ?> </font>
                                                                    </button>

                                                                    <!-- Modal Belum Proses -->
                                                                    <div class="modal fade text-left" id="modalBelumTahap2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                                                        <div class="modal-dialog modal-xl" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h4 class="modal-title" id="myModalLabel1">Daftar Semua Prodi Belum Proses Tahap 2</h4>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="table-responsive">
                                                                                        <table class="table table-striped table-bordered zero-configuration" style="width:99%;">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>No.</th>
                                                                                                    <th>Id Prodi</th>
                                                                                                    <th>Kode PT</th>
                                                                                                    <th>Nama PT</th>
                                                                                                    <th>Kode Prodi</th>
                                                                                                    <th>Nama Prodi</th>
                                                                                                    <th>Program</th>
                                                                                                    <th>Status</th>
                                                                                                    <th>Nama Status</th>
                                                                                                    <th>Semester Mulai</th>
                                                                                                    <th>Updated at</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                <?php $no = 1;
                                                                                                foreach ($belum_t2 as $bt2) { ?>
                                                                                                    <tr>
                                                                                                        <td><?= $nop++ ?></td>
                                                                                                        <td><?= $bt2->id_prodi ?></td>
                                                                                                        <td><?= $bt2->kode_pt ?></td>
                                                                                                        <td><?= $bt2->nm_pt ?></td>
                                                                                                        <td><?= $bt2->kode_prodi ?></td>
                                                                                                        <td><?= $bt2->nama_prodi ?></td>
                                                                                                        <td><?= $bt2->program ?></td>
                                                                                                        <td><?= $bt2->status_prodi ?></td>
                                                                                                        <td><?= $bt2->nm_stat_prodi ?></td>
                                                                                                        <td><?= $bt2->smt_mulai ?></td>
                                                                                                        <td><?= $bt2->updated_at ?></td>
                                                                                                    </tr>
                                                                                                <?php } ?>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <!-- Tombol untuk membuka modal -->
                                                                    <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalProsesTahap2">
                                                                        <font style="font-size: 20px;font-weight: bold; color: #563BFF;"> <?= $r2->jml_proses ?> </font>
                                                                    </button>

                                                                    <!-- Modal berhasil Proses Tahap 2 -->
                                                                    <div class="modal fade text-left" id="modalProsesTahap2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                                                        <div class="modal-dialog modal-xl" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h4 class="modal-title" id="myModalLabel1">Daftar Semua Prodi Berhasil Proses Tahap 2</h4>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="table-responsive">
                                                                                        <table class="table table-striped table-bordered zero-configuration" style="width:99%;">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>No.</th>
                                                                                                    <th>Id Prodi</th>
                                                                                                    <th>Kode PT</th>
                                                                                                    <th>Nama PT</th>
                                                                                                    <th>Kode Prodi</th>
                                                                                                    <th>Nama Prodi</th>
                                                                                                    <th>Program</th>
                                                                                                    <th>Status</th>
                                                                                                    <th>Nama Status</th>
                                                                                                    <th>Semester Mulai</th>
                                                                                                    <th>Akreditasi</th>
                                                                                                    <th>Tanggal Akhir <br> Akreditasi</th>
                                                                                                    <th>Updated at</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                <?php $nop = 1;
                                                                                                foreach ($proses_t2 as $pt2) { ?>
                                                                                                    <tr>
                                                                                                        <td><?= $nop++ ?></td>
                                                                                                        <td><?= $pt2->id_prodi ?></td>
                                                                                                        <td><?= $pt2->kode_pt ?></td>
                                                                                                        <td><?= $pt2->nm_pt ?></td>
                                                                                                        <td><?= $pt2->kode_prodi ?></td>
                                                                                                        <td><?= $pt2->nama_prodi ?></td>
                                                                                                        <td><?= $pt2->program ?></td>
                                                                                                        <td><?= $pt2->status_prodi ?></td>
                                                                                                        <td><?= $pt2->nm_stat_prodi ?></td>
                                                                                                        <td><?= $pt2->smt_mulai ?></td>
                                                                                                        <td><?= $pt2->akreditasi_prodi ?></td>
                                                                                                        <td><?= $pt2->tgl_akhir_akred ?></td>
                                                                                                        <td><?= $pt2->updated_at ?></td>
                                                                                                    </tr>
                                                                                                <?php } ?>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <!-- Tombol untuk membuka modal -->
                                                                    <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalTidakTahap2">
                                                                        <font style="font-size: 20px;font-weight: bold; color:red;"> <?= $r2->jml_tidak_ada ?> </font>
                                                                    </button>

                                                                    <!-- Modal Tidak Ada Tahap 2 -->
                                                                    <div class="modal fade text-left" id="modalTidakTahap2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                                                        <div class="modal-dialog modal-xl" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h4 class="modal-title" id="myModalLabel1">
                                                                                        Daftar Semua Prodi Tidak Ditemukan Data Akreditasi dari API PDDIKTI Tahap 2</h4>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="table-responsive">
                                                                                        <table class="table table-striped table-bordered zero-configuration" style="width:99%;">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>No.</th>
                                                                                                    <th>Id Prodi</th>
                                                                                                    <th>Kode PT</th>
                                                                                                    <th>Nama PT</th>
                                                                                                    <th>Kode Prodi</th>
                                                                                                    <th>Nama Prodi</th>
                                                                                                    <th>Program</th>
                                                                                                    <th>Status</th>
                                                                                                    <th>Nama Status</th>
                                                                                                    <th>Semester Mulai</th>
                                                                                                    <th>Updated at</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                <?php $not2 = 1;
                                                                                                foreach ($tidak_t2 as $t2) { ?>
                                                                                                    <tr>
                                                                                                        <td><?= $not2++ ?></td>
                                                                                                        <td><?= $t2->id_prodi ?></td>
                                                                                                        <td><?= $t2->kode_pt ?></td>
                                                                                                        <td><?= $t2->nm_pt ?></td>
                                                                                                        <td><?= $t2->kode_prodi ?></td>
                                                                                                        <td><?= $t2->nama_prodi ?></td>
                                                                                                        <td><?= $t2->program ?></td>
                                                                                                        <td><?= $t2->status_prodi ?></td>
                                                                                                        <td><?= $t2->nm_stat_prodi ?></td>
                                                                                                        <td><?= $t2->smt_mulai ?></td>
                                                                                                        <td><?= $t2->updated_at ?></td>
                                                                                                    </tr>
                                                                                                <?php } ?>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <?php if ($jml_belum_proses == 0) { ?>
                                                                        <br>
                                                                        <a href="<?= base_url('beranda/SinkronProdi/proses_batch_start_susulan') ?>" class="btn btn-info btn-sm process-btn">
                                                                            <i class="fa fa-forward"></i> Proses kembali
                                                                        </a>
                                                                    <?php } ?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <!-- Tombol untuk membuka modal -->
                                                                    <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalProdiAktif">
                                                                        <font style="font-size: 20px;font-weight: bold; color: #563BFF;"> <?= $r2->jml_prodi_aktif ?> </font>
                                                                    </button>

                                                                    <!-- Modal berhasil Proses Tahap 2 -->
                                                                    <div class="modal fade text-left" id="modalProdiAktif" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                                                        <div class="modal-dialog modal-xl" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h4 class="modal-title" id="myModalLabel1">Daftar Prodi Aktif / Ditampilkan</h4>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="table-responsive">
                                                                                        <table class="table table-striped table-bordered zero-configuration" style="width:99%;">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>No.</th>
                                                                                                    <th>Kode PT</th>
                                                                                                    <th>Nama PT</th>
                                                                                                    <th>Kode Prodi</th>
                                                                                                    <th>Nama Prodi</th>
                                                                                                    <th>Program</th>
                                                                                                    <th>Status</th>
                                                                                                    <th>Nama Status</th>
                                                                                                    <th>Semester Mulai</th>
                                                                                                    <th>Akreditasi</th>
                                                                                                    <th>Tanggal Akhir <br> Akreditasi</th>
                                                                                                    <th>Tanggal Update</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                <?php $nopa = 1;
                                                                                                foreach ($prodi_aktif as $pa) { ?>
                                                                                                    <tr>
                                                                                                        <td><?= $nopa++ ?></td>
                                                                                                        <td><?= $pa->kode_pt ?></td>
                                                                                                        <td><?= $pa->nm_pt ?></td>
                                                                                                        <td><?= $pa->kode_prodi ?></td>
                                                                                                        <td><?= $pa->nama_prodi ?></td>
                                                                                                        <td><?= $pa->program ?></td>
                                                                                                        <td><?= $pa->status_prodi ?></td>
                                                                                                        <td><?= $pa->nm_stat_prodi ?></td>
                                                                                                        <td><?= $pa->smt_mulai ?></td>
                                                                                                        <td><?= $pa->akreditasi_prodi ?></td>
                                                                                                        <td><?= $pa->tgl_akhir_akred ?></td>
                                                                                                        <td><?= $pa->tgl_update ?></td>
                                                                                                    </tr>
                                                                                                <?php } ?>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <div class="progress" style="height: 22px; border-radius: 8px; background: #eee;">

                                                                        <?php if ($percent == "100.00") {
                                                                            $war = "info";
                                                                        } else {
                                                                            $war = "danger";
                                                                        } ?>
                                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-<?= $war ?>"
                                                                            role="progressbar"
                                                                            style="width: <?= $percent ?>%; font-size: 15px; font-weight: 600; color: #fff; border-radius: 8px;"
                                                                            aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100">
                                                                            <?= $percent ?> %
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?php if ($jml_belum_proses == 0) { ?>
                                                                        <span class="badge badge-success" style="font-size:1rem;padding:10px 18px;border-radius:18px;box-shadow:0 2px 8px rgba(244, 244, 244, 0.12);">
                                                                            <i class="fa fa-check-circle mr-1" style="font-size:1.3rem;color:#28a745;animation: tada 1s;"></i>
                                                                            <span style="font-weight:800;color:white;">Penarikan Data Akreditasi Prodi Tahap 2 Selesai!</span>
                                                                        </span>
                                                                        <style>
                                                                            @keyframes tada {
                                                                                0% {
                                                                                    transform: scale(1);
                                                                                }

                                                                                10%,
                                                                                20% {
                                                                                    transform: scale(0.9) rotate(-3deg);
                                                                                }

                                                                                30%,
                                                                                50%,
                                                                                70%,
                                                                                90% {
                                                                                    transform: scale(1.1) rotate(3deg);
                                                                                }

                                                                                40%,
                                                                                60%,
                                                                                80% {
                                                                                    transform: scale(1.1) rotate(-3deg);
                                                                                }

                                                                                100% {
                                                                                    transform: scale(1);
                                                                                }
                                                                            }
                                                                        </style>
                                                                        <?php
                                                                    } else {
                                                                        if ($r2->status_progress == 'berhenti') {
                                                                        ?>
                                                                            <a href="<?= base_url('beranda/SinkronProdi/proses_batch_start_tahap2') ?>" class="btn btn-info btn-sm process-btn">
                                                                                <i class="fa fa-forward"></i> Proses Data Akreditasi Prodi Tahap 2
                                                                            </a>
                                                                        <?php } else { ?>
                                                                            <button class="btn btn-primary btn-md" style="background: linear-gradient(90deg,#563BFF 60%,#ff9800 100%);color:#fff;font-weight:700;box-shadow:0 2px 8px rgba(86,59,255,0.15);border-radius:18px;padding:12px 22px;animation: pulseBtn 1.2s infinite;">
                                                                                <i class="fa fa-spinner fa-spin mr-1"></i>
                                                                                <span style="font-size:1.1rem;">Sedang proses penarikan data akreditasi prodi tahap 2...</span>
                                                                            </button>
                                                                            <style>
                                                                                @keyframes pulseBtn {
                                                                                    0% {
                                                                                        box-shadow: 0 0 0 0 rgba(86, 59, 255, 0.25);
                                                                                    }

                                                                                    70% {
                                                                                        box-shadow: 0 0 0 10px rgba(255, 152, 0, 0);
                                                                                    }

                                                                                    100% {
                                                                                        box-shadow: 0 0 0 0 rgba(86, 59, 255, 0.25);
                                                                                    }
                                                                                }
                                                                            </style>
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

<br>
<br>
<!-- END: Content-->

<?= $this->load->view('admin/v_footer') ?>

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

                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
                <div class="mt-2" style="font-size:1.2rem;color:#1967d2;font-weight:600;">
                    Loading...
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
                <button class="btn btn-danger btn-sm" id="cancelBatchBtn" style="display:none;">
                    <i class="fa fa-times"></i> Batalkan Proses
                </button>

                <div style="margin-top:8px;margin-bottom:12px;font-size:18px;">
                    <span id="loadingStatusText"></span>
                </div>

                <div id="loadingLog" class="mb-2 p-2"
                    style="font-size:14px;color:#444;max-height:250px;overflow:auto;background:rgba(240,240,240,0.85);border-radius:10px;display:none"></div>

                <div id="motivasiText" style="font-size:13px;color:#888;"></div>
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

            // Mulai batch baru(hanya sekali)
            // Ambil token CSRF dari input hidden di form (atau dari meta tag jika ada)
            var csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
            var csrfHash = '<?= $this->security->get_csrf_hash(); ?>';

            var postData = {};
            postData[csrfName] = csrfHash;

            $.post(startBatchUrl, postData, function(res) {

                if (res.status === 'ok') {
                    $("#loadingLog").show().html("<i>Proses penarikan data dimulai...</i>");

                    currentProgressId = res.progress_id;
                    jobUrl = res.job_url;
                    progressUrl = res.progress_url;
                    resultUrl = res.result_url;
                    jenisProgress = res.jenis;

                    // LANGSUNG JALANKAN proses_batch_job untuk chunk pertama!
                    var postJobData = {};
                    postJobData[csrfName] = csrfHash;
                    $.post(jobUrl, postJobData, function(chunkRes) {
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

            // Ambil token CSRF dari variabel PHP
            var csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
            var csrfHash = '<?= $this->security->get_csrf_hash(); ?>';

            var postData = {
                progress_id: currentProgressId,
                jenis: jenisProgress
            };
            postData[csrfName] = csrfHash;

            $.post('<?= base_url("beranda/SinkronProdi/cancel_batch") ?>', postData, function(res) {
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
                        var postData = {};
                        postData[csrfName] = csrfHash;
                        $.post(startBatchUrl, postData, function(res) {
                            if (res.status === 'ok') {
                                // Update ke progressId baru dan URL baru!
                                currentProgressId = res.progress_id;
                                jobUrl = res.job_url;
                                progressUrl = res.progress_url;
                                resultUrl = res.result_url;

                                // Langsung eksekusi batch chunk pertama di progress_id baru!
                                var postJobData = {};
                                postJobData[csrfName] = csrfHash;
                                $.post(jobUrl, postJobData, function(chunkRes) {
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