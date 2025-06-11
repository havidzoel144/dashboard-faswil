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
                                                    <label class="col-md-3 label-control" for="projectinput1">Kode Perguruan Tinggi</label>
                                                    <div class="col-md-8 mx-auto">
                                                        <input type="text" name="kode_pt" class="form-control border-bottom" placeholder="Masukkan Kode PT">
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="projectinput1">Perguruan Tinggi</label>
                                                    <div class="col-md-8 mx-auto">
                                                        <input type="text" name="nama_pt" class="form-control border-bottom" placeholder="Masukkan Perguruan Tinggi">
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="projectinput1">Status</label>
                                                    <div class="col-md-8 mx-auto">
                                                        <input type="text" name="nm_status" class="form-control border-bottom" placeholder="Masukkan Status">
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                                <!-- <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="projectinput1">Peringkat Akreditasi</label>
                                                    <div class="col-md-8 mx-auto">
                                                        <input type="text" name="akreditasi_pt" class="form-control border-bottom" placeholder="Masukkan Peringkat Akreditasi">
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div> -->

                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="projectinput1">Peringkat Akreditasi</label>
                                                    <div class="col-md-8 mx-auto">
                                                        <select class="custom-select mb-1 border-bottom" id="akreditasi_pt" name="akreditasi_pt">
                                                            <option selected value="-">Pilih Akreditasi</option>
                                                            <?php foreach ($akreditasi_pt as $akre) { ?>
                                                                <option value="<?= $akre['akreditasi_pt'] == "" ? 'kosong' : $akre['akreditasi_pt'] ?>"><?= $akre['akreditasi_pt'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="projectinput1">Kata Kunci</label>
                                                    <div class="col-md-8 mx-auto">
                                                        <div id="search-container"></div>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                            </div>


                                            <table id="beranda" class="table table-striped table-bordered" style="width: 99%;">
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
                            <b><i>* Berdasarkan data PDDikti pertanggal <?= $tglIndonesia ?></i></b>
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
<!-- END: Page Vendor JS-->

<!-- BEGIN: Page JS-->
<script src="<?= base_url() ?>app-assets/js/scripts/tables/datatables/datatable-basic.js"></script>
<!-- END: Page JS-->

<script>
    $(document).ready(function() {
        var dataTable = $('#beranda').DataTable({
            dom: '<"top data-dosen"li>frt<"bottom"p><"clear">',
            processing: true,
            serverSide: true,
            searching: true,
            language: {
                search: "",
                searchPlaceholder: "Masukkan kata kunci" // Menambahkan placeholder
            },
            ajax: {
                url: "<?= base_url('beranda/beranda/data_pt_ok'); ?>",
                type: "POST"
            },
            order: [
                [2, "asc"]
            ]
        });

        // Pindahkan kotak pencarian DataTables
        $("#beranda_filter").detach().appendTo('#search-container');

        $('.dataTables_filter input[type="search"]').removeClass('form-control-sm');
        $('.dataTables_filter input[type="search"]').addClass('border-bottom');
        $('.dataTables_filter label').css({
            'width': '100%'
        });

        // Menambahkan event listener ke setiap input pencarian
        var searchInputs = $('.table-search-row input');
        var selectedAkreditasi = document.getElementById('akreditasi_pt');

        searchInputs.eq(0).on('keyup change', function() {
            dataTable.column(1).search(this.value).draw();
        });

        searchInputs.eq(1).on('keyup change', function() {
            dataTable.column(2).search(this.value).draw();
        });

        searchInputs.eq(2).on('keyup change', function() {
            dataTable.column(3).search(this.value).draw();
        });

        // searchInputs.eq(3).on('keyup change', function() {
        //     dataTable.column(4).search(this.value).draw();
        // });

        selectedAkreditasi.addEventListener('change', function() {
            var selectedAkreditasi = this.value; // Mendapatkan nilai yang dipilih pada elemen select
            dataTable.column(4).search(selectedAkreditasi).draw();
        });

    });
</script>