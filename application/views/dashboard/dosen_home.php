<!DOCTYPE html>
<html lang="en">
<?php
if (!$this->session->userdata('logged_in')) {
    redirect('auth');
    exit;
}
?>
<?php if ($this->session->userdata('akses') !== 'DOSEN'): ?>
    <script>
        alert("Anda tidak memiliki akses ke halaman ini!");
        window.location.href = "<?= base_url('logout') ?>"; // Redirect ke halaman utama
    </script>
    <?php exit; ?>
<?php endif; ?>

<head>
    <?php $this->load->view('templates/header'); ?>
</head>

<body id="page-top" class="bg-white">
    <!-- Splash Screen -->
    <div class="splash-screen" id="splash">
        <img src="assets/img/sas.png" alt="Loading">
    </div>
    <div id="main-content" style="display: none;">
        <!-- Floating Sidebar -->
        <?php $this->load->view('templates/sidebar_dosen'); ?>
        <!-- Floating Sidebar -->

        <!-- Content -->
        <?php $this->load->view('konten_dosen'); ?>
        <!-- Content -->

        <!-- Footer -->
        <?php $this->load->view('templates/footer'); ?>
        <!-- Footer -->
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?= base_url('Auth/logout'); ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>
     <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/js/sb-admin-2.min.js') ?>"></script>
    <!-- Page level plugins -->
    <script src="<?= base_url('assets/vendor/chart.js/Chart.min.js') ?>"></script>
    <!-- Page level custom scripts -->
    <script src="<?= base_url('assets/js/demo/chart-area-demo.js') ?>"></script>
    <script src="<?= base_url('assets/js/demo/chart-pie-demo.js') ?>"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            setTimeout(() => {
                document.getElementById("splash").classList.add("hidden");
                setTimeout(() => {
                    document.getElementById("splash").style.display = "none";
                    document.getElementById("main-content").style.display = "block";
                }, 500);
            }, 1000); // Splash screen will be visible for 2 seconds
        });
    </script>
    <script>
    // Data $kehadiran sekarang adalah objek yang dikelompokkan berdasarkan id_mk
    // Setiap id_mk memiliki nama_mk dan objek pertemuan_data
    // pertemuan_data memiliki kunci nomor pertemuan, dan setiap pertemuan memiliki persentase & detail_mahasiswa
    let allKehadiranDataByMk = null;
    try {
        allKehadiranDataByMk = <?php echo json_encode($kehadiran); ?>;
        console.log('Data Kehadiran Mentah:', allKehadiranDataByMk);
    } catch (e) {
        console.error('Error parsing data kehadiran JSON:', e);
        allKehadiranDataByMk = {}; // Inisialisasi sebagai objek kosong jika ada error
    }

    // Dapatkan elemen kontainer tempat chart akan ditambahkan
    const chartContainer = document.getElementById('kehadiranChartContainer'); 
    console.log('Chart Container Element:', chartContainer);
    chartContainer.innerHTML = ''; // Kosongkan kontainer jika ada isi sebelumnya

    // Buat div baru untuk menampung chart secara horizontal dan memungkinkan scroll
    const chartsHorizontalContainer = document.createElement('div');
    chartsHorizontalContainer.style.display = 'flex';
    chartsHorizontalContainer.style.flexDirection = 'row';
    chartsHorizontalContainer.style.overflowX = 'auto'; // Aktifkan scroll horizontal
    chartsHorizontalContainer.style.overflowY = 'hidden'; // Sembunyikan scroll vertikal jika ada
    chartsHorizontalContainer.style.paddingBottom = '15px'; // Beri ruang untuk scrollbar jika muncul
    chartsHorizontalContainer.style.width = '100%'; // Pastikan mengambil lebar penuh dari parent
    chartContainer.appendChild(chartsHorizontalContainer); // Tambahkan ke kontainer utama

    if (Object.keys(allKehadiranDataByMk).length === 0) {
        chartsHorizontalContainer.innerHTML = '<p class="text-center w-100">Tidak ada data kehadiran untuk ditampilkan.</p>'; // Pesan di dalam scroller
        console.log('Tidak ada data kehadiran untuk ditampilkan.');
    } else {
        // Buat chart untuk setiap mata kuliah
        for (const id_mk in allKehadiranDataByMk) {
            if (allKehadiranDataByMk.hasOwnProperty(id_mk)) {
                const mkInfo = allKehadiranDataByMk[id_mk];
                const nama_mk = mkInfo.nama_mk;
                const pertemuanDataMap = mkInfo.pertemuan_data; // Ini objek: { '1': data_p1, '2': data_p2 }
                console.log(`Processing MK: ${nama_mk} (ID: ${id_mk})`, mkInfo);

                // Urutkan kunci pertemuan (nomor pertemuan) secara numerik
                const pertemuanKeys = Object.keys(pertemuanDataMap).sort((a, b) => parseInt(a) - parseInt(b));

                // Buat elemen div untuk setiap chart (opsional, untuk styling)
                const chartWrapper = document.createElement('div');
                // chartWrapper.className = 'mb-5'; // Dihapus karena sekarang horizontal
                chartWrapper.style.minWidth = '650px'; // Lebar minimum untuk setiap chart
                chartWrapper.style.marginRight = '20px'; // Jarak antar chart
                chartWrapper.style.flexShrink = '0'; // Mencegah chart menyusut

                // Buat judul untuk chart
                const chartTitle = document.createElement('h5');
                chartTitle.className = 'text-center mt-4 text-primary font-weight-bold';
                chartTitle.textContent = 'Persentase Kehadiran - ' + nama_mk;
                
                // Buat elemen canvas baru untuk setiap chart
                const newCanvas = document.createElement('canvas');
                newCanvas.id = 'chart-' + id_mk;
                // newCanvas.height = 150; // Anda bisa set tinggi spesifik jika mau

                chartWrapper.appendChild(chartTitle);
                chartWrapper.appendChild(newCanvas);
                chartsHorizontalContainer.appendChild(chartWrapper); // Tambahkan ke scroller horizontal

                const ctx = newCanvas.getContext('2d');
                const labels = pertemuanKeys.map(pKey => 'P-' + pKey); // Label: P-1, P-2, dst.
                const persentaseValues = pertemuanKeys.map(pKey => pertemuanDataMap[pKey].persentase_kehadiran);

                try {
                    // Simpan instance chart ke dalam variabel
                    const currentChart = new Chart(ctx, { 
                        type: 'bar', 
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Kehadiran (%)',
                                data: persentaseValues,
                                backgroundColor: 'rgba(78, 115, 223, 0.7)', 
                                borderColor: 'rgba(78, 115, 223, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: { // Awal dari objek options
                            responsive: true,
                            maintainAspectRatio: true, 
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    max: 100, 
                                    title: {
                                        display: true,
                                        text: 'Persentase Kehadiran (%)'
                                    },
                                    ticks: {
                                        callback: function(value) {
                                            return value + "%";
                                        }
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Pertemuan Ke-'
                                    }
                                }
                            }, // Akhir scales
                            onClick: (evt, elements) => { // Signature disederhanakan, kita akan pakai 'currentChart' dari closure
                                console.log('Chart clicked!', evt, elements); // DEBUG: Cek apakah klik terdeteksi
                                
                                // Gunakan instance chart yang ditangkap dari scope luar (currentChart)
                                if (!currentChart) {
                                    console.error('Instance chart (currentChart) tidak terdefinisi!');
                                    return;
                                }
                                if (!currentChart.data) {
                                    console.error('currentChart.data tidak terdefinisi!', currentChart);
                                    return;
                                }

                                if (elements.length > 0) {
                                    const firstPoint = elements[0];
                                    console.log('Clicked element:', firstPoint); // DEBUG: Lihat elemen yang diklik
                                    const clickedLabel = currentChart.data.labels[firstPoint._index]; // Gunakan _index
                                    const pertemuanKe = parseInt(clickedLabel.replace('P-', ''));
                                    console.log(`Clicked Label: ${clickedLabel}, Pertemuan Ke: ${pertemuanKe}`); // DEBUG

                                    // nama_mk dan pertemuanDataMap tersedia dari scope loop for...in
                                    if (pertemuanDataMap && pertemuanDataMap[pertemuanKe]) {
                                        const detailMahasiswaList = pertemuanDataMap[pertemuanKe].detail_mahasiswa;
                                        console.log('Detail Mahasiswa untuk Popup:', detailMahasiswaList); // DEBUG
                                        tampilkanPopupDetail(nama_mk, pertemuanKe, detailMahasiswaList);
                                    } else {
                                        console.error('Data pertemuan tidak ditemukan untuk popup:', nama_mk, 'Pertemuan:', pertemuanKe);
                                        console.log('Isi pertemuanDataMap:', pertemuanDataMap); // DEBUG
                                    }
                                } else {
                                    console.log('Klik pada chart, tapi tidak ada elemen (batang/titik) yang terdeteksi.'); // DEBUG
                                }
                            }
                        } // Akhir options
                    }); // akhir new Chart
                } catch (chartError) {
                    console.error(`Gagal membuat chart untuk MK: ${nama_mk} (ID: ${id_mk})`, chartError);
                    // Anda bisa menambahkan pesan error ke chartWrapper jika mau
                    chartWrapper.innerHTML = `<p class="text-center text-danger">Gagal memuat grafik untuk ${nama_mk}.</p>`;
                }
            } // akhir if hasOwnProperty
        } // akhir for loop
    } // akhir else

    function tampilkanPopupDetail(namaMk, pertemuanKe, detailMahasiswaList) {
        console.log('Fungsi tampilkanPopupDetail dipanggil dengan:', namaMk, pertemuanKe, detailMahasiswaList); // DEBUG
        document.getElementById('modalMkNama').textContent = namaMk;
        document.getElementById('modalPertemuanKe').textContent = 'Pertemuan Ke-' + pertemuanKe;

        const listHadir = document.getElementById('listMahasiswaHadir');
        const listTidakHadir = document.getElementById('listMahasiswaTidakHadir');
        listHadir.innerHTML = ''; // Kosongkan list sebelum diisi
        listTidakHadir.innerHTML = ''; // Kosongkan list sebelum diisi

        if (!detailMahasiswaList || detailMahasiswaList.length === 0) {
            const noDataItem = document.createElement('li');
            noDataItem.className = 'list-group-item';
            noDataItem.textContent = 'Tidak ada data detail mahasiswa untuk pertemuan ini.';
            listHadir.appendChild(noDataItem.cloneNode(true));
            listTidakHadir.appendChild(noDataItem);
        } else {
            detailMahasiswaList.forEach(mhs => {
                const listItem = document.createElement('li');
                listItem.className = 'list-group-item';
                listItem.textContent = `${mhs.nama_mahasiswa} (${mhs.npm})`;

                if (mhs.status && mhs.status.toLowerCase() === 'hadir') {
                    listHadir.appendChild(listItem);
                } else {
                    listTidakHadir.appendChild(listItem);
                }
            });
        }

        if (listHadir.children.length === 0) listHadir.innerHTML = '<li class="list-group-item">Tidak ada mahasiswa hadir.</li>';
        if (listTidakHadir.children.length === 0) listTidakHadir.innerHTML = '<li class="list-group-item">Tidak ada mahasiswa yang tercatat tidak hadir.</li>';

        try {
            $('#detailKehadiranModal').modal('show');
            console.log('Modal seharusnya tampil.'); // DEBUG
        } catch (modalError) {
            console.error('Error saat menampilkan modal:', modalError); // DEBUG
        }
    }
</script>

<!-- Modal Detail Kehadiran -->
<div class="modal fade" id="detailKehadiranModal" tabindex="-1" aria-labelledby="detailKehadiranModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailKehadiranModalLabel">Detail Kehadiran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6 id="modalMkNama" class="font-weight-bold text-primary">Nama Mata Kuliah</h6>
        <p id="modalPertemuanKe" class="mb-3">Pertemuan Ke-X</p>
        <div class="row">
          <div class="col-md-6">
            <h6>Mahasiswa Hadir:</h6>
            <ul id="listMahasiswaHadir" class="list-group mb-3">
              <!-- Item akan diisi oleh JavaScript -->
            </ul>
          </div>
          <div class="col-md-6">
            <h6>Mahasiswa Tidak Hadir:</h6>
            <ul id="listMahasiswaTidakHadir" class="list-group mb-3">
              <!-- Item akan diisi oleh JavaScript -->
            </ul>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

</body>

</html>