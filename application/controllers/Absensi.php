<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Absensi');
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
}
