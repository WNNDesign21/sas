<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Pastikan path ini benar jika Anda tidak menggunakan Composer autoload untuk REST_Controller
// require APPPATH . 'libraries/REST_Controller.php'; 
// require APPPATH . 'libraries/Format.php';

use chriskacerguis\RestServer\RestController; // Jika menggunakan namespace dari Composer

class Absensi extends RestController { // Pastikan extends RestController atau REST_Controller sesuai instalasi Anda

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Mengambil data absensi berdasarkan NPM (id_user) beserta persentase kehadiran per MK
     * Method: GET
     * Parameter: id_user (NPM mahasiswa)
     * URL: api/absensi/mahasiswa?id_user=NPM_ANDA
     */
    public function index_get() {
        $npm = $this->get('id_user'); 

        if (empty($npm)) {
            $this->response([
                'status' => FALSE,
                'message' => 'Parameter id_user (NPM) dibutuhkan.'
            ], RestController::HTTP_BAD_REQUEST);
            return;
        }

        // --- Query Database Langsung di Controller ---
        $this->db->select('
            a.id_absensi,
            a.id_mk,
            mk.nama_mk,
            mk.sks,
            a.npm,
            a.tanggal,
            a.pertemuan,
            a.status
        ');
        $this->db->from('absensi a'); // Menggunakan 'absensi' sesuai kode Anda
        $this->db->join('mata_kuliah mk', 'a.id_mk = mk.id_mk'); // Menggunakan 'mata_kuliah' sesuai kode Anda
        $this->db->where('a.npm', $npm);
        $this->db->order_by('a.id_mk', 'ASC'); // Urutkan berdasarkan id_mk untuk grouping
        $this->db->order_by('a.pertemuan', 'ASC'); 

        $query = $this->db->get();
        $absensi_raw = [];

        if ($query->num_rows() > 0) {
            $absensi_raw = $query->result_array();
        }
        // --- Akhir Query Database ---

        if (!empty($absensi_raw)) {
            $result = [];
            $current_mk_id = null;
            $mk_data = null;

            foreach ($absensi_raw as $row) {
                if ($row['id_mk'] !== $current_mk_id) {
                    // Jika ada data mata kuliah sebelumnya, hitung persentase dan simpan ke hasil
                    if ($mk_data !== null) {
                        if ($mk_data['total_pertemuan_mk'] > 0) {
                            $mk_data['persentase_kehadiran'] = round(($mk_data['total_hadir_mk'] / $mk_data['total_pertemuan_mk']) * 100, 2);
                        } else {
                            $mk_data['persentase_kehadiran'] = 0.00;
                        }
                        $result[] = $mk_data;
                    }
                    // Mulai mata kuliah baru
                    $current_mk_id = $row['id_mk'];
                    $mk_data = [
                        'id_mk' => $row['id_mk'],
                        'nama_mk' => $row['nama_mk'],
                        'sks' => $row['sks'],
                        'total_pertemuan_mk' => 0, // Untuk menghitung total pertemuan per MK
                        'total_hadir_mk' => 0,     // Untuk menghitung total hadir per MK
                        'persentase_kehadiran' => 0.00, // Default persentase
                        'absensi_pertemuan' => []
                    ];
                }

                // Akumulasi data untuk mata kuliah saat ini
                if ($mk_data !== null) { // Pastikan mk_data sudah diinisialisasi
                    $mk_data['total_pertemuan_mk']++;
                    if (strtolower($row['status']) === 'hadir') { // Pengecekan case-insensitive
                        $mk_data['total_hadir_mk']++;
                    }

                    // Tambahkan detail pertemuan ke mata kuliah saat ini
                    $mk_data['absensi_pertemuan'][] = [
                        'pertemuan' => (int)$row['pertemuan'],
                        'tanggal' => $row['tanggal'],
                        'status' => $row['status'],
                        'id_absensi' => $row['id_absensi'] 
                    ];
                }
            }

            // Simpan data mata kuliah terakhir beserta persentasenya
            if ($mk_data !== null) {
                if ($mk_data['total_pertemuan_mk'] > 0) {
                    $mk_data['persentase_kehadiran'] = round(($mk_data['total_hadir_mk'] / $mk_data['total_pertemuan_mk']) * 100, 2);
                } else {
                    $mk_data['persentase_kehadiran'] = 0.00;
                }
                $result[] = $mk_data;
            }

            if (!empty($result)) {
                $this->response([
                    'status' => TRUE,
                    'message' => 'Data absensi berhasil diambil.',
                    'data' => $result
                ], RestController::HTTP_OK);
            } else {
                 $this->response([
                    'status' => FALSE,
                    'message' => 'Tidak ada data absensi yang dapat diproses untuk NPM tersebut.',
                    'data' => []
                ], RestController::HTTP_OK);
            }

        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Tidak ada data absensi ditemukan untuk NPM tersebut.',
                'data' => []
            ], RestController::HTTP_OK);
        }
    }
}