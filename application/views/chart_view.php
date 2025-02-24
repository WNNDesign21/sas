<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Kehadiran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Grafik Kehadiran Per Mata Kuliah</h2>
        <canvas id="myChart"></canvas>
    </div>

    <script>
        fetch("<?= base_url('chart/getData') ?>")
        .then(response => response.json())
        .then(data => {
            let mataKuliah = data.map(item => item.nama_matkul);
            let persentase = data.map(item => item.persentase);

            let ctx = document.getElementById('myChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: mataKuliah,
                    datasets: [{
                        label: 'Persentase Kehadiran (%)',
                        data: persentase,
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true, max: 100 }
                    }
                }
            });
        })
        .catch(error => console.error('Error:', error));
    </script>
</body>
</html>
