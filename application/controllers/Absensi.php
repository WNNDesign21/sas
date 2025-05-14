<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Absensi');
        $this->load->model('M_chartdosen');
        $this->load->library('session');

        // Cek apakah user sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $id_user = $this->session->userdata('id_user'); // Ambil ID mahasiswa yang login
        $data['absensi'] = $this->M_Absensi->get_absensi_by_mahasiswa($id_user);
        
        $this->load->view('absensi_view', $data);
    }

    public function get_chart_data()
    {
        $id_user = $this->session->userdata('id_user');
        $data = $this->M_Absensi->get_absensi_by_mahasiswa($id_user);

        echo json_encode($data);
    }

    public function kehadiran_chart() {
        // Asumsikan id_user disimpan di sesi dengan nama 'user_id' setelah login
        $id_user = $this->session->userdata('id_user');

        // Pastikan id_user ada dalam sesi
        if (!$id_user) {
            // Redirect ke halaman login atau tampilkan pesan error
            redirect('auth/login'); // Contoh redirect
            return;
        }

        $data['kehadiran'] = $this->M_chartdosen->get_rata_kehadiran_dosen($id_user);
        $this->load->view('dosen_home', $data);
    }
}
