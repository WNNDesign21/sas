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
}
?>
