<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Login extends CI_Model
{
    public function cek_login($id_user, $password)
    {
        $this->db->where('id_user', $id_user);
        $user = $this->db->get('user')->row_array();

        // Cek apakah user ditemukan dan password benar
        if ($user && $user['password'] == $password) {
            return $user;
        }
        return false;
    }

    public function get_absensi_by_user($id_user)
    {
        $this->db->select("
            id_jadwal, mata_kuliah,
            COUNT(DISTINCT pertemuan) as total_pertemuan,
            SUM(CASE WHEN status = 'Hadir' THEN 1 ELSE 0 END) as hadir
        ");
        $this->db->where('npm', $id_user);
        $this->db->group_by('id_mk');
        $query = $this->db->get('v_d_absensi');
        return $query->result_array();
    }

    public function update_foto_profil($id_user, $foto_profil)
    {
        $this->db->where('id_user', $id_user);
        return $this->db->update('user',['foto_profil'=>$foto_profil]);
    }

}
