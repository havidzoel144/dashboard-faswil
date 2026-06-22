<?= $this->load->view('v_header.php') ?>

<style>
  #doughnutChart {
    transition: opacity .3s ease;
  }
</style>

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
      <div class="row mb-3">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Grafik Penilaian SPMI</h4>
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
                    <!-- <?php if ($this->session->flashdata('success')) : ?>
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
                    <?php endif; ?> -->
                  </div>
                </div>

                <div class="tab-content px-1 pt-1">
                  <div role="tabpanel" class="tab-pane active" id="periode-aktif" aria-labelledby="periode-aktif-tab" aria-expanded="true">
                    <div class="row mb-2">
                      <div class="col-4">
                        <label class="font-weight-bold">Pilih Periode</label>
                        <select id="filterPeriode" class="select2 form-control select2-hidden-accessible">
                        </select>
                        <canvas id="doughnutChart"></canvas>
                      </div>

                      <div class="col-8 d-flex flex-column justify-content-center" style="background-image: linear-gradient(90deg, #6712c8 28%, #2375fc 98%) !important; border-radius: 10px;">

                        <h1 class="text-white align-self-center mb-2 text-bold-700">Tipologi SPMI</h1>
                        <p class="text-white text-justify px-2 font-medium-1">
                          Dalam rangka menyesuaikan kebijakan penjaminan mutu pendidikan tinggi berdasarkan Permendiktisaintek No. 39 Tahun 2025, LLDikti Wilayah III melaksanakan fasilitasi serta verifikasi dan evaluasi implementasi SPMI di perguruan tinggi. Pemetaan tipologi SPMI merupakan bagian dari pola pembinaan LLDikti yang dilakukan melalui verifikasi dan validasi implementasi SPMI perguruan tinggi melalui laman <a href="https://spmi.kemdiktisaintek.go.id" class="text-white text-bold-700" target="_blank" rel="noreferrer"><u>https://spmi.kemdiktisaintek.go.id,</u></a> sebagai dasar pemberian fasilitasi yang sesuai dengan tingkat tipologi, serta pelaksanaan pemantauan dan evaluasi secara periodik.
                        </p>
                        <p class="text-white text-justify px-2 font-medium-1">
                          Pola pembinaan SPMI diselaraskan dengan sasaran budaya mutu pada mekanisme akreditasi yang mencakup aspek masukan, proses, luaran, dan dampak, meliputi keberfungsian standar dan tata kelola SPMI, implementasi siklus PPEPP, ketersediaan laporan dan pengelolaan data, serta capaian akreditasi program studi sebagai bentuk pengakuan mutu.
                        </p>
                        <p class="text-white text-justify px-2 font-medium-1">
                          Lebih lanjut tentang Pola Pembinaan SPMI, dapat diunduh pada tautan <a href="http://lldikti3.kemdikbud.go.id/wp-content/uploads/2024/07/pola_pembinaan_spmi_ll3-Revisi-1.pdf" class="text-white text-bold-700" target="_blank" rel="noreferrer"><u>berikut.</u></a>
                        </p>
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

<?= $this->load->view('admin/v_footer') ?>

<!-- BEGIN: Page Vendor JS-->
<script src="<?= base_url() ?>app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Page JS-->
<script src="<?= base_url() ?>app-assets/js/scripts/tables/datatables/datatable-basic.js"></script>
<!-- END: Page JS-->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js" integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script>

