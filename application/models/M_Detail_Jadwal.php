<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Detail_Jadwal extends CI_Model 
{
    public function get_jadwal_by_mk($id_mk)
    {
        // Ambil data jam mulai dan selesai untuk mata kuliah tertentu
        $this->db->select('hari, jam_mulai, jam_selesai');
        $this->db->from('detail_jadwal');
        $this->db->where('id_mk', $id_mk);
        $query = $this->db->get();

        // Jika data ditemukan, kembalikan
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;  // Jika tidak ada data
        }
    }
}
