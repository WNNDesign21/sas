<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DbTest extends CI_Controller {
    public function index() {
        $query = $this->db->query("SELECT DATABASE() as db");
        $result = $query->row();
        echo "Koneksi berhasil ke database: " . $result->db;
    }
}