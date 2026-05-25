<?php
// Misalkan $dos->tgl_update sudah memiliki nilai '2024-03-08'
$tgl = $identitas_pt['tgl_update'] ?? '';

// Membuat array untuk mengkonversi nama bulan ke Indonesia
$bulanIndonesia = array(
  '01' => 'Januari',
  '02' => 'Februari',
  '03' => 'Maret',
  '04' => 'April',
  '05' => 'Mei',
  '06' => 'Juni',
  '07' => 'Juli',
  '08' => 'Agustus',
  '09' => 'September',
  '10' => 'Oktober',
  '11' => 'November',
  '12' => 'Desember'
);

// Mengubah format tanggal
$tanggal = date('d', strtotime($tgl)); // Mengambil hanya bagian tanggal
$bulan = $bulanIndonesia[date('m', strtotime($tgl))]; // Mengambil nama bulan dalam Bahasa Indonesia
$tahun = date('Y', strtotime($tgl)); // Mengambil hanya bagian tahun

// Menggabungkan kembali menjadi format tanggal Indonesia
$tglIndonesia = $tanggal . " " . $bulan . " " . $tahun;
?>

<div class="tab-pane fade active show" id="tab-identitas" role="tabpanel">
  <div class="card shadow-sm mb-2" style="border-top: 3px solid #6366f1;">
    <div class="card-header d-flex align-items-center py-2" style="background:#f5f5ff; border-bottom:1px solid #d0d0f8;">
      <span class="d-inline-flex align-items-center justify-content-center mr-2" style="width:32px;height:32px;border-radius:8px;background:#6366f1;color:#fff;font-weight:700;font-size:1rem;flex-shrink:0;">
        <i class="la la-university" style="font-size:1rem;"></i>
      </span>
      <div>
        <div class="font-weight-bold text-dark" style="font-size:1.3rem;">
          Identitas Perguruan Tinggi
        </div>
      </div>
    </div>
    <div class="card-body pt-2 pb-0">
      <div class="alert alert-light border mb-2 py-2" style="border-color:#111aa1 !important; background:#f1f1ff; color:#044db6; font-size:0.95rem;">
        <i class="la la-info-circle mr-1"></i>
        Inputan berwarna <span style="background-color: #eaf9ea; color:#216906; padding: 2px 6px; border-radius: 4px;">hijau</span> berdasarkan data PDDikti per tanggal <?= isset($tglIndonesia) && $tglIndonesia != '' ? $tglIndonesia : '....' ?>.
      </div>

      <div class="row">
        <div class="col-md-6 col-sm-12">
          <div class="form-group mb-2">
            <label class="font-weight-semibold text-dark" style="font-size:1rem;">Nama Perguruan Tinggi <span class="text-danger">*</span></label>
            <input type="text" name="nama_pt" class="form-control textarea-catatan" value="<?= isset($identitas_pt['nama_pt']) ? $identitas_pt['nama_pt'] : '' ?>" placeholder="..." style="font-size:1rem; border: 1px solid #7bc67b !important; background-color: #eaf9ea; color:#216906;" disabled required>
          </div>
        </div>
        <div class="col-md-6 col-sm-12">
          <div class="form-group mb-2">
            <label class="font-weight-semibold text-dark" style="font-size:1rem;">Alamat <span class="text-danger">*</span></label>
            <input name="alamat" class="form-control textarea-catatan" value="<?= isset($form_led['alamat']) ? $form_led['alamat'] : '' ?>" placeholder="..." style="font-size:1rem;" required>
          </div>
        </div>
        <div class="col-md-6 col-sm-12">
          <div class="form-group mb-2">
            <label class="font-weight-semibold text-dark" style="font-size:1rem;">Tanggal SK Pendirian PT <span class="text-danger">*</span></label>
            <input type="date" name="tgl_sk_pendirian_pt" class="form-control textarea-catatan" value="<?= isset($form_led['tgl_sk_pendirian_pt']) ? $form_led['tgl_sk_pendirian_pt'] : '' ?>" placeholder="..." style="font-size:1rem;" required>
          </div>
        </div>
        <div class="col-md-6 col-sm-12">
          <div class="form-group mb-2">
            <label class="font-weight-semibold text-dark" style="font-size:1rem;">Tahun Pertama Kali Menerima Mahasiswa <span class="text-danger">*</span></label>
            <input type="number" inputmode="numeric" name="tahun_pertama_terima_mhs" class="form-control textarea-catatan" value="<?= isset($form_led['tahun_pertama_terima_mhs']) ? $form_led['tahun_pertama_terima_mhs'] : '' ?>" placeholder="YYYY" min="1900" max="9999" step="1" oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,4);" style="font-size:1rem;" required>
          </div>
        </div>
        <div class="col-md-6 col-sm-12">
          <div class="form-group mb-2">
            <label class="font-weight-semibold text-dark" style="font-size:1rem;">Akreditasi Perguruan Tinggi <span class="text-danger">*</span></label>
            <input type="text" name="akreditasi_pt" class="form-control textarea-catatan" value="<?= isset($form_led['akreditasi_pt']) ? $form_led['akreditasi_pt'] : '' ?>" placeholder="..." style="font-size:1rem; border: 1px solid #7bc67b !important; background-color: #eaf9ea; color:#216906;" disabled required>
          </div>
        </div>
        <div class="col-md-6 col-sm-12">
          <div class="form-group mb-2">
            <label class="font-weight-semibold text-dark" style="font-size:1rem;">Tanggal Akhir APT <span class="text-danger">*</span></label>
            <input type="date" name="tgl_akhir_apt" class="form-control textarea-catatan" value="<?= isset($form_led['tgl_akhir_apt']) ? $form_led['tgl_akhir_apt'] : '' ?>" placeholder="..." style="font-size:1rem; border: 1px solid #7bc67b !important; background-color: #eaf9ea; color:#216906;" disabled required>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>