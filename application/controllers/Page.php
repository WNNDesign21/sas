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
}
