<?= $this->load->view('v_header.php') ?>

<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/tables/datatable/datatables.min.css">
<script src="<?= base_url() ?>assets/js/Chart.min.bar.js"></script>

<style>
    #barChart {
        max-width: 100%;
        /* Menjadikan lebar maksimum canvas sebesar container */
        border: 1px solid #ccc;
        /* Memberikan border, ubah sesuai selera */
        box-sizing: border-box;
        /* Memastikan border dan padding termasuk dalam lebar yang ditetapkan */
        width: 100%;
        /* Lebar maksimum */
        margin: 0 auto;
        /* Mengatur margin ke auto untuk mengatur elemen ke tengah halaman */
    }

    #container {
        display: flex;
        justify-content: center;
        align-items: center;
        /* height: 100vh; */
        margin: 0;
    }
</style>
<!-- END: Vendor CSS-->

<?= $this->load->view('v_menu.php') ?>

<!-- BEGIN: Content-->
<!-- <div class="app-content content center-layout"> untuk tidak full layar -->
<div class="app-content content"> <!-- untuk full layar -->
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Basic Horizontal Timeline -->
            <div class="row">
                <!-- <div class="container col-5"> //dengan css container untuk membuat posisi ditengah -->
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                <center>
                                    <b style="font-size: large;">
                                        Grafik Dosen LLDIKTI III <br>Berdasarkan Jabatan Fungsional<br>
                                        Total <?= $isi['gb'] + $isi['lk'] + $isi['l'] + $isi['aa'] + $isi['tp'] ?> Dosen
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
                                    <canvas id="barChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-8">
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

                                    <div class="table-search-row mb-1">
                                        Pencarian berdasarkan Nama Perguruan Tinggi :
                                        <input type="text" name="nm_pt" class="form-control mb-1" placeholder="Masukkan NAMA PT" />

                                        Pencarian berdasarkan Nama Program Studi :
                                        <input type="text" name="nm_prodi" class="form-control mb-1" placeholder="Masukkan NAMA PRODI" />

                                        Pencarian berdasarkan Nama Jabatan Fungsional :
                                        <input type="text" name="nm_jabatan" class="form-control mb-1" placeholder="Masukkan NAMA JAFUNG" />

                                        Pencarian berdasarkan Bidang Ilmu :
                                        <input type="text" name="bidang_ilmu" class="form-control" placeholder="Masukkan BIDANG ILMU" />
                                    </div>

                                    <table id="dataTables" class="table table-striped table-bordered">
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
                                        <tbody></tbody>
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
<script src="<?= base_url() ?>app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
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
        var dataTable = $('#dataTables').DataTable({
            processing: true,
            serverSide: true,
            // searching: false,
            ajax: {
                url: "<?= base_url('beranda/beranda/data_dosen'); ?>",
                type: "POST"
            },
            order: [
                [3, "asc"]
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
                    "data": "nidn"
                },
                {
                    "data": "nama"
                },
                {
                    "data": "nm_pt"
                },
                {
                    "data": "nm_prodi"
                },
                {
                    "data": "nm_jabatan"
                },
                {
                    "data": "bidang_ilmu"
                },
                {
                    "data": "nm_stat_aktif"
                }
            ]
        });

        // Menambahkan event listener ke setiap input pencarian
        var searchInputs = $('.table-search-row input');

        searchInputs.eq(0).on('keyup change', function() { // Pencarian untuk NAMA PT
            dataTable.column(2).search(this.value).draw(); // Angka 2 mengacu pada kolom NAMA PT (index dimulai dari 0)
        });

        searchInputs.eq(1).on('keyup change', function() { // Pencarian untuk NAMA PRODI
            dataTable.column(3).search(this.value).draw(); // Angka 3 mengacu pada kolom NAMA PRODI
        });

        searchInputs.eq(2).on('keyup change', function() { // Pencarian untuk NAMA JAFUNG
            dataTable.column(4).search(this.value).draw(); // Angka 4 mengacu pada kolom NAMA JAFUNG
        });

        searchInputs.eq(3).on('keyup change', function() { // Pencarian untuk BIDANG ILMU
            dataTable.column(5).search(this.value).draw(); // Angka 5 mengacu pada kolom BIDANG ILMU
        });

    });
</script>