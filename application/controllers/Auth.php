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
                'foto_profil' => $user['foto_profil'],
                'fakultas' => $user['fakultas'], // Tambahkan fakultas
                'prodi' => $user['prodi'],       // Tambahkan prodi
                'akses' => $user['akses'],       // Tambahkan prodi
                'fakultas_dosen' => $user['fakultas_dosen'],       // Tambahkan prodi
                'logged_in' => TRUE
            ];
            $this->session->set_userdata($data);

            // Arahkan berdasarkan role
            if ($this->session->userdata('akses') === 'MHS') {
                redirect('home'); // Halaman mahasiswa
            } elseif ($this->session->userdata('akses') === 'DOSEN') {
                redirect('dosen_home'); // Halaman dosen
            } elseif ($this->session->userdata('akses') === 'ADMIN') {
                redirect('baak_home'); // Halaman dosen
            } else {
                $this->session->set_flashdata('error', 'Akses tidak dikenali!');
                redirect('auth'); // Redirect kembali ke halaman login
            }
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

    public function get_chart_data()
    {
        $id_user = $this->session->userdata('id_user');
        $absensi = $this->M_Login->get_absensi_by_user($id_user);

        $data = [];
        foreach ($absensi as $row) {
            if ($row['total_pertemuan'] > 0) {
                $persentase = ($row['hadir'] / $row['total_pertemuan']) * 100;
            } else {
                $persentase = 0;
            }
            $data[] = [
                'matakuliah' => $row['nama_matakuliah'],
                'persentase' => $persentase
            ];
        }

        echo json_encode($data);
    }
}
