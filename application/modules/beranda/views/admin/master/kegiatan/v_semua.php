<?= $this->load->view('admin/v_header') ?>

<?= $this->load->view('admin/v_menu') ?>

<style>
  /* =====================================================
  PAGE
  ===================================================== */
  .kegiatan-page {
    padding-bottom: 70px;
  }

  .kegiatan-header {
    margin-bottom: 20px;
  }

  .kegiatan-header h1 {
    color: #172554;
    font-size: 27px;
    font-weight: 800;
    margin-bottom: 5px;
  }

  .kegiatan-header p {
    color: #64748b;
    font-size: 12px;
    margin-bottom: 0;
  }

  /* =====================================================
  BREADCRUMB
  ===================================================== */
  .kegiatan-breadcrumb {
    display: flex;
    align-items: center;
    gap: 7px;
    margin-bottom: 15px;
    font-size: 11px;
    color: #94a3b8;
  }

  .kegiatan-breadcrumb a {
    color: #4f46e5;
    font-weight: 600;
    text-decoration: none;
  }

  .kegiatan-breadcrumb a:hover {
    color: #312e81;
  }

  .kegiatan-breadcrumb i {
    font-size: 10px;
  }

  /* =====================================================
  FILTER
  ===================================================== */
  .filter-card {
    background: #fff;
    border: 1px solid #edf0f5;
    border-radius: 15px;
    padding: 13px 15px;
    margin-bottom: 20px;
    box-shadow: 0 5px 18px rgba(15, 23, 42, .04);
  }

  .filter-label {
    color: #64748b;
    font-size: 10px;
    font-weight: 700;
    margin-bottom: 5px;
  }

  .filter-card .form-control {
    height: 36px;
    border-radius: 8px;
    border-color: #e2e8f0;
    font-size: 11px;
    color: #334155;
  }

  .filter-card .form-control:focus {
    border-color: #818cf8;
    box-shadow: 0 0 0 2px rgba(99, 102, 241, .08);
  }

  /* =====================================================
  CARD KEGIATAN
  ===================================================== */
  .kegiatan-card {
    height: 100%;
    background: #fff;
    border: 1px solid #edf0f5;
    border-radius: 17px;
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(15, 23, 42, .05);
    transition: all .22s ease;
    display: flex;
    flex-direction: column;
  }

  .kegiatan-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(15, 23, 42, .09);
    border-color: #e0e7ff;
  }

  /* =====================================================
  FLYER
  ===================================================== */
  .kegiatan-flyer-wrapper {
    position: relative;
    height: 205px;
    background: #f8fafc;
    overflow: hidden;
  }

  .kegiatan-flyer {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform .3s ease;
  }

  .kegiatan-card:hover .kegiatan-flyer {
    transform: scale(1.025);
  }

  .no-flyer {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    color: #94a3b8;
  }

  .no-flyer i {
    font-size: 40px;
    margin-bottom: 7px;
  }

  .no-flyer span {
    font-size: 10px;
  }

  /* =====================================================
  BADGE
  ===================================================== */
  .kegiatan-category {
    position: absolute;
    top: 10px;
    left: 10px;
    padding: 5px 9px;
    border-radius: 7px;
    background: rgba(255, 255, 255, .94);
    backdrop-filter: blur(5px);
    font-size: 9px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .35px;
    box-shadow: 0 3px 8px rgba(15, 23, 42, .08);
  }

  .kegiatan-status {
    position: absolute;
    right: 10px;
    top: 10px;
    padding: 5px 8px;
    border-radius: 7px;
    background: rgba(255, 255, 255, .94);
    backdrop-filter: blur(5px);
    font-size: 9px;
    font-weight: 700;
    box-shadow: 0 3px 8px rgba(15, 23, 42, .08);
  }

  /* =====================================================
  CARD CONTENT
  ===================================================== */
  .kegiatan-content {
    padding: 15px;
    flex: 1;
    display: flex;
    flex-direction: column;
  }

  .kegiatan-title {
    color: #172554;
    font-size: 14px;
    font-weight: 750;
    line-height: 1.4;
    margin-bottom: 10px;
    display: -webkit-box;
    /* -webkit-line-clamp: 2; */
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .kegiatan-title a {
    color: inherit;
    text-decoration: none;
  }

  .kegiatan-title a:hover {
    color: #4f46e5;
  }

  /* =====================================================
  META
  ===================================================== */
  .kegiatan-meta {
    margin-bottom: 13px;
  }

  .kegiatan-meta-item {
    display: flex;
    align-items: flex-start;
    gap: 7px;
    margin-bottom: 6px;
    color: #64748b;
    font-size: 10px;
    line-height: 1.45;
  }

  .kegiatan-meta-item:last-child {
    margin-bottom: 0;
  }

  .kegiatan-meta-item i {
    color: #6366f1;
    font-size: 14px;
    width: 15px;
    text-align: center;
    flex-shrink: 0;
  }

  /* =====================================================
  FOOTER CARD
  ===================================================== */
  .kegiatan-card-footer {
    margin-top: auto;
    padding-top: 11px;
    border-top: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
  }

  .kegiatan-method {
    color: #94a3b8;
    font-size: 9px;
    font-weight: 600;
  }

  .btn-detail-kegiatan {
    border-radius: 8px;
    padding: 7px 11px;
    font-size: 10px;
    font-weight: 700;
    background: #eef2ff;
    color: #4338ca;
    border: 0;
    text-decoration: none !important;
    white-space: nowrap;
  }

  .btn-detail-kegiatan:hover {
    background: #4f46e5;
    color: #fff;
  }

  /* =====================================================
  EMPTY
  ===================================================== */
  .empty-kegiatan {
    background: #fff;
    border: 1px solid #edf0f5;
    border-radius: 17px;
    padding: 55px 20px;
    text-align: center;
  }

  .empty-kegiatan i {
    font-size: 55px;
    color: #cbd5e1;
    margin-bottom: 10px;
  }

  .empty-kegiatan h4 {
    color: #475569;
    font-size: 15px;
    font-weight: 700;
    margin-bottom: 5px;
  }

  .empty-kegiatan p {
    color: #94a3b8;
    font-size: 11px;
    margin: 0;
  }

  /* =====================================================
  RESPONSIVE
  ===================================================== */
  @media (max-width: 991px) {
    .kegiatan-flyer-wrapper {
      height: 220px;
    }
  }

  @media (max-width: 575px) {
    .kegiatan-header h1 {
      font-size: 23px;
    }

    .kegiatan-flyer-wrapper {
      height: 230px;
    }
  }

  /* =====================================================
  LAZY LOADING
  ===================================================== */
  .lazy-loading-wrapper {
    display: none;
    width: 100%;
    padding: 10px 0 30px 0;
    text-align: center;
  }

  .lazy-loading-content {
    display: inline-flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }

  .lazy-spinner {
    width: 30px;
    height: 30px;
    border: 3px solid #e2e8f0;
    border-top-color: #6366f1;
    border-radius: 50%;
    animation: lazySpin .7s linear infinite;
    margin-bottom: 8px;
  }

  .lazy-loading-text {
    font-size: 11px;
    font-weight: 700;
    color: #475569;
  }

  .lazy-loading-subtext {
    margin-top: 2px;
    font-size: 9px;
    color: #94a3b8;
  }

  @keyframes lazySpin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }
