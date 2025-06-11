<?= $this->load->view('admin/v_header') ?>

<!-- BEGIN: Vendor CSS-->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/vendors/css/tables/datatable/datatables.min.css">
<script src="<?= base_url() ?>assets/js/Chart.min.js"></script>

<!-- END: Vendor CSS-->

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
      <div class="row">
        <div class="col-12">
          <form method="post" action="<?= base_url('admin/ubah-password') ?>">
            <label>Password Lama</label><br>
            <input type="password" name="current_password" required><br><br>

            <label>Password Baru</label><br>
            <input type="password" name="new_password" required><br><br>

            <label>Konfirmasi Password Baru</label><br>
            <input type="password" name="confirm_password" required><br><br>

            <button type="submit">Ubah Password</button>
          </form>
        </div>
      </div>
      <!--/ Basic Horizontal Timeline -->
    </div>
  </div>
</div>
<!-- END: Content-->

<!-- MODAL TAMBAH START -->
<div class="modal fade text-left" id="backdrop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel4">TAMBAH DATA KIP KULIAH</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('admin/simpan-kip-kuliah') ?>" method="POST">
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
          <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-outline-primary">Simpan</button>
        </div>
      </form>
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
        <h5 class="modal-title" id="editModalLabel">Ubah Data KIP Kuliah</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form untuk memperbarui data -->
        <form id="editForm" method="post" action="<?= base_url('admin/update_kip_kuliah') ?>">
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

          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.2.0/chartjs-plugin-datalabels.min.js" integrity="sha512-JPcRR8yFa8mmCsfrw4TNte1ZvF1e3+1SdGMslZvmrzDYxS69J7J49vkFL8u6u8PlPJK+H3voElBtUCzaXj+6ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>