<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<!-- Modal Ubah Password -->
<div class="modal fade text-left" id="modalUbahPassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel4">UBAH PASSWORD</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?php echo form_open(site_url('admin/ubah-password'), array('class' => 'form-horizontal', 'role' => 'form')); ?>
            <input type="hidden" name="user_id" id="user_id">
            <div class="modal-body">
                <fieldset class="form-group">
                    <label for="current-password">Password Saat Ini</label>
                    <div class="input-group">
                        <input type="password" class="form-control square" id="current-password" name="current_password" placeholder="Masukkan Password Saat Ini">
                        <div class="input-group-append">
                            <span class="input-group-text toggle-password" data-target="#current-password" style="cursor:pointer;">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="form-group">
                    <label for="new-password">Password Baru</label>
                    <div class="input-group">
                        <input type="password" class="form-control square" id="new-password" name="new_password" placeholder="Masukkan Password Baru">
                        <div class="input-group-append">
                            <span class="input-group-text toggle-password" data-target="#new-password" style="cursor:pointer;">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="form-group">
                    <label for="confirm-password">Konfirmasi Password Baru</label>
                    <div class="input-group">
                        <input type="password" class="form-control square" id="confirm-password" name="confirm_password" placeholder="Masukkan Konfirmasi Password Baru">
                        <div class="input-group-append">
                            <span class="input-group-text toggle-password" data-target="#confirm-password" style="cursor:pointer;">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Ubah Password</button>
                <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<!-- BEGIN: Footer-->
<footer class="footer footer-transparent footer-light navbar-shadow">
    <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2 container center-layout"><span class="float-md-left d-block d-md-inline-block">Copyright &copy; 2023 <a class="text-bold-800 grey darken-2" href="#" target="_blank">LLDIKTI III</a></span><span class="float-md-right d-none d-lg-block">by SI BTI 4.0<i class="ft-heart pink"></i><span id="scroll-top"></span></span></p>
</footer>
<!-- END: Footer-->

<!-- BEGIN: Vendor JS-->
<script src="<?= base_url() ?>app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="<?= base_url() ?>app-assets/vendors/js/ui/jquery.sticky.js"></script>
<script src="<?= base_url() ?>app-assets/vendors/js/charts/chartist.min.js"></script>
<script src="<?= base_url() ?>app-assets/vendors/js/charts/chartist-plugin-tooltip.min.js"></script>
<script src="<?= base_url() ?>app-assets/vendors/js/charts/raphael-min.js"></script>
<script src="<?= base_url() ?>app-assets/vendors/js/charts/morris.min.js"></script>
<script src="<?= base_url() ?>app-assets/vendors/js/timeline/horizontal-timeline.js"></script>
<script src="<?= base_url() ?>app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="<?= base_url() ?>app-assets/vendors/js/extensions/toastr.min.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="<?= base_url() ?>app-assets/js/core/app-menu.js"></script>
<script src="<?= base_url() ?>app-assets/js/core/app.js"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="<?= base_url() ?>app-assets/js/scripts/pages/dashboard-ecommerce.js"></script>
<script src="<?= base_url() ?>app-assets/js/scripts/forms/select/form-select2.js"></script>

<script src="<?= base_url() ?>app-assets/js/scripts/popover/popover.js"></script>
<script src="<?= base_url() ?>app-assets/js/scripts/extensions/toastr.js"></script>
<!-- END: Page JS-->

<!-- SWEETALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- SWEETALERT -->

<script>
    window.baseURL = "<?= base_url('') ?>";

    $(document).ready(function() {
        <?php if ($this->session->flashdata('success-login')) : ?>
            toastr.success("<?= $this->session->flashdata('success-login'); ?>");
        <?php endif; ?>
        <?php if ($this->session->flashdata('success')) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: '<?= $this->session->flashdata('success'); ?>',
                confirmButtonColor: '#28a745'
            });
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')) : ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '<?= $this->session->flashdata('error'); ?>',
                confirmButtonColor: '#dc3545'
            });
        <?php endif; ?>
        <?php if ($this->session->flashdata('warning')) : ?>
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: '<?= $this->session->flashdata('warning'); ?>',
                confirmButtonColor: '#ffc107'
            });
        <?php endif; ?>
        <?php if ($this->session->flashdata('info')) : ?>
            Swal.fire({
                icon: 'info',
                title: 'Informasi',
                text: '<?= $this->session->flashdata('info'); ?>',
                confirmButtonColor: '#17a2b8'
            });
        <?php endif; ?>

        $("#program").select2({
            placeholder: "Silakan pilih Program (bisa pilih lebih dari 1)",
            allowClear: true
        });
        $("#akreditasi_prodi").select2({
            placeholder: "Silakan pilih Akreditasi Prodi (bisa pilih lebih dari 1)",
            allowClear: true
        });
        $("#akreditasi_pt").select2({
            placeholder: "Silakan pilih Peringkat Akreditasi (bisa pilih lebih dari 1)",
            allowClear: true
        });
        $("#nm_jabatan").select2({
            placeholder: "Silakan pilih Jabatan (bisa pilih lebih dari 1)",
            allowClear: true
        });
        $("#nm_stat_aktif").select2({
            placeholder: "Silakan pilih Status Keaktifan (bisa pilih lebih dari 1)",
            allowClear: true
        });
    });

    function ubahPassword(encryptedId) {
        var decoded = decodeURIComponent(encryptedId);
        document.getElementById('user_id').value = decoded;
        $('#modalUbahPassword').modal('show');
    }

    $(document).on('click', '.toggle-password', function() {
        var input = $($(this).data('target'));
        var icon = $(this).find('i');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
</script>

</body>
<!-- END: Body-->

</html>