</style>

<!-- =====================================================
CONTENT
===================================================== -->
<div class="app-content content center-layout">
  <div class="content-overlay"></div>
  <div class="content-wrapper">
    <div class="content-body kegiatan-page">
      <!-- BREADCRUMB -->
      <div class="kegiatan-breadcrumb">
        <a href="<?= base_url('admin/dashboard') ?>">
          <i class="la la-home"></i>
          Dashboard
        </a>
        <i class="la la-angle-right"></i>
        <a href="<?= base_url('admin/informasi-kegiatan') ?>">
          Kegiatan
        </a>
        <i class="la la-angle-right"></i>
        <span>Semua Kegiatan</span>
      </div>
      <!-- HEADER -->
      <div class="kegiatan-header">
        <h1>Kegiatan Penjaminan Mutu</h1>
        <p>Informasi kegiatan pembinaan, pelatihan, pendampingan, reviu, dan kegiatan strategis lainnya.</p>
      </div>
      <!-- FILTER -->
      <div class="filter-card">
        <div class="row align-items-end">
          <div class="col-md-5 mb-2 mb-md-0">
            <div class="filter-label">
              Cari Kegiatan
            </div>
            <input type="text" id="searchKegiatan" class="form-control" placeholder="Cari berdasarkan judul kegiatan...">
          </div>
          <div class="col-md-3 mb-2 mb-md-0">
            <div class="filter-label">
              Kategori
            </div>
            <select id="filterKategori" class="form-control">
              <option value="">Semua Kategori</option>
              <option value="Pelatihan">Pelatihan</option>
              <option value="Workshop">Workshop</option>
              <option value="Bimtek">Bimtek</option>
              <option value="Pendampingan">Pendampingan</option>
              <option value="Reviu">Reviu</option>
              <option value="Forum">Forum</option>
              <option value="Sosialisasi">Sosialisasi</option>
              <option value="Lainnya">Lainnya</option>
            </select>
          </div>
          <div class="col-md-3 mb-2 mb-md-0">
            <div class="filter-label">
              Status
            </div>
            <select id="filterStatus" class="form-control">
              <option value="">Semua Status</option>
              <option value="Daftar Sekarang">Daftar Sekarang</option>
              <option value="Segera Hadir">Segera Hadir</option>
              <option value="Akan Datang">Akan Datang</option>
              <option value="Berlangsung">Berlangsung</option>
              <option value="Selesai">Selesai</option>
              <option value="Ditutup">Ditutup</option>
            </select>
          </div>
          <div class="col-md-1 text-md-center">
            <button type="button" id="resetFilter" class="btn btn-light" title="Reset Filter" style="height:36px; width:36px; padding:0; border-radius:8px; color:#64748b;">
              <i class="la la-refresh"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- =================================================
      DATA KEGIATAN
      ================================================== -->
      <?php if (!empty($kegiatan)): ?>
        <div class="row" id="kegiatanContainer">
          <?= $this->load->view('admin/master/kegiatan/v_card_item', ['kegiatan' => $kegiatan], true) ?>
        </div>

        <!-- =========================================
        LOADING
        ========================================== -->
        <div id="lazyLoader" class="lazy-loading-wrapper">
          <div class="lazy-loading-content">
            <div class="lazy-spinner"></div>
            <div class="lazy-loading-text">
              Memuat kegiatan lainnya...
            </div>

            <div class="lazy-loading-subtext">
              Mohon tunggu sebentar
            </div>
          </div>
        </div>

        <!-- =========================================
        EMPTY FILTER
        ========================================== -->
        <div id="filterEmpty" class="empty-kegiatan" style="display:none;">
          <i class="la la-search"></i>
          <h4>Kegiatan tidak ditemukan</h4>
          <p>Coba gunakan kata kunci ataufilter yang berbeda.</p>
        </div>
      <?php else: ?>
        <div class="empty-kegiatan">
          <i class="la la-calendar-times-o"></i>
          <h4>Belum Ada Kegiatan</h4>
          <p>Saat ini belum tersediainformasi kegiatan.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<?= $this->load->view('admin/v_footer') ?>

