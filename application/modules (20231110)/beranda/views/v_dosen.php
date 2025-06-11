<?= $this->load->view('v_header.php') ?>

<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/tables/datatable/datatables.min.css">
<script src="<?= base_url() ?>assets/js/Chart.min.bar.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->

<!-- END: Vendor CSS-->

<?= $this->load->view('v_menu.php') ?>

<!-- BEGIN: Content-->
<div class="app-content container center-layout mt-2">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Basic Horizontal Timeline -->
            <div class="row">
                <div class="col-5">
                    <div class="card">

                        <div class="card-header">
                            <h4 class="card-title">
                                <center>
                                    <b>
                                        <?= $isi['gb'] + $isi['lk'] + $isi['l'] + $isi['aa'] + $isi['tp'] ?> Dosen
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
                                    <canvas id="barChart" width="400" height="400"></canvas>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-7">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Data Dosen</h4>
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
                                    <table id="dosen" class="table table-striped table-bordered">
                                        <thead>
                                            <tr style="background-color: chartreuse;">
                                                <th class="text-center">#</th>
                                                <th class="text-center">No. Registrasi</th>
                                                <th class="text-center">Nama</th>
                                                <th class="text-center">Perguruan <br>Tinggi</th>
                                                <th class="text-center">Program <br>Studi</th>
                                                <th class="text-center">Jabatan <br> Akademik</th>
                                                <th class="text-center">Bidang <br>Ilmu</th>
                                                <th class="text-center">Status <br> Keaktifan</th>
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
                <!-- <div class="col-7">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Data Perguruan Tinggi</h4>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <div class="table-responsive">
                                    <table id="dosen" class="table table-striped table-bordered">
                                        <thead>
                                            <tr style="background-color: chartreuse;">
                                                <th class="text-center">#</th>
                                                <th class="text-center">No. Registrasi</th>
                                                <th class="text-center">Nama</th>
                                                <th class="text-center">Perguruan <br>Tinggi</th>
                                                <th class="text-center">Program <br>Studi</th>
                                                <th class="text-center">Jabatan <br> Akademik</th>
                                                <th class="text-center">Bidang <br>Ilmu</th>
                                                <th class="text-center">Status <br> Keaktifan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
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
    var da = <?= json_encode($isi); ?>

    // Ambil data dari controller dan simpan dalam variabel JavaScript
    var labels = ['Guru Besar', 'Lektor Kepala', 'Lektor', 'Asisten Ahli', 'Tenaga Pengajar'];
    var data = [da.gb, da.lk, da.l, da.aa, da.tp];

    var datasets = [];

    // Palet warna yang berbeda
    var colors = [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)'
    ];

    for (var i = 0; i < labels.length; i++) {
        datasets.push({
            label: labels[i],
            data: [data[i]],
            backgroundColor: colors[i], // Menggunakan warna dari palet warna
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        });
    }

    var ctx = document.getElementById('barChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jumlah'],
            datasets: datasets
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            legend: {
                display: true, // Menampilkan legenda
                position: 'bottom', // Atur posisi legenda ke bawah grafik
                labels: {
                    fontColor: 'black' // Warna teks legenda
                }
            }
        }
    });
</script>

<script>
    $(document).ready(function() {
        $("#dosen").DataTable({
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
                url: "<?= base_url('beranda/beranda/data_dosen') ?>",
                type: 'POST',
            },
            order: [
                [1, "asc"]
            ]
        });
    })
</script>