<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SinkronPt extends MX_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->library(['javascript', 'upload']);
        $this->load->model('Periode_model');
        date_default_timezone_set("Asia/Jakarta");

        if (!$this->session->userdata('username')) {
            $this->session->set_flashdata('error', 'Anda belum login.');
            redirect('login');
        }
    }

    public function import_pt_awal()
    {
        if (isset($_FILES['file_excel']['name'])) {
            $file_mimes = array('application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

            if (in_array($_FILES['file_excel']['type'], $file_mimes)) {
                $file = $_FILES['file_excel']['tmp_name'];

                // Load file excel menggunakan IOFactory dari PhpSpreadsheet
                $spreadsheet    = IOFactory::load($file);
                $sheet          = $spreadsheet->getActiveSheet();
                $highestRow     = $sheet->getHighestRow(); // Mendapatkan jumlah baris tertinggi

                $this->db->truncate("data_pt_awal"); // Hapus data lama sebelum import

                // Looping setiap baris dari file Excel, mulai dari baris keempat untuk skip header
                for ($row = 2; $row <= $highestRow; $row++) {
                    $kd_pt  = trim($sheet->getCell('A' . $row)->getValue());
                    $nm_pt  = $sheet->getCell('B' . $row)->getValue();

                    // // Data yang akan di-insert ke dalam database
                    $data = array(
                        'kd_pt' => trim($kd_pt),
                        'nm_pt' => $nm_pt
                    );
                    $this->db->insert("data_pt_awal", $data);
                }

                //hapus data pt tahap1 dan tahap2
                $jml_awal = $this->db->query("SELECT * FROM data_pt_awal")->num_rows();
                $dt1 = [
                    'jenis' => 'data_pt_t1',
                    'jml_awal' => $jml_awal,
                    'jml_proses' => 0,
                    'jml_tidak_ada' => 0,
                    'status_progress' => 'berhenti'
                ];
                $this->db->where('jenis', 'data_pt_t1');
                $this->db->update('rekap_sinkron', $dt1);

                $dt2 = [
                    'jenis' => 'data_pt_t2',
                    'jml_awal' => 0,
                    'jml_proses' => 0,
                    'jml_tidak_ada' => 0,
                    'status_progress' => 'berhenti'
                ];
                $this->db->where('jenis', 'data_pt_t2');
                $this->db->update('rekap_sinkron', $dt2);

                $this->db->truncate('data_pt_tahap1');
                $this->db->truncate('data_pt_tahap2');
                $this->db->truncate('data_pt_tidak_ada');
                $this->db->truncate('data_pt_tidak_ada_tahap2');

                // Set flashdata untuk pesan sukses
                $this->session->set_flashdata('success', "Sebanyak $jml_awal berhasil diimport");
                redirect('sinkronPt');
            } else {
                $this->session->set_flashdata('error', 'File yang diupload bukan file Excel.');
                redirect('sinkronPt');
            }
        }
    }

    function index()
    {
        $data = [
            'sinkron' => 'active',
            'sinkronPt' => 'active',
            'periode' => 'active',
            'data_periode' => $this->Periode_model->get_all_data_periode(),
        ];

        $c          = $this->db->query("SELECT * FROM rekap_sinkron WHERE jenis='data_pt_t1'");
        $jml_awal   = $this->db->query("SELECT * FROM data_pt_awal")->num_rows();

        $data['rekap']      = $c->result();
        $data['jml_awal']   = $jml_awal;

        $data['rekap_t2']   = $this->db->query("SELECT * from rekap_sinkron WHERE jenis='data_pt_t2'")->result();
        $data['pt_awal']    = $this->db->query("SELECT * FROM data_pt_awal ORDER BY nm_pt ASC")->result();
        $data['belum_t1']   = $this->db->query("SELECT * FROM `data_pt_awal` WHERE `kd_pt` NOT IN (SELECT kode_pt FROM `data_pt_tahap1`)")->result();
        $data['proses_t1']  = $this->db->query("SELECT * FROM data_pt_tahap1")->result();
        $data['tidak_t1']   = $this->db->query("SELECT * FROM data_pt_tidak_ada")->result();
        $data['proses_t2']  = $this->db->query("SELECT * FROM data_pt_tahap2")->result();
        $data['belum_t2']   = $this->db->query("SELECT * FROM `data_pt_tahap1` WHERE `kode_pt` NOT IN (SELECT kode_pt FROM `data_pt_tahap2`)")->result();
        $data['tidak_t2']   = $this->db->query("SELECT * FROM data_pt_tidak_ada_tahap2")->result();

        $this->load->view("admin/sinkron/v_index", $data);
    }

    public function proses_ulang()
    {
        $jml_awal   = $this->db->query("SELECT * FROM data_pt_awal")->num_rows();

        $this->db->trans_start();

        $up_t1 = [
            'jml_awal' => $jml_awal,
            'jml_proses' => 0,
            'jml_tidak_ada' => 0,
            'jml_prodi' => 0,
            'jml_prodi_aktif' => 0
        ];
        $this->db->where('jenis', 'data_pt_t1');
        $this->db->update('rekap_sinkron', $up_t1);

        $up_t2 = [
            'jml_awal' => 0,
            'jml_proses' => 0,
            'jml_tidak_ada' => 0,
            'jml_prodi' => 0,
            'jml_prodi_aktif' => 0
        ];
        $this->db->where('jenis', 'data_pt_t2');
        $this->db->update('rekap_sinkron', $up_t2);

        $this->db->truncate('data_pt_tahap1');
        $this->db->truncate('data_pt_tidak_ada');
        $this->db->truncate('data_pt_tahap2');
        $this->db->truncate('data_pt_tidak_ada_tahap2');

        $this->db->trans_complete();

        if ($this->db->trans_status() === true) {
            $this->session->set_flashdata('success', 'Data berhasil diproses ulang');
        } else {
            $this->session->set_flashdata('error', 'Data gagal diproses ulang');
        }

        redirect('sinkronPt');
    }

    // --- 1. Inisialisasi batch, memulai proses dan buat job file & log file
    public function proses_batch_start()
    {
        $progress_id     = uniqid();
        $job_file         = APPPATH . "logs/job_$progress_id.json";
        $log_file         = APPPATH . "logs/progress_$progress_id.log";

        // Ambil semua data yang perlu diproses
        $data_isi = $this->db->query("SELECT
                                        *
                                        FROM
                                        `data_pt_awal` a
                                        LEFT JOIN `data_pt_tahap1` b
                                            ON a.`kd_pt` = b.`kode_pt`
                                        WHERE b.`updated_at` IS NULL 
                                        AND a.`kd_pt` NOT IN (SELECT kode_pt FROM `data_pt_tidak_ada`) 
                                        LIMIT 20")->result_array();

        $this->db->query("UPDATE rekap_sinkron SET status_progress='proses' WHERE jenis='data_pt_t1'");

        $total = count($data_isi);
        file_put_contents($job_file, json_encode($data_isi));

        // SIMPAN waktu mulai & total di file log
        file_put_contents($log_file, "Proses penarikan data dimulai<br>\n[START_TIMESTAMP]: " . date('Y-m-d H:i:s') . ")<br>\n");

        $this->session->set_userdata('batch_total_' . $progress_id, $total);
        $this->session->set_userdata('batch_processed_' . $progress_id, 0);

        echo json_encode([
            'status' => 'ok',
            'progress_id' => $progress_id,
            'jenis' => 'data_pt_t1',
            'job_url' => base_url('beranda/SinkronPt/proses_batch_job/' . $progress_id),
            'progress_url' => base_url('beranda/SinkronPt/polling_progress/' . $progress_id),
            'result_url' => base_url('beranda/SinkronPt')
        ]);
    }

    // --- 2. Eksekusi 1 chunk (misal 20 dosen) per request
    public function proses_batch_job($progress_id)
    {
        $job_file = APPPATH . "logs/job_$progress_id.json";
        $log_file = APPPATH . "logs/progress_$progress_id.log";

        if (!file_exists($job_file)) {
            echo json_encode(['status' => 'done', 'remaining' => 0]);
            return;
        }

        $isi_list   = json_decode(file_get_contents($job_file), true);
        $chunk      = array_splice($isi_list, 0, 20);
        $processed  = 0;

        foreach ($chunk as $da) {
            $processed++;
            $kd_pt  = $da['kd_pt'];
            $nm_pt  = $da['nm_pt'];

            file_put_contents($log_file, "Memproses: $nm_pt ($kd_pt)<br>\n", FILE_APPEND);

            // ---- Tarik API per PT, dan simpan ke DB
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.kemdikbud.go.id:8445/pddikti/1.2/pt/' . $kd_pt,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer 1FAzRSp5uZsdWm1g2pm1FLsA9KbOppaR',
                    'Content-Type: application/x-www-form-urlencoded'
                ),
                CURLOPT_SSL_VERIFYPEER => false,
            ));
            $respon         = curl_exec($curl);
            $http_code      = curl_getinfo($curl, CURLINFO_HTTP_CODE);  // Cek status HTTP
            curl_close($curl);

            // Cek apakah HTTP response-nya 200
            if ($http_code != 200) {
                file_put_contents($log_file, "   ✖️ Gagal request API dengan kode HTTP: $http_code $nm_pt ($kd_pt)<br>\n", FILE_APPEND);
                continue;
            }

            if ($respon !== false) {
                $responseData = json_decode($respon, true);

                if (is_array($responseData) && count($responseData) > 0) {

                    if (isset($responseData[0]['id'])) {
                        $data_insert = [
                            'kode_pt'        => isset($responseData[0]['kode']) ? $responseData[0]['kode'] : null,
                            'nama_pt'        => isset($responseData[0]['nama']) ? $responseData[0]['nama'] : null,
                            'status_pt'      => isset($responseData[0]['status']) ? $responseData[0]['status'] : null,
                            'bentuk_pt'      => isset($responseData[0]['bentuk_pendidikan']['nama']) ? $responseData[0]['bentuk_pendidikan']['nama'] : null,
                            'tgl_update'     => date('Y-m-d')
                        ];
                        // Simpan dengan replace/update (hindari duplikat)
                        $this->db->replace('data_pt_tahap1', $data_insert);

                        file_put_contents($log_file, "   ✔️ Berhasil tarik & simpan data API  $nm_pt ($kd_pt)<br>\n", FILE_APPEND);
                    } else {
                        file_put_contents($log_file, "   ✖️ Data tidak ditemukan di item $nm_pt ($kd_pt)<br>\n", FILE_APPEND);
                    }
                } else {
                    file_put_contents($log_file, "   ✖️ Data tidak ditemukan/format tidak sesuai  $nm_pt ($kd_pt)<br>\n", FILE_APPEND);

                    // Jika data tidak ditemukan, tetap simpan ke DB dengan no_sertifikat kosong
                    $data_insert = [
                        'kode_pt' => $kd_pt,
                        'nama_pt' => $nm_pt
                    ];
                    $this->db->replace('data_pt_tidak_ada', $data_insert);
                }
            } else {
                file_put_contents($log_file, "   ✖️ Gagal request API $nm_pt ($kd_pt)<br>\n", FILE_APPEND);
            }

            // Update jumlah yang sudah diproses di session
            $processed_now = $this->session->userdata('batch_processed_' . $progress_id);
            $this->session->set_userdata('batch_processed_' . $progress_id, $processed_now + 1);
        }

        // Simpan sisa dosen ke job file
        if (count($isi_list) > 0) {
            file_put_contents($job_file, json_encode($isi_list));
        } else {
            @unlink($job_file);
            file_put_contents($log_file, "[END_TIMESTAMP]: " . date('Y-m-d H:i:s') . ")<br>\n", FILE_APPEND);
            file_put_contents($log_file, "Proses selesai<br>\n", FILE_APPEND);

            // Update rekap_sinkron
            $jawal      = $this->db->query("SELECT * FROM data_pt_awal")->num_rows();
            $jrwy       = $this->db->query("SELECT
                                        *
                                        FROM
                                        `data_pt_awal` a
                                        JOIN `data_pt_tahap1` b
                                            ON a.`kd_pt` = b.`kode_pt`")->num_rows();

            $jtidak_ada = $this->db->query("SELECT * FROM data_pt_tidak_ada")->num_rows();

            $rekap_data = [
                'jml_awal' => $jawal,
                'jml_proses' => $jrwy,
                'jml_tidak_ada' => $jtidak_ada
            ];
            $this->db->where('jenis', 'data_pt_t1');
            $this->db->update('rekap_sinkron', $rekap_data);
            // ==== End update rekap ====
        }

        echo json_encode([
            'status' => 'ok',
            'remaining' => count($isi_list)
        ]);
    }

    // --- 3. Endpoint polling progress log
    public function polling_progress($progress_id)
    {
        $progress_file  = APPPATH . 'logs/progress_' . $progress_id . '.log';
        $logs           = '';
        $finished       = false;
        $selisih        = 0;

        // Hitung progress by real data
        $jawal      = $this->db->query("SELECT * FROM data_pt_awal")->num_rows();
        $jrwy       = $this->db->query("SELECT
                                        *
                                        FROM
                                        `data_pt_awal` a
                                        JOIN `data_pt_tahap1` b
                                            ON a.`kd_pt` = b.`kode_pt`")->num_rows();

        $jtidak_ada = $this->db->query("SELECT * FROM data_pt_tidak_ada")->num_rows();

        $total_proses   = $jrwy + $jtidak_ada;
        $percent        = ($jawal > 0) ? number_format(($total_proses / $jawal) * 100, 2) : '0.00';
        $selisih        = $jawal - $total_proses;

        if (file_exists($progress_file)) {
            $logs = file_get_contents($progress_file);

            if (strpos($logs, 'Proses selesai') !== false) { // Cek jika batch selesai
                $finished = true;

                // Hapus session batch
                $this->session->unset_userdata('batch_total_' . $progress_id);
                $this->session->unset_userdata('batch_processed_' . $progress_id);

                @unlink($progress_file);

                // Hapus log file jika sudah selesai
                if ($selisih <= 0) {
                    $percent = 100;

                    $this->db->query("UPDATE rekap_sinkron SET status_progress='berhenti' WHERE jenis='data_pt_t1'");

                    $this->db->query("UPDATE rekap_sinkron SET status_progress='berhenti', jml_awal='$jrwy' WHERE jenis='data_pt_t2'");
                }
            }
        }

        echo json_encode([
            'selisih' => $selisih,
            'logs' => $logs,
            'finished' => $finished,
            'percent' => $percent,
            'processed' => $total_proses,
            'total' => $jawal,
            'label' => "status dan bentuk PT",
        ]);
    }

    // --- 1. Inisialisasi batch, memulai proses dan buat job file & log file
    public function proses_batch_start_tahap2()
    {
        $progress_id     = uniqid();
        $job_file         = APPPATH . "logs/job_$progress_id.json";
        $log_file         = APPPATH . "logs/progress_$progress_id.log";

        // Ambil semua data yang perlu diproses
        $dais = $this->db->query("SELECT
                                    a.*,
                                    b.`updated_at`
                                    FROM
                                    `data_pt_tahap1` a
                                    LEFT JOIN `data_pt_tahap2` b
                                        ON a.`kode_pt` = b.`kode_pt`
                                    WHERE b.`updated_at` IS NULL
                                    AND a.`kode_pt` NOT IN (SELECT kode_pt FROM `data_pt_tidak_ada_tahap2`) 
                                    LIMIT 20")->result_array();

        $this->db->query("UPDATE rekap_sinkron SET status_progress='proses' WHERE jenis='data_pt_t2'");

        $total = count($dais);
        file_put_contents($job_file, json_encode($dais));

        // SIMPAN waktu mulai & total di file log
        file_put_contents($log_file, "Proses penarikan data dimulai<br>\n[START_TIMESTAMP]: " . date('Y-m-d H:i:s') . ")<br>\n");

        $this->session->set_userdata('batch_total_' . $progress_id, $total);
        $this->session->set_userdata('batch_processed_' . $progress_id, 0);

        echo json_encode([
            'status' => 'ok',
            'progress_id' => $progress_id,
            'jenis' => 'data_pt_t2',
            'job_url' => base_url('beranda/SinkronPt/proses_batch_job_tahap2/' . $progress_id),
            'progress_url' => base_url('beranda/SinkronPt/polling_progress_tahap2/' . $progress_id),
            'result_url' => base_url('beranda/SinkronPt')
        ]);
    }

    // --- 2. Eksekusi 1 chunk (misal 20 dosen) per request
    public function proses_batch_job_tahap2($progress_id)
    {
        $job_file = APPPATH . "logs/job_$progress_id.json";
        $log_file = APPPATH . "logs/progress_$progress_id.log";

        if (!file_exists($job_file)) {
            echo json_encode(['status' => 'done', 'remaining' => 0]);
            return;
        }

        $isi_list   = json_decode(file_get_contents($job_file), true);
        $chunk      = array_splice($isi_list, 0, 20);
        $processed  = 0;

        foreach ($chunk as $da) {
            $processed++;
            $kd_pt  = $da['kode_pt'];
            $nm_pt  = $da['nama_pt'];

            file_put_contents($log_file, "Memproses: $nm_pt ($kd_pt)<br>\n", FILE_APPEND);

            // ---- Tarik API per PT, dan simpan ke DB
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.kemdikbud.go.id:8445/pddikti/1.2/pt/' . $kd_pt . '/akreditasi',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer 1FAzRSp5uZsdWm1g2pm1FLsA9KbOppaR',
                    'Content-Type: application/x-www-form-urlencoded'
                ),
                CURLOPT_SSL_VERIFYPEER => false,
            ));
            $respon                 = curl_exec($curl);
            $http_code              = curl_getinfo($curl, CURLINFO_HTTP_CODE);  // Cek status HTTP
            curl_close($curl);

            // Cek apakah HTTP response-nya 200
            if ($http_code != 200) {
                file_put_contents($log_file, "   ✖️ Gagal request API dengan kode HTTP: $http_code $nm_pt ($kd_pt)<br>\n", FILE_APPEND);
                continue;
            }

            if ($respon !== false) {
                $responseData = json_decode($respon, true);

                if (is_array($responseData) && count($responseData) > 0) {

                    if (isset($responseData[0]['pt']['id'])) {
                        $daup = [
                            'kode_pt'           => $responseData[0]['pt']['kode'] ?? null,
                            'nama_pt'           => $responseData[0]['pt']['nama'] ?? null,
                            'akreditasi_pt'     => $responseData[0]['nilai'] ?? null,
                            'tgl_mulai_akred'   => $responseData[0]['tgl_sk_akreditasi'] ?? null,
                            'tgl_akhir_akred'   => $responseData[0]['tst_sk_akreditasi'] ?? null,
                            'tgl_update'        => date('Y-m-d')
                        ];
                        // Simpan dengan replace/update (hindari duplikat)
                        $this->db->replace('data_pt_tahap2', $daup);

                        file_put_contents($log_file, "   ✔️ Berhasil tarik & simpan data API  $nm_pt ($kd_pt)<br>\n", FILE_APPEND);
                    } else {
                        file_put_contents($log_file, "   ✖️ identitas tidak ditemukan di item $nm_pt ($kd_pt)<br>\n", FILE_APPEND);
                    }
                } else {
                    file_put_contents($log_file, "   ✖️ Data tidak ditemukan/format tidak sesuai  $nm_pt ($kd_pt)<br>\n", FILE_APPEND);

                    // Jika data tidak ditemukan, tetap simpan ke DB dengan no_sertifikat kosong
                    $data_insert = [
                        'kode_pt' => $kd_pt,
                        'nama_pt' => $nm_pt
                    ];
                    $this->db->replace('data_pt_tidak_ada_tahap2', $data_insert);
                }
            } else {
                file_put_contents($log_file, "   ✖️ Gagal request API $nm_pt ($kd_pt)<br>\n", FILE_APPEND);
            }

            // Update jumlah yang sudah diproses di session
            $processed_now = $this->session->userdata('batch_processed_' . $progress_id);
            $this->session->set_userdata('batch_processed_' . $progress_id, $processed_now + 1);
        }

        // Simpan sisa dosen ke job file
        if (count($isi_list) > 0) {
            file_put_contents($job_file, json_encode($isi_list));
        } else {
            @unlink($job_file);
            file_put_contents($log_file, "[END_TIMESTAMP]: " . date('Y-m-d H:i:s') . ")<br>\n", FILE_APPEND);
            file_put_contents($log_file, "Proses selesai<br>\n", FILE_APPEND);

            // Update rekap_sinkron
            $jawal      = $this->db->query("SELECT * FROM data_pt_tahap1")->num_rows();
            $jrwy       = $this->db->query("SELECT
                                            *
                                            FROM
                                            `data_pt_tahap1` a
                                            JOIN `data_pt_tahap2` b
                                                ON a.`kode_pt` = b.`kode_pt`")->num_rows();
            $jtidak_ada = $this->db->query("SELECT * FROM data_pt_tidak_ada_tahap2")->num_rows();

            $rekap_data = [
                'jml_awal' => $jawal,
                'jml_proses' => $jrwy,
                'jml_tidak_ada' => $jtidak_ada
            ];
            $this->db->where('jenis', 'data_pt_t2');
            $this->db->update('rekap_sinkron', $rekap_data);
            // ==== End update rekap ====
        }

        echo json_encode([
            'status' => 'ok',
            'remaining' => count($isi_list)
        ]);
    }

    // --- 3. Endpoint polling progress log
    public function polling_progress_tahap2($progress_id)
    {
        $progress_file  = APPPATH . 'logs/progress_' . $progress_id . '.log';
        $logs           = '';
        $finished       = false;
        $selisih        = 0;

        // Hitung progress by real data
        $jawal      = $this->db->query("SELECT * FROM data_pt_tahap1")->num_rows();
        $jrwy       = $this->db->query("SELECT
                                            *
                                            FROM
                                            `data_pt_tahap1` a
                                            JOIN `data_pt_tahap2` b
                                                ON a.`kode_pt` = b.`kode_pt`")->num_rows();
        $jtidak_ada = $this->db->query("SELECT * FROM data_pt_tidak_ada_tahap2")->num_rows();

        $total_proses   = $jrwy + $jtidak_ada;
        $percent        = ($jawal > 0) ? number_format(($total_proses / $jawal) * 100, 2) : '0.00';
        $selisih        = $jawal - $total_proses;

        if (file_exists($progress_file)) {
            $logs = file_get_contents($progress_file);

            if (strpos($logs, 'Proses selesai') !== false) { // Cek jika batch selesai
                $finished = true;

                // Hapus session batch
                $this->session->unset_userdata('batch_total_' . $progress_id);
                $this->session->unset_userdata('batch_processed_' . $progress_id);

                @unlink($progress_file);

                // Hapus log file jika sudah selesai
                if ($selisih <= 0) {
                    $percent = 100;

                    $this->db->query("UPDATE rekap_sinkron SET status_progress='berhenti' WHERE jenis='data_pt_t2'");
                    $this->db->query("TRUNCATE TABLE data_pt_backup");
                    $this->db->query("INSERT INTO `data_pt_backup` SELECT * FROM `data_pt`");
                    $this->db->query("TRUNCATE TABLE data_pt");
                    $this->db->query("INSERT INTO `data_pt`
                                        SELECT
                                        a.`kd_pt`,
                                        b.`nama_pt`,
                                        COALESCE(b.`status_pt`, '') AS status_pt,
                                        COALESCE(c.`akreditasi_pt`, '') AS akreditasi_pt,
                                        COALESCE(b.`bentuk_pt`, '') AS bentuk_pt,
                                        COALESCE(c.tgl_mulai_akred, '0000-00-00') AS tgl_mulai_akred,
                                        COALESCE(c.tgl_akhir_akred, '0000-00-00') AS tgl_akhir_akred,
                                        CURDATE() AS tgl_update
                                        FROM
                                        `data_pt_awal` a
                                        LEFT JOIN `data_pt_tahap1` b
                                            ON a.`kd_pt` = b.`kode_pt`
                                        LEFT JOIN `data_pt_tahap2` c
                                            ON a.`kd_pt` = c.`kode_pt`");
                }
            }
        }

        echo json_encode([
            'selisih' => $selisih,
            'logs' => $logs,
            'finished' => $finished,
            'percent' => $percent,
            'processed' => $total_proses,
            'total' => $jawal,
            'label' => "akreditasi PT",
        ]);
    }

    public function cancel_batch()
    {
        $progress_id     = $this->input->post('progress_id', true);
        $jenis           = $this->input->post('jenis', true);

        $this->db->query("UPDATE rekap_sinkron SET status_progress='berhenti' WHERE jenis='$jenis'");

        if (!$progress_id) {
            echo json_encode(['status' => 'error', 'msg' => 'Progress ID tidak ditemukan.']);
            return;
        }

        $job_file = APPPATH . "logs/job_$progress_id.json";
        $log_file = APPPATH . "logs/progress_$progress_id.log";

        // Hapus file jika ada
        if (file_exists($job_file)) @unlink($job_file);
        if (file_exists($log_file)) @unlink($log_file);

        // Hapus session
        $this->session->unset_userdata('batch_total_' . $progress_id);
        $this->session->unset_userdata('batch_processed_' . $progress_id);

        echo json_encode(['status' => 'ok']);
    }
}
