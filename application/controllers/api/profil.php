<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Profil extends RestController // Sebaiknya nama class adalah User (singular) jika endpoint untuk satu user
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Mengambil data profil mahasiswa (nama, npm, fakultas, prodi, foto_profil)
     * berdasarkan id_user (npm) yang dikirim sebagai parameter.
     *
     * @method GET
     * @param string $id_user NPM mahasiswa yang login
     * @return Response
     *
     * Contoh penggunaan: GET api/users?id_user=NPM_MAHASISWA
     * atau jika Anda ingin menggunakan path parameter: GET api/users/profile/NPM_MAHASISWA
     * (namun contoh di bawah menggunakan query parameter `id_user`)
     */
    public function index_get()
    {
        // Ambil id_user (npm) dari parameter GET
        $id_user_login = $this->get('id_user');

        if (!$id_user_login) {
            $this->response([
                'status' => false,
                'message' => 'Parameter id_user (NPM) diperlukan'
            ], RestController::HTTP_BAD_REQUEST);
            return;
        }

        $this->db->select('m.nama, m.npm, m.fakultas, m.prodi, u.foto_profil');
        $this->db->from('mhs m'); // m adalah alias untuk tabel mhs
        $this->db->join('user u', 'u.id_user = m.npm', 'left'); // u adalah alias untuk tabel user, 'left' join untuk memastikan data mhs tetap tampil meski foto_profil mungkin null
        $this->db->where('m.npm', $id_user_login); // atau 'u.id_user' jika itu yang dikirim dari mobile dan merupakan NPM

        $profil = $this->db->get()->row(); // Mengambil satu baris data

        if ($profil) {
            $this->response([
                'status' => true,
                'message' => 'Data profil ditemukan',
                'data' => $profil
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Profil mahasiswa tidak ditemukan'
            ], RestController::HTTP_NOT_FOUND);
        }
    }
}
?>