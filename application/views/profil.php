<!DOCTYPE html>
<html lang="id">
<?php $this->load->view('templates/akses'); ?>

<head>
    <?php $this->load->view('templates/header'); ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
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
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" id="totalAbsensiText">95%</div>
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
                        <div class="card">
                            <div class="card-header">
                                <ul class="nav nav-tabs card-header-tabs" id="profilTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="idcard-tab" data-toggle="tab" href="#id-card"
                                            role="tab" aria-controls="idcard" aria-selected="true">ID Card</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="foto-tab" data-toggle="tab" href="#foto" role="tab"
                                            aria-controls="foto" aria-selected="false">Ganti Foto</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="password-tab" data-toggle="tab" href="#password"
                                            role="tab" aria-controls="password" aria-selected="false">Ubah Password</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content" id="profilTabsContent">
                                <div class="id-card tab-pane fade show active" id="id-card" role="tabpanel"
                                    aria-labelledby="idcard-tab">
                                    <div class="glass-card buttom-in-fade">
                                        <img src="<?= base_url($this->session->userdata('foto_profil') ?: 'assets/foto_profil/hu.jpg'); ?>"
                                            alt="Foto Profil" class="profile-img">
                                        <h4 class="text-muted"> <?= $this->session->userdata('nama_user'); ?></h4>
                                        <p class="text-muted"><strong>NPM:</strong>
                                            <?= $this->session->userdata('id_user'); ?></p>
                                        <p class="text-muted"><strong>FAKULTAS</strong> - <?= $this->session->userdata('fakultas'); ?></p>
                                        <p class="text-muted"><strong>Program Studi</strong> - <?= $this->session->userdata('prodi'); ?>
                                        </p>
                                        <p class="text-muted"><strong>Angkatan:</strong> 2023</p>
                                        <h6 class="text-muted"><strong>UNIVERSITAS HORIZON INDONESIA</strong></h>
                                    </div>
                                </div>
                                <!-- Tab 2: Ganti Foto -->
                                <div class="id-card tab-pane fade justify-content-center" id="foto" role="tabpanel"
                                    aria-labelledby="foto-tab">
                                    <?php echo form_open_multipart('Setting/upload_foto', ['id' => 'form-upload-foto']); ?>
                                    <div class="glass-card buttom-in-fade">
                                        <div class="form-group text-center mb-3">
                                            <label>Foto Profil Saat Ini:</label><br>
                                            <img id="current-foto"
                                                src="<?= base_url($this->session->userdata('foto_profil') ?: 'assets/foto_profil/hu.jpg'); ?>"
                                                alt="Foto Profil" class="img-thumbnail no-bg" width="150" height="150"
                                                style="object-fit: cover; border:none; border-radius: 8px;">
                                        </div>

                                        <div class="form-group text-center">
                                            <label for="foto_profil" class="btn btn-primary btn-lg"
                                                style="width: 100%; max-width: 400px; cursor: pointer;">
                                                <i class="fas fa-upload"></i> Pilih Foto Baru
                                            </label>
                                            <input type="file" id="foto_profil" name="foto" accept="image/*" required
                                                style="display: none;">
                                            <small class="form-text text-muted mt-1">Ukuran maksimal 2MB, format JPG,
                                                JPEG,
                                                PNG.</small>
                                            <div id="file-name" class="mt-2 text-info"></div>
                                        </div>


                                        <div class="form-group text-center mt-3">
                                            <img id="preview-foto" src="#" alt="Preview Foto Baru"
                                                class="img-thumbnail rounded-circle d-none" width="150" height="150"
                                                style="object-fit: cover;">
                                        </div>

                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-primary" id="btn-submit-foto"
                                                disabled>Simpan Foto Profil</button>
                                        </div>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>


                                <!-- Tab 3: Ubah Password -->
                                <div class="id-card tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                                    <div class="glass-card buttom-in-fade">
                                        <form action="<?= base_url('Setting/update_password') ?>" method="post">
                                            <div class="form-group-floating">
                                                <i class="fas fa-lock"></i>
                                                <input type="password" name="old_password"
                                                    class="form-control glow-input" required placeholder=" ">
                                                <label>Password Lama</label>
                                            </div>
                                            <div class="form-group-floating">
                                                <i class="fas fa-key"></i>
                                                <input type="password" name="new_password"
                                                    class="form-control glow-input" required placeholder=" ">
                                                <label>Password Baru</label>
                                            </div>
                                            <div class="form-group-floating">
                                                <i class="fas fa-shield-alt"></i>
                                                <input type="password" name="confirm_password"
                                                    class="form-control glow-input" required placeholder=" ">
                                                <label>Konfirmasi Password Baru</label>
                                            </div>
                                            <div class="text-center mt-4">
                                                <button type="submit" class="btn btn-futuristic">🔐 Ubah
                                                    Password</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->load->view('jadwal'); ?>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if ($this->session->flashdata('message')): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "<?php echo $this->session->flashdata('message'); ?>",
                confirmButtonText: 'OK'
            });
        </script>
    <?php elseif ($this->session->flashdata('error')): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: "<?php echo $this->session->flashdata('error'); ?>",
                confirmButtonText: 'OK'
            });
        </script>
    <?php endif; ?>
    <script>
        $(document).ready(function () {
            // Update custom file input label
            $('#foto_profil').on('change', function () {
                const fileInput = this;
                const file = fileInput.files[0];
                const label = $(this).next('.custom-file-label');
                const submitBtn = $('#btn-submit-foto');
                const preview = $('#preview-foto');

                if (file) {
                    label.text(file.name);

                    // Validate file size (max 2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        Swal.fire({
                            icon: 'error',
                            title: 'File Terlalu Besar',
                            text: 'Ukuran file maksimal adalah 2MB.',
                        });
                        fileInput.value = "";
                        label.text('Pilih file...');
                        preview.attr('src', '#').addClass('d-none');
                        submitBtn.prop('disabled', true);
                        return;
                    }

                    // Preview the image
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.attr('src', e.target.result).removeClass('d-none');
                    }
                    reader.readAsDataURL(file);

                    // Enable submit button
                    submitBtn.prop('disabled', false);
                } else {
                    label.text('Pilih file...');
                    preview.attr('src', '#').addClass('d-none');
                    submitBtn.prop('disabled', true);
                }
            });
        });
    </script>

</body>

</html>