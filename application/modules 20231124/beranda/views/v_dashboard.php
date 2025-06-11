<?= $this->load->view('v_header.php') ?>

<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/tables/datatable/datatables.min.css">
<script src="<?= base_url() ?>assets/js/Chart.min.js"></script>

<!-- END: Vendor CSS-->

<?= $this->load->view('v_menu.php') ?>

<!-- BEGIN: Content-->
<div class="app-content content center-layout"> <!-- untuk tidak full layar -->
    <!-- <div class="app-content content center-layout"> -->
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Basic Horizontal Timeline -->
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                <center>
                                    <b>
                                        <?= $data['universitas'] + $data['sekolah_tinggi'] + $data['politeknik'] + $data['institut'] + $data['akademik'] + $data['akademik_komunitas'] ?> Perguruan Tinggi
                                    </b>
                                </center>
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
                                    <canvas id="myPieChart" width="400" height="400"></canvas>
                                    <br>
                                    <center>
                                        <div class="table-responsive">
                                            <table width="100%" border="0" class="ml-1">
                                                <tr>
                                                    <td width="5%" rowspan="2" bgcolor="#FF0000">&nbsp;</td>
                                                    <td width="20%"><strong><?= $data['universitas'] ?> PTS</strong></td>
                                                    <td width="5%" rowspan="2" bgcolor="cyan">&nbsp;</td>
                                                    <td width="20%"><strong><?= $data['sekolah_tinggi'] ?> PTS</strong></td>
                                                    <td width="5%" rowspan="2" bgcolor="chartreuse">&nbsp;</td>
                                                    <td width="30%"><strong><?= $data['politeknik'] ?> PTS</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>Universitas</td>
                                                    <td>Sekolah Tinggi</td>
                                                    <td>Politeknik</td>
                                                </tr>
                                            </table>
                                            <br>
                                            <table width="100%" border="0" class="ml-1 mb-1">
                                                <tr>
                                                    <td width="5%" rowspan="2" bgcolor="orange">&nbsp;</td>
                                                    <td width="20%"><strong><?= $data['institut'] ?> PTS</strong></td>
                                                    <td width="5%" rowspan="2" bgcolor="Magenta">&nbsp;</td>
                                                    <td width="20%"><strong><?= $data['akademik'] ?> PTS</strong></td>
                                                    <td width="5%" rowspan="2" bgcolor="pink">&nbsp;</td>
                                                    <td width="30%"><strong><?= $data['akademik_komunitas'] ?> PTS</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>Institut</td>
                                                    <td>Akademi</td>
                                                    <td>Akademi Komunitas</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Data Perguruan Tinggi</h4>
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

                                    <div class="table-search-row mb-1">
                                        Pencarian berdasarkan Kode Perguruan Tinggi :
                                        <input type="text" name="kode_pt" class="form-control mb-1" placeholder="Masukkan Kode PT" />

                                        Pencarian berdasarkan Nama Perguruan Tinggi :
                                        <input type="text" name="nama_pt" class="form-control mb-1" placeholder="Masukkan Perguruan Tinggi" />

                                        Pencarian berdasarkan Status :
                                        <input type="text" name="nm_status" class="form-control mb-1" placeholder="Masukkan Status" />

                                        Pencarian berdasarkan Peringkat Akreditasi :
                                        <input type="text" name="akreditasi_pt" class="form-control" placeholder="Masukkan Peringkat Akreditasi" />
                                    </div>

                                    <table id="beranda" class="table table-striped table-bordered">
                                        <thead>
                                            <tr style="background-color: chartreuse;">
                                                <th class="text-center">#</th>
                                                <th class="text-center">Kode</th>
                                                <th class="text-center">Nama</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Peringkat <br> Akreditasi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
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

<?= $this->load->view('v_footer.php') ?>

<!-- BEGIN: Page Vendor JS-->
<script src="<?= base_url() ?>app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Page JS-->
<script src="<?= base_url() ?>app-assets/js/scripts/tables/datatables/datatable-basic.js"></script>
<!-- END: Page JS-->

