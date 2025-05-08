<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {
	public function index() {
        // Menampilkan halaman tables.php
        $this->load->view('login');
	}
	public function home() {
        // Menampilkan halaman tables.php
        $this->load->view('dashboard/home');
	}
	public function dosen_home() {
        // Menampilkan halaman tables.php
        $this->load->view('dashboard/dosen_home');
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
}
