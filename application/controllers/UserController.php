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
        $data['baak'] = $this->UserModel->getAllBaak();
        $this->load->view('user_view', $data);
    }
    public function getMahasiswa() {
        $data['mahasiswa'] = $this->UserModel->getAllMahasiswa();
        $data['dosen'] = $this->UserModel->getAllDosen();
        $data['baak'] = $this->UserModel->getAllBaak();
        echo json_encode($data);
    }
    public function getUser() {
        $data['user'] = $this->UserModel->getAllUser();
        // $data['dosen'] = $this->UserModel->getAllDosen();
        // $data['baak'] = $this->UserModel->getAllBaak();
        echo json_encode($data);
    }

    public function addUser() {
        $userId = $this->input->post('userId');
        $password = $this->input->post('password');
        $name = $this->input->post('name');
        $tipe = $this->input->post('user_type');
        $akses = $this->input->post('akses');

        $result = $this->UserModel->insertUser($userId, $password, $name, $tipe, $akses);
        echo json_encode(['status' => $result ? 'success' : 'error']);
    }
    public function deleteUser()
{
    $id = $this->input->post('id');

    if ($id) {
        $this->db->where('id_user', $id);
        $this->db->delete('user');

        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID tidak ditemukan.']);
    }
}

}
?>
