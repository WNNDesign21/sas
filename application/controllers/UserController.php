<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('UserModel');
    }

    public function index() {
        $data['mahasiswa'] = $this->UserModel->getAllMahasiswa();
        $data['dosen'] = $this->UserModel->getAllDosen();
        $this->load->view('user_view', $data);
    }
    public function getMahasiswa() {
        $data['mahasiswa'] = $this->UserModel->getAllMahasiswa();
        $data['dosen'] = $this->UserModel->getAllDosen();
        echo json_encode($data);
    }

    public function addUser() {
        $userId = $this->input->post('userId');
        $password = $this->input->post('password');
        $name = $this->input->post('name');
        $akses = $this->input->post('akses');

        $result = $this->UserModel->insertUser($userId, $password, $name, $akses);
        echo json_encode(['status' => $result ? 'success' : 'error']);
    }
}
?>
