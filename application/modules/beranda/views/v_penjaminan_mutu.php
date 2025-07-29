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
              <h4 class="card-title">Data Penjaminan Mutu</h4>
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

                <div class="row">
                  <div class="col-12">
                    <?php if ($this->session->flashdata('success')) : ?>
                      <div class="alert alert-success alert-dismissible fade show" id="flash-message">
                        <?= $this->session->flashdata('success'); ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                      </div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('error')) : ?>
                      <div class="alert alert-danger alert-dismissible fade show" id="flash-message">
                        <?= $this->session->flashdata('error'); ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>

                <ul class="nav nav-tabs nav-underline no-hover-bg nav-justified nav-tabs-material">
                  <li class="nav-item">
                    <a class="nav-link waves-effect waves-dark active" id="periode-aktif-tab" data-toggle="tab" href="#periode-aktif" aria-controls="periode-aktif" aria-expanded="true">Periode Aktif</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link waves-effect waves-dark" id="riwayat-spmi-tab" data-toggle="tab" href="#riwayat-spmi" aria-controls="riwayat-spmi" aria-expanded="false">Riwayat SPMI</a>
                  </li>
                  <div class="nav-tabs-indicator" style="left: 0px; right: 457.875px;"></div>
                </ul>

                <div class="tab-content px-1 pt-1">
                  <div role="tabpanel" class="tab-pane active" id="periode-aktif" aria-labelledby="periode-aktif-tab" aria-expanded="true">
                    <div class="row mb-2">
                      <div class="col-4">
                        <canvas id="doughnutChart"></canvas>
                      </div>

                      <div class="col-8 d-flex flex-column justify-content-center" style="background-image: linear-gradient(90deg, #6712c8 28%, #2375fc 98%) !important; border-radius: 10px;">

                        <h1 class="text-white align-self-center mb-2 text-bold-700">Tipologi SPMI</h1>
                        <p class="text-white text-justify px-2 font-medium-1">
                          Dalam rangka menjalankan amanat Permendikbudristek No. 53 Tahun 2023 tentang Penjaminan Mutu Pendidikan Tinggi, dimana LLDikti diberikan tugas untuk melakukan fasilitasi pengembangan dan implementasi SPMI, serta melaksanakan verifikasi dan evaluasi SPMI di perguruan tinggi. maka LLDikti Wilayah III mengembangkan sebuah Pola Pembinaan SPMI yang dimulai dengan pemetaan tipologi SPMI, verifikasi-validasi yang berkelanjutan, pemberian fasilitasi yang sesuai dengan tingkat tipologi, serta pelaksanaan pemantauan dan evaluasi secara periodik.
                        </p>
                        <p class="text-white text-justify px-2 font-medium-1">
                          Pengukuran pada pemetaan tipologi SPMI menggunakan butir-butir penilaian penjaminan mutu yang menjadi syarat perlu dalam mekanisme akreditasi institusi, sehingga hasilnya dapat menjadi refleksi dan evaluasi bagi perguruan tinggi dalam memperbaiki tata kelola dan penjaminan mutu internal.
                        </p>
                        <p class="text-white text-justify px-2 font-medium-1">
                          Lebih lanjut tentang Pola Pembinaan SPMI, dapat diunduh pada tautan <a href="http://lldikti3.kemdikbud.go.id/wp-content/uploads/2024/07/pola_pembinaan_spmi_ll3-Revisi-1.pdf" class="text-white text-bold-700" target="_blank" rel="noreferrer"><u>berikut.</u></a>
                        </p>
                      </div>
                    </div>

                    <div class="row">

                      <div class="col-12 d-flex flex-column justify-content-center" style="background-image: linear-gradient(90deg, #6712c8 28%, #2375fc 98%) !important; border-radius: 10px;">
                        <h4 class="text-center text-white mt-2"><i class="ft ft-filter"> Filter Pencarian </i></h4>
                        <hr>

                        <div class="table-search-row mb-1">
                          <div class="form-group row">
                            <div class="col-md-3">
                              <label class="text-right text-white" for="">Kode / Nama Perguruan Tinggi</label>
                            </div>
                            <div class="col-md-8">
                              <select class="select2 form-control select2-hidden-accessible" data-select2-id="1" tabindex="-1" aria-hidden="true" name="kode_pt" id="kode_pt" style="width: 100%;">
                                <option value="">Silakan pilih Kode / Nama PT</option>
                                <?php foreach ($kode_nama_pt as $item) { ?>
                                  <option value="<?= $item['kode_pt'] ?>"><?= $item['kode_pt'] ?> - <?= $item['nm_pt'] ?></option>
                                <?php } ?>
                              </select>
                              <!-- <input type="text" name="kode_pt" class="form-control border-bottom" placeholder="Masukkan Kode / Nama PT"> -->
                            </div>
                            <div class="col-md-1"></div>
                          </div>
                        </div>
                      </div>

                      <form class="form form-horizontal" style="width: 100%;">
                        <div class="form-body">
                          <table id="tabel-penjaminan-mutu" class="table table-striped table-bordered" style="width: 100%;">
                            <thead>
                              <tr style="background-color: #563BFF; color: #ffffff">
                                <th class="text-center" rowspan="3">#</th>
                                <th class="text-center" rowspan="3" style="width: 10%;">Periode <span class="text-danger" data-toggle="popover" data-content="Periode 1 : Januari - Juni <br> Periode 2 : Juli - November" data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span></th>
                                <th class="text-center" rowspan="3">Kode PT</th>
                                <th class="text-center" rowspan="3">Nama PT</th>
                                <th class="text-center" colspan="3">Butir Penilaian</th>
                                <th class="text-center" rowspan="3">
                                  Skor <br> Total <br>
                                  <span class="text-danger" data-toggle="popover" data-content="Skor Total =((Skor 1a+(2*Skor 1b))/3)x2,22)+(Skor 2 x 2,78)" data-trigger="hover" data-original-title="Formula Perhitungan"><i class="la la-info-circle"></i></span>
                                </th>
                                <th class="text-center" rowspan="3">
                                  Tipologi
                                  <span class="text-danger" data-toggle="popover" data-content="Tipologi 1 rentang Nilai Terbobot : 17,5 < n ≤ 20; <br> Tipologi 2 rentang Nilai Terbobot : 15 < n ≤ 17,5; <br> Tipologi 3 rentang Nilai Terbobot : 10 ≤ n ≤ 15; <br> Tipologi 4 Nilai Terbobot : < 10;" data-trigger="hover" data-original-title="Ketentuan Tipologi" data-html="true"><i class="la la-info-circle"></i></span>
                                </th>
                                <th class="text-center" rowspan="3">Akreditasi <br> Institusi</th>
                                <th class="text-center" rowspan="3">Persentase <br> Prodi <br> Terakreditasi</th>
                              </tr>
                              <tr style="background-color: #563BFF; color: #ffffff">
                                <th class="text-center" colspan="2">Butir 1 <br> (Bobot 2,22)</th>
                                <th class="text-center">Butir 2 <br> (Bobot 2,78)</th>
                              </tr>
                              <tr style="background-color: #563BFF; color: #ffffff">
                                <th class="text-center text-wrap">Skor 1a <span class="text-danger" data-toggle="popover" data-content="Ketersediaan dokumen formal SPMI yang dibuktikan dengan keberadaan 5 aspek sebagai berikut: <br> (1) organ/fungsi spmi, <br> (2) dokumen SPMI <br> (3) auditor internal <br> (4) hasil audit <br> (5) bukti tndak lanjut" data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span></th>
                                <th class="text-center text-wrap">Skor 1b <span class="text-danger" data-toggle="popover" data-content="Ketersediaan bukti sahih terkait praktik baik  pengembangan budaya mutu di perguruan tinggi melalui RTM yang mengagendakan unsur-unsur <br> (1) hasil audit internal <br> (2) umpan balik <br> (3) kinerja proses dan kesesuaian produk <br> (4) status tindakan pencegahan dan perbaikan <br> (5) tindak lanjut dari tinjauan sebelumnya <br> (6) perubahan yang dapat mempengaruhi sistem manajemen mutu <br> (7) rekomendasi peningkatan" data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span></th>
                                <th class="text-center text-wrap">Skor 2 <span class="text-danger" data-toggle="popover" data-content="Efektivitas pelaksanaan penjaminan mutu yang memenuhi 4 aspek sbb: <br> 1. keberadaan dokumen formal penetapan standar mutu <br> 2. standar mutu dilaksanakan secara konsisten <br> 3. minitoring evaluasi dan pengendalian terhadap standar mutu yang telah ditetapkan <br> 4. hasilnya ditindaklanjuti untuk perbaikan dan peningkatan mutu" data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span></th>
                              </tr>
                            </thead>
                            <tbody></tbody>
                          </table>
                        </div>
                      </form>
                    </div>
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
                    <b><i>* Berdasarkan data PDDikti pertanggal <?= $tglIndonesia ?></i></b><br>
                    <b><i>* Data Terkini dapat diakses melalui:</i></b>
                    <ul>
                      <li>Data Perguruan Tinggi : PDDikti (<a href="https://pddikti.kemdiktisaintek.go.id/" target="_blank" rel="noopener noreferrer">pddikti.kemdikbud.go.id</a>)</li>
                      <li>Data Akreditasi : BAN PT (<a href="https://www.banpt.or.id/" target="_blank" rel="noopener noreferrer">banpt.or.id</a>)</li>
                    </ul>

                  </div>

                  <div class="tab-pane" id="riwayat-spmi" role="tabpanel" aria-labelledby="riwayat-spmi-tab" aria-expanded="false">
                    <div class="row mb-2">
                      <div class="col-5 pr-2">
                        <div class="row">
                          <div class="col-12" style="background-image: linear-gradient(90deg, #6712c8 28%, #2375fc 98%) !important;">
                            <h4 class="text-center text-white mt-2"><i class="ft ft-filter"> Filter Pencarian </i></h4>
                            <hr>

                            <div class="form-group row">
                              <div class="col-12">
                                <select class="select2 form-control select2-hidden-accessible" data-select2-id="1" tabindex="-1" aria-hidden="true" name="kode_pt_riwayat" id="kode_pt_riwayat" style="width: 100%;">
                                  <option value="">Silakan pilih Kode / Nama PT</option>
                                  <?php foreach ($kode_nama_pt as $item) { ?>
                                    <option value="<?= $item['kode_pt'] ?>"><?= $item['kode_pt'] ?> - <?= $item['nm_pt'] ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                              <div class="col-md-1"></div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-12">
                            <div id="chartLegends" style="margin-top: 20px;" class="">
                              <div class="d-flex justify-content-around flex-column">
                                <div style="display: flex; align-items: center; font-weight: bold;">
                                  <div style="width: 40px; height: 40px; background-color: rgba(0, 128, 0, 0.2); margin-right: 10px;">
                                  </div>
                                  <p>Tipologi 1: 17.5 < n ≤ 20</p>
                                </div>
                                <div style="display: flex; align-items: center; font-weight: bold; margin-top: 5px;">
                                  <div style="width: 40px; height: 40px; background-color: rgba(255, 255, 0, 0.2); margin-right: 10px;">
                                  </div>
                                  <p>Tipologi 2: 15 < n ≤ 17.5 </p>
                                </div>
                                <div style="display: flex; align-items: center; font-weight: bold; margin-top: 5px;">
                                  <div style="width: 40px; height: 40px; background-color: rgba(255, 165, 0, 0.2); margin-right: 10px;">
                                  </div>
                                  <p>Tipologi 3: 10 ≤ n ≤ 15</p>
                                </div>
                                <div style="display: flex; align-items: center; font-weight: bold; margin-top: 5px;">
                                  <div style="width: 40px; height: 40px; background-color: rgba(255, 0, 0, 0.2); margin-right: 10px;">
                                  </div>
                                  <p>Tipologi 4: n < 10</p>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-7">
                        <div class="form-group row d-flex justify-content-center pb-1">
                          <div class="col-12" style="border: 1px solid black;">
                            <!-- Canvas untuk Chart -->
                            <canvas id="lineChart" width="400" height="200" class="d-none"></canvas>
                            <div id="chartMessage" style="text-align: center; font-size: 18px; color: gray; padding-top: 200px;" class="">Chart akan tampil setelah pilih Perguruan Tinggi</div>
                          </div>
                        </div>
                      </div>
                    </div>
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
<!-- END: Page Vendor JS-->

<!-- BEGIN: Page JS-->
<script src="<?= base_url() ?>app-assets/js/scripts/tables/datatables/datatable-basic.js"></script>
<!-- END: Page JS-->
<script src="<?= base_url() ?>assets/js_tampil/data_penjaminan_mutu.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js" integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script>

<script type="text/javascript">
  // Mendefinisikan data untuk chart
  var data_tipologi = <?= json_encode($data); ?>;

  // Membuat array untuk data dan labels
  const labels = data_tipologi.map(item => item.tipologi); // Ambil semua nama tipologi
  const jumlah = data_tipologi.map(item => parseInt(item.jumlah_tipologi)); // Ambil jumlah_tipologi sebagai angka
  const $total_data = data_tipologi.map(item => parseInt(item.total_data)); // Ambil jumlah_tipologi sebagai angka
  const $periode = data_tipologi.map(item => item.periode); // Ambil jumlah_tipologi sebagai angka
  const $prd = $periode[0].slice(-1) == 1 ? $periode[0].substring(0, 4) + ' Periode 1' : $periode[0].substring(0, 4) + ' Periode 2';

  // Tambahkan array persentase dengan menghitung persentase dari jumlah_tipologi
  const percentages = data_tipologi.map(item => {
    const percentage = (parseInt(item.jumlah_tipologi) / item.total_data) * 100;
    return percentage.toFixed(1); // Membatasi 1 digit setelah koma
  });

  // Mendapatkan elemen canvas
  const canvas = document.getElementById('doughnutChart');

  // Membuat objek data dengan konfigurasi chart
  const data = {
    // labels: ['Tipologi 1', 'Tipologi 2', 'Tipologi 3', 'Tipologi 4'],
    labels: labels,
    datasets: [{
      // data: [data_tipologi.tipologi_1, data_tipologi.tipologi_2, data_tipologi.tipologi_3, data_tipologi.tipologi_4],
      data: percentages,
      jumlah: jumlah,
      backgroundColor: ['#0796B7', '#0000CD', '#FFA360', '#00008B'],
      // backgroundColor: ['rgba(0, 128, 0, 0.2)', 'rgba(255, 255, 0, 0.2)', 'rgba(255, 165, 0, 0.2)', 'rgba(255, 0, 0, 0.2)'],
      hoverBackgroundColor: ['#046980', '#00008F', '#B27243', '#000061'],
      // hoverBackgroundColor: ['rgba(0, 128, 0, 0.2)', 'rgba(255, 255, 0, 0.2)', 'rgba(255, 165, 0, 0.2)', 'rgba(255, 0, 0, 0.2)']
      borderWidth: 4,
      borderColor: 'white',
      hoverBorderColor: 'black'
    }]
  };

  // Opsi tambahan untuk kustomisasi chart
  const options = {
    responsive: true, // Membuat chart responsif sesuai ukuran kontainer
    plugins: {
      legend: {
        display: true, // Menampilkan legenda
        position: 'top', // Posisi legenda (top, bottom, left, right)
        labels: {
          generateLabels: (chart) => {
            const datasets = chart.data.datasets;
            return datasets[0].data.map((data, i) => ({
              text: `${chart.data.labels[i]}: ${datasets[0].jumlah[i]} PT`,
              fillStyle: datasets[0].backgroundColor[i],
              strokeStyle: datasets[0].backgroundColor[i],
              index: i
            }))
          }
        }
      },
      tooltip: {
        enabled: true, // Mengaktifkan tooltip saat hover
        callbacks: {
          label: function(tooltipItem) {
            const index = tooltipItem.dataIndex;
            const value = (tooltipItem.dataset['jumlah'][index]);
            const label = tooltipItem.label; // Ambil label (Tipologi 1, 2, dst.)
            const percentage = tooltipItem.raw; // Ambil persentase
            return `${label}: ${value} (${percentage}%)`;
          }
        }
      },
      title: {
        display: true, // Menampilkan judul
        text: 'Distribusi Tipologi ' + $prd, // Teks judul
        font: {
          size: 18, // Ukuran font judul
        }
      },
      datalabels: {
        color: '#000', // Warna label
        backgroundColor: 'white',
        anchor: 'center', // Posisi label
        align: 'center', // Penyelarasan label
        formatter: (value, context) => {
          const label = context.chart.data.labels[context.dataIndex];
          const jumlah = (context.chart.data.datasets[0].jumlah[context.dataIndex]);
          // return `${label}: ${jumlah} (${value}%)`; // Format teks label
          return `${jumlah} (${value}%)`; // Format teks label
        }
      },
      annotation: {
        annotations: {
          dLabel: {
            type: 'doughnutLabel',
            content: ({
              chart
            }) => ['Total',
              $total_data[0],
            ],
            font: [{
              size: 40
            }, {
              size: 30
            }],
            color: ['black', 'red']
          }
        }
      }
    },
    animation: {
      animateScale: true, // Mengaktifkan animasi skala
      animateRotate: true // Mengaktifkan animasi rotasi
    },
    cutout: '50%', // Ukuran lubang di tengah chart
  };

  // Membuat chart doughnut
  new Chart(canvas, {
    type: 'doughnut',
    data: data,
    options: options, // Menambahkan opsi di sini
    plugins: [ChartDataLabels] // Tambahkan plugin datalabels di sini
  });
</script>