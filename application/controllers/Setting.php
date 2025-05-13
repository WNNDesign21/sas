<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('UserModel'); // Pastikan model UserModel sudah diload
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login'); // Redirect ke halaman login jika belum login
        }
    }

    public function index()
    {
        $data['title'] = 'Pengaturan Akun';
        $data['user'] = $this->UserModel->getUserById($this->session->userdata('id_user'));
        $this->load->view('setting', $data);
    }

    public function upload_foto()
    {
        $id_user = $this->session->userdata('id_user');
        $upload_path = 'assets/foto_profil/';

        // echo 'Upload Path: ' . $upload_path . '<br>';
        // echo 'Folder exists? ' . (is_dir($upload_path) ? 'YES' : 'NO') . '<br>';
        // echo 'Writable? ' . (is_writable($upload_path) ? 'YES' : 'NO') . '<br>';

        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 2048;
        $config['file_name'] = 'profil_' . $id_user;
        $config['overwrite'] = TRUE;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        // Proses upload
        if ($this->upload->do_upload('foto')) {
            $file_data = $this->upload->data();
            $relative_path = 'assets/foto_profil/' . $file_data['file_name']; // Path relatif untuk disimpan di DB
            $this->M_Login->update_foto_profil($id_user, $relative_path);
            $this->session->set_userdata('foto_profil', $relative_path);
            $this->session->set_flashdata('message', 'Foto Profil berhasil diubah!');
            redirect('setting');
        } else {
            echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors()]);
        }
    }
}