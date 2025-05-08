<!DOCTYPE html>
<html lang="id">
<?php
if (!$this->session->userdata('logged_in')) {
    redirect('auth');
    exit;
}
?>
<?php if ($this->session->userdata('akses') !== 'ADMIN'): ?>
    <script>
        alert("Anda tidak memiliki akses ke halaman ini!");
        window.location.href = "<?= base_url('logout') ?>"; // Redirect ke halaman utama
    </script>
<?php exit; ?>
<?php endif; ?>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Panel User</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <?php $this->load->view('templates/header'); ?>
</head>
<body class="container my-4">
     <!-- Floating Sidebar -->
     <?php $this->load->view('templates/sidebar_baak'); ?>
        <!-- Floating Sidebar -->

<h2>KELOLA AKUN</h2>

<!-- RINGKASAN -->
<div class="row text-white mb-4">
  <div class="col-md-3">
    <div class="bg-primary p-3 rounded">Total User: <span id="totalUser">0</span></div>
  </div>
  <div class="col-md-3">
    <div class="bg-success p-3 rounded">Mahasiswa: <span id="totalMahasiswa">0</span></div>
  </div>
  <div class="col-md-3">
    <div class="bg-info p-3 rounded">Dosen: <span id="totalDosen">0</span></div>
  </div>
  <div class="col-md-3">
    <div class="bg-warning p-3 rounded">BAAK: <span id="totalBaak">0</span></div>
  </div>
</div>

<!-- HEADER DAN TOMBOL -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
    Tambah User
</button>

<!-- FILTER DAN SEARCH -->
<div class="row mb-3">
  <div class="col-md-4">
    <select id="filterTipe" class="form-select">
      <option value="semua">Semua Tipe</option>
      <option value="Mahasiswa">Mahasiswa</option>
      <option value="Dosen">Dosen</option>
      <option value="Baak">BAAK</option>
    </select>
  </div>
  <div class="col-md-4">
    <input type="text" id="searchInput" class="form-control" placeholder="Cari Nama atau ID User" />
  </div>
</div>

<!-- TABEL USER -->
<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>ID</th>
        <th>Tipe</th>
        <th>Akses</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody id="userTable">
      <tr><td colspan="6" class="text-center">Loading...</td></tr>
    </tbody>
  </table>
</div>

<!-- PAGINASI -->
<div class="d-flex justify-content-between mb-5">
  <button class="btn btn-secondary" id="prevPage">Sebelumnya</button>
  <button class="btn btn-secondary" id="nextPage">Berikutnya</button>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addUserModalLabel">Tambah User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addUserForm">
            <div class="mb-3">
                <label class="form-label">Pilih Tipe User</label>
                <select id="user_type" name="user_type" class="form-control" required>
                    <option value="">Pilih Tipe User</option>
                    <option value="Mahasiswa">Mahasiswa</option>
                    <option value="Dosen">Dosen</option>
                    <option value="Baak">Baak</option>
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
                <input type="text" name="userId" class="form-control" placeholder="Masukkan NPM Anda" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukan Password Anda" required>
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
      </div>
    </div>
  </div>
</div>

