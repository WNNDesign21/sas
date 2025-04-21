<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_attendance extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // Tambahkan ini
    }
    public function save_attendance($course, $session, $qr_path) {
        $data = [
            'course' => $course,
            'session' => $session,
            'qr_code' => $qr_path
        ];
        $this->db->insert('attendance', $data);
    }
     /**
     * Ambil jadwal berdasarkan NIDN dosen yang login.
     */
    public function getJadwalByDosen($nidn) {
        $this->db->select('
            detail_jadwal.id_jadwal, 
            detail_jadwal.id_mk, 
            mata_kuliah.nama_mk, 
            detail_jadwal.hari, 
            detail_jadwal.jam_mulai, 
            detail_jadwal.jam_selesai, 
            detail_jadwal.total_pertemuan, 
            detail_jadwal.ruangan
        ');
        $this->db->from('detail_jadwal');
        $this->db->join('mata_kuliah', 'mata_kuliah.id_mk = detail_jadwal.id_mk');
        $this->db->where('detail_jadwal.nidn', $nidn);
        return $this->db->get()->result_array();
    }

    /**
     * Ambil daftar QR Code berdasarkan NIDN dosen yang login.
     */
    public function getQrByDosen($nidn) {
        $this->db->select('
            qr_codes.id_mk, 
            qr_codes.pertemuan, 
            qr_codes.qr_text, 
            qr_codes.qr_image, 
            mata_kuliah.nama_mk
        ');
        $this->db->from('qr_codes');
        $this->db->join('mata_kuliah', 'mata_kuliah.id_mk = qr_codes.id_mk');
        $this->db->join('detail_jadwal', 'detail_jadwal.id_mk = qr_codes.id_mk');
        $this->db->where('detail_jadwal.nidn', $nidn);
        return $this->db->get()->result_array();
    }
}
?>