<div class="table-responsive">
  <table id="tabel-kegiatan" class="table table-striped table-bordered">
    <thead>
      <tr style="background-color: #563BFF; color: #ffffff">
        <th class="text-center">Urutan</th>
        <th class="text-center">Kegiatan</th>
        <th class="text-center">Status</th>
        <th class="text-center">Unggulan</th>
        <th class="text-center">Tampil <br> Dashboard</th>
        <th class="text-center">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $i = 0; // Inisialisasi counter
      if (!empty($kegiatan)) { // Cek apakah array kegiatan tidak kosong
        foreach ($kegiatan as $data) {
      ?>
          <tr>
            <td class="text-center" style="width: 3%;">
              <select class="form-control form-control-sm ubah-urutan" data-id="<?= $data->id ?>"
                data-urutan="<?= $data->urutan ?>">
                <?php for ($i = 1; $i <= $jumlah_data; $i++): ?>
                  <option value="<?= $i ?>" <?= $data->urutan == $i ? 'selected' : '' ?>>
                    <?= $i ?>
                  </option>
                <?php endfor; ?>
              </select>
            </td>
            <td class="text-start" style="width: 45%;">
              <div style="display: flex; gap: 16px;">
                <div style="flex: 1;">
                  <strong>Judul Kegiatan: <span style="color: <?= $data->warna_label ?>"><?= $data->judul ?></span></strong><br>
                  <strong>Kategori: <span style="color: <?= $data->warna_label ?>"><?= $data->kategori ?></span></strong><br>
                  <strong>Deskripsi:</strong> <?= $data->deskripsi ?><br>

                  <strong>Metode:</strong> <?= $data->metode ?><br>
                  <strong>Tanggal:</strong> <?= date('d M Y', strtotime($data->tanggal_mulai)) ?> s/d <?= date('d M Y', strtotime($data->tanggal_selesai)) ?><br>
                  <strong>Jam:</strong> <?= date('H:i', strtotime($data->jam_mulai)) ?> s/d <?= date('H:i', strtotime($data->jam_selesai)) . ' ' . $data->zona_waktu  ?><br>
                  <strong>Lokasi:</strong> <?= $data->lokasi ?><br>
                  <strong>Link Meeting:</strong> <a href="<?= $data->link_meeting ?>" target="_blank"><?= $data->link_meeting ?></a>
                </div>
                <div style="flex: 0 0 auto;">
                  <strong>Flyer:</strong><br>
                  <?php if (!empty($data->flyer)) : ?>
                    <img src="<?= base_url('uploads/flyer/' . $data->flyer) ?>" alt="Flyer" style="max-width: 200px; max-height: 200px;" data-action="zoom">
                  <?php else : ?>
                    <span>Tidak ada flyer</span>
                  <?php endif; ?>
                </div>
              </div>
            </td>
            <td class="text-center" style="width: 5%;">
              <select class="form-control form-control-sm mx-auto" data-id="<?= $data->id ?>" data-status="<?= $data->status ?>" style="width: auto;" onchange="updateStatus(this)">
                <option value="Draft" <?= $data->status == 'Draft' ? 'selected' : '' ?>>Draft</option>
                <option value="Pendaftaran" <?= $data->status == 'Pendaftaran' ? 'selected' : '' ?>>Pendaftaran</option>
                <option value="Segera Hadir" <?= $data->status == 'Segera Hadir' ? 'selected' : '' ?>>Segera Hadir</option>
                <option value="Akan Datang" <?= $data->status == 'Akan Datang' ? 'selected' : '' ?>>Akan Datang</option>
                <option value="Berlangsung" <?= $data->status == 'Berlangsung' ? 'selected' : '' ?>>Berlangsung</option>
                <option value="Selesai" <?= $data->status == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                <option value="Ditutup" <?= $data->status == 'Ditutup' ? 'selected' : '' ?>>Ditutup</option>
              </select>
            </td>
            <td class="text-center" style="width: 5%;">
              <select class="form-control form-control-sm mx-auto" data-id="<?= $data->id ?>" data-unggulan="<?= $data->unggulan ?>" style="width: auto;" onchange="updateUnggulan(this)">
                <option value="0" <?= $data->unggulan == '0' ? 'selected' : '' ?>>Tidak</option>
                <option value="1" <?= $data->unggulan == '1' ? 'selected' : '' ?>>Ya</option>
              </select>
            </td>
            <td class="text-center" style="width: 5%;">
              <select class="form-control form-control-sm mx-auto" data-id="<?= $data->id ?>" data-tampil_dashboard="<?= $data->tampil_dashboard ?>" style="width: auto;" onchange="updateTampilDashboard(this)">
                <option value="0" <?= $data->tampil_dashboard == '0' ? 'selected' : '' ?>>Tidak</option>
                <option value="1" <?= $data->tampil_dashboard == '1' ? 'selected' : '' ?>>Ya</option>
              </select>
            </td>
            <td class="text-center" style="width: 5%;">
              <div class="btn-group-vertical btn-group-sm" role="group" aria-label="Aksi pengguna">
                <button class="btn btn-primary waves-effect waves-light" type="button" onclick='openEditModal("<?= $data->id ?>", "<?= addslashes($data->nama) ?>", "<?= addslashes($data->username) ?>", "<?= addslashes($data->email) ?>", <?= json_encode($data->role_id) ?>, "<?= $data->status ?>")' data-toggle="tooltip" data-placement="top" data-original-title="Ubah Data"><i class="la la-edit"></i></button>
                <button class="btn btn-danger waves-effect waves-light" type="button" onclick="confirmDelete('<?= $data->id ?>')" data-toggle="tooltip" data-placement="top" data-original-title="Hapus Data"><i class="la la-trash"></i></button>
              </div>
            </td>

          </tr>
        <?php
        }
      } else { // Jika kegiatan kosong
        ?>
        <tr>
          <td colspan="7" class="text-center">Data tidak tersedia</td> <!-- Baris kosong -->
        </tr>
      <?php
      }
      ?>
    </tbody>
  </table>
</div>