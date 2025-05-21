<?php if ($this->session->userdata('akses') !== 'MHS'): ?>
    <script>
        alert("Anda tidak memiliki akses ke halaman ini!");
        window.location.href = "<?= base_url('logout') ?>"; // Redirect ke halaman utama
    </script>
    <?php exit; ?>
<?php endif; ?>