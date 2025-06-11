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
      <?php
      $roles = $this->session->userdata('roles'); // ambil array roles dari session

      $role_names = [];
      if (!empty($roles) && is_array($roles)) {
        foreach ($roles as $role) {
          $role_names[] = ucwords($role->nama_role); // bisa juga strtoupper($role->nama_role)
        }
      }

      $roles_string = implode(', ', $role_names);
      ?>
      <div class="row mb-2">
        <div class="col-12">
          <h1 class="display-5">
            Selamat datang
            <span class="badge-info"><?= $this->session->userdata('nama') ?></span> di website Dashboard LLDIKTI 3.
            Anda login sebagai
            <span class="badge-info"><?= $roles_string ?></span>
          </h1>
        </div>
      </div>

      <div class="row">
        <div class="col-xl-3 col-lg-6 col-12">
          <div class="card pull-up">
            <div class="card-content">
              <div class="card-body">
                <div class="media d-flex">
                  <div class="media-body text-left">
                    <h3 class="info">850</h3>
                    <h6>Products Sold</h6>
                  </div>
                  <div>
                    <i class="icon-basket-loaded info font-large-2 float-right"></i>
                  </div>
                </div>
                <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                  <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
          <div class="card pull-up">
            <div class="card-content">
              <div class="card-body">
                <div class="media d-flex">
                  <div class="media-body text-left">
                    <h3 class="warning">$748</h3>
                    <h6>Net Profit</h6>
                  </div>
                  <div>
                    <i class="icon-pie-chart warning font-large-2 float-right"></i>
                  </div>
                </div>
                <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                  <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
          <div class="card pull-up">
            <div class="card-content">
              <div class="card-body">
                <div class="media d-flex">
                  <div class="media-body text-left">
                    <h3 class="success">146</h3>
                    <h6>New Customers</h6>
                  </div>
                  <div>
                    <i class="icon-user-follow success font-large-2 float-right"></i>
                  </div>
                </div>
                <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                  <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-12">
          <div class="card pull-up">
            <div class="card-content">
              <div class="card-body">
                <div class="media d-flex">
                  <div class="media-body text-left">
                    <h3 class="danger">99.89 %</h3>
                    <h6>Customer Satisfaction</h6>
                  </div>
                  <div>
                    <i class="icon-heart danger font-large-2 float-right"></i>
                  </div>
                </div>
                <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                  <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
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

<script type="text/javascript">
  $(document).ready(function() {
    var dataTable = $('#tabel-kip-kuliah').DataTable({
      dom: '<"top data-dosen"li>frt<"bottom"p><"clear">',
      // processing: true,
      // serverSide: true,
      searching: false,
    });


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
        Swal.fire({
          title: "Berhasil!",
          text: "Data telah dihapus.",
          icon: "success"
        }).then(() => {
          // Setelah pengguna klik tombol OK, baru proses penghapusan dilakukan
          window.location.href = "<?= base_url('admin/hapus-kip-kuliah/') ?>" + id;
        });
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