<?= $this->load->view('admin/v_header.php') ?>
<style>
  #chartTipologi {
    height: 500px !important;
  }
</style>
<?= $this->load->view('admin/v_menu.php') ?>

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
      <div class="row mb-3">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Data Penjaminan Mutu</h4>
              <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
              </div>
            </div>

            <div class="card-content collapse show">
              <div class="card-body card-dashboard">
                <div class="tab-content px-1 pt-1">
                  <div role="tabpanel" class="tab-pane active" id="periode-aktif" aria-labelledby="periode-aktif-tab" aria-expanded="true">
                    <div class="row mb-2">
                      <div class="col-6">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                          <button id="btnPanLeft" class="btn btn-primary btn-sm">
                            ← Previous
                          </button>
                          <div id="periodeInfo" class="font-weight-bold"></div>
                          <button id="btnPanRight" class="btn btn-primary btn-sm">
                            Next →
                          </button>
                        </div>
                        <canvas id="chartTipologi"></canvas>
                      </div>

                      <div class="col-6 d-flex flex-column justify-content-center p-2" style="background-image: linear-gradient(90deg, #6712c8 28%, #2375fc 98%) !important; border-radius: 10px;">

                        <h1 class="text-white align-self-center mb-2 text-bold-700">Tipologi SPMI</h1>
                        <p class="text-white text-justify px-2 font-medium-1">
                          Dalam rangka menyesuaikan kebijakan penjaminan mutu pendidikan tinggi berdasarkan Permendiktisaintek No. 39 Tahun 2025, LLDikti Wilayah III melaksanakan fasilitasi serta verifikasi dan evaluasi implementasi SPMI di perguruan tinggi. Pemetaan tipologi SPMI merupakan bagian dari pola pembinaan LLDikti yang dilakukan melalui verifikasi dan validasi implementasi SPMI perguruan tinggi melalui laman <a href="https://spmi.kemdiktisaintek.go.id" class="text-white text-bold-700" target="_blank" rel="noreferrer"><u>https://spmi.kemdiktisaintek.go.id,</u></a> sebagai dasar pemberian fasilitasi yang sesuai dengan tingkat tipologi, serta pelaksanaan pemantauan dan evaluasi secara periodik.
                        </p>
                        <p class="text-white text-justify px-2 font-medium-1">
                          Pola pembinaan SPMI diselaraskan dengan sasaran budaya mutu pada mekanisme akreditasi institusi (IAPT 4.1) yang mencakup aspek masukan, proses, luaran, dan dampak, meliputi keberfungsian standar dan tata kelola SPMI, implementasi siklus PPEPP, ketersediaan laporan dan pengelolaan data, serta capaian akreditasi program studi sebagai bentuk pengakuan mutu.
                        </p>
                        <p class="text-white text-justify px-2 font-medium-1">
                          Lebih lanjut tentang Pola Pembinaan SPMI, dapat diunduh pada tautan <a href="http://lldikti3.kemdikbud.go.id/wp-content/uploads/2024/07/pola_pembinaan_spmi_ll3-Revisi-1.pdf" class="text-white text-bold-700" target="_blank" rel="noreferrer"><u>berikut.</u></a>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>

                <?php if (false) : ?>
                  <div class="row">
                    <div class="col-4 mx-auto">
                      <canvas id="doughnutChart"></canvas>
                    </div>
                  </div>
                <?php endif; ?>
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
  var data_tipologi = <?= json_encode($data); ?>;
  /*
  |--------------------------------------------------------------------------
  | DATA
  |--------------------------------------------------------------------------
  */
  const dataLabels = <?= json_encode($labels); ?>;
  const dataCapaianPT = <?= json_encode($capaian_pt); ?>;
  const dataRataNasional = <?= json_encode($rata_rata_per_periode); ?>;
  /*
  |--------------------------------------------------------------------------
  | SKOR NOL
  |--------------------------------------------------------------------------
  */
  const skorNol = <?= json_encode($skor_nol) ?> || {};  

  /*
  |--------------------------------------------------------------------------
  | FORMAT LABEL PERIODE
  |--------------------------------------------------------------------------
  | 20261 => 1/2026
  | 20262 => 2/2026
  */
  function formatPeriode(periode) {
    periode = periode.toString();

    const tahun = periode.substring(0, 4);
    const semester = periode.substring(4);

    return semester + '/' + tahun;
  }

  /*
  |--------------------------------------------------------------------------
  | ARRAY UNTUK CHART
  |--------------------------------------------------------------------------
  */

  // labels chart
  const labels = dataLabels.map(function(item) {
    return formatPeriode(item);
  });

  // capaian PT
  const capaianPT = dataCapaianPT.map(function(item) {
    return parseFloat(item);
  });

  // rata-rata nasional
  const rataNasional = dataRataNasional.map(function(item) {
    return parseFloat(item);
  });

  /*
  |--------------------------------------------------------------------------
  | STATUS PT TIDAK MEMENUHI
  |--------------------------------------------------------------------------
  */
  const skorNolStatus = dataLabels.map(function(periode) {
    // jika array ada isi -> true
    return (
      skorNol[periode] &&
      skorNol[periode].length > 0
    );
  });

  console.log(skorNolStatus);
  

  /*
  |--------------------------------------------------------------------------
  | GLOBAL VARIABLE
  |--------------------------------------------------------------------------
  */
  let lineChart = null;
  const visibleDataCount = labels.length > 4 ? 4 : labels.length; // jumlah data yang ditampilkan saat awal
  const panStep = 1;
  let xMin = 0;
  let xMax = visibleDataCount - 1;

  /*
  |--------------------------------------------------------------------------
  | DATASET
  |--------------------------------------------------------------------------
  */
  function getChartData() {
    return {
      labels: labels,
      datasets: [
        // CAPAIAN PT
        {
          label: 'Capaian PT',
          data: capaianPT,
          borderColor: '#3366cc',
          // warna titik per data
          pointBackgroundColor: skorNolStatus.map(function(item) {
            return item ? '#dc3545' : '#3366cc';
          }),

          // border titik
          pointBorderColor: skorNolStatus.map(function(item) {
            return item ? '#dc3545' : '#3366cc';
          }),

          // ukuran titik
          pointRadius: skorNolStatus.map(function(item) {
            return item ? 8 : 5;
          }),

          // hover titik
          pointHoverRadius: skorNolStatus.map(function(item) {
            return item ? 10 : 8;
          }),
          backgroundColor: '#3366cc',
          borderWidth: 3,
          tension: 0,
          fill: false,
          // pointRadius: 5,
          // pointHoverRadius: 8
        },

        // RATA NASIONAL
        {
          label: 'Rata-rata Nasional',
          data: rataNasional,
          borderColor: '#f57c00',
          backgroundColor: '#f57c00',
          borderWidth: 3,
          tension: 0.3,
          fill: false,
          pointRadius: 5,
          pointHoverRadius: 8
        },

        // AMBANG BATAS
        {
          label: 'Ambang Terpenuhi',
          data: labels.map(() => 4),
          borderColor: 'red',
          borderWidth: 2,
          borderDash: [10, 5],
          pointRadius: 0,
          fill: false
        }
      ]
    };
  }

  /*
  |--------------------------------------------------------------------------
  | UPDATE BUTTON
  |--------------------------------------------------------------------------
  */
  function updateNavigationButtons() {
    // Disable tombol kiri
    $('#btnPanLeft').prop(
      'disabled',
      xMin <= 0
    );
    // Disable tombol kanan
    $('#btnPanRight').prop(
      'disabled',
      xMax >= labels.length - 1
    );
  }

  /*
  |--------------------------------------------------------------------------
  | UPDATE INFO PERIODE
  |--------------------------------------------------------------------------
  */
  function updatePeriodeInfo() {
    $('#periodeInfo').html(
      labels[xMin] + ' - ' + labels[xMax]
    );
  }

  /*
  |--------------------------------------------------------------------------
  | RENDER CHART
  |--------------------------------------------------------------------------
  */
  function createChart() {
    lineChart = new Chart(
      document.getElementById('chartTipologi'), {
        type: 'line',
        data: getChartData(),
        options: {
          responsive: true,
          maintainAspectRatio: false,
          interaction: {
            intersect: false,
            mode: 'index'
          },
          plugins: {
            legend: {
              position: 'bottom'
            },
            title: {
              display: true,
              text: 'Tipologi SPMI'
            },
            zoom: {
              pan: {
                enabled: true,
                mode: 'x',
                threshold: 10,
              },
              zoom: {
                wheel: {
                  enabled: false
                },
                pinch: {
                  enabled: false
                },
                mode: 'x',
              },
              limits: {
                x: {
                  minRange: visibleDataCount
                }
              }
            },
            tooltip: {
              callbacks: {
                afterLabel: function(context) {
                  // hanya dataset capaian PT
                  if (context.dataset.label !== 'Capaian PT') {
                    return '';
                  }
                  const isTidakMemenuhi =
                    skorNolStatus[context.dataIndex];
                  if (isTidakMemenuhi) {
                    return '⚠ PT Tidak Memenuhi';
                  }
                  return '';
                }
              }
            },
          },
          scales: {
            x: {
              offset: true,
              min: xMin,
              max: xMax,
              title: {
                display: true,
                text: 'Periode'
              }
            },
            y: {
              offset: true,
              min: 0,
              max: 8,
              ticks: {
                stepSize: 1
              },
              title: {
                display: true,
                text: 'Skor'
              }
            }
          }
        }
      }
    );
    updateNavigationButtons();
    updatePeriodeInfo();
  }

  function updateChartRange() {
    lineChart.options.scales.x.min = xMin;
    lineChart.options.scales.x.max = xMax;
    // UPDATE TANPA ANIMASI
    lineChart.update('quiet');
    updateNavigationButtons();
    updatePeriodeInfo();
  }

  /*
  |--------------------------------------------------------------------------
  | PAN LEFT
  |--------------------------------------------------------------------------
  */
  function panLeft() {
    if (xMin - panStep >= 0) {
      xMin -= panStep;
      xMax -= panStep;
      updateChartRange();
    }
  }

  /*
  |--------------------------------------------------------------------------
  | PAN RIGHT
  |--------------------------------------------------------------------------
  */
  function panRight() {
    if (xMax + panStep < labels.length) {
      xMin += panStep;
      xMax += panStep;
      updateChartRange();
    }
  }

  /*
  |--------------------------------------------------------------------------
  | EVENT BUTTON
  |--------------------------------------------------------------------------
  */
  $('#btnPanLeft').on('click', function(e) {
    e.preventDefault();
    panLeft();
  });
  $('#btnPanRight').on('click', function(e) {
    e.preventDefault();
    panRight();
  });

  /*
  |--------------------------------------------------------------------------
  | INIT
  |--------------------------------------------------------------------------
  */
  createChart();
</script>