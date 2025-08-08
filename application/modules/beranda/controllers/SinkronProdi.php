<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class sinkronProdi extends MX_Controller
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

    public function proses_ulang()
    {
        $jml_awal = $this->db->query("SELECT * FROM data_pt_tahap1")->num_rows();

        $this->db->trans_start();

        $up_t1 = [
            'jml_awal' => $jml_awal,
            'jml_proses' => 0,
            'jml_tidak_ada' => 0,
            'jml_prodi' => 0,
            'jml_prodi_aktif' => 0
        ];
        $this->db->where('jenis', 'data_prodi_t1');
        $this->db->update('rekap_sinkron', $up_t1);

        $up_t2 = [
            'jml_awal' => 0,
            'jml_proses' => 0,
            'jml_tidak_ada' => 0,
            'jml_prodi' => 0,
            'jml_prodi_aktif' => 0
        ];
        $this->db->where('jenis', 'data_prodi_t2');
        $this->db->update('rekap_sinkron', $up_t2);

        $this->db->truncate('data_prodi_tahap1');
        $this->db->truncate('data_prodi_tidak_ada_tahap1');
        $this->db->truncate('data_prodi_tahap2');
        $this->db->truncate('data_prodi_tidak_ada_tahap2');

        $this->db->trans_complete();

        if ($this->db->trans_status() === true) {
            $this->session->set_flashdata('success', 'Data berhasil diproses ulang');
        } else {
            $this->session->set_flashdata('error', 'Data gagal diproses ulang');
        }

        redirect('sinkronProdi');
    }

    function index()
    {
        $data = [
            'sinkron' => 'active',
            'sinkronProdi' => 'active',
            'periode' => 'active',
            'data_periode' => $this->Periode_model->get_all_data_periode(),
        ];

        $c          = $this->db->query("SELECT * FROM rekap_sinkron WHERE jenis='data_prodi_t1'");
        $jml_awal   = $this->db->query("SELECT * FROM data_pt_tahap1")->num_rows();

        if ($c->row()->jml_proses == 0 && $c->row()->jml_tidak_ada == 0) { //jika belum ada data yang diproses
            $upd = [
                'jml_awal' => $jml_awal
            ];
            $this->db->where('jenis', 'data_prodi_t1');
            $this->db->update('rekap_sinkron', $upd);
        }

        $data['rekap']      = $this->db->query("SELECT * FROM rekap_sinkron WHERE jenis='data_prodi_t1'")->result();
        $data['rekap_t2']   = $this->db->query("SELECT * from rekap_sinkron WHERE jenis='data_prodi_t2'")->result();

        $data['belum_t1']   = $this->db->query("SELECT
                                                a.*
                                                FROM
                                                `data_pt_tahap1` a
                                                LEFT JOIN data_prodi_tahap1 b
                                                ON a.`kode_pt` = b.kode_pt
                                                WHERE b.updated_at IS NULL
                                                AND a.`kode_pt` NOT IN (SELECT kode_pt FROM `data_prodi_tidak_ada_tahap1`)
                                                GROUP BY b.kode_pt")->result();

        $data['proses_t1']  = $this->db->query("SELECT
                                                a.*
                                                FROM
                                                `data_pt_tahap1` a
                                                JOIN data_prodi_tahap1 b
                                                ON a.`kode_pt` = b.kode_pt
                                                WHERE  a.`kode_pt` NOT IN (SELECT kode_pt FROM `data_prodi_tidak_ada_tahap1`)
                                                GROUP BY b.kode_pt")->result();

        $data['tidak_t1']   = $this->db->query("SELECT * FROM data_prodi_tidak_ada_tahap1")->result();
        $data['prodi_t1']   = $this->db->query("SELECT * FROM `data_prodi_tahap1` ORDER BY `nm_pt` ASC")->result();

        $data['data_awal']  = $this->db->query("SELECT * FROM data_pt_tahap1 ORDER BY nama_pt ASC")->result();

        $data['belum_t2']   = $this->db->query("SELECT
                                                a.*,
                                                b.updated_at
                                                FROM
                                                data_prodi_tahap1 a
                                                LEFT JOIN data_prodi_tahap2 b
                                                ON a.id_prodi = b.id_prodi
                                                WHERE b.`updated_at` IS NULL
                                                AND a.id_prodi NOT IN (SELECT id_prodi FROM `data_prodi_tidak_ada_tahap2`)
                                                ORDER BY a.`nm_pt` ASC")->result();

        $data['proses_t2']  = $this->db->query("SELECT
                                                a.*,
                                                b.`akreditasi_prodi`,
                                                b.`tgl_akhir_akred`,
                                                b.`updated_at`
                                                FROM
                                                data_prodi_tahap1 a
                                                LEFT JOIN data_prodi_tahap2 b
                                                ON a.id_prodi = b.id_prodi
                                                WHERE a.id_prodi NOT IN (SELECT id_prodi FROM `data_prodi_tidak_ada_tahap2`)
                                                ORDER BY a.`nm_pt` ASC")->result();

        $data['tidak_t2']       = $this->db->query("SELECT * FROM data_prodi_tidak_ada_tahap2")->result();

        $data['prodi_aktif']    = $this->db->query("SELECT * FROM `data_prodi` ORDER BY nm_pt ASC")->result();

        $this->load->view("admin/sinkron/v_sinkron_prodi", $data);
    }

    // --- 1. Inisialisasi batch, memulai proses dan buat job file & log file
    public function proses_batch_start()
    {
        $progress_id     = uniqid();
        $job_file         = APPPATH . "logs/job_$progress_id.json";
        $log_file         = APPPATH . "logs/progress_$progress_id.log";

        // Ambil semua data yang perlu diproses
        $data_isi = $this->db->query("SELECT
                                        a.`kode_pt`,
                                        a.`nama_pt`
                                        FROM
                                        `data_pt_tahap1` a
                                        LEFT JOIN data_prodi_tahap1 b
                                            ON a.`kode_pt` = b.`kode_pt`
                                        WHERE b.`updated_at` IS NULL 
                                        AND a.`kode_pt` NOT IN (SELECT kode_pt FROM `data_prodi_tidak_ada_tahap1`)
                                        LIMIT 20")->result_array();

        $this->db->query("UPDATE rekap_sinkron SET status_progress='proses' WHERE jenis='data_prodi_t1'");

        $total = count($data_isi);
        file_put_contents($job_file, json_encode($data_isi));

        // SIMPAN waktu mulai & total di file log
        file_put_contents($log_file, "Proses penarikan data prodi tahap 1 dimulai<br>\n[START_TIMESTAMP]: " . date('Y-m-d H:i:s') . ")<br>\n");

        $this->session->set_userdata('batch_total_' . $progress_id, $total);
        $this->session->set_userdata('batch_processed_' . $progress_id, 0);

        echo json_encode([
            'status' => 'ok',
            'progress_id' => $progress_id,
            'jenis' => 'data_prodi_t1',
            'job_url' => base_url('beranda/SinkronProdi/proses_batch_job/' . $progress_id),
            'progress_url' => base_url('beranda/SinkronProdi/polling_progress/' . $progress_id),
            'result_url' => base_url('sinkronProdi')
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
            $kd_pt  = $da['kode_pt'];
            $nm_pt  = $da['nama_pt'];

            file_put_contents($log_file, "Memproses: $nm_pt ($kd_pt)<br>\n", FILE_APPEND);

            // ---- Tarik API per PT, dan simpan ke DB
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.kemdikbud.go.id:8445/pddikti/1.2/pt/' . $kd_pt . '/prodi',
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
            $respon = curl_exec($curl);
            curl_close($curl);

            if ($respon !== false) {
                $responseData = json_decode($respon, true);
                if (is_array($responseData) && isset($responseData[0]['id'])) {

                    foreach ($responseData as $item) {
                        // Ambil data sesuai struktur API Anda
                        $data_insert = [
                            'id_prodi'       => isset($item['id']) ? $item['id'] : null,
                            'kode_pt'        => isset($item['pt']['kode']) ? $item['pt']['kode'] : null,
                            'nm_pt'          => isset($item['pt']['nama']) ? $item['pt']['nama'] : null,
                            'kode_prodi'     => isset($item['kode']) ? $item['kode'] : null,
                            'nama_prodi'     => isset($item['nama']) ? $item['nama'] : null,
                            'program'        => isset($item['jenjang_didik']['nama']) ? $item['jenjang_didik']['nama'] : null,
                            'status_prodi'   => isset($item['status']) ? $item['status'] : null,
                            'smt_mulai'      => isset($item['semester_mulai']) ? $item['semester_mulai'] : null,
                            'tgl_update'     => date('Y-m-d')
                        ];
                        // Simpan dengan replace/update (hindari duplikat)
                        $this->db->replace('data_prodi_tahap1', $data_insert);
                    }
                    file_put_contents($log_file, "   ✔️ Berhasil tarik & simpan data API  $nm_pt ($kd_pt)<br>\n", FILE_APPEND);
                } else {
                    file_put_contents($log_file, "   ✖️ Data tidak ditemukan/format tidak sesuai  $nm_pt ($kd_pt)<br>\n", FILE_APPEND);

                    // Jika data tidak ditemukan, tetap simpan ke DB data tidak ada
                    $dain = [
                        'kode_pt' => $kd_pt,
                        'nama_pt' => $nm_pt
                    ];
                    $this->db->replace('data_prodi_tidak_ada_tahap1', $dain);
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
                                            JOIN `data_prodi_tahap1` b
                                                ON a.`kode_pt` = b.`kode_pt`
                                            GROUP BY b.kode_pt")->num_rows();

            $jtidak_ada = $this->db->query("SELECT * FROM data_prodi_tidak_ada_tahap1")->num_rows();
            $jprodi     = $this->db->query("SELECT * FROM data_prodi_tahap1")->num_rows();

            $rekap_data = [
                'jml_awal' => $jawal,
                'jml_proses' => $jrwy,
                'jml_tidak_ada' => $jtidak_ada,
                'jml_prodi' => $jprodi
            ];
            $this->db->where('jenis', 'data_prodi_t1');
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
        $jawal      = $this->db->query("SELECT * FROM data_pt_tahap1")->num_rows();
        $jrwy       = $this->db->query("SELECT
                                        *
                                        FROM
                                        `data_pt_tahap1` a
                                        JOIN `data_prodi_tahap1` b
                                            ON a.`kode_pt` = b.`kode_pt`
                                        GROUP BY b.kode_pt")->num_rows();

        $jtidak_ada = $this->db->query("SELECT * FROM data_prodi_tidak_ada_tahap1")->num_rows();
        $jprodi     = $this->db->query("SELECT * FROM data_prodi_tahap1")->num_rows();

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

                    $this->db->query("UPDATE
                                        data_prodi_tahap1 a
                                        JOIN `ref_status` b
                                            ON a.status_prodi = b.`kd_status` 
                                        SET a.nm_stat_prodi=b.`nm_status`");

                    $this->db->query("UPDATE rekap_sinkron SET status_progress='berhenti' WHERE jenis='data_prodi_t1'");

                    $this->db->query("UPDATE rekap_sinkron SET status_progress='berhenti', jml_awal='$jprodi' WHERE jenis='data_prodi_t2'");
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
            'label' => "status dan semester mulai program studi",
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
                                    b.updated_at
                                    FROM
                                    data_prodi_tahap1 a
                                    LEFT JOIN data_prodi_tahap2 b
                                        ON a.id_prodi = b.id_prodi
                                    WHERE b.`updated_at` IS NULL
                                    AND a.id_prodi NOT IN (SELECT id_prodi FROM `data_prodi_tidak_ada_tahap2`)
                                    LIMIT 20")->result_array();

        $this->db->query("UPDATE rekap_sinkron SET status_progress='proses' WHERE jenis='data_prodi_t2'");

        $total = count($dais);
        file_put_contents($job_file, json_encode($dais));

        // SIMPAN waktu mulai & total di file log
        file_put_contents($log_file, "Proses penarikan data <b>akreditasi prodi</b> dimulai<br>\n[START_TIMESTAMP]: " . date('Y-m-d H:i:s') . ")<br>\n");

        $this->session->set_userdata('batch_total_' . $progress_id, $total);
        $this->session->set_userdata('batch_processed_' . $progress_id, 0);

        echo json_encode([
            'status' => 'ok',
            'progress_id' => $progress_id,
            'jenis' => 'data_prodi_t2',
            'job_url' => base_url('beranda/SinkronProdi/proses_batch_job_tahap2/' . $progress_id),
            'progress_url' => base_url('beranda/SinkronProdi/polling_progress_tahap2/' . $progress_id),
            'result_url' => base_url('sinkronProdi')
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
            $id_prodi       = $da['id_prodi'];
            $kd_pt          = $da['kode_pt'];
            $nm_pt          = $da['nm_pt'];
            $kode_prodi     = $da['kode_prodi'];
            $nama_prodi     = $da['nama_prodi'];
            $program        = $da['program'];
            $status_prodi   = $da['status_prodi'];
            $nm_stat_prodi  = $da['nm_stat_prodi'];
            $smt_mulai      = $da['smt_mulai'];

            file_put_contents($log_file, "Memproses: $nm_pt ($kd_pt) prodi $nama_prodi ($kode_prodi - $id_prodi)<br>\n", FILE_APPEND);

            // ---- Tarik API per PT, dan simpan ke DB
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.kemdikbud.go.id:8445/pddikti/1.2/pt/' . $kd_pt . '/' . 'prodi/' . $id_prodi . '/akreditasi',
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
            $respon = curl_exec($curl);
            curl_close($curl);

            if ($respon !== false) {
                $responseData = json_decode($respon, true);
                if (is_array($responseData) && isset($responseData[0]['prodi']['id'])) {
                    $daup = [
                        'id_prodi'          => isset($responseData[0]['prodi']['id']) ? $responseData[0]['prodi']['id'] : null,
                        'akreditasi_prodi'  => isset($responseData[0]['nilai']) ? $responseData[0]['nilai'] : null,
                        'tgl_akhir_akred'   => isset($responseData[0]['tst_sk_akreditasi']) ? $responseData[0]['tst_sk_akreditasi'] : null,
                        'tgl_update'        => date('Y-m-d')
                    ];
                    // Simpan dengan replace/update (hindari duplikat)
                    $this->db->replace('data_prodi_tahap2', $daup);

                    file_put_contents($log_file, "   ✔️ Berhasil tarik & simpan data API  $nm_pt ($kd_pt) prodi $nama_prodi ($kode_prodi - $id_prodi)<br>\n", FILE_APPEND);
                } else {
                    file_put_contents($log_file, "   ✖️ Data tidak ditemukan/format tidak sesuai  $nm_pt ($kd_pt) prodi $nama_prodi ($kode_prodi - $id_prodi)<br>\n", FILE_APPEND);

                    // Jika data tidak ditemukan, tetap simpan ke DB data tidak ada
                    $data_insert = [
                        'id_prodi' => $id_prodi,
                        'kode_pt' => $kd_pt,
                        'nm_pt' => $nm_pt,
                        'kode_prodi' => $kode_prodi,
                        'nama_prodi' => $nama_prodi,
                        'program' => $program,
                        'status_prodi' => $status_prodi,
                        'nm_stat_prodi' => $nm_stat_prodi,
                        'smt_mulai' => $smt_mulai
                    ];
                    $this->db->replace('data_prodi_tidak_ada_tahap2', $data_insert);
                }
            } else {
                file_put_contents($log_file, "   ✖️ Gagal request API $nm_pt ($kd_pt) prodi $nama_prodi ($kode_prodi - $id_prodi)<br>\n", FILE_APPEND);
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
            $jawal      = $this->db->query("SELECT * FROM data_prodi_tahap1")->num_rows();
            $jrwy       = $this->db->query("SELECT
                                            *
                                            FROM
                                            `data_prodi_tahap1` a
                                            JOIN `data_prodi_tahap2` b
                                                ON a.id_prodi = b.id_prodi")->num_rows();

            $jtidak_ada = $this->db->query("SELECT * FROM data_prodi_tidak_ada_tahap2")->num_rows();

            $jprodi_aktif   = $this->db->query("SELECT
                                            *
                                            FROM
                                            `data_prodi_tahap1` a
                                            LEFT JOIN `data_prodi_tahap2` b
                                                ON a.id_prodi = b.id_prodi
                                            WHERE a.status_prodi='A'")->num_rows();

            $rekap_data = [
                'jml_awal' => $jawal,
                'jml_proses' => $jrwy,
                'jml_tidak_ada' => $jtidak_ada,
                'jml_prodi_aktif' => $jprodi_aktif
            ];
            $this->db->where('jenis', 'data_prodi_t2');
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
        $jawal      = $this->db->query("SELECT * FROM data_prodi_tahap1")->num_rows();
        $jrwy       = $this->db->query("SELECT
                                            *
                                            FROM
                                            `data_prodi_tahap1` a
                                            JOIN `data_prodi_tahap2` b
                                                ON a.id_prodi = b.id_prodi")->num_rows();

        $jtidak_ada = $this->db->query("SELECT * FROM data_prodi_tidak_ada_tahap2")->num_rows();

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

                    $this->db->query("UPDATE rekap_sinkron SET status_progress='berhenti' WHERE jenis='data_prodi_t2'");
                    $this->db->query("TRUNCATE TABLE data_prodi_backup");
                    $this->db->query("INSERT INTO `data_prodi_backup` SELECT * FROM `data_prodi`");
                    $this->db->query("TRUNCATE TABLE data_prodi");
                    $this->db->query("INSERT INTO `data_prodi`
                                       SELECT
                                        a.`kode_pt`,
                                        a.`nm_pt`,
                                        a.`kode_prodi`,
                                        a.`nama_prodi`,
                                        a.`program`,
                                        a.`status_prodi`,
                                        a.`nm_stat_prodi`,
                                        a.`smt_mulai`,
                                        COALESCE(b.akreditasi_prodi, '') AS akreditasi_prodi,
                                        COALESCE(b.tgl_akhir_akred, '0000-00-00') AS tgl_akhir_akred,
                                        CURDATE() AS tgl_update
                                        FROM
                                        data_prodi_tahap1 a
                                        LEFT JOIN data_prodi_tahap2 b
                                            ON a.id_prodi = b.id_prodi
                                        WHERE a.status_prodi = 'A'");
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
            'label' => "akreditasi program studi",
        ]);
    }

    // --- 1. Inisialisasi batch, memulai proses dan buat job file & log file
    public function proses_batch_start_susulan()
    {
        $progress_id     = uniqid();
        $job_file         = APPPATH . "logs/job_$progress_id.json";
        $log_file         = APPPATH . "logs/progress_$progress_id.log";

        $ca = $this->db->query("SELECT * FROM data_prodi_tidak_ada_tahap2 WHERE proses='1'")->num_rows();
        if ($ca == 0) {
            // Jika tidak ada data yang sudah diproses
            $this->db->query("UPDATE data_prodi_tidak_ada_tahap2 SET proses='1'");
        }

        // Ambil semua data yang perlu diproses
        $dais = $this->db->query("SELECT * FROM `data_prodi_tidak_ada_tahap2` WHERE proses='1'LIMIT 20")->result_array();

        $total = count($dais);
        file_put_contents($job_file, json_encode($dais));

        // SIMPAN waktu mulai & total di file log
        file_put_contents($log_file, "Proses penarikan data <b>akreditasi prodi</b> dimulai<br>\n[START_TIMESTAMP]: " . date('Y-m-d H:i:s') . ")<br>\n");

        $this->session->set_userdata('batch_total_' . $progress_id, $total);
        $this->session->set_userdata('batch_processed_' . $progress_id, 0);

        echo json_encode([
            'status' => 'ok',
            'progress_id' => $progress_id,
            'jenis' => 'data_prodi_t2',
            'job_url' => base_url('beranda/SinkronProdi/proses_batch_job_susulan/' . $progress_id),
            'progress_url' => base_url('beranda/SinkronProdi/polling_progress_susulan/' . $progress_id),
            'result_url' => base_url('sinkronProdi')
        ]);
    }

    // --- 2. Eksekusi 1 chunk (misal 20 dosen) per request
    public function proses_batch_job_susulan($progress_id)
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
            $id_prodi       = $da['id_prodi'];
            $kd_pt          = $da['kode_pt'];
            $nm_pt          = $da['nm_pt'];
            $kode_prodi     = $da['kode_prodi'];
            $nama_prodi     = $da['nama_prodi'];
            $program        = $da['program'];
            $status_prodi   = $da['status_prodi'];
            $nm_stat_prodi  = $da['nm_stat_prodi'];
            $smt_mulai      = $da['smt_mulai'];

            file_put_contents($log_file, "Memproses: $nm_pt ($kd_pt) prodi $nama_prodi ($kode_prodi - $id_prodi)<br>\n", FILE_APPEND);

            // ---- Tarik API per PT, dan simpan ke DB
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.kemdikbud.go.id:8445/pddikti/1.2/pt/' . $kd_pt . '/' . 'prodi/' . $id_prodi . '/akreditasi',
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
            $respon = curl_exec($curl);
            curl_close($curl);

            if ($respon !== false) {
                $responseData = json_decode($respon, true);
                if (is_array($responseData) && isset($responseData[0]['prodi']['id'])) {
                    $daup = [
                        'id_prodi'          => isset($responseData[0]['prodi']['id']) ? $responseData[0]['prodi']['id'] : null,
                        'akreditasi_prodi'  => isset($responseData[0]['nilai']) ? $responseData[0]['nilai'] : null,
                        'tgl_akhir_akred'   => isset($responseData[0]['tst_sk_akreditasi']) ? $responseData[0]['tst_sk_akreditasi'] : null,
                        'tgl_update'        => date('Y-m-d')
                    ];
                    // Simpan dengan replace/update (hindari duplikat)
                    $this->db->replace('data_prodi_tahap2', $daup);

                    //update proses = 0 dan berhasil=1 pada table data_prodi_tidak_ada_tahap2
                    $daupt2 = [
                        'proses' => '0',
                        'berhasil' => '1'
                    ];
                    $this->db->where('id_prodi', $id_prodi);
                    $this->db->update('data_prodi_tidak_ada_tahap2', $daupt2);

                    file_put_contents($log_file, "   ✔️ Berhasil tarik & simpan data API  $nm_pt ($kd_pt) prodi $nama_prodi ($kode_prodi - $id_prodi)<br>\n", FILE_APPEND);
                } else {
                    file_put_contents($log_file, "   ✖️ Data tidak ditemukan/format tidak sesuai  $nm_pt ($kd_pt) prodi $nama_prodi ($kode_prodi - $id_prodi)<br>\n", FILE_APPEND);

                    //update proses = 0 pada table data_prodi_tidak_ada_tahap2
                    $daupt2 = [
                        'proses' => '0'
                    ];
                    $this->db->where('id_prodi', $id_prodi);
                    $this->db->update('data_prodi_tidak_ada_tahap2', $daupt2);
                }
            } else {
                file_put_contents($log_file, "   ✖️ Gagal request API $nm_pt ($kd_pt) prodi $nama_prodi ($kode_prodi - $id_prodi)<br>\n", FILE_APPEND);
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
        }

        echo json_encode([
            'status' => 'ok',
            'remaining' => count($isi_list)
        ]);
    }

    // --- 3. Endpoint polling progress log
    public function polling_progress_susulan($progress_id)
    {
        $progress_file  = APPPATH . 'logs/progress_' . $progress_id . '.log';
        $logs           = '';
        $finished       = false;
        $selisih        = 0;

        // Hitung progress by real data
        $jawal          = $this->db->query("SELECT * FROM data_prodi_tidak_ada_tahap2")->num_rows();
        $total_proses   = $this->db->query("SELECT * FROM data_prodi_tidak_ada_tahap2 WHERE proses='0'")->num_rows();

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

                    $this->db->query("TRUNCATE TABLE data_prodi_susulan_backup");
                    $this->db->query("INSERT INTO `data_prodi_susulan_backup` SELECT * FROM `data_prodi`");
                    $this->db->query("TRUNCATE TABLE data_prodi");
                    $this->db->query("INSERT INTO `data_prodi`
                                       SELECT
                                        a.`kode_pt`,
                                        a.`nm_pt`,
                                        a.`kode_prodi`,
                                        a.`nama_prodi`,
                                        a.`program`,
                                        a.`status_prodi`,
                                        a.`nm_stat_prodi`,
                                        a.`smt_mulai`,
                                        COALESCE(b.akreditasi_prodi, '') AS akreditasi_prodi,
                                        COALESCE(b.tgl_akhir_akred, '0000-00-00') AS tgl_akhir_akred,
                                        CURDATE() AS tgl_update
                                        FROM
                                        data_prodi_tahap1 a
                                        LEFT JOIN data_prodi_tahap2 b
                                            ON a.id_prodi = b.id_prodi
                                        WHERE a.status_prodi = 'A'");

                    $this->db->query("DELETE FROM data_prodi_tidak_ada_tahap2 WHERE proses='0' AND berhasil='1'");


                    // proses update rekap sinkron 
                    $jtidak_ada = $this->db->query("SELECT * FROM data_prodi_tidak_ada_tahap2")->num_rows();
                    $cr         = $this->db->query("SELECT * FROM rekap_sinkron WHERE jenis='data_prodi_t2'")->row();

                    $jml_proses = $cr->jml_awal - $jtidak_ada;

                    $rekap_data = [
                        'jml_proses' => $jml_proses,
                        'jml_tidak_ada' => $jtidak_ada
                    ];
                    $this->db->where('jenis', 'data_prodi_t2');
                    $this->db->update('rekap_sinkron', $rekap_data);
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
            'label' => "akreditasi program studi",
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
