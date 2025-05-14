<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_dosen extends CI_Controller {
    public function index() {
        $nidn = $this->session->userdata('id_user');

        // Ambil semua jadwal dosen
        $this->load->model('Chart_model');
        $data['chart'] = $this->Chart_model->getPersentaseKehadiran($nidn);

        $this->load->view('home_dosen', $data);
    }
}