<script>
    // Mendefinisikan data untuk chart
    var data = <?= json_encode($data); ?>

    // Mendefinisikan data untuk chart
    var total = data.universitas + data.sekolah_tinggi + data.politeknik + data.institut + data.akademik + data.akademik_komunitas;
    var percentages = {
        universitas: ((data.universitas / total) * 100).toFixed(2),
        sekolah_tinggi: ((data.sekolah_tinggi / total) * 100).toFixed(2),
        politeknik: ((data.politeknik / total) * 100).toFixed(2),
        institut: ((data.institut / total) * 100).toFixed(2),
        akademik: ((data.akademik / total) * 100).toFixed(2),
        akademik_komunitas: ((data.akademik_komunitas / total) * 100).toFixed(2)
    };

    // Susun label-label sesuai dengan jenisnya
    var tulisan = [
        percentages.universitas + '%\nUniversitas',
        percentages.sekolah_tinggi + '%\nSekolah Tinggi',
        percentages.politeknik + '%\nPoliteknik',
        percentages.institut + '%\nInstitut',
        percentages.akademik + '%\nAkademi',
        percentages.akademik_komunitas + '%\nAkademik Komunitas'
    ];

    // Mendefinisikan data untuk chart
    var pieData = {
        labels: ['Universitas', 'Sekolah Tinggi', 'Politeknik', 'Institut', 'Akademi', 'Akademik Komunitas'],
        datasets: [{
            data: [data.universitas, data.sekolah_tinggi, data.politeknik, data.institut, data.akademik, data.akademik_komunitas],
            backgroundColor: ['red', 'cyan', 'chartreuse', 'orange', 'Magenta', 'pink']
        }]
    };

    // Mendapatkan konteks untuk menggambar chart
    var ctx = document.getElementById('myPieChart').getContext('2d');

    // Membuat pie chart
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: pieData,
        options: {
            legend: {
                display: false,
                position: 'bottom', // Menetapkan posisi legend ke 'bottom'
            },
            animation: {
                onComplete: function() {
                    var chart = this.chart;
                    var ctx = chart.ctx;
                    var width = chart.width;
                    var height = chart.height;

                    chart.data.datasets.forEach(function(dataset) {
                        for (var i = 0; i < dataset.data.length; i++) {
                            var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
                            var total = dataset._meta[Object.keys(dataset._meta)[0]].total;
                            var midAngle = model.startAngle + (model.endAngle - model.startAngle) / 2;

                            var x = model.x + (model.outerRadius - 10) * Math.cos(midAngle);
                            var y = model.y + (model.outerRadius - 10) * Math.sin(midAngle);

                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle';
                            ctx.fillStyle = 'black'; // Warna teks

                            // Ubah ukuran font di sini
                            var fontSize = 15; // Ukuran font dalam pixel
                            ctx.font = fontSize + 'px sans-serif';

                            var percentage = parseFloat((dataset.data[i] / total * 100).toFixed(2));
                            ctx.fillText(tulisan[i], x, y);
                        }
                    });
                }
            }
        }
    });
</script>

<!-- <script>
    $(document).ready(function() {
        $("#beranda").DataTable({
            dom: 'lfrtip',
            lengthMenu: [
                [10, 25, 50, 10000],
                ['10', '25', '50', 'Show All']
            ],
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            searching: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?= base_url('beranda/beranda/data_pt') ?>",
                type: 'POST',
            },
            order: [
                [1, "asc"]
            ]
        });
    })
</script> -->

<script>
    $(document).ready(function() {
        var dataTable = $('#beranda').DataTable({
            processing: true,
            serverSide: true,
            // searching: false,
            ajax: {
                url: "<?= base_url('beranda/beranda/data_pt_baru'); ?>",
                type: "POST"
            },
            order: [
                [2, "asc"]
            ],
            columnDefs: [{
                targets: 0, // Kolom nomor urut
                searchable: false,
                orderable: false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1; // Menghasilkan nomor urut
                }
            }],
            columns: [
                null, // Kolom nomor urut (diisi oleh render function)
                {
                    "data": "kode_pt"
                },
                {
                    "data": "nama_pt"
                },
                {
                    "data": "nm_status"
                },
                {
                    "data": "akreditasi_pt"
                }
            ]
        });

        // Menambahkan event listener ke setiap input pencarian
        var searchInputs = $('.table-search-row input');

        searchInputs.eq(0).on('keyup change', function() {
            dataTable.column(1).search(this.value).draw();
        });

        searchInputs.eq(1).on('keyup change', function() {
            dataTable.column(2).search(this.value).draw();
        });

        searchInputs.eq(2).on('keyup change', function() {
            dataTable.column(3).search(this.value).draw();
        });

        searchInputs.eq(3).on('keyup change', function() {
            dataTable.column(4).search(this.value).draw();
        });

    });
</script>