document.addEventListener("DOMContentLoaded", function () {
	let chartInstance = null; // Deklarasi variabel global untuk menyimpan instance chart

	fetch(base_url + "auth/get_chart_data")
		.then((response) => response.json())
		.then((data) => {
			if (!data || data.length === 0) {
				console.error("Data tidak valid untuk ditampilkan.");
				return;
			}

			let labels = data.map((item) => `${item.matakuliah}`);
			let values = data.map((item) => parseFloat(item.persentase));

			console.log("Labels:", labels);
			console.log("Values:", values);

			const ctx = document.getElementById("absensiChart1").getContext("2d");

			// Jika chartInstance sudah ada, hancurkan dulu sebelum membuat baru
			if (chartInstance) {
				chartInstance.destroy();
			}

			// Buat chart baru
			chartInstance = new Chart(ctx, {
				type: "line",
				data: {
					labels: labels,
					datasets: [
						{
							label: "Persentase Kehadiran",
							data: values,
							backgroundColor: "rgba(54, 162, 235, 0)",
							borderColor: "rgba(54, 162, 235, 1)",
							borderWidth: 3,
						},
					],
				},
				options: {
					responsive: true,
					maintainAspectRatio: false,
					scales: {
						yAxes: [
							{
								ticks: {
									beginAtZero: true, // Memastikan skala Y mulai dari 0%
									min: 0, // Menetapkan batas bawah sumbu Y ke 0
									max: 100,
									maxTicksLimit: 15,
									padding: 10,
									stepSize: 20,
									// Format angka dengan tanda persen
									callback: function (value) {
										return value + "%";
									},
								},
							},
						],
					},
				},
				plugins: {
					legend: {
						display: true,
					},
					tooltip: {
						callbacks: {
							label: function (tooltipItem) {
								return tooltipItem.raw.toFixed(2) + "%";
							},
						},
					},
				},
			});
		})
		.catch((error) => console.error("Error fetching chart data:", error));
});
