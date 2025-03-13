<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_attendance extends CI_Model {
    public function save_attendance($course, $session, $qr_path) {
        $data = [
            'course' => $course,
            'session' => $session,
            'qr_code' => $qr_path
        ];
        $this->db->insert('attendance', $data);
    }
}
?>