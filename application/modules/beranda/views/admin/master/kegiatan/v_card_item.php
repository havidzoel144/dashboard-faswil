<?php if (!empty($kegiatan)): ?>
  <?php foreach ($kegiatan as $item): ?>
    <?php
    $warna = !empty($item->warna_label) ? $item->warna_label : '#4f46e5';
    $tanggal = !empty($item->tanggal_mulai) ? strtotime($item->tanggal_mulai) : false;
    $tanggalText = $tanggal ? date('d M Y', $tanggal) : '-';
    $jamMulai = !empty($item->jam_mulai) ? date('H:i', strtotime($item->jam_mulai)) : '-';
    $jamSelesai = !empty($item->jam_selesai) ? date('H:i', strtotime($item->jam_selesai)) : '-';
    ?>

    <div class="col-xl-3 col-lg-4 col-md-6 mb-4 kegiatan-item">
      <div class="kegiatan-card">
        <!-- ================================
        FLYER
        ================================= -->
        <div class="kegiatan-flyer-wrapper">
          <?php if (!empty($item->flyer)): ?>
            <img src="<?= base_url('uploads/flyer/' . $item->flyer) ?>" alt="<?= htmlspecialchars($item->judul) ?>" class="kegiatan-flyer" loading="lazy">
          <?php else: ?>
            <div class="no-flyer">
              <i class="la la-image"></i>
              <span>Flyer belum tersedia</span>
            </div>
          <?php endif; ?>

          <!-- CATEGORY -->
          <div class="kegiatan-category" style="color:<?= $warna ?>;">
            <?= htmlspecialchars($item->kategori) ?>
          </div>

          <!-- STATUS -->
          <div class="kegiatan-status" style="color:<?= $warna ?>;">
            <?= htmlspecialchars($item->status) ?>
          </div>
        </div>

        <!-- ================================
        CONTENT
        ================================= -->
        <div class="kegiatan-content">
          <!-- TITLE -->
          <div class="kegiatan-title">
            <a href="<?= base_url('admin/kelola-kegiatan/detail/' . safe_url_encrypt($item->id)) ?>">
              <?= htmlspecialchars($item->judul) ?>
            </a>
          </div>

          <!-- ================================
          META
          ================================= -->
          <div class="kegiatan-meta">
            <!-- DATE -->
            <div class="kegiatan-meta-item">
              <i class="la la-calendar"></i>
              <span>
                <?= $tanggalText ?>
              </span>
            </div>

            <!-- TIME -->
            <div class="kegiatan-meta-item">
              <i class="la la-clock-o"></i>
              <span>
                <?= $jamMulai ?>
                -
                <?= $jamSelesai ?>
                <?= !empty($item->zona_waktu) ? htmlspecialchars($item->zona_waktu) : 'WIB' ?>
              </span>
            </div>

            <!-- LOCATION -->
            <?php if (!empty($item->lokasi)): ?>
              <div class="kegiatan-meta-item">
                <i class="la la-map-marker"></i>
                <span>
                  <?= htmlspecialchars($item->lokasi) ?>
                </span>
              </div>
            <?php endif; ?>
          </div>

          <!-- ================================
          FOOTER
          ================================= -->
          <div class="kegiatan-card-footer">
            <span class="kegiatan-method">
              <i class="la la-laptop"></i>
              <?= htmlspecialchars($item->metode) ?>
            </span>

            <a href="<?= base_url('admin/kelola-kegiatan/detail/' . safe_url_encrypt($item->id)) ?>" class="btn-detail-kegiatan">
              Lihat Detail
              <i class="la la-arrow-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>