<?= $this->load->view('admin/v_header') ?>

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
                    if (substr($periode, 4, 1) == "1") {
                        $isi_periode = substr($periode, 0, 4) . ' Periode 1';
                    } else {
                        $isi_periode = substr($periode, 0, 4) . ' Periode 2';
                    }
                    ?>

                    <div class="card-header text-center" style="background: linear-gradient(90deg, #563BFF 0%, #6A82FB 100%); color: #fff; border-radius: 10px 10px 0 0; box-shadow: 0 2px 8px rgba(86,59,255,0.08);">

                        <h4 class="card-title" id="heading-buttons1" style="color: white; font-weight: bold; letter-spacing: 1px; margin-bottom: 8px;">
                            <i class="fa fa-check-circle" style="color: #ffd700; margin-right: 8px;"></i>
                            Daftar Fasilitator
                        </h4>
                        <div style="font-size: 1.1em;">
                            <i class="fa fa-calendar" style="color: #fff;"></i>
                            <b><?= $isi_periode ?></b>
                        </div>
                        <a class="heading-elements-toggle" style="color: #fff;"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    </div>

                    <div style="margin-left: 20px;margin-top: 20px;">
                        <a href="<?= base_url('admin/validator') ?>">
                            <button class="btn btn-info btn-md" type="button">
                                <i class="fa fa-arrow-left"></i> Lihat Daftar Periode
                            </button>
                        </a>
                    </div>

                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tabel-penilaian" class="table table-striped table-bordered">
                                    <thead>
                                        <tr style="background-color: #563BFF; color: #ffffff">
                                            <th class="text-center">#</th>
                                            <th class="text-center">Nama</th>
                                            <th class="text-center">Jumlah PT</th>
                                            <th class="text-center">Jumlah Valid</th>
                                            <th class="text-center">Jumlah Revisi</th>
                                            <th class="text-center">Jumlah Belum Validasi</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php $no = 1; ?>
                                            <?php foreach ($val as $v) { ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td class="text-center"><?= $v->nama ?></td>
                                            <td class="text-center" style="font-weight: bold; color:#563BFF; font-size: large;"><?= $v->jml_pt ?></td>
                                            <td class="text-center" style="font-weight: bold; color:green; font-size: large;"><?= $v->jml_valid ?></td>
                                            <td class="text-center" style="font-weight: bold; color:chocolate; font-size: large;"><?= $v->jml_revisi ?></td>
                                            <td class="text-center" style="font-weight: bold; color:red; font-size: large;"><?= $v->jml_blm_validasi ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url('penilaian-validator/' . safe_url_encrypt($periode)) ?>" class="btn btn-primary btn-sm">Validasi</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tr>
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