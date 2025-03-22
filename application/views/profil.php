<!DOCTYPE html>
<html lang="id">

<head>
    <?php $this->load->view('templates/header'); ?>
</head>

<body>
    <!-- sidebar -->
    <?php $this->load->view('templates/sidebar'); ?>
    <div id="wrapper">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between">
                <!-- <h1 class="h3 mb-0 text-gray-800">SAS - Smart Attendance Student</h1> -->
                <img class="left-in-fade" src="<?= base_url('assets/img/sas.png'); ?>"
                    style="height:50px; margin-top:20px; margin-left: 8%; margin-bottom: 2%;" alt="">
            </div>
            <!-- Content Row -->
            <div class="row justify-content-end right-in-fade">
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        NAMA</div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        <?= $this->session->userdata('nama_user'); ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        FAKULTAS / PRODI</div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">
                                        <?= $this->session->userdata('fakultas'); ?> /
                                        <?= $this->session->userdata('prodi'); ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-2 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">TOTAL ABSENSI
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">95%</div>
                                        </div>
                                        <div class="col">
                                            <div class="progress progress-sm mr-2">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-lightbulb fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Content Row -->
            <div class="row">
                <!-- Card for Image -->
                <div class="col-xl-4 col-lg-7 d-flex justify-content-center align-items-center">
                    <div class="card bg-transparent border-0 shadow-none mb-0">
                        <!-- Card Header - Dropdown -->
                        <div
                            class="card-header bg-transparent border-0 py-3 d-flex flex-row align-items-center justify-content-center">
                        </div>
                        <!-- Card Body / Image Place -->
                        <div class="card-body-img d-flex justify-content-center align-items-center">
                            <img src="<?= base_url($this->session->userdata('foto_profil') ?: 'assets/foto_profil/hu.jpg'); ?>"
                                alt="Deskripsi gambar" width="320" class="zoom-in-fade" style="margin-top">
                        </div>
                    </div>
                </div>
                <!-- Area Card for Chart -->
                <div class="col-xl-8 col-lg-7 right-in-fade">
                    <div class="card shadow mb-4">
                        <div class="id-card">
                            <img src="assets/foto_profil/profil_4337855201230085.jpg" alt="Foto Profil"
                                class="profile-img">
                            <h4 class="fw-bold"> WENDI NUGRAHA NURRAHMANSYAH</h4>
                            <p class="text-muted"><strong>NPM:</strong> 4337855201230085</p>
                            <p><strong>FAKULTAS</strong> - FICT</p>
                            <p><strong>Program Studi</strong> - S1 INFORMATIKA</p>
                            <p><strong>Angkatan:</strong> 2023</p>
                            <h6><strong>UNIVERSITAS HORIZON INDONESIA</strong></h>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="assets/js/sb-admin-2.min.js"></script>
    <!-- Page level plugins -->
    <script src="assets/vendor/chart.js/Chart.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="assets/js/demo/chart-area-demo.js"></script>
    <script src="assets/js/demo/chart-pie-demo.js"></script>
    <script src="assets/vendor/chart.js/a_chart.js"></script>
</body>

</html>