<div class="tab-pane fade" id="tab-bab1" role="tabpanel">
  <div class="card shadow-sm mb-2" style="border-top:3px solid #8b5cf6;">
    <div class="card-header d-flex align-items-center py-2" style="background:#f8f4ff; border-bottom:1px solid #ddd6fe;">
      <span class="d-inline-flex align-items-center justify-content-center mr-2" style="width:32px;height:32px;border-radius:8px;background:#8b5cf6;color:#fff;font-weight:700;font-size:1rem;flex-shrink:0;">
        <i class="la la-book" style="font-size:1rem;"></i>
      </span>
      <div>
        <div class="font-weight-bold text-dark" style="font-size:1.3rem;">
          Bab 1 &mdash; Pendahuluan
        </div>
      </div>
    </div>
    <div class="card-body pt-2 pb-0">
      <div class="form-group mb-2">
        <label class="font-weight-semibold text-dark" style="font-size:1rem;">
          <i class="la la-pencil mr-1" style="color:#8b5cf6;"></i>1. Dasar Penyusunan <span class="text-danger">*</span>
        </label>
        <textarea name="dasar_penyusunan" id="dasar_penyusunan" rows="10" class="form-control narasi-led-200 textarea-catatan" data-max-words="200" placeholder="Tuliskan dasar penyusunan..." required style="font-size:1rem; resize:vertical; line-height:1.5;"><?= isset($form_led['dasar_penyusunan']) ? $form_led['dasar_penyusunan'] : '' ?></textarea>
        <small class="form-text text-muted">Deskripsikan secara rinci (maksimal 200 kata).</small>
        <small class="form-text text-primary" id="counter_dasar_penyusunan">0/200 kata</small>
      </div>
      <div class="form-group mb-0">
        <label class="font-weight-semibold text-dark" style="font-size:1rem;">
          <i class="la la-pencil mr-1" style="color:#8b5cf6;"></i>2. Mekanisme Kerja Penyusunan Laporan <span class="text-danger">*</span>
        </label>
        <textarea name="mekanisme_kerja_penyusunan_laporan" id="mekanisme_kerja_penyusunan_laporan" rows="10" class="form-control narasi-led-200 textarea-catatan" data-max-words="200" placeholder="Tuliskan mekanisme kerja penyusunan laporan..." required style="font-size:1rem; resize:vertical; line-height:1.5;" <?= $form_led['status_led'] === '1' ? 'disabled' : '' ?>><?= isset($form_led['mekanisme_kerja_penyusunan_laporan']) ? $form_led['mekanisme_kerja_penyusunan_laporan'] : '' ?></textarea>
        <small class="form-text text-muted">Deskripsikan secara rinci (maksimal 200 kata).</small>
        <small class="form-text text-primary" id="counter_mekanisme_kerja_penyusunan_laporan">0/200 kata</small>
      </div>
    </div>
  </div>
</div>