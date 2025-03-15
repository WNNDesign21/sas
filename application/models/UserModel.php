<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {
    public function getAllMahasiswa() {
        return $this->db->get('mhs')->result_array();
    }

    public function getAllDosen() {
        return $this->db->get('dosen')->result_array();
    }

    public function insertUser($userId, $password, $name, $akses) {
        return $this->db->insert('user', [
            'id_user' => $userId,
            'password' => $password,
            'nama_user' => $name,
            'akses' => $akses,
        ]);
    }
}
?>
