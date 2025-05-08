<?php
defined('BASEPATH') or exit('No direct script access allowed');

class QrController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('session');
        $this->load->model('QrModel'); // Pastikan model diload
        $this->load->database(); // Pastikan database diload di controller
        $this->load->library('ciqrcode'); // Pastikan ini ada
        // Cek apakah user sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login'); // Redirect ke halaman login jika belum login
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
    
        // Cek apakah QR Code sudah ada
        $cek_qr = $this->db->get_where('qr_codes', [
            'id_mk' => $id_mk,
            'pertemuan' => $pertemuan
        ])->row_array();
    
        if ($cek_qr) {
            $this->session->set_flashdata('error', 'QR Code untuk pertemuan ini sudah dibuat sebelumnya!');
            redirect('QrController');
            return;
        }
        
    
        // Ambil data jam mulai dan jam selesai dari database
        $this->load->model('M_Detail_Jadwal');
        $jadwal = $this->M_Detail_Jadwal->get_jadwal_by_mk($id_mk);
    
        if ($jadwal === null) {
            // Gunakan output untuk mengirimkan response JSON
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Jadwal untuk mata kuliah ini tidak ditemukan.'
                ]));
            return;
        }
    
        // Ambil hari dan jam mulai dan jam selesai dari database
        $hari_ini = date('l');
        $jam_mulai = $jadwal->jam_mulai;
        $jam_selesai = $jadwal->jam_selesai;
    
        // Waktu sekarang
        $waktu_sekarang = date("H:i");
        
        if ($hari_ini != $jadwal->hari) {
            $this->session->set_flashdata('error', 'QR Code hanya dapat di-generate pada hari ' . $jadwal->hari);
            redirect('QrController');
            // echo json_encode([
            //     'status' => false,
            //     'message' => "Mata kuliah ini hanya bisa dimulai pada hari $jadwal->hari"
            // ]);
            return;
        }
        
    
        // Cek apakah waktu sekarang berada dalam rentang yang valid
        if (strtotime($waktu_sekarang) < strtotime($jam_mulai) || strtotime($waktu_sekarang) > strtotime($jam_selesai)) {
            $this->session->set_flashdata('error', 'QR Code hanya dapat di-generate antara jam ' . $jam_mulai . ' dan ' . $jam_selesai);
            redirect('QrController');
            return;
        }
             
    
        $mk = $this->QrModel->getMataKuliahById($id_mk);
        $qr_text = $id_mk . " | " . $mk['nama_mk'] . " | " . $pertemuan;
    
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
    
        // Tambahkan absensi "tidak hadir" untuk semua mahasiswa
        $mahasiswa = $this->db->get_where('mhs_mk', ['id_mk' => $id_mk])->result();
    
        foreach ($mahasiswa as $mhs) {
            $insert_data = [
                'id_mk' => $id_mk,
                'npm' => $mhs->npm,
                'tanggal' => date('Y-m-d'),
                'pertemuan' => $pertemuan,
                'status' => 'tidak hadir'
            ];
            $this->db->insert('absensi', $insert_data);
        }
    
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
    public function attendance()
    {
        // Ambil NIDN dari session
        $nidn = $this->session->userdata('id_user');

        // Pastikan user yang login adalah dosen
        if ($this->session->userdata('akses') !== 'DOSEN') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman ini.');
            redirect('auth');
            exit;
        }

        // Load model jika belum dimuat
        $this->load->model('M_attendance');

        // Ambil jadwal berdasarkan NIDN dosen yang login
        $data['detail_jadwal'] = $this->M_attendance->getJadwalByDosen($nidn);
        $data['qr_codes'] = $this->M_attendance->getQrByDosen($nidn);

        // Load tampilan dengan data yang sudah difilter
        $this->load->view('attendance_view', $data);
    }
    public function getMataKuliah() {
        if ($this->input->is_ajax_request()) {
            $nidn = $this->session->userdata('id_user'); // Ambil nidn dari session

            // Ambil mata kuliah berdasarkan nidn yang sedang login
            $mata_kuliah = $this->MataKuliahModel->getMataKuliahByNidn($nidn);

            // Kirimkan data mata kuliah dalam format JSON
            echo json_encode($mata_kuliah);
            exit;
        }
    }
}
?>