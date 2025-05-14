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
            redirect('profil');
        } else {
            echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors()]);
        }
    }
    public function update_password()
    {
        $this->load->library('session');
        $this->load->model('UserModel');

        $id_user = $this->session->userdata('id_user');
        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('new_password');
        $confirm_password = $this->input->post('confirm_password');

        $user = $this->UserModel->getUserById($id_user);

        if (!$user) {
            $this->session->set_flashdata('error', 'User tidak ditemukan.');
            redirect('profil');
        }
        // echo "Input Password: " . $old_password . "<br>";
        // echo "Database Password: " . $user['password'] . "<br>";
        // exit;


        // Bandingkan langsung karena password belum di-hash
        // Cek password lama
        if ($old_password !== $user['password']) {
            $this->session->set_flashdata('error', 'Password lama salah.');
            redirect('profil');
        }

        // Cek konfirmasi password baru
        if ($new_password !== $confirm_password) {
            $this->session->set_flashdata('error', 'Konfirmasi password baru tidak cocok.');
            redirect('profil');
        }

        // Simpan password baru (plaintext)
        $this->UserModel->update_password($id_user, $new_password);

        // Jika semuanya berhasil
        $this->session->set_flashdata('message', 'Password berhasil diubah.');
        redirect('profil');


    }


}