<script>
  $(document).ready(function() {
    /*
     * ==============================================
     * LAZY LOAD CONFIG
     * ==============================================
     */
    let offset = <?= count($kegiatan ?? []) ?>;
    let hasMore = <?= (($total_kegiatan ?? 0) > count($kegiatan ?? [])) ? 'true' : 'false' ?>;
    let loading = false;
    let requestVersion = 0;

    /*
     * ==============================================
     * AMBIL FILTER
     * ==============================================
     */
    function getFilter() {
      return {
        keyword: $('#searchKegiatan').val().trim(),
        kategori: $('#filterKategori').val(),
        status: $('#filterStatus').val()
      };
    }

    /*
     * ==============================================
     * LOAD DATA
     * ==============================================
     */
    function loadKegiatan(reset = false) {
      /*
       * ==============================================
       * CEK STATUS
       * ==============================================
       */
      if (!reset && (!hasMore || loading)) {
        return;
      }

      /*
       * Versi request
       */
      const currentVersion = ++requestVersion;

      /*
       * ==============================================
       * RESET FILTER
       * ==============================================
       */
      if (reset) {
        offset = 0;
        hasMore = true;
        $('#kegiatanContainer').empty();
        $('#filterEmpty').hide();
      }

      loading = true;

      /*
       * ==============================================
       * TAMPILKAN LOADING
       * ==============================================
       */
      $('#lazyLoader').stop(true, true).fadeIn(200);

      /*
       * Waktu mulai loading
       */
      const loadingStart = Date.now();

      /*
       * Minimal loader tampil:
       *
       * scroll = 1200 ms
       * filter = 300 ms
       */
      const minimumLoadingTime = reset ? 300 : 1200;
      const filter = getFilter();

      /*
       * ==============================================
       * LIMIT
       * ==============================================
       */
      const limit = reset ? 8 : 4;

      /*
       * ==============================================
       * AJAX
       * ==============================================
       */
      $.ajax({
        url: "<?= base_url('admin/kelola-kegiatan/loadMore') ?>",
        type: "GET",
        dataType: "json",
        data: {
          offset: offset,
          limit: limit,
          keyword: filter.keyword,
          kategori: filter.kategori,
          status: filter.status
        },

        /*
         * ==========================================
         * SUCCESS
         * ==========================================
         */
        success: function(response) {
          /*
           * Abaikan response lama
           */
          if (currentVersion !== requestVersion) {
            return;
          }

          if (!response.status) {
            finishLoading();
            return;
          }

          /*
           * Hitung berapa lama request
           * sudah berjalan
           */
          const elapsed = Date.now() - loadingStart;

          /*
           * Kalau request terlalu cepat,
           * pertahankan animasi sampai
           * minimumLoadingTime tercapai.
           */
          const remainingDelay = Math.max(0, minimumLoadingTime - elapsed);

          setTimeout(
            function() {
              /*
               * Pastikan ini masih
               * request terbaru
               */
              if (currentVersion !== requestVersion) {
                return;
              }

              /*
               * =================================
               * TAMBAHKAN CARD
               * =================================
               */

              if (response.html) {
                /*
                 * Bungkus card baru sementara
                 * untuk animasi masuk
                 */
                const $newCards = $(response.html);

                /*
                 * Card dibuat transparan dulu
                 */
                $newCards.css({
                  opacity: 0,
                  transform: 'translateY(15px)'
                });

                /*
                 * Masukkan ke container
                 */
                $('#kegiatanContainer').append($newCards);

                /*
                 * Animasi card muncul
                 */
                setTimeout(
                  function() {
                    $newCards.css({
                      transition: 'all .4s ease',
                      opacity: 1,
                      transform: 'translateY(0)'
                    });
                  }, 50
                );
              }

              /*
               * =================================
               * UPDATE OFFSET
               * =================================
               */
              offset += parseInt(response.loaded || 0);

              /*
               * Masih ada data?
               */
              hasMore = response.has_more === true;

              /*
               * =================================
               * EMPTY FILTER
               * =================================
               */
              if (parseInt(response.total || 0) === 0) {
                $('#filterEmpty').fadeIn(200);
              } else {
                $('#filterEmpty').hide();
              }

              /*
               * Selesai loading
               */
              finishLoading();
            },
            remainingDelay
          );
        },

        /*
         * ==========================================
         * ERROR
         * ==========================================
         */
        error: function(xhr) {
          if (currentVersion !== requestVersion) {
            return;
          }

          console.error('Gagal memuat kegiatan.', xhr.responseText);
          finishLoading();
        }
      });

      /*
       * ==============================================
       * FINISH LOADING
       * ==============================================
       */
      function finishLoading() {
        $('#lazyLoader').stop(true, true).fadeOut(200, function() {
          loading = false;
        });
      }
    }

    /*
     * ==============================================
     * LAZY LOAD SAAT SCROLL
     * ==============================================
     */
    let scrollTimer = null;

    $(window).on('scroll', function() {
      clearTimeout(scrollTimer);
      scrollTimer = setTimeout(function() {
        /*
         * Jika posisi user sudah
         * mendekati bawah halaman
         */
        const posisiScroll = $(window).scrollTop() + $(window).height();
        const tinggiDocument = $(document).height();

        /*
         * 300px sebelum mencapai bawah,
         * ambil 4 data berikutnya
         */
        if (posisiScroll >= tinggiDocument - 300) {
          loadKegiatan(false);
        }
      }, 100);
    });

    /*
     * ==============================================
     * SEARCH
     * ==============================================
     */
    let searchTimer = null;

    $('#searchKegiatan').on('input', function() {
      clearTimeout(searchTimer);

      /*
       * Delay supaya tidak request
       * setiap user mengetik 1 huruf
       */
      searchTimer = setTimeout(function() {
        loadKegiatan(true);
      }, 400);
    });

    /*
     * ==============================================
     * FILTER KATEGORI
     * ==============================================
     */
    $('#filterKategori').on('change', function() {
      loadKegiatan(true);
    });

    /*
     * ==============================================
     * FILTER STATUS
     * ==============================================
     */
    $('#filterStatus').on('change', function() {
      loadKegiatan(true);
    });

    /*
     * ==============================================
     * RESET FILTER
     * ==============================================
     */
    $('#resetFilter').on('click', function() {
      $('#searchKegiatan').val('');
      $('#filterKategori').val('');
      $('#filterStatus').val('');
      loadKegiatan(true);
    });
  });
</script>