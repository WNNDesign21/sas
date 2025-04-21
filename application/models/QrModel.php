<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QrModel extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database(); // Tambahkan ini untuk memastikan database dimuat
    }

    public function getAllMataKuliah() {
        return $this->db->get('mata_kuliah')->result_array();
    }

    public function getMataKuliahById($id) {
        return $this->db->get_where('mata_kuliah', ['id_mk' => $id])->row_array();
    }

    public function saveQrCode($data) {
        return $this->db->insert('qr_codes', $data);
    }
    public function getMataKuliahByNidn($nidn) {
        $this->db->select('mata_kuliah.id_mk, mata_kuliah.nama_mk');
        $this->db->from('mata_kuliah');
        $this->db->join('detail_jadwal', 'detail_jadwal.id_mk = mata_kuliah.id_mk');
        $this->db->where('detail_jadwal.nidn', $nidn);
        $query = $this->db->get();

        return $query->result();
    }
}
?>
