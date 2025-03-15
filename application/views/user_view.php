<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
</head>

<body class="container mt-4">

    <h2 class="mb-4">Tambah User</h2>

    <form id="addUserForm">
        <div class="mb-3">
            <label class="form-label">Pilih Tipe User</label>
            <select id="user_type" name="user_type" class="form-control" required>
                <option value="">Pilih Tipe User</option>
                <option value="mahasiswa">Mahasiswa</option>
                <option value="dosen">Dosen</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Pilih User</label>
            <select id="name" name="name" class="form-control" required>
                <option value="">Pilih User</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">NPM/NIDN</label>
            <input type="text" name="userId" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Akses</label>
            <select name="akses" id="akses" class="form-control" required>
                <option value="">Pilih Akses</option>
                <option value="MHS">Mahasiswa</option>
                <option value="Dosen">Dosen</option>
                <option value="Admin">Admin</option>
            </select>
        </div>


        <button type="submit" class="btn btn-primary w-100">Tambah User</button>
    </form>

    <script>
        $(document).ready(function () {
            $('#user_type').change(function () {
                var userType = $(this).val();
                $('#name').html('<option value="">Loading...</option>');

                $.ajax({
                    url: '<?= base_url("UserController/getMahasiswa") ?>',
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        console.log("Data dari server:", data); // Debugging
                        var options = '<option value="">Pilih User</option>';
                        if (userType === 'mahasiswa') { // Mahasiswa
                            data.mahasiswa.forEach(function (m) {
                                options += `<option value="${m.npm}" data-npm="${m.npm}">${m.nama}</option>`;
                            });
                        } else if (userType === 'dosen') { // Dosen
                            data.dosen.forEach(function (d) {
                                options += `<option value="${d.nama_dosen}" data-npm="${d.nidn}">${d.nama_dosen}</option>`;
                            });
                        }
                        $('#name').html(options); // Perbarui dropdown
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                        $('#name').html('<option value="">Gagal Memuat Data</option>');
                    }
                });
            });

            // Ketika user dipilih, otomatis isi field NPM/NIDN
            $('#name').change(function () {
                var selectedNPM = $(this).find(':selected').data('npm');
                $('input[name="userId"]').val(selectedNPM); // Isi field username dengan NPM/NIDN
            });

            $('#addUserForm').submit(function (e) {
                e.preventDefault();
                $.ajax({
                    url: '<?= base_url("UserController/addUser") ?>',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            alert('User berhasil ditambahkan!');
                            location.reload();
                        } else {
                            alert('Gagal menambahkan user!');
                        }
                    }
                });
            });
        });

    </script>

</body>

</html>