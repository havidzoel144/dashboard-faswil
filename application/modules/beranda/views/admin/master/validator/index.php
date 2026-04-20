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

                    <div class="card-content" style="background: linear-gradient(135deg, #f5f7ff 0%, #f8f9fa 100%); padding: 20px; border-bottom: 2px solid #563BFF; border-radius: 0 0 10px 10px;">
                        <div class="row">
                            <div class="col-md-12">
                                <h6 style="font-weight: 600; margin-bottom: 15px; color: #563BFF; font-size: 14px; letter-spacing: 0.5px;">
                                    <i class="fa fa-info-circle" style="margin-right: 8px;"></i>Keterangan Kolom
                                </h6>
                                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 12px;">
                                    <div style="padding: 10px; background: #fff; border-left: 4px solid #563BFF; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                                        <strong style="color: #563BFF; font-size: 12px;">Jumlah PT:</strong>
                                        <p style="margin: 5px 0 0 0; font-size: 12px; color: #666;">Total jumlah Perguruan Tinggi dalam periode penilaian</p>
                                    </div>
                                    <div style="padding: 10px; background: #fff; border-left: 4px solid #222526; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                                        <strong style="color: #222526; font-size: 12px;">Menunggu Approval Admin:</strong>
                                        <p style="margin: 5px 0 0 0; font-size: 12px; color: #666;">Jumlah data yang belum disetujui oleh admin</p>
                                    </div>
                                    <div style="padding: 10px; background: #fff; border-left: 4px solid green; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                                        <strong style="color: green; font-size: 12px;">Valid:</strong>
                                        <p style="margin: 5px 0 0 0; font-size: 12px; color: #666;">Jumlah data yang telah valid</p>
                                    </div>
                                    <div style="padding: 10px; background: #fff; border-left: 4px solid #3f0f59; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                                        <strong style="color: #3f0f59; font-size: 12px;">Draft Validator:</strong>
                                        <p style="margin: 5px 0 0 0; font-size: 12px; color: #666;">Jumlah data dalam status draft oleh validator</p>
                                    </div>
                                    <div style="padding: 10px; background: #fff; border-left: 4px solid chocolate; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                                        <strong style="color: chocolate; font-size: 12px;">Revisi:</strong>
                                        <p style="margin: 5px 0 0 0; font-size: 12px; color: #666;">Jumlah data yang memerlukan perbaikan/revisi</p>
                                    </div>
                                    <div style="padding: 10px; background: #fff; border-left: 4px solid red; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                                        <strong style="color: red; font-size: 12px;">Belum Validasi:</strong>
                                        <p style="margin: 5px 0 0 0; font-size: 12px; color: #666;">Jumlah data yang belum divalidasi</p>
                                    </div>
                                    <div style="padding: 10px; background: #fff; border-left: 4px solid #306fdb; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                                        <strong style="color: #306fdb; font-size: 12px;">Input Faswil:</strong>
                                        <p style="margin: 5px 0 0 0; font-size: 12px; color: #666;">Jumlah data yang telah diinput oleh Faswil</p>
                                    </div>
                                    <div style="padding: 10px; background: #fff; border-left: 4px solid #999; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                                        <strong style="color: #999; font-size: 12px;">Faswil Belum Input:</strong>
                                        <p style="margin: 5px 0 0 0; font-size: 12px; color: #666;">Faswil belum melakukan proses penilaian</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tabel-penilaian" class="table table-striped table-bordered">
                                    <thead>
                                        <tr style="background-color: #563BFF; color: #ffffff">
                                            <th class="text-center">#</th>
                                            <th class="text-center">Periode</th>
                                            <th class="text-center">Keterangan</th>
                                            <th class="text-center">Jumlah <br> PT</th>
                                            <th class="text-center">Menunggu <br> Aprrovel <br> Admin</th>
                                            <th class="text-center">Valid</th>
                                            <th class="text-center">Draft <br> Validator</th>
                                            <th class="text-center">Revisi</th>
                                            <th class="text-center">Belum <br> Validasi</th>
                                            <th class="text-center">Input <br> Faswil</th>
                                            <th class="text-center">Faswil <br> Belum <br> Input</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        if (!empty($val)) { // Cek apakah array progres_penilaian tidak kosong
                                            foreach ($val as $v) { ?>
                                                <tr>
                                                    <td class="text-center"><?= $no++ ?></td>
                                                    <td class="text-center"><?= $v->periode ?></td>
                                                    <td class="text-center"><?= $v->keterangan ?></td>
                                                    <td class="text-center" style="font-weight: bold; color:#563BFF; font-size: large;"><?= $v->jml_pt ?></td>
                                                    <td class="text-center" style="font-weight: bold; color:#222526; font-size: large;"><?= $v->jml_menunggu_approval_admin ?></td>
                                                    <td class="text-center" style="font-weight: bold; color:green; font-size: large;"><?= $v->jml_valid ?></td>
                                                    <td class="text-center" style="font-weight: bold; color:#3f0f59; font-size: large;"><?= $v->jml_draft ?></td>
                                                    <td class="text-center" style="font-weight: bold; color:chocolate; font-size: large;"><?= $v->jml_revisi ?></td>
                                                    <td class="text-center" style="font-weight: bold; color:red; font-size: large;"><?= $v->jml_blm_validasi ?></td>
                                                    <td class="text-center" style="font-weight: bold; color:#306fdb; font-size: large;"><?= $v->jml_input_faswil ?></td>
                                                    <td class="text-center" style="font-weight: bold; color:grey; font-size: large;"><?= $v->jml_faswil_belum_input ?></td>
                                                    <td class="text-center">
                                                        <a href="<?= base_url('penilaian-validator/' . safe_url_encrypt($v->periode)) ?>" class="btn btn-primary btn-sm">Validasi</a>
                                                    </td>
                                                </tr>
                                            <?php }
                                        } else { ?>
                                            <tr>
                                                <td colspan="12" class="text-center">Tidak ada data untuk ditampilkan.</td>
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

<script type="text/javascript">
    $(document).ready(function() {
        $('#tabel-penilaian').DataTable();
    });
</script>