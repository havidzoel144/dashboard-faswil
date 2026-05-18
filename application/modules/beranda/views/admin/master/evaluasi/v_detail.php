<?= $this->load->view('admin/v_header') ?>

<style>
  .label-rating {
    text-align: center;
    font-weight: bold;
    color: #ffffff;
    font-size: medium;
  }

  .star-rating {
    display: flex;
    justify-content: center;
    gap: 5px;
  }

  .star-rating img {
    width: 30px;
    height: 30px;
  }

  .evaluasi-360 {
    border: 2px solid #563BFF;
    padding: 10px;
    border-radius: 10px;
    background: linear-gradient(135deg, #ad6be2 0%, #444feb 100%);
  }
</style>

<?= $this->load->view('admin/v_menu') ?>

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
        <div class="col-lg-8 col-sm-12 mx-auto">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title" id="heading-buttons1">List Data Fasilitator</h4>
            </div>
            <div class="card-content">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="tabel-data-fasilitator" class="table table-striped table-bordered">
                    <thead>
                      <tr style="background-color: #563BFF; color: #ffffff">
                        <th class="text-center">#</th>
                        <th class="text-center">Nama Fasilitator</th>
                        <th class="text-center">Periode</th>
                        <th class="text-center">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $i = 0; // Inisialisasi counter
                      if (!empty($data_fasilitator)) { // Cek apakah array data_fasilitator tidak kosong
                        foreach ($data_fasilitator as $data) {
                      ?>
                          <tr>
                            <td class="text-center" style="width: 2%;"><?= ++$i ?></td>
                            <td class="text-start" style="width: 10%;"><?= $data->nama_fasilitator ?></td>
                            <td class="text-start" style="width: 13%;"><?= $data->keterangan ?></td>
                            <td class="text-center" style="width: 5%;">
                              <button class="btn btn-primary btn-sm waves-effect waves-light btn-evaluasi" type="button" data-toggle="tooltip" data-placement="top" data-original-title="Evaluasi Faswil" data-id="<?= safe_url_encrypt($data->fasilitator_id) ?>" data-jenis="<?= has_role([2]) ? 'LLDIKTI' : (has_role([4]) && $this->session->userdata('user_id') == $data->fasilitator_id ? 'EVALUASI DIRI' : (has_role([4]) && $this->session->userdata('user_id') != $data->fasilitator_id ? 'PEER REVIEW' : (has_role([6]) ? 'PT BINAAN' : ''))) ?>"><i class="la la-edit"></i> Evaluasi</button>
                            </td>
                          </tr>
                        <?php
                        }
                      } else { // Jika data_fasilitator kosong
                        ?>
                        <tr>
                          <td colspan="6" class="text-center">Data tidak tersedia</td> <!-- Baris kosong -->
                        </tr>
                      <?php
                      }
                      ?>
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

<!-- MODAL UBAH START -->
<!-- Modal untuk evaluasi faswil -->
<div class="modal fade" id="evaluasiModal" tabindex="-1" role="dialog" aria-labelledby="evaluasiModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="evaluasiModalLabel">EVALUASI FASILITATOR</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Form untuk memperbarui data -->
      <?php echo form_open(site_url('admin/evaluasi-360/simpan'), array('class' => 'form-horizontal', 'role' => 'form', 'id' =>  'form-evaluasi')); ?>
      <input type="hidden" id="fasilitator_id" name="fasilitator_id"> <!-- Input tersembunyi untuk ID -->
      <input type="hidden" id="periode" name="periode"> <!-- Input tersembunyi untuk Periode -->
      <input type="hidden" id="jenis_evaluasi" name="jenis_evaluasi"> <!-- Input tersembunyi untuk jenis evaluasi -->
      <div class="modal-body">
        <fieldset class="form-group">
          <div class="row">
            <div class="col-6">
              <label for="nama-fasilitator">Nama Fasilitator</label>
              <span class="font-weight-bolder" id="nama-fasilitator"></span>
            </div>
            <div class="col-6">
              <label for="periode">Periode</label>
              <span class="font-weight-bolder" id="label-periode"></span>
            </div>
          </div>
        </fieldset>
        <hr>
        <!-- Star Rating Role 2: Admin Penjamnu -->
        <?php if (has_role([2])) : ?>
          <fieldset class="form-group evaluasi-360">
            <div class="row">
              <div class="col-12">
                <label class="label-rating" for="kedisiplinan">Kedisiplinan</label>
                <div class="star-rating" data-nama="kedisiplinan" style="cursor: pointer;">
                </div>
              </div>
            </div>
          </fieldset>
          <fieldset class="form-group evaluasi-360">
            <div class="row">
              <div class="col-12">
                <label class="label-rating" for="akurasi-regulasi">Akurasi Regulasi</label>
                <div class="star-rating" data-nama="akurasi-regulasi" style="cursor: pointer;">
                </div>
              </div>
            </div>
          </fieldset>
          <fieldset class="form-group evaluasi-360">
            <div class="row">
              <div class="col-12">
                <label class="label-rating" for="kepatuhan-sop">Kepatuhan SOP</label>
                <div class="star-rating" data-nama="kepatuhan-sop" style="cursor: pointer;">
                </div>
              </div>
            </div>
          </fieldset>
          <fieldset class="form-group evaluasi-360">
            <div class="row">
              <div class="col-12">
                <label class="label-rating" for="kontribusi">Kontribusi Terhadap Capaian Kinerja Wilayah</label>
                <div class="star-rating" data-nama="kontribusi" style="cursor: pointer;">
                </div>
              </div>
            </div>
          </fieldset>
        <?php endif; ?>
        <!-- Star Rating Role 2: Admin Penjamnu -->

        <!-- Star Rating Role 4: Fasilitator -->
        <?php if (has_role([4])) : ?>
          <div id="peer-review">
            <fieldset class="form-group evaluasi-360">
              <div class="row">
                <div class="col-12">
                  <label class="label-rating" for="keselarasan-interpretasi">Keselarasan Interpretasi Regulasi</label>
                  <div class="star-rating" data-nama="keselarasan-interpretasi" style="cursor: pointer;">
                  </div>
                </div>
              </div>
            </fieldset>
            <fieldset class="form-group evaluasi-360">
              <div class="row">
                <div class="col-12">
                  <label class="label-rating" for="kerjasama-tim">Kerjasama Tim</label>
                  <div class="star-rating" data-nama="kerjasama-tim" style="cursor: pointer;">
                  </div>
                </div>
              </div>
            </fieldset>
            <fieldset class="form-group evaluasi-360">
              <div class="row">
                <div class="col-12">
                  <label class="label-rating" for="etika-integritas">Etika & Integritas</label>
                  <div class="star-rating" data-nama="etika-integritas" style="cursor: pointer;">
                  </div>
                </div>
              </div>
            </fieldset>
            <fieldset class="form-group evaluasi-360">
              <div class="row">
                <div class="col-12">
                  <label class="label-rating" for="dukungan-fasilitator">Dukungan Terhadap Fasilitator Lain</label>
                  <div class="star-rating" data-nama="dukungan-fasilitator" style="cursor: pointer;">
                  </div>
                </div>
              </div>
            </fieldset>
          </div>

          <div id="evaluasi-diri">
            <fieldset class="form-group evaluasi-360">
              <div class="row">
                <div class="col-12">
                  <label class="label-rating" for="refleksi-kompetensi">Refleksi Kompetensi</label>
                  <div class="star-rating" data-nama="refleksi-kompetensi" style="cursor: pointer;">
                  </div>
                </div>
              </div>
            </fieldset>
            <fieldset class="form-group evaluasi-360">
              <div class="row">
                <div class="col-12">
                  <label class="label-rating" for="objektivitas-diri">Objektivitas Diri</label>
                  <div class="star-rating" data-nama="objektivitas-diri" style="cursor: pointer;">
                  </div>
                </div>
              </div>
            </fieldset>
            <fieldset class="form-group evaluasi-360">
              <div class="row">
                <div class="col-12">
                  <label class="label-rating" for="rencana-peningkatan-kinerja">Rencana Peningkatan Kinerja</label>
                  <div class="star-rating" data-nama="rencana-peningkatan-kinerja" style="cursor: pointer;">
                  </div>
                </div>
              </div>
            </fieldset>
          </div>
        <?php endif; ?>
        <!-- Star Rating Role 4: Fasilitator -->

        <!-- Star Rating Role 6: PT Binaan -->
        <?php if (has_role([6])) : ?>
          <fieldset class="form-group evaluasi-360">
            <div class="row">
              <div class="col-12">
                <label class="label-rating" for="kualitas-pendampingan">Kualitas Pendampingan</label>
                <div class="star-rating" data-nama="kualitas-pendampingan" style="cursor: pointer;">
                </div>
              </div>
            </div>
          </fieldset>
          <fieldset class="form-group evaluasi-360">
            <div class="row">
              <div class="col-12">
                <label class="label-rating" for="komunikasi">Komunikasi</label>
                <div class="star-rating" data-nama="komunikasi" style="cursor: pointer;">
                </div>
              </div>
            </div>
          </fieldset>
          <fieldset class="form-group evaluasi-360">
            <div class="row">
              <div class="col-12">
                <label class="label-rating" for="kejelasan-regulasi">Kejelasan Regulasi</label>
                <div class="star-rating" data-nama="kejelasan-regulasi" style="cursor: pointer;">
                </div>
              </div>
            </div>
          </fieldset>
          <fieldset class="form-group evaluasi-360">
            <div class="row">
              <div class="col-12">
                <label class="label-rating" for="dampak-pembinaan">Dampak Pembinaan</label>
                <div class="star-rating" data-nama="dampak-pembinaan" style="cursor: pointer;">
                </div>
              </div>
            </div>
          </fieldset>
        <?php endif; ?>
        <!-- Star Rating Role 6: PT Binaan -->


      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="simpan-evaluasi">Simpan</button>
        <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
      <?php echo form_close(); ?>
      <!-- Form untuk evaluasi faswil -->
    </div>
  </div>
</div>
<!-- MODAL UBAH END -->
<?= $this->load->view('admin/v_footer') ?>

<!-- BEGIN: Page Vendor JS-->
<script src=" <?= base_url() ?>app-assets/vendors/js/tables/datatable/datatables.min.js">
</script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Page JS-->
<script src="<?= base_url() ?>app-assets/js/scripts/tables/datatables/datatable-basic.js"></script>
<!-- END: Page JS-->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js" integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
  $(document).ready(function() {
    var dataFasilitator = $('#tabel-data-fasilitator').DataTable();

    // Inisialisasi tooltip saat tabel selesai digambar ulang
    dataFasilitator.on('draw.dt', function() {
      $('[data-toggle="tooltip"]').tooltip();
    });

    // Sembunyikan alert flash message setelah 2 detik
    setTimeout(function() {
      $('#flash-message').fadeOut('slow');
    }, 2000);

    // Inisialisasi plugin rating + tooltip tiap star & tombol cancel
    $('.star-rating').each(function() {
      var namaNilai = $(this).data('nama');
      var $rating = $(this);

      $rating.raty({
        score: 0,
        cancel: true,
        scoreName: 'rating[' + namaNilai + ']',
        hints: ['Sangat Kurang', 'Kurang', 'Cukup', 'Baik', 'Sangat Baik'],
        cancelHint: 'Batalkan penilaian'
      });

      // Tambahkan bootstrap tooltip ke icon star dan cancel
      $rating.find('img').each(function() {
        var title = $(this).attr('title') || $(this).attr('data-alt');
        $(this)
          .attr('data-toggle', 'tooltip')
          .attr('data-placement', 'top')
          .attr('title', title);
      });

      $rating.find('img[data-alt="cancel"]').attr('title', 'Batalkan penilaian');

      $rating.find('[data-toggle="tooltip"]').tooltip({
        trigger: 'hover'
      });
    });
  });

  $(document).on('click', '.btn-evaluasi', function() {
    var namaFasilitator = $(this).closest('tr').find('td:nth-child(2)').text();
    var idFasilitator = $(this).data('id');
    var jenis_evaluasi = $(this).data('jenis');
    var periode = $(this).closest('tr').find('td:nth-child(3)').text();
    var user_id = <?= $this->session->userdata('user_id') ?>;

    // Reset semua rating ke 0
    $('.star-rating').each(function() {
      $(this).raty('set', 0);
    });

    $('#nama-fasilitator').text(namaFasilitator); // Tampilkan nama fasilitator di modal
    $('#fasilitator_id').val(idFasilitator); // Set nilai ID fasilitator ke input tersembunyi di modal
    $('#jenis_evaluasi').val(jenis_evaluasi); // Set nilai Jenis Evaluasi ke input tersembunyi di modal
    $('#periode').val(periode); // Set nilai periode ke input tersembunyi di modal
    $('#label-periode').text(periode); // Tampilkan periode di modal
    if (user_id != idFasilitator) {
      $('#peer-review').show();
      $('#evaluasi-diri').hide();
    } else {
      $('#peer-review').hide();
      $('#evaluasi-diri').show();
    }

    $('#evaluasiModal').modal('show');
  });

  $(document).on('click', '#simpan-evaluasi', function(e) {
    e.preventDefault(); // Mencegah form submit default
    var namaFasilitator = $('#nama-fasilitator').text();
    var idFasilitator = $('#fasilitator_id').val();

    Swal.fire({
      title: 'Evaluasi Faswil',
      text: "Apakah Anda ingin melakukan evaluasi untuk " + namaFasilitator + "?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Evaluasi!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        $('#form-evaluasi').submit(); // Submit form jika pengguna mengkonfirmasi
      }
    });
  });
</script>