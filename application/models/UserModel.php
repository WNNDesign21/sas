<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {
    public function getAllMahasiswa() {
        return $this->db->get('mhs')->result_array();
    }

    public function getAllDosen() {
        return $this->db->get('dosen')->result_array();
    }
    public function getAllBaak() {
        return $this->db->get('baak')->result_array();
    }
    public function getAllUser() {
        return $this->db->get('user')->result_array();
    }

    public function insertUser($userId, $password, $name, $tipe, $akses) {
        return $this->db->insert('user', [
            'id_user' => $userId,
            'password' => $password,
            'nama_user' => $name,
            'tipe' => $tipe,
            'akses' => $akses,
        ]);
    }
}
?>
