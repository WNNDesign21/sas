<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class check_gd extends CI_Controller {
    public function index() {
        echo "<pre>";
        var_dump(gd_info());
        echo "</pre>";
    }
}
