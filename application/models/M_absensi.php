<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Absensi extends CI_Model
{
    public function get_absensi_by_mahasiswa($id_user)
    {
        $this->db->select('m.nama_matkul, COUNT(a.id_absensi) as total_hadir, j.total_pertemuan');
        $this->db->from('absensi a');
        $this->db->join('jadwal j', 'a.id_jadwal = j.id_jadwal');
        $this->db->join('mata_kuliah m', 'j.id_matkul = m.id_matkul');
        $this->db->where('a.id_user', $id_user);
        $this->db->group_by('m.nama_matkul, j.total_pertemuan');

        return $this->db->get()->result();
    }
}
