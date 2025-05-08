<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('UserModel'); // Pastikan model UserModel sudah diload
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login'); // Redirect ke halaman login jika belum login
        }
    }

    public function index() {
        $data['title'] = 'Pengaturan Akun';
        $data['user'] = $this->UserModel->getUserById($this->session->userdata('id_user'));
        $this->load->view('setting', $data);
    }

    public function upload_foto() {
        $id_user = $this->session->userdata('id_user');

        $config['upload_path'] = FCPATH . 'assets/foto_profil/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 2048;
        $config['file_name'] = 'profil_' . $id_user;
        $config['overwrite'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('foto_profil')) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
        } else {
            $upload_data = $this->upload->data();
            $foto_path = 'assets/foto_profil/' . $upload_data['file_name'];

            $this->UserModel->update_foto_profil($id_user, $foto_path);
            $this->session->set_userdata('foto_profil', $foto_path);
            $this->session->set_flashdata('success', 'Foto profil berhasil diperbarui.');
        }
        redirect('setting');
    }
}