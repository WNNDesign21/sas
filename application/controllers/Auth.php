<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Login');  // Pastikan nama model sesuai
        $this->load->library('session');
        $this->load->helper('url'); // Tambahkan ini
    }

    public function index()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('home');
        }
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
        $this->output->set_header("Pragma: no-cache");
        $this->load->view('login');

    }

    public function proses_login()
    {
        $id_user = $this->input->post('id_user');
        $password = $this->input->post('password');

        $user = $this->M_Login->cek_login($id_user, $password); // Perbaiki pemanggilan model

        if ($user) {
            $data = [
                'id_user' => $user['id_user'],
                'nama_user' => $user['nama_user'],
                'logged_in' => TRUE
            ];
            $this->session->set_userdata($data);
            redirect('home');
        } else {
            $this->session->set_flashdata('error', 'Email atau password salah!');
            redirect('');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
        $this->output->set_header("Pragma: no-cache");
        redirect('auth');
    }
}
