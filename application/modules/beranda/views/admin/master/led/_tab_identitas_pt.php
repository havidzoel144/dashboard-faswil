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
        Identitas Perguruan Tinggi berdasarkan data PDDikti per tanggal <?= isset($identitas_pt['tgl_update']) && $identitas_pt['tgl_update'] != '' ? format_tanggal_indonesia($identitas_pt['tgl_update']) : '....' ?>.
      </div>

      <div class="row">
        <div class="col-md-6 col-sm-12">
          <div class="form-group mb-2">
            <label class="font-weight-semibold text-dark" style="font-size:1rem;">Nama Perguruan Tinggi <span class="text-danger">*</span></label>
            <input type="text" name="nama_pt" class="form-control textarea-catatan" value="<?= isset($identitas_pt['nama_pt']) ? $identitas_pt['nama_pt'] : '' ?>" placeholder="Nama Perguruan Tinggi" disabled required>
          </div>
        </div>
        <div class="col-md-6 col-sm-12">
          <div class="form-group mb-2">
            <label class="font-weight-semibold text-dark" style="font-size:1rem;">Alamat <span class="text-danger">*</span></label>
            <input name="alamat" class="form-control textarea-catatan" value="<?= isset($form_led['alamat']) ? $form_led['alamat'] : '' ?>" placeholder="Alamat Perguruan Tinggi" disabled required>
          </div>
        </div>
        <div class="col-md-6 col-sm-12">
          <div class="form-group mb-2">
            <label class="font-weight-semibold text-dark" style="font-size:1rem;">Tanggal SK Pendirian PT <span class="text-danger">*</span></label>
            <input type="text" name="tgl_sk_pendirian_pt" class="form-control textarea-catatan" value="<?= isset($form_led['tgl_sk_pendirian_pt']) ? $form_led['tgl_sk_pendirian_pt'] : '' ?>" placeholder="Tanggal SK Pendirian PT" disabled required>
          </div>
        </div>
        <div class="col-md-6 col-sm-12">
          <div class="form-group mb-2">
            <label class="font-weight-semibold text-dark" style="font-size:1rem;">Akreditasi Perguruan Tinggi <span class="text-danger">*</span></label>
            <input type="text" name="akreditasi_pt" class="form-control textarea-catatan" value="<?= isset($form_led['akreditasi_pt']) ? $form_led['akreditasi_pt'] : '' ?>" placeholder="Akreditasi Perguruan Tinggi" disabled required>
          </div>
        </div>
        <div class="col-md-6 col-sm-12">
          <div class="form-group mb-2">
            <label class="font-weight-semibold text-dark" style="font-size:1rem;">Tanggal Akhir APT <span class="text-danger">*</span></label>
            <input type="date" name="tgl_akhir_apt" class="form-control textarea-catatan" value="<?= isset($form_led['tgl_akhir_apt']) ? $form_led['tgl_akhir_apt'] : '' ?>" placeholder="..." disabled required>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>