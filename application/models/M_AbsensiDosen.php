<?php
class M_AbsensiDosen extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_rata_kehadiran_dosen($nidn) // $nidn adalah id_user (NIDN) dosen
    {
        // 1. Dapatkan semua detail absensi untuk dosen ini
        $this->db->select('
            a.id_mk,
            mk.nama_mk,
            a.pertemuan,
            a.npm,
            u.nama_user as nama_mahasiswa,
            a.status
        ');
        $this->db->from('absensi a');
        $this->db->join('mata_kuliah mk', 'a.id_mk = mk.id_mk');
        $this->db->join('detail_jadwal dj', 'a.id_mk = dj.id_mk'); // Untuk memfilter berdasarkan NIDN dosen
        $this->db->join('user u', 'a.npm = u.id_user', 'left'); // Join ke tabel user untuk nama mahasiswa
        $this->db->where('dj.nidn', $nidn);
        $this->db->where('u.akses', 'MHS'); // Pastikan hanya mengambil user dengan akses Mahasiswa
        $this->db->order_by('a.id_mk ASC, a.pertemuan ASC, u.nama_user ASC');
        $all_absensi_details = $this->db->get()->result_array();

        if (empty($all_absensi_details)) {
            return []; // Tidak ada data untuk diproses
        }

        // 2. Dapatkan jumlah mahasiswa terdaftar per mata kuliah yang diajar dosen ini
        $this->db->select('mm.id_mk, COUNT(DISTINCT mm.npm) as total_mahasiswa_terdaftar_mk');
        $this->db->from('mhs_mk mm');
        $this->db->join('detail_jadwal dj_filter', 'mm.id_mk = dj_filter.id_mk');
        $this->db->join('user u_mhs', 'mm.npm = u_mhs.id_user'); // Pastikan npm adalah mahasiswa
        $this->db->where('dj_filter.nidn', $nidn);
        $this->db->where('u_mhs.akses', 'MHS');
        $this->db->group_by('mm.id_mk');
        $mahasiswa_terdaftar_query = $this->db->get()->result_array();
        
        $mahasiswa_terdaftar_map = [];
        foreach ($mahasiswa_terdaftar_query as $row) {
            $mahasiswa_terdaftar_map[$row['id_mk']] = (int)$row['total_mahasiswa_terdaftar_mk'];
        }

        // 3. Proses dan kelompokkan data
        $grouped_data = [];
        foreach ($all_absensi_details as $detail) {
            $id_mk = $detail['id_mk'];
            $nama_mk = $detail['nama_mk'];
            $pertemuan = (int)$detail['pertemuan'];

            // Inisialisasi struktur jika belum ada
            if (!isset($grouped_data[$id_mk])) {
                $grouped_data[$id_mk] = [
                    'nama_mk' => $nama_mk,
                    'pertemuan_data' => []
                ];
            }
            if (!isset($grouped_data[$id_mk]['pertemuan_data'][$pertemuan])) {
                $total_mahasiswa_di_mk = $mahasiswa_terdaftar_map[$id_mk] ?? 0;
                $grouped_data[$id_mk]['pertemuan_data'][$pertemuan] = [
                    'jumlah_hadir' => 0,
                    'total_mahasiswa_di_mk' => $total_mahasiswa_di_mk,
                    'persentase_kehadiran' => 0, // Akan dihitung nanti
                    'detail_mahasiswa' => []
                ];
            }

            // Tambahkan detail mahasiswa
            $grouped_data[$id_mk]['pertemuan_data'][$pertemuan]['detail_mahasiswa'][] = [
                'npm' => $detail['npm'],
                'nama_mahasiswa' => $detail['nama_mahasiswa'] ?? $detail['npm'], // Fallback ke NPM jika nama null
                'status' => $detail['status']
            ];

            // Hitung jumlah hadir
            if (strtolower($detail['status']) == 'hadir') {
                $grouped_data[$id_mk]['pertemuan_data'][$pertemuan]['jumlah_hadir']++;
            }
        }

        // 4. Hitung persentase
        foreach ($grouped_data as $id_mk => &$mk_data) { // Gunakan reference (&) untuk modifikasi langsung
            foreach ($mk_data['pertemuan_data'] as $no_pertemuan => &$p_data) { // Gunakan reference
                $persentase = 0;
                if ($p_data['total_mahasiswa_di_mk'] > 0) {
                    $persentase = ($p_data['jumlah_hadir'] / $p_data['total_mahasiswa_di_mk']) * 100;
                }
                $p_data['persentase_kehadiran'] = round($persentase, 2);
            }
        }
        unset($mk_data); // Hapus reference
        unset($p_data);  // Hapus reference

        return $grouped_data; // Kirim data yang sudah dikelompokkan dan dihitung persentasenya
    }
}
?>