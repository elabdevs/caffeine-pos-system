<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
		<title>Café Admin Dashboard - Analytics</title>
		<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
		<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
		<link rel="stylesheet" href="../../assets/css/styles.css">
	</head>
	<body class="bg-slate-900 bg-cover bg-center min-h-screen text-white/95" style="background-image: url('https://images.hdqwalls.com/wallpapers/dark-abstract-black-minimal-4k-q0.jpg');">
		<div class="flex h-screen">
			<?php include dirname(__DIR__, 2) . '/Views/partials/sidebar.php'; ?>
			<div class="flex-1 flex flex-col overflow-hidden">
				<header class="lg:hidden sidebar p-4 flex items-center justify-between">
					<a class="flex items-center space-x-3 text-cyan-300" href="#">
						<span class="material-symbols-outlined text-3xl">local_cafe</span>
						<h1 class="text-xl font-bold">Café</h1>
					</a>
					<button class="p-2 rounded-md hover:bg-white/10" id="mobile-menu-toggle">
					<span class="material-symbols-outlined">menu</span>
					</button>
				</header>
				<main class="flex-1 p-4 md:p-6 lg:p-8 overflow-y-auto">
					<div class="max-w-7xl mx-auto space-y-8">
						<header class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
							<div>
								<h2 class="text-3xl font-bold tracking-tight text-white">Detailed Café Analytics</h2>
								<p class="text-base text-white/60 mt-1">Deep dive into your sales, product, and staff performance.</p>
							</div>
							<div class="flex items-center gap-2 flex-wrap">
								<div class="relative">
									<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-white/40">calendar_today</span>
									<input class="form-input rounded-lg w-full sm:w-56 pl-10 pr-4 py-2 text-sm" id="date-range" placeholder="Last 30 Days" type="text"/>
								</div>
								<div class="relative">
									<select class="form-select rounded-lg appearance-none w-full sm:w-auto pl-4 pr-10 py-2 text-sm">
										<option selected="">All Locations</option>
										<option>Main Street Café</option>
										<option>Parkside Kiosk</option>
									</select>
									<span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-white/40 pointer-events-none">expand_more</span>
								</div>
								<button class="bg-cyan-500/80 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-cyan-500 transition-colors shadow-[0_4px_14px_rgba(56,189,248,0.20)] flex items-center gap-2">
								<span class="material-symbols-outlined text-base">download</span>
								<span>Export Data</span>
								</button>
							</div>
						</header>
						<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
							<div class="glassmorphism p-5 rounded-xl">
								<h3 class="text-sm font-medium text-white/60">Total Revenue</h3>
								<p class="text-3xl font-bold mt-2">$28,345.50</p>
								<p class="text-sm text-green-400 mt-1 flex items-center"><span class="material-symbols-outlined text-base mr-1">arrow_upward</span>+12.5%</p>
							</div>
							<div class="glassmorphism p-5 rounded-xl">
								<h3 class="text-sm font-medium text-white/60">Total Orders</h3>
								<p class="text-3xl font-bold mt-2">1,452</p>
								<p class="text-sm text-green-400 mt-1 flex items-center"><span class="material-symbols-outlined text-base mr-1">arrow_upward</span>+8.2%</p>
							</div>
							<div class="glassmorphism p-5 rounded-xl">
								<h3 class="text-sm font-medium text-white/60">Avg. Order Value</h3>
								<p class="text-3xl font-bold mt-2">$19.52</p>
								<p class="text-sm text-red-400 mt-1 flex items-center"><span class="material-symbols-outlined text-base mr-1">arrow_downward</span>-1.1%</p>
							</div>
							<div class="glassmorphism p-5 rounded-xl">
								<h3 class="text-sm font-medium text-white/60">Customer Return Rate</h3>
								<p class="text-3xl font-bold mt-2">68%</p>
								<p class="text-sm text-green-400 mt-1 flex items-center"><span class="material-symbols-outlined text-base mr-1">arrow_upward</span>+3.4%</p>
							</div>
						</div>
						<div class="grid grid-cols-1 xl:grid-cols-5 gap-6">
							<div class="glassmorphism p-6 rounded-2xl xl:col-span-3">
								<div class="flex justify-between items-center mb-4">
									<h3 class="text-lg font-semibold">Sales Trends</h3>
									<div class="flex items-center gap-2 text-sm">
										<button class="bg-white/10 px-3 py-1 rounded-md text-white/80 hover:bg-white/20 transition-colors">Day</button>
										<button class="bg-white/20 px-3 py-1 rounded-md text-white font-semibold">Week</button>
										<button class="bg-white/10 px-3 py-1 rounded-md text-white/80 hover:bg-white/20 transition-colors">Month</button>
									</div>
								</div>
								<div class="h-72">
									<img alt="Sales Trends Chart" class="w-full h-full object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBqGDTthT9nO5XL7G12sUcxuMpKN5y5w72Ix0Wk5R6HXM0afecsBQvw1RXApS9Ib4ysYVaq3xMvLFKHn0ARnGiWVwbH-S_7YfslOnD93mmz_WupO1F1x5jWFZa3FwiieQh5m97kBEiaP4G6WHIhE1wQn9mR6K9tE4O4mB2CZbcCH1U7VDGNv3B3lXZhocHoafpEugGl5sEDSOjIHK4x2I9fp6drTwAK8jeWqzo8gvJzMMLMUTzPfadF4_2xZcY5gyxM3UjI8YQN3Wp0"/>
								</div>
							</div>
							<div class="glassmorphism p-6 rounded-2xl xl:col-span-2">
								<h3 class="text-lg font-semibold mb-4">Hourly Sales Heatmap</h3>
								<div class="h-72">
									<img alt="Hourly Sales Heatmap" class="w-full h-full object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDzaocBC1f_4D47_SzsnO5ojEkKPCQNh8jocHE2Aeg8v-IX8JTfpWUZG-8Qat-4irrSYpqFVd5SbKe7VWTeZhrvUgI4W_OM7hgV4Jho_pUMYzXqwA9vSPjdHAN3RoRAX3_VyibGPiEMzoGiVvj_A0lyfpc3AgywSOIppRxYAWam6v9PX0wnJUkbKNOZWEtji8LH9uOhvzxf5x0YOM6UspbEROaMBEyI22t77789hC-dHh0gGOeqDVhFW4ChtYcOs6eNOCBewtgM3EyQ"/>
								</div>
							</div>
						</div>
						<div class="glassmorphism p-6 rounded-2xl">
							<h3 class="text-lg font-semibold mb-4">Detailed Breakdown</h3>
							<div class="overflow-x-auto">
								<table class="w-full text-left min-w-[800px]">
									<thead>
										<tr>
											<th class="table-header-cell">Product</th>
											<th class="table-header-cell">Category</th>
											<th class="table-header-cell">Units Sold</th>
											<th class="table-header-cell">Net Sales</th>
											<th class="table-header-cell">% of Total Sales</th>
											<th class="table-header-cell">Refunds</th>
										</tr>
									</thead>
									<tbody>
										<tr class="table-row">
											<td class="table-body-cell font-medium">Latte</td>
											<td class="table-body-cell text-white/70">Coffee</td>
											<td class="table-body-cell">452</td>
											<td class="table-body-cell">$2,486.00</td>
											<td class="table-body-cell">
												<div class="flex items-center gap-2">
													<div class="w-24 bg-white/10 rounded-full h-1.5">
														<div class="bg-cyan-400 h-1.5 rounded-full" style="width: 21%"></div>
													</div>
													<span>8.77%</span>
												</div>
											</td>
											<td class="table-body-cell text-red-400">5</td>
										</tr>
										<tr class="table-row">
											<td class="table-body-cell font-medium">Espresso</td>
											<td class="table-body-cell text-white/70">Coffee</td>
											<td class="table-body-cell">389</td>
											<td class="table-body-cell">$1,556.00</td>
											<td class="table-body-cell">
												<div class="flex items-center gap-2">
													<div class="w-24 bg-white/10 rounded-full h-1.5">
														<div class="bg-cyan-400 h-1.5 rounded-full" style="width: 15%"></div>
													</div>
													<span>5.49%</span>
												</div>
											</td>
											<td class="table-body-cell text-red-400">2</td>
										</tr>
										<tr class="table-row">
											<td class="table-body-cell font-medium">Croissant</td>
											<td class="table-body-cell text-white/70">Pastry</td>
											<td class="table-body-cell">310</td>
											<td class="table-body-cell">$1,395.00</td>
											<td class="table-body-cell">
												<div class="flex items-center gap-2">
													<div class="w-24 bg-white/10 rounded-full h-1.5">
														<div class="bg-cyan-400 h-1.5 rounded-full" style="width: 13%"></div>
													</div>
													<span>4.92%</span>
												</div>
											</td>
											<td class="table-body-cell text-red-400">8</td>
										</tr>
										<tr class="table-row">
											<td class="table-body-cell font-medium">Avocado Toast</td>
											<td class="table-body-cell text-white/70">Food</td>
											<td class="table-body-cell">255</td>
											<td class="table-body-cell">$2,805.00</td>
											<td class="table-body-cell">
												<div class="flex items-center gap-2">
													<div class="w-24 bg-white/10 rounded-full h-1.5">
														<div class="bg-cyan-400 h-1.5 rounded-full" style="width: 25%"></div>
													</div>
													<span>9.90%</span>
												</div>
											</td>
											<td class="table-body-cell text-red-400">1</td>
										</tr>
										<tr class="table-row border-b-0">
											<td class="table-body-cell font-medium">Iced Tea</td>
											<td class="table-body-cell text-white/70">Drinks</td>
											<td class="table-body-cell">180</td>
											<td class="table-body-cell">$720.00</td>
											<td class="table-body-cell">
												<div class="flex items-center gap-2">
													<div class="w-24 bg-white/10 rounded-full h-1.5">
														<div class="bg-cyan-400 h-1.5 rounded-full" style="width: 8%"></div>
													</div>
													<span>2.54%</span>
												</div>
											</td>
											<td class="table-body-cell text-red-400">0</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
							<div class="glassmorphism p-6 rounded-2xl">
								<h3 class="text-lg font-semibold mb-4">Payment Methods</h3>
								<div class="space-y-4">
									<div class="flex items-center justify-between text-sm">
										<span class="font-medium">Credit Card</span>
										<span class="text-white/70">$18,424.57 (65%)</span>
									</div>
									<div class="w-full bg-white/10 rounded-full h-2">
										<div class="bg-purple-500 h-2 rounded-full" style="width: 65%"></div>
									</div>
									<div class="flex items-center justify-between text-sm">
										<span class="font-medium">Debit Card</span>
										<span class="text-white/70">$6,802.92 (24%)</span>
									</div>
									<div class="w-full bg-white/10 rounded-full h-2">
										<div class="bg-indigo-500 h-2 rounded-full" style="width: 24%"></div>
									</div>
									<div class="flex items-center justify-between text-sm">
										<span class="font-medium">Cash</span>
										<span class="text-white/70">$2,267.64 (8%)</span>
									</div>
									<div class="w-full bg-white/10 rounded-full h-2">
										<div class="bg-teal-500 h-2 rounded-full" style="width: 8%"></div>
									</div>
									<div class="flex items-center justify-between text-sm">
										<span class="font-medium">Other</span>
										<span class="text-white/70">$850.37 (3%)</span>
									</div>
									<div class="w-full bg-white/10 rounded-full h-2">
										<div class="bg-slate-500 h-2 rounded-full" style="width: 3%"></div>
									</div>
								</div>
							</div>
							<div class="glassmorphism p-6 rounded-2xl lg:col-span-2">
								<h3 class="text-lg font-semibold mb-4">Staff Performance</h3>
								<div class="overflow-x-auto">
									<table class="w-full text-left min-w-[500px]">
										<thead>
											<tr class="border-b border-white/10">
												<th class="py-3 px-4 font-medium text-white/60 text-sm">Employee</th>
												<th class="py-3 px-4 font-medium text-white/60 text-sm">Sales</th>
												<th class="py-3 px-4 font-medium text-white/60 text-sm">Orders</th>
												<th class="py-3 px-4 font-medium text-white/60 text-sm">Avg. Sale</th>
											</tr>
										</thead>
										<tbody>
											<tr class="border-b border-white/10 hover:bg-white/5 transition-colors">
												<td class="py-3 px-4 flex items-center gap-3">
													<img alt="Jane Doe" class="w-9 h-9 rounded-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAS35e3KDeOca7Ij-hcsi5dULOmn00ftaUQHuh40y4SzxutrjgG4Y8DFldXzTrH4wIzKAHSDpfw51loC0T7RG0FGwRqzVYldZAhXTtdg3DohfyrTz7Jnu2k_Djc16KGFe-qnE3HFi3oTWnwQ0LhUmzb8j-A2_lqwQka0_vDTzDpKIko8O3leGHIc3phXIcGWTyA4FUzctKEhhrLJFExJr4gLQLcul5G_cjlzrC3Fz_8MbufFxB4UhAVyYtkbvwW1VNpy7Ir-yOUvtfQ"/>
													<div>
														<p class="font-medium text-sm">Jane Doe</p>
														<p class="text-xs text-white/60">Barista</p>
													</div>
												</td>
												<td class="py-3 px-4">$10,123.50</td>
												<td class="py-3 px-4">512</td>
												<td class="py-3 px-4">$19.77</td>
											</tr>
											<tr class="border-b border-white/10 hover:bg-white/5 transition-colors">
												<td class="py-3 px-4 flex items-center gap-3">
													<img alt="John Smith" class="w-9 h-9 rounded-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAM7OcGLAeRPP45nmHtXJ6Nc9LERCxfSbuUtUHz170F1kBMPqF6qtIZ10PmLXqxG9fMxGyB_RZHKiDL2kSr-UUMw4EpF-AN1gfMkLdfMzHyfsWdyXWJBsZ-YV7tLautsWPS7L-yZI_t6UiChJY5UWF-siqOmTnucCjstsBfoA2SNUOl3qIyySO85RZmrNsz5asIUJU170CbR4jqbr9nbb8k4b5_BjNtpklOuFCv2y1ta_mdbruLtlFt2o-nh4TQHRsNNE98A7JG6TaI"/>
													<div>
														<p class="font-medium text-sm">John Smith</p>
														<p class="text-xs text-white/60">Cashier</p>
													</div>
												</td>
												<td class="py-3 px-4">$9,854.75</td>
												<td class="py-3 px-4">501</td>
												<td class="py-3 px-4">$19.67</td>
											</tr>
											<tr class="border-b-0 hover:bg-white/5 transition-colors">
												<td class="py-3 px-4 flex items-center gap-3">
													<img alt="Emily White" class="w-9 h-9 rounded-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAUsIlEI5tXEOAReieGXUKcihS5twdRG6v6v5-339RSdCUdOcvz-eT5PDdtd8T7Jn4f6IdqYuakrv1pu9Jkk-rwW8nfxMxXiCQ0KLsQMvwQminunxcZEyEiamu2gBAiExePLx9rz1xjTsEdBTRWI6Dsrs-DUrO4nASSPp6JpjhoTG8n2IZ1_I_uUn_wpgIznUDNtssUcKTIjtvckE0S5-OAZIeW3_n9ZMsAQ-OotRFEnP24zfRDfASjS-EtNKKfA_XJkNJ_X3Yb5l_4"/>
													<div>
														<p class="font-medium text-sm">Emily White</p>
														<p class="text-xs text-white/60">Barista</p>
													</div>
												</td>
												<td class="py-3 px-4">$8,367.25</td>
												<td class="py-3 px-4">439</td>
												<td class="py-3 px-4">$19.06</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</main>
			</div>
			<div class="fixed top-0 left-0 w-full h-full sidebar p-6 flex-col z-30 hidden" id="mobile-menu">
				<div class="flex items-center justify-between mb-10">
					<a class="flex items-center space-x-3 text-cyan-300" href="#">
						<span class="material-symbols-outlined text-4xl">local_cafe</span>
						<h1 class="text-2xl font-bold">Café</h1>
					</a>
					<button class="p-2 rounded-md hover:bg-white/10" id="mobile-menu-close">
					<span class="material-symbols-outlined">close</span>
					</button>
				</div>
				<nav class="flex flex-col space-y-2 flex-grow">
					<a class="flex items-center space-x-4 p-3 rounded-lg hover:bg-white/5 transition-colors w-full text-white/70 hover:text-white" href="#" title="Dashboard">
					<span class="material-symbols-outlined">dashboard</span>
					<span class="font-medium">Dashboard</span>
					</a>
					<a class="flex items-center space-x-4 p-3 rounded-lg hover:bg-white/5 transition-colors w-full text-white/70 hover:text-white" href="#" title="Orders">
					<span class="material-symbols-outlined">receipt_long</span>
					<span class="font-medium">Orders</span>
					</a>
					<a class="flex items-center space-x-4 p-3 rounded-lg hover:bg-white/5 transition-colors w-full text-white/70 hover:text-white" href="#" title="Menu">
					<span class="material-symbols-outlined">restaurant_menu</span>
					<span class="font-medium">Menu</span>
					</a>
					<div>
						<button class="dropdown-toggle flex items-center justify-between space-x-4 p-3 rounded-lg w-full text-white/70 hover:text-white" title="Settings">
							<div class="flex items-center space-x-4">
								<span class="material-symbols-outlined">settings</span>
								<span class="font-medium">Settings</span>
							</div>
							<span class="material-symbols-outlined transition-transform">expand_more</span>
						</button>
						<div class="dropdown-content ml-4 mt-2 space-y-1">
							<a class="block p-2 pl-8 rounded-lg text-sm text-white/60 hover:bg-white/5 hover:text-white transition-colors" href="#">General</a>
							<a class="block p-2 pl-8 rounded-lg text-sm text-white/60 hover:bg-white/5 hover:text-white transition-colors" href="#">Users &amp; Roles</a>
							<a class="block p-2 pl-8 rounded-lg text-sm text-white/60 hover:bg-white/5 hover:text-white transition-colors" href="#">Hardware</a>
							<a class="block p-2 pl-8 rounded-lg text-sm text-white/60 hover:bg-white/5 hover:text-white transition-colors" href="#">Billing</a>
						</div>
					</div>
					<div>
						<button class="dropdown-toggle flex items-center justify-between space-x-4 p-3 rounded-lg bg-white/10 text-white shadow-lg w-full" title="Analytics">
							<div class="flex items-center space-x-4">
								<span class="material-symbols-outlined">analytics</span>
								<span class="font-medium">Analytics</span>
							</div>
							<span class="material-symbols-outlined transition-transform">expand_more</span>
						</button>
						<div class="dropdown-content ml-4 mt-2 space-y-1">
							<a class="block p-2 pl-8 rounded-lg text-sm bg-white/10 text-white font-semibold transition-colors" href="#">Sales Performance</a>
							<a class="block p-2 pl-8 rounded-lg text-sm text-white/60 hover:bg-white/5 hover:text-white transition-colors" href="#">Inventory Insights</a>
							<a class="block p-2 pl-8 rounded-lg text-sm text-white/60 hover:bg-white/5 hover:text-white transition-colors" href="#">Customer Behavior</a>
							<a class="block p-2 pl-8 rounded-lg text-sm text-white/60 hover:bg-white/5 hover:text-white transition-colors" href="#">Staff Performance</a>
						</div>
					</div>
				</nav>
				<div class="mt-auto">
					<a class="flex items-center space-x-4 p-3 rounded-lg hover:bg-white/5 transition-colors w-full text-white/70 hover:text-white" href="#" title="Logout">
					<span class="material-symbols-outlined">logout</span>
					<span class="font-medium">Logout</span>
					</a>
				</div>
			</div>
		</div>
		<script>
			document.addEventListener('DOMContentLoaded', () => {
			    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
			    dropdownToggles.forEach(toggle => {
			        if (toggle.title === 'Analytics' || toggle.title === 'Settings') {
			            const content = toggle.nextElementSibling;
			            if (toggle.title === 'Analytics') {
			                toggle.classList.add('open');
			                toggle.querySelector('.material-symbols-outlined:last-child').classList.add('rotate-180');
			                content.style.maxHeight = content.scrollHeight + "px";
			            }
			        }
			        toggle.addEventListener('click', () => {
			            const icon = toggle.querySelector('.material-symbols-outlined:last-child');
			            const content = toggle.nextElementSibling;
			            toggle.classList.toggle('open');
			            icon.classList.toggle('rotate-180');
			            if (content.style.maxHeight) {
			                content.style.maxHeight = null;
			            } else {
			                content.style.maxHeight = content.scrollHeight + "px";
			            }
			        });
			    });
			    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
			    const mobileMenuClose = document.getElementById('mobile-menu-close');
			    const mobileMenu = document.getElementById('mobile-menu');
			    mobileMenuToggle.addEventListener('click', () => {
			        mobileMenu.classList.remove('hidden');
			        mobileMenu.classList.add('flex');
			    });
			    mobileMenuClose.addEventListener('click', () => {
			        mobileMenu.classList.add('hidden');
			        mobileMenu.classList.remove('flex');
			    });
			});
		</script>
	</body>
</html>