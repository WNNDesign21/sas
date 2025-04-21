<!DOCTYPE html>
<html lang="id">

<?php
// Pastikan hanya dosen yang bisa mengakses halaman ini
if (strtoupper($this->session->userdata('akses')) !== 'DOSEN') {
    ?>
    <script>
        alert("Anda tidak memiliki akses ke halaman ini!");
        window.location.href = "<?= base_url('auth') ?>"; // Redirect ke halaman login
    </script>
    <?php exit; ?>
<?php } ?>
<?php if ($this->session->flashdata('error')): ?>
    <script>
        alert("<?= $this->session->flashdata('error'); ?>");
    </script>
<?php endif; ?>

<?php if ($this->session->flashdata('success')): ?>
    <script>
        alert("<?= $this->session->flashdata('success'); ?>");
    </script>
<?php endif; ?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate QR Code</title>

    <!-- SB Admin 2 Styles -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="<?= base_url('assets/css/sb-admin-2.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/sb-admin-2.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        .qr-thumbnail {
            cursor: pointer;
            transition: 0.3s;
        }

        .qr-thumbnail:hover {
            transform: scale(1.1);
        }
    </style>
</head>

<body id="page-top">
    <div class="splash-screen" id="splash">
        <img src="<?= base_url('assets/img/sas.png'); ?>" alt="Loading">
    </div>

    <!-- Page Wrapper -->
    <div id="wrapper" style="display: none;">

        <!-- Sidebar -->
        <?php $this->load->view('templates/sidebar_dosen'); ?>
        <!-- End Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div class="d-sm-flex align-items-center justify-content-between">
                <img class="left-in-fade" src="<?= base_url('assets/img/sas.png'); ?>"
                    style="height:50px; margin-top:20px; margin-left: 12%; margin-bottom: 2%" alt="">
            </div>

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6 left-in-fade">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <form method="POST" action="<?= base_url('QrController/generate') ?>">
                                        <div class="mb-3">
                                            <label class="form-label">Mata Kuliah</label>
                                            <?php
                                            $nidn = $this->session->userdata('id_user');
                                            $mata_kuliah = $this->db->query("
                                                SELECT DISTINCT mata_kuliah.id_mk, mata_kuliah.nama_mk 
                                                FROM detail_jadwal 
                                                JOIN mata_kuliah ON mata_kuliah.id_mk = detail_jadwal.id_mk 
                                                WHERE detail_jadwal.nidn = '$nidn'
                                            ")->result_array();
                                            ?>
                                            <select name="mata_kuliah" class="form-control" required>
                                                <option value="">Pilih Mata Kuliah</option>
                                                <?php foreach ($mata_kuliah as $mk): ?>
                                                    <option value="<?= $mk['id_mk'] ?>"><?= $mk['nama_mk'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Pertemuan Ke-</label>
                                            <input type="number" name="pertemuan" class="form-control" required>
                                        </div>

                                        <button type="submit" class="btn btn-primary w-100 mb-3">Generate QR
                                            Code</button>
                                        <button class="btn btn-primary w-100" onclick="toggleQRCode()">Tampilkan /
                                            Sembunyikan QR Code</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- QR Code Terbaru -->
                        <div class="col-lg-6 right-in-fade">
                            <div class="card shadow mb-4">
                                <div class="card-body text-center">
                                    <h5>QR Code Terbaru</h5>
                                    <?php
                                    $nidn = $this->session->userdata('id_user');
                                    $this->db->select('qr_codes.*');
                                    $this->db->from('qr_codes');
                                    $this->db->join('detail_jadwal', 'qr_codes.id_mk = detail_jadwal.id_mk');
                                    $this->db->where('detail_jadwal.nidn', $nidn);
                                    $this->db->order_by('qr_codes.id', 'DESC');
                                    $qr_terbaru = $this->db->get()->row_array();

                                    if ($qr_terbaru): ?>
                                        <a href="#" onclick="showQrCode('<?= base_url($qr_terbaru['qr_image']) ?>')">
                                            <img src="<?= base_url($qr_terbaru['qr_image']) ?>" width="200"
                                                class="img-fluid shadow-lg mt-3 qr-thumbnail mb-3">
                                        </a>
                                        <?php
                                        $qr_parts = explode('|', $qr_terbaru['qr_text'] ?? '');

                                        $id_mk = isset($qr_parts[0]) ? trim($qr_parts[0]) : '-';
                                        $nama_matakuliah = isset($qr_parts[1]) ? trim($qr_parts[1]) : '-';
                                        $pertemuan = isset($qr_parts[2]) ? trim($qr_parts[2]) : '-';
                                        ?>
                                        <p><strong>
                                                Kode Kelas: <?= $id_mk ?>
                                                <br>Matakuliah: <?= $nama_matakuliah ?>
                                                <br>Pertemuan :
                                                <?= $pertemuan ?></strong></p>

                                        <!-- <p><strong><?= $qr_terbaru['qr_text'] ?></strong></p> -->
                                    <?php else: ?>
                                        <p>Belum ada QR Code yang di-generate.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Tabel Daftar QR Code -->
                    <div class="card shadow mb-4" id="qrCodeContainer" style="display: none;">
                        <div class="card-body">
                            <h3 class="mb-3">Daftar QR Code</h3>

                            <!-- Filter Mata Kuliah -->
                            <form method="GET">
                                <label for="id_mk">Pilih Mata Kuliah:</label>
                                <select name="id_mk" id="id_mk" onchange="this.form.submit()"
                                    class="form-control w-50 mb-3">
                                    <option value="">-- Semua Mata Kuliah --</option>
                                    <?php
                                    // Mendapatkan nidn (user yang sedang login) dari session
                                    $nidn = $this->session->userdata('id_user'); // Sesuaikan dengan session kamu
                                    
                                    // Query untuk mendapatkan mata kuliah yang diampu oleh dosen (berdasarkan nidn)
                                    $this->db->select('mata_kuliah.id_mk, mata_kuliah.nama_mk');
                                    $this->db->from('mata_kuliah');
                                    $this->db->join('detail_jadwal', 'detail_jadwal.id_mk = mata_kuliah.id_mk');
                                    $this->db->where('detail_jadwal.nidn', $nidn); // Filter berdasarkan nidn (dosen yang login)
                                    $mata_kuliah = $this->db->get()->result(); // Dapatkan daftar mata kuliah yang diampu oleh dosen
                                    
                                    // Loop untuk menampilkan mata kuliah pada dropdown
                                    foreach ($mata_kuliah as $mk):
                                        ?>
                                        <option value="<?= $mk->id_mk ?>" <?= isset($_GET['id_mk']) && $_GET['id_mk'] == $mk->id_mk ? 'selected' : '' ?>>
                                            <?= $mk->nama_mk ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </form>

                            <!-- Tabel Daftar QR Code -->
                            <table class="table table-bordered text-center">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Mata Kuliah</th>
                                        <th>Pertemuan</th>
                                        <th>QR Code</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Mendapatkan nidn (user yang sedang login) dari session
                                    $nidn = $this->session->userdata('id_user'); // Sesuaikan dengan session kamu
                                    
                                    // Ambil id_mk dari parameter GET jika ada (filter mata kuliah)
                                    $id_mk_filter = $this->input->get('id_mk');

                                    // Query untuk mengambil daftar QR Code berdasarkan nidn (user_id yang login)
                                    $query = "
                    SELECT qr_codes.*, mata_kuliah.nama_mk 
                    FROM qr_codes 
                    JOIN mata_kuliah ON qr_codes.id_mk = mata_kuliah.id_mk
                    JOIN detail_jadwal ON detail_jadwal.id_mk = mata_kuliah.id_mk 
                    WHERE detail_jadwal.nidn = ?
                ";

                                    // Parameter query dengan nidn yang login
                                    $params = [$nidn];

                                    // Jika ada filter id_mk (mata kuliah yang dipilih), tambahkan ke query
                                    if (!empty($id_mk_filter)) {
                                        $query .= " AND qr_codes.id_mk = ?";
                                        $params[] = $id_mk_filter;
                                    }

                                    $query .= " ORDER BY qr_codes.id DESC";

                                    // Eksekusi query
                                    $qr_codes = $this->db->query($query, $params)->result_array();

                                    // Loop untuk menampilkan data QR Code
                                    foreach ($qr_codes as $qr):
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars($qr['nama_mk']) ?></td>
                                            <td>Pertemuan ke-<?= htmlspecialchars($qr['pertemuan']) ?></td>
                                            <td>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#qrModal"
                                                    onclick="showQrCode('<?= base_url($qr['qr_image']) ?>')">
                                                    <img src="<?= base_url($qr['qr_image']) ?>" width="80"
                                                        class="qr-thumbnail">
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End Content Wrapper -->

    </div>
    <!-- End Page Wrapper -->

    <!-- Modal Bootstrap -->
    <div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center w-100" id="qrModalLabel">SCAN QR UNTUK ABSEN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="qrModalImg" src="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function showQrCode(qrUrl) {
            document.getElementById('qrModalImg').src = qrUrl;
        }

        document.addEventListener("DOMContentLoaded", function () {
            setTimeout(() => {
                document.getElementById("splash").classList.add("hidden");
                setTimeout(() => {
                    document.getElementById("splash").style.display = "none";
                    document.getElementById("wrapper").style.display = "block";
                }, 500);
            }, 1000);
        });
    </script>
    <script>
        function showQrCode(qrUrl) {
            document.getElementById('qrModalImg').src = qrUrl;
            var qrModal = new bootstrap.Modal(document.getElementById('qrModal'));
            qrModal.show();
        }
    </script>
    <script>
        function toggleQRCode() {
            var qrContainer = document.getElementById("qrCodeContainer");

            if (qrContainer.style.display === "none") {
                qrContainer.style.display = "block";
            } else {
                qrContainer.style.display = "none";
            }
        }
    </script>


</body>

</html>