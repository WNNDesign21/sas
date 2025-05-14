<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session'); // Pastikan session di-load
        $this->load->helper('url');      // Pastikan url helper di-load
        // Anda bisa mempertimbangkan untuk autoload M_AbsensiDosen jika sering dipakai
        // $this->load->model('M_AbsensiDosen');
    }

	public function index() {
        // Menampilkan halaman tables.php
        $this->load->view('login');
	}
	public function home() {
        // Menampilkan halaman tables.php
        $this->load->view('dashboard/home');
	}
	public function dosen_home() {
        // Cek apakah user sudah login dan memiliki role dosen
        if (!$this->session->userdata('logged_in') || $this->session->userdata('akses') != 'DOSEN') {
            redirect('auth'); // Redirect ke halaman login jika tidak login atau bukan dosen
            return;
        }
        $id_user = $this->session->userdata('id_user');
        if (!$id_user) {
            redirect('auth'); // Redirect jika tidak ada id_user di sesi
            return;
        }
        $this->load->model('M_AbsensiDosen'); // Load model yang dibutuhkan
        $data['kehadiran'] = $this->M_AbsensiDosen->get_rata_kehadiran_dosen($id_user);
        $this->load->view('dashboard/dosen_home', $data); // Kirim data $kehadiran ke view
	}
	public function baak_home() {
        // Menampilkan halaman tables.php
        $this->load->view('dashboard/baak_home');
	}
	public function profil() {
        // Menampilkan halaman tables.php
        $this->load->view('profil');
	}
	public function profil_dosen() {
        // Menampilkan halaman tables.php
        $this->load->view('profil_dosen');
	}
	public function setting() {
        // Menampilkan halaman tables.php
        $this->load->view('setting');
	}
	public function test() {
        // Menampilkan halaman tables.php
        $this->load->view('test');
	}
}
