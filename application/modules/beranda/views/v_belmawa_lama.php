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
                            <h4 class="card-title">Data MBKM</h4>
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
                                <h3 class="text-center">Grafik Perkembangan Persemester Perbentuk</h3>
                                <div class="table-responsive d-flex justify-content-center">
                                    <canvas id="barChart" width="1000" height="500"></canvas>
                                </div>
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
                                                    <label class="col-md-3 label-control" for="projectinput1">Kode / Nama Perguruan Tinggi</label>
                                                    <div class="col-md-8 mx-auto">
                                                        <select class="select2 form-control select2-hidden-accessible" data-select2-id="1" tabindex="-1" aria-hidden="true" name="kode_pt" id="kode_pt">
                                                            <option value="">Silakan pilih Kode / Nama PT</option>
                                                            <?php foreach ($kode_nama_pt as $item) { ?>
                                                                <option value="<?= $item['kode_pt'] ?>"><?= $item['kode_pt'] ?> - <?= $item['nm_pt'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                            </div>


                                            <table id="tabel-mbkm" class="table table-striped table-bordered" style="width: 99%;">
                                                <thead>
                                                    <tr style="background-color: #563BFF; color: #ffffff">
                                                        <th class="text-center" rowspan="2">#</th>
                                                        <th class="text-center" rowspan="2">Kode PT</th>
                                                        <th class="text-center" rowspan="2">Nama PT</th>
                                                        <th class="text-center" rowspan="2">Jumlah Mahasiswa Aktif<br> (Program S1, D4, D2, D2, D1)</th>
                                                        <th class="text-center" colspan="6">Jumlah Mahasiswa Peserta MBKM</th>
                                                        <th class="text-center" rowspan="2">Persentase <br>Peserta MBKM</th>
                                                    </tr>
                                                    <tr style="background-color: #563BFF; color: #ffffff">
                                                        <th class="text-center">S1</th>
                                                        <th class="text-center">D4</th>
                                                        <th class="text-center">D3</th>
                                                        <th class="text-center">D2</th>
                                                        <th class="text-center">D1</th>
                                                        <th class="text-center">Jumlah <br>Peserta MBKM</th>
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
                            <?php
                            // Misalkan $dos->tgl_update sudah memiliki nilai '2024-03-08'
                            // $tgl = $dos->tgl_update;
                            $tgl = $tg->tgl_update;

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

                            <b><i>* Hanya menampilkan data pada semester aktif</i></b><br>
                            <b><i>* Berdasarkan data PDDikti pertanggal <?= $tglIndonesia ?></i></b>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Basic Horizontal Timeline -->

            <!-- Basic Horizontal Timeline -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Data KIP Kuliah</h4>
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
                                <div class="table-responsive d-flex justify-content-center">
                                    <canvas id="lineChart" width="800" height="400"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <div class="table-responsive">

                                    <form class="form form-horizontal">
                                        <div class="form-body">
                                            <table id="tabel-kip-kuliah" class="table table-striped table-bordered" style="width: 99%;">
                                                <thead>
                                                    <tr style="background-color: #563BFF; color: #ffffff">
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">Tahun</th>
                                                        <th class="text-center">Kuota Reguler</th>
                                                        <th class="text-center">Kuota Usulan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 0; // Inisialisasi counter
                                                    if (!empty($data_kip_kuliah)) { // Cek apakah array data_kip_kuliah tidak kosong
                                                        foreach ($data_kip_kuliah as $data) {
                                                    ?>
                                                            <tr>
                                                                <td class="text-center" style="width: 5%;"><?= ++$i ?></td>
                                                                <td class="text-center" style="width: 25%;"><?= $data['tahun'] ?></td>
                                                                <td class="text-center" style="width: 25%;"><?= $data['kuota_reguler'] ?></td>
                                                                <td class="text-center" style="width: 25%;"><?= $data['kuota_usulan'] ?></td>
                                                            </tr>
                                                        <?php
                                                        }
                                                    } else { // Jika data_kip_kuliah kosong
                                                        ?>
                                                        <tr>
                                                            <td colspan="4" class="text-center">Data tidak tersedia</td> <!-- Baris kosong -->
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>

                                        </div>
                                    </form>

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

<script src="<?= base_url() ?>assets/js_tampil/data_belmawa.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js" integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    // Ambil data dari controller dan simpan dalam variabel JavaScript
    var chartData = <?= json_encode($grafik_data); ?>;

    var labels = [];
    var universitasData = [];
    var institutData = [];
    var sekolahTinggiData = [];
    var akademiData = [];
    var politeknikData = [];
    var akademiKomunitasData = [];
    var lineChartUniversitasData = []; // Data untuk diagram garis
    var lineChartData = []; // Data untuk diagram garis

    chartData.forEach(function(data) {
        if (!labels.includes(data.id_smt)) {
            labels.push(data.id_smt);
        }
        switch (data.bentuk_pt) {
            case 'Universitas':
                universitasData.push(data.jumlah);
                lineChartUniversitasData.push(data.jumlah);
                break;
            case 'Institut':
                institutData.push(data.jumlah);
                break;
            case 'Sekolah Tinggi':
                sekolahTinggiData.push(data.jumlah);
                break;
            case 'Akademi':
                akademiData.push(data.jumlah);
                break;
            case 'Politeknik':
                politeknikData.push(data.jumlah);
                break;
            case 'Akademi Komunitas':
                akademiKomunitasData.push(data.jumlah);
                break;
        }
        // lineChartData.push(data.jumlah); // Simpan data untuk diagram garis (misalnya jumlah total)
    });

    // Palet warna yang berbeda
    var colors = [
        '#00008B',
        '#FF6347',
        '#2f871e',
        '#1D90FF',
        '#8338ab',
        '#69e051',
    ];

    var datasets = [{
            label: 'Universitas',
            data: universitasData,
            backgroundColor: colors[0],
            borderColor: colors[0],
            borderWidth: 1,
            type: 'bar' // Grafik batang
        },
        // {
        //     label: 'Universitas',
        //     data: lineChartUniversitasData,
        //     borderColor: colors[0], // Warna garis
        //     borderWidth: 2,
        //     fill: false,
        //     type: 'line', // Grafik garis
        //     tension: 0, // Membuat garis lebih halus
        // },
        {
            label: 'Institut',
            data: institutData,
            backgroundColor: colors[1],
            borderColor: colors[1],
            borderWidth: 1,
            type: 'bar' // Grafik batang
        },
        {
            label: 'Sekolah Tinggi',
            data: sekolahTinggiData,
            backgroundColor: colors[2],
            borderColor: colors[2],
            borderWidth: 1,
            type: 'bar' // Grafik batang
        },
        {
            label: 'Akademi',
            data: akademiData,
            backgroundColor: colors[3],
            borderColor: colors[3],
            borderWidth: 1,
            type: 'bar' // Grafik batang
        },
        {
            label: 'Politeknik',
            data: politeknikData,
            backgroundColor: colors[4],
            borderColor: colors[4],
            borderWidth: 1,
            type: 'bar' // Grafik batang
        },
        {
            label: 'Akademi Komunitas',
            data: akademiKomunitasData,
            backgroundColor: colors[5],
            borderColor: colors[5],
            borderWidth: 1,
            type: 'bar' // Grafik batang
        },
        // {
        //     label: 'Total Mahasiswa', // Label untuk diagram garis
        //     data: lineChartData, // Data yang diambil dari variabel totalMBKMData
        //     borderColor: '#FF0000', // Warna garis
        //     borderWidth: 2,
        //     fill: false,
        //     type: 'line', // Grafik garis
        //     tension: 0.1, // Membuat garis lebih halus
        //     hidden: false // Menyembunyikan legend untuk dataset ini
        // }
    ];

    var ctx = document.getElementById('barChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: datasets
        },
        plugins: [ChartDataLabels],
        options: {
            plugins: {
                legend: {
                    display: true, // Menampilkan legenda
                    position: 'bottom', // Atur posisi legenda ke bawah grafik
                    labels: {
                        fontColor: 'black' // Warna teks legenda
                    }
                },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    backgroundColor: function(context) {
                        return context.dataset.backgroundColor;
                    },
                    borderRadius: 4,
                    color: 'white',
                    font: {
                        weight: 'bold'
                    },
                    formatter: function(value, context) {
                        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    },
                }
            },
            responsive: false, // Grafik responsif
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

<!-- KIP CHART -->
<script>
    // Ambil data dari PHP ke JavaScript
    var labels = <?= json_encode(array_column($grafik_data_kip, 'tahun')) ?>;
    var kuota_reguler = <?= json_encode(array_column($grafik_data_kip, 'kuota_reguler')) ?>;
    var kuota_usulan = <?= json_encode(array_column($grafik_data_kip, 'kuota_usulan')) ?>;

    // Membuat grafik menggunakan Chart.js
    var ctx = document.getElementById('lineChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line', // Grafik garis
        data: {
            labels: labels, // Label sumbu X (Tahun)
            datasets: [{
                    label: 'Kuota Reguler',
                    data: kuota_reguler, // Data untuk kuota reguler
                    borderColor: 'rgba(75, 192, 192, 1)', // Warna garis
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Warna area di bawah garis
                    borderWidth: 2, // Ketebalan garis
                    fill: true // Isi area di bawah garis
                },
                {
                    label: 'Usulan Masyarakat',
                    data: kuota_usulan, // Data untuk kuota usulan
                    borderColor: 'rgba(255, 99, 132, 1)', // Warna garis
                    backgroundColor: 'rgba(255, 99, 132, 0.2)', // Warna area di bawah garis
                    borderWidth: 2, // Ketebalan garis
                    fill: true // Isi area di bawah garis
                }
            ]
        },
        options: {
            responsive: false, // Grafik responsif
            scales: {
                y: {
                    beginAtZero: true // Sumbu Y dimulai dari 0
                }
            },
            plugins: {
                legend: {
                    position: 'bottom', // Posisi legend di bawah
                }
            }
        }
    });
</script>