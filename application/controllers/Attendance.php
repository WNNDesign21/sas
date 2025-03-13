<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('M_attendance');
        $this->load->helper(['url', 'form']);
        $this->load->library(['ciqrcode']);
    }

    public function index() {
        $this->load->view('qr');
    }

    public function generate_qr() {
        $course = $this->input->post('course');
        $session = $this->input->post('session');

        if ($course && $session) {
            $attendanceInfo = [
                'course' => $course,
                'session' => $session,
                'timestamp' => date('Y-m-d H:i:s'),
            ];

            $qrData = json_encode($attendanceInfo);
            $this->load->library('ciqrcode');
            $filePath = 'uploads/qrcodes/' . time() . '.png';
            
            $params['data'] = $qrData;
            $params['level'] = 'H';
            $params['size'] = 10;
            $params['savename'] = FCPATH . $filePath;
            $this->ciqrcode->generate($params);
            
            // Simpan ke database
            $this->Attendance_model->save_attendance($course, $session, $filePath);
            
            $data['qr_path'] = base_url($filePath);
            $this->load->view('qr', $data);
        }
    }
}
?>
