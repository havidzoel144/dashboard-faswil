<?= $this->load->view('admin/v_header') ?>

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
        <div class="col-md-12 col-sm-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title" id="heading-buttons1">List Data KIP Kuliah</h4>
              <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <?php if (has_role([3])) : ?>
                  <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-tambah-data="false" data-target="#tambah-data">Tambah Data</button>
                <?php endif; ?>
              </div>
            </div>
            <div class="card-content">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="tabel-kip-kuliah" class="table table-striped table-bordered">
                    <thead>
                      <tr style="background-color: #563BFF; color: #ffffff">
                        <th class="text-center">#</th>
                        <th class="text-center">Tahun</th>
                        <th class="text-center">Kuota Reguler</th>
                        <th class="text-center">Kuota Usulan</th>
                        <th class="text-center">Aksi</th>
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
                            <td class="text-center" style="width: 15%;">
                              <button class="btn btn-info btn-sm waves-effect waves-light" type="button" onclick="openEditModal('<?= $data['id'] ?>', '<?= $data['tahun'] ?>', '<?= $data['kuota_reguler'] ?>', '<?= $data['kuota_usulan'] ?>')">Ubah</button>
                              <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" onclick="confirmDelete(<?= $data['id'] ?>)">Hapus</button>
                            </td>

                          </tr>
                        <?php
                        }
                      } else { // Jika data_kip_kuliah kosong
                        ?>
                        <tr>
                          <td colspan="5" class="text-center">Data tidak tersedia</td> <!-- Baris kosong -->
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

<!-- MODAL TAMBAH START -->
<div class="modal fade text-left" id="tambah-data" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel4">TAMBAH DATA KIP KULIAH</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- <form action="<?= base_url('admin/simpan-kip-kuliah') ?>" method="POST"> -->
      <?php echo form_open(base_url('admin/simpan-kip-kuliah'), array('class' => 'form-horizontal', 'role' => 'form')); ?>
      <div class="modal-body">
        <fieldset class="form-group">
          <label for="tahun">Tahun</label>
          <input type="text" class="form-control square" id="tahun" name="tahun" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" value="<?= date('Y') ?>">
        </fieldset>
        <fieldset class="form-group">
          <label for="kuota_reguler">Kuota Reguler</label>
          <input type="text" class="form-control square" id="kuota_reguler" name="kuota_reguler" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
        </fieldset>
        <fieldset class="form-group">
          <label for="kuota_usulan">Kuota Usulan</label>
          <input type="text" class="form-control square" id="kuota_usulan" name="kuota_usulan" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');">
        </fieldset>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
      <?php echo form_close(); ?>
      <!-- </form> -->
    </div>
  </div>
</div>
<!-- MODAL TAMBAH END -->

<!-- MODAL UBAH START -->
<!-- Modal untuk mengubah data -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">UBAH DATA KIP KULIAH</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form untuk memperbarui data -->
        <!-- <form id="editForm" method="post" action="<?= base_url('admin/update-kip-kuliah') ?>"> -->
        <?php echo form_open(base_url('admin/update-kip-kuliah'), array('class' => 'form-horizontal', 'role' => 'form')); ?>
        <input type="hidden" id="edit_id" name="id"> <!-- Input tersembunyi untuk ID -->

        <div class="form-group">
          <label for="edit_tahun">Tahun</label>
          <input type="text" class="form-control" id="edit_tahun" name="tahun" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" required>
        </div>

        <div class="form-group">
          <label for="edit_kuota_reguler">Kuota Reguler</label>
          <input type="text" class="form-control" id="edit_kuota_reguler" name="kuota_reguler" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" required>
        </div>

        <div class="form-group">
          <label for="edit_kuota_usulan">Kuota Usulan</label>
          <input type="text" class="form-control" id="edit_kuota_usulan" name="kuota_usulan" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Data</button>
        <?php echo form_close(); ?>
        <!-- </form> -->
      </div>
    </div>
  </div>
</div>
<!-- MODAL UBAH END -->

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

<script type="text/javascript">
  $(document).ready(function() {
    var dataTable = $('#tabel-kip-kuliah').DataTable();

    // Sembunyikan alert flash message setelah 3 detik (3000 ms)
    setTimeout(function() {
      $('#flash-message').fadeOut('slow');
    }, 2000); // 3 detik
  });

  function confirmDelete(id) {
    Swal.fire({
      title: "Yakin?",
      text: "Anda akan menghapus data ini!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Tidak!",
      confirmButtonText: "Yes, hapus!"
    }).then((result) => {
      if (result.isConfirmed) {
        // Langsung redirect ke controller yang menangani penghapusan
        window.location.href = "<?= base_url('admin/hapus-kip-kuliah/') ?>" + id;
      }
    });

    // if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
    // Jika konfirmasi "Ya", kirim permintaan ke server untuk menghapus data
    // window.location.href = "<?= base_url('admin/hapus-kip-kuliah/') ?>" + id;
    // }
    // Jika user klik "No", tidak terjadi apa-apa, alert ditutup
  }

  function openEditModal(id, tahun, kuota_reguler, kuota_usulan) {
    // Isi form di modal dengan data yang ada menggunakan jQuery
    $('#edit_id').val(id);
    $('#edit_tahun').val(tahun);
    $('#edit_kuota_reguler').val(kuota_reguler);
    $('#edit_kuota_usulan').val(kuota_usulan);

    // Tampilkan modal menggunakan jQuery
    $('#editModal').modal('show');
  }
</script>