<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Login extends CI_Model {
    public function cek_login($id_user, $password) {
        $this->db->where('id_user', $id_user);
        $user = $this->db->get('user')->row_array();

        // Cek apakah user ditemukan dan password benar
        if ($user && $user['password'] == $password) {
            return $user;
        }
        return false;
    }
}
