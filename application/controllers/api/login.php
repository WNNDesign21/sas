<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Login extends RestController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // POST: api/login
    public function index_post()
    {
        $id_user = $this->post('id_user');
        $password = $this->post('password');

        if (!$id_user || !$password) {
            $this->response([
                'status' => false,
                'message' => 'ID User dan Password wajib diisi'
            ], RestController::HTTP_BAD_REQUEST);
            return;
        }

        $user = $this->db->get_where('user', ['id_user' => $id_user])->row();

        if (!$user) {
            $this->response([
                'status' => false,
                'message' => 'User tidak ditemukan'
            ], RestController::HTTP_NOT_FOUND);
        } else {
            if ($user->password === $password) { // sesuaikan dengan enkripsi jika ada
                $this->response([
                    'status' => true,
                    'message' => 'Login berhasil',
                    'data' => [
                        'id_user' => $user->id_user,
                        'nama' => $user->nama_user,
                        'akses' => $user->akses,
                        'foto_profil' => $user->foto_profil,
                    ]
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Password salah'
                ], RestController::HTTP_UNAUTHORIZED);
            }
        }
    }
}

?>