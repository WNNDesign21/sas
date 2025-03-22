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
                                    FAKULTAS</div>
                                <div class="h6 mb-0 font-weight-bold text-gray-800">
                                    <?= $this->session->userdata('fakultas_dosen'); ?>
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
                    <!-- Card Header for Chart & Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Absensi</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Dropdown Header:</div>
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body for Chart -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="absensiChart1"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">
                <!-- Jadwal -->
                <?php $this->load->view('jadwal'); ?>
                <!-- Jadwal -->

            </div>
        </div>
    </div>
</div>