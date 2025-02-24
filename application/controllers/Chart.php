<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('M_absensi');
        if (!$this->session->userdata('npm')) {
            redirect('auth/login'); // Redirect jika belum login
        }
    }

    public function index() {
        $this->load->view('chart_view');
    }

    public function getData() {
        $npm = $this->session->userdata('npm');
        $data = $this->Absensi_model->get_kehadiran_by_mahasiswa($id_mahasiswa);
        echo json_encode($data);
    }
}
