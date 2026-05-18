<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Skoring_akreditasi
{
  public function hitung($data)
  {
    $jumlah_prodi         = (int)$data['jumlah_prodi_aktif'];
    $prodi_terakreditasi  = (int)$data['prodi_terakreditasi'];
    $persentase_unggul    = (float)$data['persentase_unggul_atau_a'];
    $jenis_pt             = $data['jenis_pt'];

    $semua_terakreditasi = ($jumlah_prodi > 0 && $jumlah_prodi == $prodi_terakreditasi);

    // Default
    $hasil = [
      'skor' => 0,
      'keterangan' => 'Tidak memenuhi'
    ];

    // ==========================
    // SYARAT DASAR
    // ==========================
    if (!$semua_terakreditasi) {
      return $hasil;
    }

    // Minimal skor 1
    $hasil = [
      'skor' => 1,
      'keterangan' => 'Semua prodi terakreditasi'
    ];

    // ==========================
    // KHUSUS PTS VOKASI
    // ==========================
    if ($jenis_pt == 'PTS_VOKASI') {

      // SKOR 2
      if ($persentase_unggul >= 15) {
        return [
          'skor' => 2,
          'keterangan' => 'PTS Vokasi >= 15%'
        ];
      }

      // SKOR 1.5
      if ($persentase_unggul >= 10 && $persentase_unggul < 15) {
        return [
          'skor' => 1.5,
          'keterangan' => 'PTS Vokasi >=10% sd <15%'
        ];
      }

      return $hasil;
    }

    // ==========================
    // KATEGORI JUMLAH PRODI
    // ==========================
    $kategori_besar = ($jumlah_prodi >= 40 || $jumlah_prodi <= 10);

    // ==========================
    // SKOR 2
    // ==========================
    if ($kategori_besar && $persentase_unggul >= 20) {
      return [
        'skor' => 2,
        'keterangan' => '>=20%'
      ];
    }

    if (!$kategori_besar && $persentase_unggul >= 15) {
      return [
        'skor' => 2,
        'keterangan' => '>=15%'
      ];
    }

    // ==========================
    // SKOR 1.5
    // ==========================
    if ($kategori_besar && $persentase_unggul >= 15 && $persentase_unggul < 20) {
      return [
        'skor' => 1.5,
        'keterangan' => '>=15% sd <20%'
      ];
    }

    if (!$kategori_besar && $persentase_unggul >= 10 && $persentase_unggul < 15) {
      return [
        'skor' => 1.5,
        'keterangan' => '>=10% sd <15%'
      ];
    }

    return $hasil;
  }
}
