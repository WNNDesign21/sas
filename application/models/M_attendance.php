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
            jadwal.id_jadwal, 
            jadwal.id_mk, 
            mata_kuliah.nama_mk, 
            jadwal.haritanggal, 
            jadwal.jam_mulai, 
            jadwal.jam_selesai, 
            jadwal.pertemuan, 
            jadwal.ruangan
        ');
        $this->db->from('jadwal');
        $this->db->join('mata_kuliah', 'mata_kuliah.id_mk = jadwal.id_mk');
        $this->db->where('jadwal.nidn', $nidn);
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
        $this->db->join('jadwal', 'jadwal.id_mk = qr_codes.id_mk');
        $this->db->where('jadwal.nidn', $nidn);
        return $this->db->get()->result_array();
    }
}
?>