<?= $this->load->view('v_header.php') ?>

<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/tables/datatable/datatables.min.css">
<script src="<?= base_url() ?>assets/js/Chart.min.js"></script>

<!-- END: Vendor CSS-->

<?= $this->load->view('v_menu.php') ?>

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Basic Horizontal Timeline -->
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Individual column searching (text inputs)</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <p class="card-text">The searching functionality that is provided by DataTables is very useful for quickly search through the information in the table - however the search is global, and you may wish to present controls to search on specific columns only. DataTables has the ability to apply searching to a specific column through the column().search() method (note that the name of the method is search not filter since filter() is used to apply a filter to a result set).
                                    </p>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered input_data_baru">
                                            <thead>
                                                <tr>
                                                    <th>NIDN</th>
                                                    <th>NAMA</th>
                                                    <th>NAMA PT</th>
                                                    <th>NAMA PRODI</th>
                                                    <th>NAMA JAFUNG</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($a as $a) { ?>
                                                    <tr>
                                                        <td><?= $a->nidn ?></td>
                                                        <td><?= $a->nama ?></td>
                                                        <td><?= $a->nm_pt ?></td>
                                                        <td><?= $a->nm_prodi ?></td>
                                                        <td><?= $a->nm_jabatan ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>NIDN</th>
                                                    <th>NAMA</th>
                                                    <th>NAMA PT</th>
                                                    <th>NAMA PRODI</th>
                                                    <th>NAMA JAFUNG</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
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

<?= $this->load->view('v_footer.php') ?>

<!-- BEGIN: Page Vendor JS-->
<script src="<?= base_url() ?>app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
<script src="<?= base_url() ?>app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Page JS-->
<script src="<?= base_url() ?>app-assets/js/scripts/ui/breadcrumbs-with-stats.js"></script>
<!-- END: Page JS-->

<script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('.input_data_baru tfoot th').each(function() {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        });

        // DataTable
        var tableSearching = $('.input_data_baru').DataTable();

        // Apply the search
        tableSearching.columns().every(function() {
            var that = this;

            $('input', this.footer()).on('keyup change', function() {
                if (that.search() !== this.value) {
                    that
                        .search(this.value)
                        .draw();
                }
            });
        });
    });
</script>