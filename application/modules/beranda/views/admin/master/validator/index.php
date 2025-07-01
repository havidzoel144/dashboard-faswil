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
                    <div class="card-header text-center" style="background: linear-gradient(90deg, #563BFF 0%, #6A82FB 100%); color: #fff; border-radius: 10px 10px 0 0; box-shadow: 0 2px 8px rgba(86,59,255,0.08);">

                        <h4 class="card-title" id="heading-buttons1" style="color: white; font-weight: bold; letter-spacing: 1px; margin-bottom: 8px;">
                            <i class="fa fa-check-circle" style="color: #ffd700; margin-right: 8px;"></i>
                            Daftar Periode Penilaian Validator
                        </h4>
                        <a class="heading-elements-toggle" style="color: #fff;"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    </div>

                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tabel-penilaian" class="table table-striped table-bordered">
                                    <thead>
                                        <tr style="background-color: #563BFF; color: #ffffff">
                                            <th class="text-center">#</th>
                                            <th class="text-center">Periode</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php $no = 1; ?>
                                            <?php foreach ($val as $v) { ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td class="text-center">
                                                <?php
                                                if (substr($v->periode, -1, 1) == '1') {
                                                    $periode = substr($v->periode, 0, 4) . ' Periode 1';
                                                } else {
                                                    $periode = substr($v->periode, 0, 4) . ' Periode 2';
                                                }
                                                ?>
                                                <?= $periode ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?= base_url('daftar-fasilitator/' . safe_url_encrypt($v->periode)) ?>" class="btn btn-primary btn-sm">Lihat Fasilitator</a>
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