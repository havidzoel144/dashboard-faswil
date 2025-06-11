<?= $this->load->view('v_header.php') ?>

<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/tables/datatable/datatables.min.css">
<script src="<?= base_url() ?>assets/js/Chart.min.js"></script>

<!-- END: Vendor CSS-->

<?= $this->load->view('v_menu.php') ?>

<!-- BEGIN: Content-->
<div class="app-content content center-layout">
    <!-- untuk tidak full layar -->
    <!-- <div class="app-content content center-layout"> -->
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Basic Horizontal Timeline -->
            <div class="row">

                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Data Program Studi</h4>
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

                                    <h4 class="text-center"><i class="ft ft-filter"> Filter Pencarian </i></h4>
                                    <hr>

                                    <form class="form form-horizontal">
                                        <div class="form-body">
                                            <div class="table-search-row mb-1">

                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="projectinput1">Kode / Nama Perguruan Tinggi</label>
                                                    <div class="col-md-8 mx-auto">
                                                        <select class="select2 form-control select2-hidden-accessible" data-select2-id="1" tabindex="-1" aria-hidden="true" name="kode_pt" id="kode_pt">
                                                            <option value="">Silakan pilih Kode / Nama PT</option>
                                                            <?php foreach ($kode_nama_pt as $item) { ?>
                                                                <option value="<?= $item['kode_pt'] ?>"><?= $item['kode_pt'] ?> - <?= $item['nm_pt'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <!-- <input type="text" name="kode_pt" class="form-control border-bottom" placeholder="Masukkan Kode / Nama PT"> -->
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="program_studi">Program Studi</label>
                                                    <div class="col-md-8 mx-auto">
                                                        <input type="text" name="program_studi" class="form-control border-bottom" placeholder="Masukkan Program Studi">
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="program">Program</label>
                                                    <div class="col-md-8 mx-auto">
                                                        <select class="select2 form-control select2-hidden-accessible" multiple="" data-select2-id="12" tabindex="-1" aria-hidden="true" name="program[]" id="program">
                                                            <?php foreach ($program as $item) { ?>
                                                                <option value="<?= $item['program'] ?>"><?= $item['program'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                                <!-- <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="projectinput1">Status</label>
                                                    <div class="col-md-8 mx-auto">
                                                        <input type="text" name="nm_status" class="form-control border-bottom" placeholder="Masukkan Status">
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div> -->

                                                <!-- <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="projectinput1">Peringkat Akreditasi</label>
                                                    <div class="col-md-8 mx-auto">
                                                        <input type="text" name="akreditasi_pt" class="form-control border-bottom" placeholder="Masukkan Peringkat Akreditasi">
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div> -->

                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="akreditasi_prodi">Akreditasi Prodi</label>
                                                    <div class="col-md-8 mx-auto">
                                                        <select class="select2 form-control select2-hidden-accessible" multiple="" data-select2-id="12" tabindex="-1" aria-hidden="true" name="akreditasi_prodi[]" id="akreditasi_prodi">
                                                            <?php foreach ($akreditasi_prodi as $item) { ?>
                                                                <option value="<?= $item['akreditasi_prodi'] == '' ? 'kosong' : $item['akreditasi_prodi'] ?>"><?= $item['akreditasi_prodi'] == '' ? '(-)' : $item['akreditasi_prodi'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="">Tanggal Akhir Akreditasi</label>
                                                    <div class="col-md-8 mx-auto">
                                                        <div class="row">
                                                            <div class="col-5">
                                                                <input id="tanggal_awal" class="form-control" type="date" placeholder="Pilih Tanggal Awal">
                                                            </div>
                                                            <div class="col-2">
                                                                <p>sampai dengan</p>
                                                            </div>
                                                            <div class="col-5">
                                                                <input id="tanggal_akhir" class="form-control" type="date" placeholder="Pilih Tanggal Akhir">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                                <!-- <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="projectinput1">Kata Kunci</label>
                                                    <div class="col-md-8 mx-auto">
                                                        <div id="search-container"></div>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div> -->

                                            </div>


                                            <table id="tabel-prodi" class="table table-striped table-bordered" style="width: 99%;">
                                                <thead>
                                                    <tr style="background-color: #563BFF; color: #ffffff">
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">Kode PT</th>
                                                        <th class="text-center">Nama PT</th>
                                                        <th class="text-center">Kode Prodi</th>
                                                        <th class="text-center">Nama Prodi</th>
                                                        <th class="text-center">Program</th>
                                                        <th class="text-center">Status <br> Keaktifan Prodi</th>
                                                        <th class="text-center">Semester <br> Mulai</th>
                                                        <th class="text-center">Akreditasi <br> Prodi</th>
                                                        <th class="text-center">Tanggal Akhir <br> Akreditasi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>

                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <?php
                            // Misalkan $dos->tgl_update sudah memiliki nilai '2024-03-08'
                            // $tgl = $dos->tgl_update;
                            $tgl = $tg->tgl_update;

                            // Membuat array untuk mengkonversi nama bulan ke Indonesia
                            $bulanIndonesia = array(
                                '01' => 'Januari',
                                '02' => 'Februari',
                                '03' => 'Maret',
                                '04' => 'April',
                                '05' => 'Mei',
                                '06' => 'Juni',
                                '07' => 'Juli',
                                '08' => 'Agustus',
                                '09' => 'September',
                                '10' => 'Oktober',
                                '11' => 'November',
                                '12' => 'Desember'
                            );

                            // Mengubah format tanggal
                            $tanggal = date('d', strtotime($tgl)); // Mengambil hanya bagian tanggal
                            $bulan = $bulanIndonesia[date('m', strtotime($tgl))]; // Mengambil nama bulan dalam Bahasa Indonesia
                            $tahun = date('Y', strtotime($tgl)); // Mengambil hanya bagian tahun

                            // Menggabungkan kembali menjadi format tanggal Indonesia
                            $tglIndonesia = $tanggal . " " . $bulan . " " . $tahun;
                            ?>

                            <b><i>* Berdasarkan data PDDikti pertanggal <?= $tglIndonesia ?></i></b><br>
                            <b><i>* Data Terkini dapat diakses melalui:</i></b>
                            <ul>
                                <li>Data Program Studi : PDDikti (<a href="https://pddikti.kemdiktisaintek.go.id/" target="_blank" rel="noopener noreferrer">pddikti.kemdikbud.go.id</a>)</li>
                                <li>Data Akreditasi : BAN PT (<a href="https://www.banpt.or.id/" target="_blank" rel="noopener noreferrer">banpt.or.id</a>)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Basic Horizontal Timeline -->
        </div>
    </div>
</div>
<!-- END: Content-->

<?= $this->load->view('v_footer.php') ?>

<!-- BEGIN: Page Vendor JS-->
<script src="<?= base_url() ?>app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
<script src="<?= base_url() ?>assets/js_tampil/data_prodi.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Page JS-->
<script src="<?= base_url() ?>app-assets/js/scripts/tables/datatables/datatable-basic.js"></script>
<!-- END: Page JS-->