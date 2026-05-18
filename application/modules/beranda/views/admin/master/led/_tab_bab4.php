<div class="tab-pane fade" id="tab-bab4" role="tabpanel">
  <div class="card shadow-sm mb-2" style="border-top:3px solid #ec4899;">
    <div class="card-header d-flex align-items-center py-2" style="background:#fff0f6; border-bottom:1px solid #fce7f3;">
      <span class="d-inline-flex align-items-center justify-content-center mr-2" style="width:32px;height:32px;border-radius:8px;background:#ec4899;color:#fff;font-weight:700;font-size:1rem;flex-shrink:0;">
        <i class="la la-book" style="font-size:1rem;"></i>
      </span>
      <div>
        <div class="font-weight-bold text-dark" style="font-size:1.3rem;">
          Bab 4 &mdash; Penutup
        </div>
      </div>
    </div>
    <div class="card-body pt-2 pb-0">
      <div class="form-group mb-0">
        <label class="font-weight-semibold text-dark" style="font-size:0.98rem;">
          <i class="la la-pencil mr-1" style="color:#ec4899;"></i> Narasi Bab 4 <span class="text-danger">*</span>
        </label>
        <textarea name="narasi_bab4" id="narasi_bab4" rows="6" class="form-control narasi-led-500 textarea-catatan" data-max-words="500" placeholder="Tuliskan narasi penutup LED..." required style="font-size:0.98rem; resize:vertical; line-height:1.5;"><?= isset($form_led['narasi_bab4']) ? $form_led['narasi_bab4'] : '' ?></textarea>
        <small class="form-text text-muted">Deskripsikan secara rinci (maksimal 500 kata).</small>
        <small class="form-text text-primary" id="counter_narasi_bab4">0/500 kata</small>
      </div>
    </div>
  </div>
</div>