<!DOCTYPE html>
<html lang="id">
<?php if ($this->session->userdata('akses') !== 'DOSEN'): ?>
    <script>
        alert("Anda tidak memiliki akses ke halaman ini!");
        window.location.href = "<?= base_url('auth') ?>"; // Redirect ke halaman utama
    </script>
<?php exit; ?>
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
        <img src="assets/img/sas.png" alt="Loading">
    </div>
    <!-- Page Wrapper -->
    <div id="wrapper" style="display: none;">

        <!-- Sidebar -->
        <?php $this->load->view('sidebar'); ?>
        <!-- End Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div class="d-sm-flex align-items-center justify-content-between">
                <!-- <h1 class="h3 mb-0 text-gray-800">SAS - Smart Attendance Student</h1> -->
                <img class="left-in-fade" src="<?= base_url('assets/img/sas.png'); ?>"
                    style="height:50px; margin-top:20px; margin-left: 12%; margin-bottom: 2%" alt="">
            </div>

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <form method="POST" action="<?= base_url('QrController/generate') ?>">
                                        <div class="mb-3">
                                            <label class="form-label">Mata Kuliah</label>
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

                                        <button type="submit" class="btn btn-primary w-100">Generate QR Code</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Daftar QR Code -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <h3 class="mb-3">Daftar QR Code</h3>
                            <table class="table table-bordered text-center">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Mata Kuliah</th>
                                        <th>Pertemuan</th>
                                        <th>QR Code</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($this->db->order_by('id', 'DESC')->get('qr_codes')->result_array() as $qr): ?>
                                        <tr>
                                            <td><?= $this->db->get_where('mata_kuliah', ['id_mk' => $qr['id_mk']])->row()->nama_mk ?>
                                            </td>
                                            <td><?= $qr['pertemuan'] ?></td>
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
    <!-- JavaScript untuk Menampilkan QR Code di Modal -->
    <script>
        function showQrCode(qrUrl) {
            document.getElementById('qrModalImg').src = qrUrl;
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            setTimeout(() => {
                document.getElementById("splash").classList.add("hidden");
                setTimeout(() => {
                    document.getElementById("splash").style.display = "none";
                    document.getElementById("wrapper").style.display = "block";
                }, 500);
            }, 1000); // Splash screen will be visible for 2 seconds
        });
    </script>
</body>

</html>