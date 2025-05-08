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


            $this->db->select('fakultas, prodi');
            $this->db->where('npm', $user['id_user']);  // Sesuaikan dengan kolom yang sesuai di tabel mhs
            $mhs_query = $this->db->get('mhs');  // Tabel mahasiswa

            if ($mhs_query->num_rows() > 0) {
                // Ambil data fakultas dan prodi dari tabel mhs
                $mhs_data = $mhs_query->row_array();
                $user['fakultas'] = $mhs_data['fakultas'];
                $user['prodi'] = $mhs_data['prodi'];
            }
            $this->db->select('fakultas');
            $this->db->where('nidn', $user['id_user']);
            $dosen_query = $this->db->get('dosen');

            if ($dosen_query->num_rows() > 0) {
                $dosen_data = $dosen_query->row_array();
                $user['fakultas_dosen'] = $dosen_data['fakultas']; // Tambahkan fakultas dosen
            } else {
                $user['fakultas_dosen'] = null; // Jika bukan dosen, set null
            }
            return $user;
        }
        return false;
    }

    public function get_absensi_by_user($id_user)
    {
        $this->db->select("
            id_mk,nama_matakuliah,
            COUNT(DISTINCT pertemuan) as total_pertemuan,
            SUM(CASE WHEN status = 'Hadir' THEN 1 ELSE 0 END) as hadir
        ");
        $this->db->where('mahasiswa', $id_user);
        $this->db->group_by('id_mk');
        $query = $this->db->get('v_d_absensi');
        return $query->result_array();
    }

    public function update_foto_profil($id_user, $foto_profil)
    {
        $this->db->where('id_user', $id_user);
        return $this->db->update('user', ['foto_profil' => $foto_profil]);
    }

}
