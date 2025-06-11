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
                <div class="container col-xl-4">
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
                                            <table width="100%" border="0" class="">
                                                <tr>
                                                    <td width="5%" rowspan="2" bgcolor="#0796B7">&nbsp;</td>
                                                    <td width="20%">&nbsp;<strong><?= $data['universitas'] ?> PT</strong></td>
                                                    <td width="5%" rowspan="2" bgcolor="#0000CD">&nbsp;</td>
                                                    <td width="20%">&nbsp;<strong><?= $data['sekolah_tinggi'] ?> PT</strong></td>
                                                    <td width="5%" rowspan="2" bgcolor="#FFA360">&nbsp;</td>
                                                    <td width="30%">&nbsp;<strong><?= $data['politeknik'] ?> PT</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;Universitas</td>
                                                    <td>&nbsp;Sekolah Tinggi</td>
                                                    <td>&nbsp;Politeknik</td>
                                                </tr>
                                            </table>
                                            <br>
                                            <table width="100%" border="0" class="">
                                                <tr>
                                                    <td width="5%" rowspan="2" bgcolor="#1D90FF">&nbsp;</td>
                                                    <td width="20%">&nbsp;<strong><?= $data['institut'] ?> PT</strong></td>
                                                    <td width="5%" rowspan="2" bgcolor="#00008B">&nbsp;</td>
                                                    <td width="20%">&nbsp;<strong><?= $data['akademik'] ?> PT</strong></td>
                                                    <td width="5%" rowspan="2" bgcolor="#DAB79F">&nbsp;</td>
                                                    <td width="30%">&nbsp;<strong><?= $data['akademik_komunitas'] ?> PT</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;Institut</td>
                                                    <td>&nbsp;Akademi</td>
                                                    <td>&nbsp;Akademi Komunitas</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <?php
                            // Misalkan $dos->tgl_update sudah memiliki nilai '2024-03-08'
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
                            <b><i>* Berdasarkan data PDDikti pertanggal <?= $tglIndonesia ?></i></b>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8">
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

<!-- <script>
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
            backgroundColor: ['#0796B7', '#0000CD', '#FFA360', '#1D90FF', '#00008B', '#DAB79F']
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
</script> -->

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
        percentages.akademik_komunitas + '%\nAkademi Komunitas'
    ];

    // Mendefinisikan data untuk chart
    var pieData = {
        labels: ['Universitas', 'Sekolah Tinggi', 'Politeknik', 'Institut', 'Akademi', 'Akademi Komunitas'],
        datasets: [{
            data: [data.universitas, data.sekolah_tinggi, data.politeknik, data.institut, data.akademik, data.akademik_komunitas],
            backgroundColor: ['#0796B7', '#0000CD', '#FFA360', '#1D90FF', '#00008B', '#DAB79F']
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

                            // Penyesuaian posisi teks untuk berada di luar lingkaran
                            var offsetFromPie = -35; // Penyesuaian offset untuk menjauh dari pie
                            var x = model.x + (model.outerRadius + offsetFromPie) * Math.cos(midAngle);
                            var y = model.y + (model.outerRadius + offsetFromPie) * Math.sin(midAngle);

                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle';
                            ctx.fillStyle = 'white'; // Warna teks
                            ctx.strokeStyle = 'black'; // Warna stroke
                            ctx.lineWidth = 3; // Lebar stroke

                            // Ubah ukuran font di sini
                            var fontSize = 15; // Ukuran font dalam pixel
                            ctx.font = fontSize + 'px sans-serif';

                            var text = tulisan[i].split('%'); // Memisahkan persentase dan nama kategori
                            var percentText = text[0] + '%';
                            var categoryText = text[1];

                            // Menyesuaikan posisi teks persentase dan nama kategori
                            ctx.strokeText(percentText, x, y - fontSize / 2); // Untuk persentase
                            ctx.fillText(percentText, x, y - fontSize / 2); // Untuk persentase

                            ctx.strokeText(categoryText, x, y + fontSize / 2); // Untuk nama kategori
                            ctx.fillText(categoryText, x, y + fontSize / 2); // Untuk nama kategori


                        }
                    });
                }
            }
        }
    });
</script>