<?php
defined('BASEPATH') or exit('No direct script access allowed');

class QrController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('QrModel'); // Pastikan model diload
        $this->load->database(); // Pastikan database diload di controller
        $this->load->library('ciqrcode'); // Pastikan ini ada
        // Cek apakah user sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('AuthController/login'); // Redirect ke halaman login jika belum login
        }

        // Cek apakah user memiliki akses sebagai Dosen
        if ($this->session->userdata('akses') !== 'DOSEN') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
    }

    public function index()
    {
        $data['mata_kuliah'] = $this->QrModel->getAllMataKuliah();
        $this->load->view('qr_generate', $data);
    }
    public function generate()
    {
        $id_mk = $this->input->post('mata_kuliah');
        $pertemuan = $this->input->post('pertemuan');

        $mk = $this->QrModel->getMataKuliahById($id_mk);
        $qr_text = "Mata Kuliah: " . $mk['nama_mk'] . " | Pertemuan: " . $pertemuan;

        $filename = 'qr_' . time() . '.png';
        $filepath = 'uploads/qrcodes/' . $filename;

        $params['data'] = $qr_text;
        $params['level'] = 'H';
        $params['size'] = 10;
        $params['savename'] = FCPATH . $filepath;
        $this->ciqrcode->generate($params);
        $this->addLogoToQRCode(FCPATH . $filepath, FCPATH . 'uploads/logo.png');

        $data = [
            'id_mk' => $id_mk,
            'pertemuan' => $pertemuan,
            'qr_text' => $qr_text,
            'qr_image' => $filepath
        ];
        $this->QrModel->saveQrCode($data);

        redirect('QrController');
    }

    private function addLogoToQRCode($qr_path, $logo_path)
    {
        // Cek apakah file logo tersedia
        if (!file_exists($logo_path)) {
            return;
        }

        // Load gambar QR Code
        $qr_image = imagecreatefrompng($qr_path);
        $logo_image = imagecreatefrompng($logo_path);

        // Aktifkan mode alpha blending untuk menjaga transparansi
        imagealphablending($logo_image, true);
        imagesavealpha($logo_image, true);

        // Dapatkan ukuran QR Code
        $qr_width = imagesx($qr_image);
        $qr_height = imagesy($qr_image);

        // Dapatkan ukuran logo
        $logo_width = imagesx($logo_image);
        $logo_height = imagesy($logo_image);

        // Tentukan ukuran baru logo (20% dari QR Code)
        $new_logo_width = $qr_width * 0.2;
        $new_logo_height = ($logo_height / $logo_width) * $new_logo_width;

        // Tentukan posisi untuk menempatkan logo di tengah
        $pos_x = ($qr_width - $new_logo_width) / 2;
        $pos_y = ($qr_height - $new_logo_height) / 2;

        // Resize logo tanpa kehilangan transparansi
        $resized_logo = imagecreatetruecolor($new_logo_width, $new_logo_height);
        imagesavealpha($resized_logo, true);
        $transparent = imagecolorallocatealpha($resized_logo, 0, 0, 0, 127);
        imagefill($resized_logo, 0, 0, $transparent);
        imagecopyresampled($resized_logo, $logo_image, 0, 0, 0, 0, $new_logo_width, $new_logo_height, $logo_width, $logo_height);

        // Gabungkan logo dengan QR Code menggunakan transparansi
        $this->imagecopymerge_alpha($qr_image, $resized_logo, $pos_x, $pos_y, 0, 0, $new_logo_width, $new_logo_height, 100);

        // Simpan kembali QR Code dengan logo
        imagesavealpha($qr_image, true);
        imagepng($qr_image, $qr_path);

        // Hapus gambar dari memori
        imagedestroy($qr_image);
        imagedestroy($logo_image);
        imagedestroy($resized_logo);
    }
    private function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct)
    {
        $cut = imagecreatetruecolor($src_w, $src_h);
        imagesavealpha($cut, true);
        $trans = imagecolorallocatealpha($cut, 0, 0, 0, 127);
        imagefill($cut, 0, 0, $trans);
        imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
        imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
        imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
    }
}
?>