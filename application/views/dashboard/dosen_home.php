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
        window.location.href = "<?= base_url('auth') ?>"; // Redirect ke halaman utama
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
</body>

</html>