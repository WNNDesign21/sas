<!DOCTYPE html>
<html>
<head>
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
<body class="bg-light">
    <div class="container py-5">
        <h3><?= $title; ?></h3>

        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
        <?php elseif($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Ganti Foto Profil</div>
                    <div class="card-body">
                        <?php echo form_open_multipart('setting/upload_foto'); ?>
                            <div class="form-group">
                                <label>Foto Profil Saat Ini:</label><br>
                                <img src="<?= base_url($user['foto_profil'] ?: 'assets/foto_profil/default.png'); ?>" alt="Foto Profil" class="img-thumbnail" width="150">
                                <small class="form-text text-muted">Ukuran maksimal 2MB, format JPG, JPEG, PNG.</small>
                            </div>
                            <div class="form-group">
                                <label for="foto_profil">Pilih Foto Baru:</label>
                                <input type="file" class="form-control-file" id="foto_profil" name="foto_profil" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Foto Profil</button>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
            </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>