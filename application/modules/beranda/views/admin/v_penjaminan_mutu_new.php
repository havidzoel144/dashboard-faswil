<?= $this->load->view('admin/v_header.php') ?>

<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/tables/datatable/datatables.min.css">
<script src="<?= base_url() ?>assets/js/Chart.min.js"></script>

<!-- END: Vendor CSS-->

<?= $this->load->view('admin/v_menu.php') ?>

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

      <div class="form-group row d-flex justify-content-center">
        <button type="button" class="btn btn-dark mb-1 waves-effect waves-light" data-toggle="modal" data-backdrop="false" data-target="#backdrop">Import Data</button>
        <a href="<?= base_url('uploads/template_penjaminan_mutu.xlsx') ?>" class="btn btn-success mb-1 waves-effect waves-light">Download Template</a>
        <!-- Tombol untuk truncate tabel -->
        <button type="button" class="btn btn-danger mb-1 waves-effect waves-light" data-toggle="modal" data-backdrop="false" data-target="#backdropHapus">Hapus Data</button>
      </div>
    </div>
  </div>

  <form class="form form-horizontal" style="width: 100%;">
    <div class="form-body">
      <table id="tabel-penjaminan-mutu" class="table table-striped table-bordered" style="width: 100%;">
        <thead>
          <tr style="background-color: #563BFF; color: #ffffff">
            <th class="text-center" rowspan="3">#</th>
            <th class="text-center" rowspan="3">Periode <span class="text-danger" data-toggle="popover" data-content="Periode 1 : Januari - Juni <br> Periode 2 : Juli - November" data-trigger="hover" data-original-title="Detail" data-html="true"><i class="la la-info-circle"></i></span></th>
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

<!-- MODAL OMPORT START -->
<div class="modal fade text-left" id="backdrop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel4">IMPORT DATA PENJAMINAN MUTU</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- <form action="<?= base_url('admin/import-penjaminan-mutu') ?>" method="POST" enctype="multipart/form-data" id="form-import-data"> -->
      <?php echo form_open_multipart(base_url('admin/import-penjaminan-mutu'), array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'form-import-data')); ?>
      <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
      <div class="modal-body">
        <fieldset class="form-group">
          <label for="periode">Periode</label>
          <select class="select2 form-control select2-hidden-accessible" name="periode" id="periode">
            <option value="">Silakan pilih periode</option>
            <?php foreach ($periode as $item) { ?>
              <option value="<?= $item['periode']; ?>"><?= substr($item['periode'], 0, 4) . ' -- ' . $item['bulan']; ?></option>
            <?php } ?>
          </select>
        </fieldset>
        <fieldset class="form-group">
          <label for="import">Upload File</label>
          <input type="file" class="form-control-file" id="exampleInputFile" name="file_excel" accept=".xlsx, .xls">
        </fieldset>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="import-data">Import</button>
        <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
      <?php echo form_close(); ?>
      <!-- </form> -->
    </div>
  </div>
</div>
<!-- MODAL OMPORT END -->

<!-- MODAL HAPUS DATA START -->
<div class="modal fade text-left" id="backdropHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel4">HAPUS DATA PENJAMINAN MUTU</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- <form action="<?= base_url('admin/hapus-data-penjaminan-mutu') ?>" method="POST" enctype="multipart/form-data" id="form-hapus-data"> -->
      <?php echo form_open(base_url('admin/hapus-data-penjaminan-mutu'), array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'form-hapus-data')); ?>
      <div class="modal-body">
        <fieldset class="form-group">
          <label for="periode">Periode</label>
          <select class="select2 form-control select2-hidden-accessible" name="periode" id="periode-hapus">
            <option value="">Silakan pilih periode</option>
            <?php foreach ($periode as $item) { ?>
              <option value="<?= $item['periode']; ?>"><?= substr($item['periode'], 0, 4) . ' -- ' . $item['bulan']; ?></option>
            <?php } ?>
          </select>
        </fieldset>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="hapus-data">Hapus</button>
        <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
      <?php echo form_close(); ?>
      <!-- </form> -->
    </div>
  </div>
</div>
<!-- MODAL HAPUS DATA END -->

<?= $this->load->view('admin/v_footer') ?>

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