<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
		<title>Yönetici Paneli - Liquid Glass</title>
		<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
		<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
		<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
		<link rel="stylesheet" href="../assets/css/styles.css">
	</head>
	<body class="bg-cover bg-center min-h-screen text-white" style="background-image: url('https://images.hdqwalls.com/wallpapers/dark-abstract-black-minimal-4k-q0.jpg');">
		<div class="flex flex-col xl:flex-row h-screen">
            <?php include($sidebar); ?>
			<div class="flex-1 flex flex-col overflow-hidden">
				<?php include($header); ?>
				<main class="flex-1 p-4 lg:p-6 overflow-y-auto">
					<div class="grid grid-cols-1 sm:grid-cols-2 2xl:grid-cols-4 gap-6">
						<div class="widget glassmorphism p-6 flex flex-col justify-between">
							<div>
								<div class="flex justify-between items-center">
									<p class="text-lg font-semibold text-white/80">Toplam Gelir</p>
									<span class="material-symbols-outlined text-cyan-300">attach_money</span>
								</div>
								<p class="text-3xl lg:text-4xl font-bold mt-2">$45,231.89</p>
							</div>
							<p class="text-sm text-green-400 flex items-center mt-2">
								<span class="material-symbols-outlined text-base mr-1">arrow_upward</span> +20.1% from last month
							</p>
						</div>
						<div class="widget glassmorphism p-6 flex flex-col justify-between">
							<div>
								<div class="flex justify-between items-center">
									<p class="text-lg font-semibold text-white/80">Abonelikler</p>
									<span class="material-symbols-outlined text-purple-300">subscriptions</span>
								</div>
								<p class="text-3xl lg:text-4xl font-bold mt-2">+2,350</p>
							</div>
							<p class="text-sm text-green-400 flex items-center mt-2">
								<span class="material-symbols-outlined text-base mr-1">arrow_upward</span> +180.1% from last month
							</p>
						</div>
						<div class="widget glassmorphism p-6 flex flex-col justify-between">
							<div>
								<div class="flex justify-between items-center">
									<p class="text-lg font-semibold text-white/80">Satışlar</p>
									<span class="material-symbols-outlined text-pink-300">shopping_cart</span>
								</div>
								<p class="text-3xl lg:text-4xl font-bold mt-2">+12,234</p>
							</div>
							<p class="text-sm text-green-400 flex items-center mt-2">
								<span class="material-symbols-outlined text-base mr-1">arrow_upward</span> +19% from last month
							</p>
						</div>
						<div class="widget glassmorphism p-6 flex flex-col justify-between">
							<div>
								<div class="flex justify-between items-center">
									<p class="text-lg font-semibold text-white/80">Şu Anda Aktif</p>
									<span class="material-symbols-outlined text-amber-300">electric_bolt</span>
								</div>
								<p class="text-3xl lg:text-4xl font-bold mt-2">+573</p>
							</div>
							<p class="text-sm text-red-400 flex items-center mt-2">
								<span class="material-symbols-outlined text-base mr-1">arrow_downward</span> -2.8% from yesterday
							</p>
						</div>
						<div class="widget glassmorphism p-6 sm:col-span-2 2xl:col-span-2">
							<p class="text-lg font-semibold mb-4">Zamana Göre Gelir</p>
							<div class="h-64 sm:h-72 lg:h-80">
								<canvas id="revenueChart"></canvas>
							</div>
						</div>
						<div class="widget glassmorphism p-6 sm:col-span-2 2xl:col-span-2">
							<p class="text-lg font-semibold mb-4">Bölgelere Göre Satış</p>
							<div class="h-64 sm:h-72 lg:h-80 flex justify-center items-center">
								<canvas id="salesChart"></canvas>
							</div>
						</div>
						<div class="widget glassmorphism p-6 col-span-1 sm:col-span-2 2xl:col-span-4">
							<p class="text-lg font-semibold mb-4">Son İşlemler</p>
							<div class="overflow-x-auto">
								<table class="w-full text-left min-w-[600px]">
									<thead>
										<tr class="text-white/80 border-b border-white/20">
											<th class="p-3 font-semibold">Fatura No</th>
											<th class="p-3 font-semibold">Müşteri</th>
											<th class="p-3 font-semibold">Tarih</th>
											<th class="p-3 font-semibold">Tutar</th>
											<th class="p-3 font-semibold">Durum</th>
										</tr>
									</thead>
									<tbody>
										<tr class="border-b border-white/10">
											<td class="p-3">INV-00123</td>
											<td class="p-3">Liam Johnson</td>
											<td class="p-3">2024-04-01</td>
											<td class="p-3">$250.00</td>
											<td class="p-3"><span class="bg-green-500/30 text-green-300 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">Ödendi</span></td>
										</tr>
										<tr class="border-b border-white/10">
											<td class="p-3">INV-00122</td>
											<td class="p-3">Olivia Smith</td>
											<td class="p-3">2024-03-30</td>
											<td class="p-3">$150.00</td>
											<td class="p-3"><span class="bg-blue-500/30 text-blue-300 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">Gönderildi</span></td>
										</tr>
										<tr class="border-b border-white/10">
											<td class="p-3">INV-00121</td>
											<td class="p-3">Noah Williams</td>
											<td class="p-3">2024-03-29</td>
											<td class="p-3">$350.00</td>
											<td class="p-3"><span class="bg-yellow-500/30 text-yellow-300 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">Beklemede</span></td>
										</tr>
										<tr>
											<td class="p-3">INV-00120</td>
											<td class="p-3">Emma Brown</td>
											<td class="p-3">2024-03-28</td>
											<td class="p-3">$450.00</td>
											<td class="p-3"><span class="bg-red-500/30 text-red-300 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">İptal Edildi</span></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</main>
			</div>
		</div>
		<script>
			// Toggle mobile menu
			const menuToggle = document.getElementById('menu-toggle');
			const navMenu = document.getElementById('nav-menu');
			menuToggle.addEventListener('click', () => {
			    navMenu.classList.toggle('hidden');
			});
			// Mock data for charts
			const revenueData = {
			    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
			    datasets: [{
			        label: 'Revenue',
			        data: [12000, 19000, 30000, 25000, 22000, 38000, 41000],
			        borderColor: 'rgba(56, 189, 248, 0.8)',
			        backgroundColor: 'rgba(56, 189, 248, 0.2)',
			        fill: true,
			        tension: 0.4,
			        pointBackgroundColor: 'rgba(56, 189, 248, 1)',
			        pointBorderColor: '#fff',
			        pointHoverRadius: 7,
			        pointHoverBackgroundColor: '#fff',
			        pointHoverBorderColor: 'rgba(56, 189, 248, 1)',
			    }]
			};
			const salesData = {
			    labels: ['North America', 'Europe', 'Asia', 'South America', 'Africa'],
			    datasets: [{
			        label: 'Sales by Region',
			        data: [3500, 2500, 1500, 1000, 500],
			        backgroundColor: [
			            'rgba(56, 189, 248, 0.7)',
			            'rgba(167, 139, 250, 0.7)',
			            'rgba(244, 114, 182, 0.7)',
			            'rgba(251, 191, 36, 0.7)',
			            'rgba(52, 211, 153, 0.7)',
			        ],
			        borderColor: [
			            'rgba(56, 189, 248, 1)',
			            'rgba(167, 139, 250, 1)',
			            'rgba(244, 114, 182, 1)',
			            'rgba(251, 191, 36, 1)',
			            'rgba(52, 211, 153, 1)',
			        ],
			        borderWidth: 1,
			        hoverOffset: 10
			    }]
			};
			// Chart.js configuration
			const chartOptions = (isLineChart = true) => ({
			    maintainAspectRatio: false,
			    responsive: true,
			    plugins: {
			        legend: {
			            display: isLineChart ? false : true,
			            position: 'bottom',
			            labels: {
			                color: 'rgba(255, 255, 255, 0.8)',
			                padding: 20,
			                font: {
			                    size: 14
			                }
			            }
			        },
			        tooltip: {
			            backgroundColor: 'rgba(0, 0, 0, 0.7)',
			            titleFont: {
			                size: 14
			            },
			            bodyFont: {
			                size: 12
			            },
			            padding: 10,
			            cornerRadius: 8,
			            displayColors: false,
			        }
			    },
			    scales: isLineChart ? {
			        x: {
			            ticks: {
			                color: 'rgba(255, 255, 255, 0.7)'
			            },
			            grid: {
			                color: 'rgba(255, 255, 255, 0.1)'
			            }
			        },
			        y: {
			            ticks: {
			                color: 'rgba(255, 255, 255, 0.7)'
			            },
			            grid: {
			                color: 'rgba(255, 255, 255, 0.1)'
			            }
			        }
			    } : {}
			});
			// Render Charts
			const revenueCtx = document.getElementById('revenueChart').getContext('2d');
			new Chart(revenueCtx, {
			    type: 'line',
			    data: revenueData,
			    options: chartOptions()
			});
			const salesCtx = document.getElementById('salesChart').getContext('2d');
			new Chart(salesCtx, {
			    type: 'doughnut',
			    data: salesData,
			    options: chartOptions(false)
			});
		</script>
	</body>
</html>