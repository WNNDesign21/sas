<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
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
    public function getUserById($id_user) {
        return $this->db->where('id_user', $id_user)->get('user')->row_array();
    }

    public function update_foto_profil($id_user, $foto_profil) {
        $data = array('foto_profil' => $foto_profil);
        $this->db->where('id_user', $id_user);
        return $this->db->update('user', $data);
    }

    public function update_password($id_user, $password_hash) {
        return $this->db->update('user', ['password' => $password_hash], ['id_user' => $id_user]);
    }
}
?>
