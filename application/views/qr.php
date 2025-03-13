<!DOCTYPE html>
<html>
<head>
    <title>Generate QR Attendance</title>
</head>
<body>
    <?php echo form_open('attendance/generate_qr'); ?>
        <label>Nama Mata Kuliah:</label>
        <input type="text" name="course" required>
        <label>Pertemuan Ke-:</label>
        <input type="number" name="session" required>
        <button type="submit">Generate QR Code</button>
    <?php echo form_close(); ?>
    
    <?php if (!empty($qr_path)): ?>
        <h3>QR Code:</h3>
        <img src="<?php echo $qr_path; ?>" alt="QR Code">
    <?php endif; ?>
</body>
</html>