<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class attendance extends RestController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // POST: api/login
    public function index_get()
    {
        $user = $this->db->get('absensi')->result();

        if (!$user) {
            $this->response([
                'status' => false,
                'message' => 'User tidak ditemukan'
            ], RestController::HTTP_NOT_FOUND);
        } else {
            $this->response([
                'status'=> true,
                'message'=> 'Data Ditemukan',
                'data'=> $user
                ], RestController::HTTP_OK);
        }
    }
}

?>