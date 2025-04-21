<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Scanqr extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // POST: api/scanqr
    public function index_post()
    {
        $id_user = $this->post('id_user');       // NPM mahasiswa yang login
        $qr_data = $this->post('qr_data');       // Format: pertemuan|id_mk|nama_mk|pertemuan

        $data_parts = explode('|', $qr_data);

        if (count($data_parts) !== 3) {
            $this->response([
                'status' => false,
                'message' => 'Format QR Code tidak valid!'
            ], RestController::HTTP_BAD_REQUEST);
            return;
        }

        $id_mk = trim($data_parts[0]);
        $pertemuan = trim($data_parts[2]);
        $tanggal = date('Y-m-d');

        // Cek apakah user sudah absen pada hari & pertemuan yang sama
        $cek = $this->db->get_where('absensi', [
            'id_mk' => $id_mk,
            'npm' => $id_user,
            'tanggal' => $tanggal,
            'pertemuan' => $pertemuan
        ])->row();

        if ($cek) {
            $this->response([
                'status' => false,
                'message' => 'Anda sudah melakukan absensi untuk pertemuan ini.'
            ], 409);
            return;
        }

        $absensi_data = [
            'id_mk' => $id_mk,
            'npm' => $id_user,
            'tanggal' => $tanggal,
            'pertemuan' => $pertemuan,
            'status' => 'HADIR'
        ];

        $this->db->insert('absensi', $absensi_data);

        $this->response([
            'status' => true,
            'message' => 'Absensi berhasil disimpan.',
            'data' => $absensi_data
        ], RestController::HTTP_CREATED);
    }
}
