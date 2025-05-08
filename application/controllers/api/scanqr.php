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
    $id_user = $this->post('id_user');
    $qr_data = $this->post('qr_data');

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
    $hari_ini = date('l'); // contoh: Monday, Tuesday...

    // Ambil jadwal berdasarkan id_mk, npm, dan hari ini
    $jadwal = $this->db->get_where('detail_jadwal', [
        'id_mk' => $id_mk,
        // 'npm' => $id_user, // jika kolom ini ada. Jika tidak, hapus saja
        'hari' => $hari_ini
    ])->row();

    if (!$jadwal) {
        $this->response([
            'status' => false,
            'message' => 'Jadwal kuliah tidak ditemukan untuk hari ini.'
        ], RestController::HTTP_NOT_FOUND);
        return;
    }

    $jam_mulai = $jadwal->jam_mulai;
    $jam_selesai = $jadwal->jam_selesai;
    $waktu_sekarang = date("H:i");

    if ($waktu_sekarang < $jam_mulai || $waktu_sekarang > $jam_selesai) {
        $this->response([
            'status' => false,
            'message' => 'Absensi hanya dapat dilakukan antara jam ' . $jam_mulai . ' dan ' . $jam_selesai
        ], RestController::HTTP_FORBIDDEN);
        return;
    }

    // Cek apakah mahasiswa terdaftar
    $is_registered = $this->db->get_where('mhs_mk', [
        'npm' => $id_user,
        'id_mk' => $id_mk
    ])->row();

    if (!$is_registered) {
        $this->response([
            'status' => false,
            'message' => 'Anda tidak terdaftar di mata kuliah ini.'
        ], RestController::HTTP_UNAUTHORIZED);
        return;
    }

    // Cek dan update/insert absensi
    $cek = $this->db->get_where('absensi', [
        'id_mk' => $id_mk,
        'npm' => $id_user,
        'tanggal' => $tanggal,
        'pertemuan' => $pertemuan
    ])->row();

    if ($cek) {
        if (strtoupper($cek->status) === 'HADIR') {
            $this->response([
                'status' => false,
                'message' => 'Anda sudah melakukan absensi untuk pertemuan ini.'
            ], 409);
        } else {
            $this->db->update('absensi', ['status' => 'HADIR'], [
                'id_mk' => $id_mk,
                'npm' => $id_user,
                'tanggal' => $tanggal,
                'pertemuan' => $pertemuan
            ]);

            $this->response([
                'status' => true,
                'message' => 'Status absensi diperbarui menjadi HADIR.'
            ], 200);
        }
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
