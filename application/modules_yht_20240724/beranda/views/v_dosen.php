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
<div class="app-content content">
    <!-- untuk full layar -->
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Basic Horizontal Timeline -->
            <div class="row">
                <div class="container col-xl-11">
                    <!-- <div class="col-4"> -->
                    <div class="card">
                        <div class="card-content collapse show">
                            <div class="container col-xl-8">
                                <!-- <div class="col-4"> -->
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">
                                            <center>
                                                <b style="font-size: large;">
                                                    Grafik Dosen LLDIKTI III <br>Berdasarkan Jabatan Fungsional<br>
                                                </b>
                                                <h1 style="font-weight: 600;">
                                                    Total <?= str_replace(",", ".", number_format($isi['gb'] + $isi['lk'] + $isi['l'] + $isi['aa'] + $isi['tp'])) ?> Dosen
                                                </h1>
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
                        </div>
                        <div class="card-footer">
                            <?php
                            // Misalkan $dos->tgl_update sudah memiliki nilai '2024-03-08'
                            $tgl = $dos->tgl_update;

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

                            <b><i>* Berdasarkan data PDDikti pertanggal <?= $tglIndonesia ?></i></b>
                        </div>
                    </div>
                </div>

                <div class="container col-xl-11">
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

                                    <h4 class="text-center"><i class="ft ft-filter"> Filter Pencarian </i></h4>
                                    <hr>

                                    <form class="form form-horizontal">
                                        <div class="form-body">
                                            <div class="table-search-row mb-1">

                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="projectinput1">Perguruan Tinggi</label>
                                                    <div class="col-md-8 mx-auto">
                                                        <input type="text" name="nm_pt" class="form-control border-bottom" placeholder="Masukkan NAMA PT">
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="projectinput1">Program Studi</label>
                                                    <div class="col-md-8 mx-auto">
                                                        <input type="text" name="nm_prodi" class="form-control border-bottom" placeholder="Masukkan NAMA PRODI">
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="projectinput1">Jabatan Akademik</label>
                                                    <div class="col-md-8 mx-auto">
                                                        <select class="custom-select mb-1 border-bottom" id="nm_jabatan" name="nm_jabatan">
                                                            <option selected value="">Pilih JAFUNG</option>
                                                            <option value="Tenaga Pengajar">Tenaga Pengajar</option>
                                                            <option value="Asisten Ahli">Asisten Ahli</option>
                                                            <option value="Lektor">Lektor</option>
                                                            <option value="Lektor Kepala">Lektor Kepala</option>
                                                            <option value="Profesor">Profesor</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="projectinput1">Bidang Ilmu</label>
                                                    <div class="col-md-8 mx-auto">
                                                        <input type="text" name="bidang_ilmu" class="form-control border-bottom" placeholder="Masukkan BIDANG ILMU">
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="projectinput1">Status Keaktifan</label>
                                                    <div class="col-md-8 mx-auto">
                                                        <input type="text" name="nm_stat_aktif" class="form-control border-bottom" placeholder="Masukkan Status Keaktifan">
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

                                            <table id="dataTables" class="table table-striped table-bordered" style="width: 99%;">
                                                <thead>
                                                    <tr style="background-color: #563BFF; color: #ffffff">
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
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <b><i>* Berdasarkan data PDDikti pertanggal <?= $tglIndonesia ?></i></b>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js" integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        // Mendefinisikan data untuk chart
        var da = <?= json_encode($isi); ?>

        // Ambil data dari controller dan simpan dalam variabel JavaScript
        var labels = ['Guru Besar', 'Lektor Kepala', 'Lektor', 'Asisten Ahli', 'Tenaga Pengajar'];
        var data = [da.gb, da.lk, da.l, da.aa, da.tp];

        var datasets = [];

        // Palet warna yang berbeda
        var colors = [
            // 'rgba(255, 99, 132, 0.2)',
            // 'rgba(54, 162, 235, 0.2)',
            // 'rgba(255, 206, 86, 0.2)',
            // 'rgba(75, 192, 192, 0.2)',
            // 'rgba(153, 102, 255, 0.2)',
            '#00008B',
            '#0000FF',
            '#1D90FF',
            '#40E0D0',
            '#AFEEEE',
        ];

        var fColors = [
            '#FFFFFF',
            '#FFFFFF',
            '#FFFFFF',
            '#FFFFFF',
            '#FFFFFF',
        ];

        for (var i = 0; i < labels.length; i++) {
            datasets.push({
                label: labels[i],
                data: [data[i]],
                backgroundColor: colors[i], // Menggunakan warna dari palet warna
                // borderColor: 'rgba(255, 99, 132, 1)',
                borderColor: colors[i],
                borderWidth: 1,
                datalabels: {
                    color: fColors[i],
                    anchor: 'end',
                    align: 'top',
                    backgroundColor: colors[i],
                    borderColor: colors[i],
                    borderWidth: 1,
                    borderRadius: 5,
                    // opacity: 0.5,
                    font: {
                        size: 16
                    },
                    formatter: function(value, context) {
                        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    },
                    textStrokeColor: '#241098',
                    textStrokeWidth: 4,
                    // textShadowBlur: 20,
                    // textShadowColor: 'black'
                }
            });
        }

        var ctx = document.getElementById('barChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jumlah'],
                datasets: datasets
            },
            plugins: [ChartDataLabels],
            options: {
                plugins: {
                    legend: {
                        display: true, // Menampilkan legenda
                        position: 'top', // Atur posisi legenda ke bawah grafik
                        labels: {
                            fontColor: 'black' // Warna teks legenda
                        }
                    },
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },

            }
        });
    </script>

    <script>
        $(document).ready(function() {
            var dataTable = $('#dataTables').DataTable({
                dom: '<"top data-dosen"li>frt<"bottom"p><"clear">',
                processing: true,
                serverSide: true,
                searching: true,
                language: {
                    search: "",
                    searchPlaceholder: "Masukkan kata kunci" // Menambahkan placeholder
                },
                ajax: {
                    url: "<?= base_url('beranda/beranda/data_dosen'); ?>",
                    type: "POST"
                },
                order: [
                    [3, "asc"]
                ]
            });

            // Pindahkan kotak pencarian DataTables
            $("#dataTables_filter").detach().appendTo('#search-container');

            $('.dataTables_filter input[type="search"]').removeClass('form-control-sm');
            $('.dataTables_filter input[type="search"]').addClass('border-bottom');
            $('.dataTables_filter label').css({
                'width': '100%'
            });

            // Menambahkan event listener ke setiap input pencarian
            var searchInputs = $('.table-search-row input');
            var selectJafung = document.getElementById('nm_jabatan');

            searchInputs.eq(0).on('keyup change', function() { // Pencarian untuk NAMA PT
                dataTable.column(2).search(this.value).draw(); // Angka 2 mengacu pada kolom NAMA PT (index dimulai dari 0)
            });

            searchInputs.eq(1).on('keyup change', function() { // Pencarian untuk NAMA PRODI
                console.log('prodi:', this.value);
                dataTable.column(3).search(this.value).draw(); // Angka 3 mengacu pada kolom NAMA PRODI
            });

            searchInputs.eq(2).on('keyup change', function() { // Pencarian untuk BIDANG ILMU
                dataTable.column(5).search(this.value).draw(); // Angka 5 mengacu pada kolom BIDANG ILMU
            });

            searchInputs.eq(3).on('keyup change', function() { // Pencarian untuk status keaktifan
                dataTable.column(6).search(this.value).draw(); // Angka 6 mengacu pada kolom status keaktifan
            });

            selectJafung.addEventListener('change', function() {
                var selectedJafung = this.value; // Mendapatkan nilai yang dipilih pada elemen select
                dataTable.column(4).search(selectedJafung).draw();
            });

        });
    </script>