<!-- SCRIPT -->
<script>
  let allUsers = [];
  let currentPage = 1;
  const pageSize = 10;

  function renderStats() {
    $('#totalUser').text(allUsers.length);
    $('#totalMahasiswa').text(allUsers.filter(u => u.tipe === 'Mahasiswa').length);
    $('#totalDosen').text(allUsers.filter(u => u.tipe === 'Dosen').length);
    $('#totalBaak').text(allUsers.filter(u => u.tipe === 'Baak').length);
  }

  function renderTable(data) {
    let table = '';
    const start = (currentPage - 1) * pageSize;
    const pagedData = data.slice(start, start + pageSize);

    if (pagedData.length === 0) {
      table = `<tr><td colspan="6" class="text-center">Tidak ada data</td></tr>`;
    } else {
      pagedData.forEach((u, index) => {
        table += `
          <tr>
            <td>${start + index + 1}</td>
            <td>${u.nama}</td>
            <td>${u.id}</td>
            <td>${u.tipe}</td>
            <td>${u.akses}</td>
            <td>
              <button class="btn btn-sm btn-warning" onclick="editUser('${u.id}')">Edit</button>
              <button class="btn btn-sm btn-danger" onclick="hapusUser('${u.id}')">Hapus</button>
            </td>
          </tr>`;
      });
    }

    $('#userTable').html(table);
  }

  function filterAndSearch() {
    const tipe = $('#filterTipe').val();
    const search = $('#searchInput').val().toLowerCase();

    let filtered = allUsers.filter(u => {
      const matchTipe = tipe === 'semua' || u.tipe === tipe;
      const matchSearch = u.nama.toLowerCase().includes(search) || u.id.toLowerCase().includes(search);
      return matchTipe && matchSearch;
    });

    renderTable(filtered);
  }

  function loadUsers() {
    $.ajax({
      url: '<?= base_url("UserController/getUser") ?>',
      method: 'GET',
      dataType: 'json',
      success: function (res) {
        allUsers = [];

        res.user.forEach(m => {
          allUsers.push({ nama: m.nama_user, id: m.id_user, tipe: m.tipe , akses: m.akses });
        });

        renderStats();
        filterAndSearch();
      }
    });
  }

  function hapusUser(id) {
  if (confirm('Yakin ingin menghapus user ini?')) {
    $.ajax({
      url: '<?= base_url("UserController/deleteUser") ?>',
      type: 'POST',
      data: { id: id },
      dataType: 'json',
      success: function (response) {
        if (response.status === 'success') {
          alert('User berhasil dihapus!');
          // Refresh data di client
          allUsers = allUsers.filter(u => u.id !== id);
          renderStats();
          filterAndSearch();
        } else {
          alert('Gagal menghapus user!');
        }
      },
      error: function () {
        alert('Terjadi kesalahan saat menghapus user.');
      }
    });
  }
}


  function editUser(id) {
    alert('Fitur edit user belum diimplementasikan.');
  }

  $(document).ready(function () {
    loadUsers();

    $('#filterTipe, #searchInput').on('input change', function () {
      currentPage = 1;
      filterAndSearch();
    });

    $('#nextPage').click(function () {
      const totalPages = Math.ceil(allUsers.length / pageSize);
      if (currentPage < totalPages) {
        currentPage++;
        filterAndSearch();
      }
    });

    $('#prevPage').click(function () {
      if (currentPage > 1) {
        currentPage--;
        filterAndSearch();
      }
    });
  });

// Script Tambah User
$(document).ready(function () {
    $('#user_type').change(function () {
        var userType = $(this).val();
        $('#name').html('<option value="">Loading...</option>');
        $('input[name="password"]').val('');
        $('#userId').val(''); // Reset field NPM/NIDN saat tipe user berubah

        $.ajax({
            url: '<?= base_url("UserController/getMahasiswa") ?>',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                console.log("Data dari server:", data); // Debugging
                var options = '<option value="">Pilih User</option>';
                if (userType === 'Mahasiswa') { // Mahasiswa
                    data.mahasiswa.forEach(function (m) {
                        options += `<option value="${m.npm}" data-npm="${m.npm}">${m.nama}</option>`;
                    });
                } else if (userType === 'Dosen') { // Dosen
                    data.dosen.forEach(function (d) {
                        options += `<option value="${d.nama_dosen}" data-npm="${d.nidn}">${d.nama_dosen}</option>`;
                    });
                } else if (userType === 'Baak') { // Baak
                    data.baak.forEach(function (b) {
                        options += `<option value="${b.nama}" data-npm="${b.id_baak}">${b.nama}</option>`;
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
        var selectedName = $(this).val();
        
        // Cek apakah user sudah terdaftar
        var userExists = allUsers.some(function(user) {
            return user.id === selectedNPM;
        });

        if (userExists) {
            alert('User sudah terdaftar');
            $('#addUserForm')[0].reset(); // Reset form
            $('#name').html('<option value="">Pilih User</option>'); // Reset dropdown
        } else {
            $('input[name="userId"]').val(selectedNPM); // Isi field username dengan NPM/NIDN
        }
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
                    location.reload(); // Reload halaman
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