<script type="text/javascript">
  const groupedData = <?= json_encode($data); ?>;
  const periodeSelect = document.getElementById('filterPeriode');
  let doughnutChart = null;
  // ===============================
  // isi select periode
  // ===============================
  Object.keys(groupedData).forEach(function(periode) {
    const label =
      periode.slice(-1) == 1 ?
      periode.substring(0, 4) + ' Periode 1' :
      periode.substring(0, 4) + ' Periode 2';
    periodeSelect.innerHTML += `
        <option value="${periode}">
            ${label}
        </option>
    `;
  });
  // ===============================
  // render chart
  // ===============================
  function renderChart(periode) {
    let data_tipologi = groupedData[periode] || [];
    // filter tipologi kosong
    data_tipologi = data_tipologi.filter(item => {
      const t = item?.tipologi;
      return t !== null &&
        t !== undefined &&
        String(t).trim() !== '' &&
        String(t).toLowerCase() !== 'null';
    });
    if (data_tipologi.length === 0) {
      return;
    }
    const labels = data_tipologi.map(item => item.tipologi);
    const jumlah = data_tipologi.map(item =>
      parseInt(item.jumlah_tipologi)
    );
    const total_data = parseInt(data_tipologi[0].total_data);
    const percentages = data_tipologi.map(item => {
      const percentage =
        (parseInt(item.jumlah_tipologi) / item.total_data) * 100;
      return percentage.toFixed(1);
    });
    const prd =
      periode.slice(-1) == 1 ?
      periode.substring(0, 4) + ' Periode 1' :
      periode.substring(0, 4) + ' Periode 2';
    const canvas = document.getElementById('doughnutChart');
    // destroy chart lama
    if (doughnutChart) {
      doughnutChart.destroy();
    }
    doughnutChart = new Chart(canvas, {
      type: 'doughnut',
      data: {
        labels: labels,
        datasets: [{
          data: percentages,
          jumlah: jumlah,
          backgroundColor: [
            '#0796B7',
            '#0000CD',
            '#FFA360',
            '#00008B'
          ],
          hoverBackgroundColor: [
            '#046980',
            '#00008F',
            '#B27243',
            '#000061'
          ],
          borderWidth: 4,
          borderColor: 'white',
          hoverBorderColor: 'black'
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: true,
            position: 'top',
            labels: {
              generateLabels: (chart) => {
                const datasets = chart.data.datasets;
                return datasets[0].data.map((data, i) => ({
                  text: `${chart.data.labels[i]}: ${datasets[0].jumlah[i]} PT`,
                  fillStyle: datasets[0].backgroundColor[i],
                  strokeStyle: datasets[0].backgroundColor[i],
                  index: i
                }));
              }
            }
          },
          tooltip: {
            enabled: true,
            callbacks: {
              label: function(tooltipItem) {
                const index = tooltipItem.dataIndex;
                const value =
                  tooltipItem.dataset.jumlah[index];
                const label = tooltipItem.label;
                const percentage = tooltipItem.raw;
                return `${label}: ${value} (${percentage}%)`;
              }
            }
          },
          title: {
            display: true,
            text: 'Distribusi Tipologi ' + prd,
            font: {
              size: 18
            }
          },
          datalabels: {
            color: '#000',
            backgroundColor: 'white',
            anchor: 'center',
            align: 'center',
            formatter: (value, context) => {
              const jumlah =
                context.chart.data.datasets[0]
                .jumlah[context.dataIndex];
              return `${jumlah} (${value}%)`;
            }
          },
          annotation: {
            annotations: {
              dLabel: {
                type: 'doughnutLabel',
                content: ({
                  chart
                }) => [
                  'Total',
                  total_data
                ],
                font: [{
                    size: 40
                  },
                  {
                    size: 30
                  }
                ],
                color: ['black', 'red']
              }
            }
          }
        },
        animation: {
          duration: 1000,
          easing: 'easeOutQuart',
          animateRotate: true,
          animateScale: true
        },
        transitions: {
          active: {
            animation: {
              duration: 800
            }
          }
        },
        cutout: '50%',
      },
      plugins: [ChartDataLabels]
    });
  }
  // ===============================
  // event change periode
  // 
  $('#filterPeriode').on('change', function() {
    const periode = $(this).val();
    updateChartByPeriode(periode);
  });
  // ===============================
  // default load pertama
  // ===============================
  const firstPeriode = Object.keys(groupedData).slice(-1)[0];
  if (firstPeriode) {
    periodeSelect.value = firstPeriode;
    renderChart(firstPeriode);
  }

  function updateChartByPeriode(periode) {

    $('#doughnutChart').css('opacity', '.3');

    setTimeout(function() {

      const rows = groupedData[periode] || [];

      const labels = rows.map(item => item.tipologi);

      const jumlah = rows.map(item =>
        parseInt(item.jumlah_tipologi)
      );

      const percentages = rows.map(item =>
        parseFloat(item.persentase)
      );

      const total_data = rows.length > 0 ?
        rows[0].total_data :
        0;

      const prd =
        periode.slice(-1) == 1 ?
        periode.substring(0, 4) + ' Periode 1' :
        periode.substring(0, 4) + ' Periode 2';

      doughnutChart.data.labels = labels;
      doughnutChart.data.datasets[0].data = percentages;
      doughnutChart.data.datasets[0].jumlah = jumlah;

      doughnutChart.options.plugins.title.text =
        'Distribusi Tipologi ' + prd;

      doughnutChart.options.plugins.annotation.annotations.dLabel.content = ['Total', total_data];

      doughnutChart.update();

      $('#doughnutChart').css('opacity', '1');

    }, 200);
  }
</script>