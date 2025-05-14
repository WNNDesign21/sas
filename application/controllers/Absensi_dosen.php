<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absensi_dosen extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_AbsensiDosen'); // Load model yang baru
        $this->load->library('session');

        // Cek apakah user sudah login dan memiliki role dosen (opsional)
        if (!$this->session->userdata('logged_in') || $this->session->userdata('akses') != 'DOSEN') {
            redirect('auth'); // Redirect ke halaman login jika tidak login atau bukan dosen
        }
    }

    public function kehadiran_chart()
    {
        $id_user = $this->session->userdata('id_user');

        if (!$id_user) {
            redirect('auth'); // Redirect jika tidak ada id_user di sesi
            return;
        }

        $data['kehadiran'] = $this->M_AbsensiDosen->get_rata_kehadiran_dosen($id_user);
        $this->load->view('dashboard/dosen_home', $data); // Asumsi chart ditampilkan di dosen_home
    }
}
?>