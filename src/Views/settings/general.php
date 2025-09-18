<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
		<title>Café Admin Dashboard - General Settings</title>
		<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
		<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
		<link rel="stylesheet" href="../../assets/css/styles.css">
	</head>
	<body class="bg-slate-900 bg-cover bg-center min-h-screen text-white/95" style="background-image: url('https://images.hdqwalls.com/wallpapers/dark-abstract-black-minimal-4k-q0.jpg');">
		<div class="flex flex-col xl:flex-row h-screen">
			<?php include dirname(__DIR__, 2) . '/Views/partials/sidebar.php'; ?>
			<div class="flex-1 flex flex-col overflow-hidden">
				<main class="flex-1 p-4 md:p-6 overflow-y-auto">
					<div class="max-w-7xl mx-auto space-y-8">
						<header class="mb-8">
							<h2 class="text-3xl font-bold tracking-tight">General Settings</h2>
							<p class="text-base text-white/60 mt-1">Manage your café's general information and settings.</p>
						</header>
						<div class="glassmorphism p-6 md:p-8 rounded-2xl">
							<h3 class="text-xl font-semibold mb-6">Café Information</h3>
							<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
								<div class="lg:col-span-2 space-y-6">
									<div>
										<label class="block text-sm font-medium text-white/70 mb-2" for="cafe-name">Café Name</label>
										<input class="form-input w-full rounded-lg text-sm" id="cafe-name" placeholder="Enter your café name" type="text" value="The Cozy Bean"/>
									</div>
									<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
										<div>
											<label class="block text-sm font-medium text-white/70 mb-2" for="address">Address</label>
											<input class="form-input w-full rounded-lg text-sm" id="address" placeholder="e.g. 123 Coffee Lane" type="text" value="123 Coffee Lane, Brewville"/>
										</div>
										<div>
											<label class="block text-sm font-medium text-white/70 mb-2" for="phone">Phone Number</label>
											<input class="form-input w-full rounded-lg text-sm" id="phone" placeholder="e.g. +1 (555) 123-4567" type="tel" value="+1 (555) 123-4567"/>
										</div>
									</div>
								</div>
								<div class="lg:col-span-1">
									<label class="block text-sm font-medium text-white/70 mb-2">Café Logo</label>
									<div class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-white/20 rounded-lg h-full">
										<img alt="Café Logo" class="w-24 h-24 rounded-full mb-4 object-cover border-2 border-white/20" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDh1n-v2HwHq8j4eCPeT4itQejY6VBzIgqz2aFrBEshc1Hjuyvo0WgdLLKc2w8-1uNbVcMQF8VF0k30W6yJg7o9BVm3JR3wo12WLTcsnxP9Ca67YuJkC4xsloPh1mgYpUiMW-elXDhhuPxEy80JPoEZXhDmDEqJ2asu_TQaq3QrcgnEx6g1wLklxdmuoRs3L84FDzLbioX3oYwd_fKDe-mN2Chq_EItqdos3siKA75hp9BYD5jMkkWrl-VwYoalcHUSu-S4DPetPgt1"/>
										<button class="bg-cyan-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-cyan-600 transition-colors">Upload New Logo</button>
										<p class="text-xs text-white/60 mt-2">PNG, JPG up to 5MB.</p>
									</div>
								</div>
							</div>
						</div>
						<div class="glassmorphism p-6 md:p-8 rounded-2xl">
							<h3 class="text-xl font-semibold mb-6">Business Hours</h3>
							<div class="space-y-4">
								<div class="grid grid-cols-[100px,1fr,1fr,auto] items-center gap-x-4 gap-y-2">
									<label class="text-sm font-medium text-white/90">Monday</label>
									<input class="form-input rounded-lg text-sm w-full" type="time" value="08:00"/>
									<input class="form-input rounded-lg text-sm w-full" type="time" value="20:00"/>
									<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors"><span class="material-symbols-outlined">delete</span></button>
								</div>
								<div class="grid grid-cols-[100px,1fr,1fr,auto] items-center gap-x-4 gap-y-2">
									<label class="text-sm font-medium text-white/90">Tuesday</label>
									<input class="form-input rounded-lg text-sm w-full" type="time" value="08:00"/>
									<input class="form-input rounded-lg text-sm w-full" type="time" value="20:00"/>
									<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors"><span class="material-symbols-outlined">delete</span></button>
								</div>
								<div class="grid grid-cols-[100px,1fr,1fr,auto] items-center gap-x-4 gap-y-2">
									<label class="text-sm font-medium text-white/90">Wednesday</label>
									<input class="form-input rounded-lg text-sm w-full" type="time" value="08:00"/>
									<input class="form-input rounded-lg text-sm w-full" type="time" value="20:00"/>
									<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors"><span class="material-symbols-outlined">delete</span></button>
								</div>
								<div class="grid grid-cols-[100px,1fr,1fr,auto] items-center gap-x-4 gap-y-2">
									<label class="text-sm font-medium text-white/90">Thursday</label>
									<input class="form-input rounded-lg text-sm w-full" type="time" value="08:00"/>
									<input class="form-input rounded-lg text-sm w-full" type="time" value="20:00"/>
									<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors"><span class="material-symbols-outlined">delete</span></button>
								</div>
								<div class="grid grid-cols-[100px,1fr,1fr,auto] items-center gap-x-4 gap-y-2">
									<label class="text-sm font-medium text-white/90">Friday</label>
									<input class="form-input rounded-lg text-sm w-full" type="time" value="08:00"/>
									<input class="form-input rounded-lg text-sm w-full" type="time" value="22:00"/>
									<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors"><span class="material-symbols-outlined">delete</span></button>
								</div>
								<div class="grid grid-cols-[100px,1fr,1fr,auto] items-center gap-x-4 gap-y-2">
									<label class="text-sm font-medium text-white/90">Saturday</label>
									<input class="form-input rounded-lg text-sm w-full" type="time" value="09:00"/>
									<input class="form-input rounded-lg text-sm w-full" type="time" value="22:00"/>
									<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors"><span class="material-symbols-outlined">delete</span></button>
								</div>
								<div class="grid grid-cols-[100px,1fr,1fr,auto] items-center gap-x-4 gap-y-2 opacity-60">
									<label class="text-sm font-medium text-white/80">Sunday</label>
									<input class="form-input rounded-lg text-sm w-full" disabled="" type="time" value="00:00"/>
									<input class="form-input rounded-lg text-sm w-full" disabled="" type="time" value="00:00"/>
									<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors"><span class="material-symbols-outlined">delete</span></button>
								</div>
							</div>
							<button class="mt-6 bg-white/5 border border-white/10 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-white/10 transition-colors flex items-center space-x-2">
							<span class="material-symbols-outlined text-base">add</span>
							<span>Add Hours</span>
							</button>
						</div>
						<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
							<div class="glassmorphism p-6 md:p-8 rounded-2xl">
								<h3 class="text-xl font-semibold mb-6">Financials</h3>
								<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
									<div>
										<label class="block text-sm font-medium text-white/70 mb-2" for="currency">Currency</label>
										<select class="form-input rounded-lg text-sm w-full" id="currency">
											<option selected="">USD ($)</option>
											<option>EUR (€)</option>
											<option>GBP (£)</option>
											<option>JPY (¥)</option>
										</select>
									</div>
									<div>
										<label class="block text-sm font-medium text-white/70 mb-2" for="tax-rate">Tax Rate (%)</label>
										<input class="form-input w-full rounded-lg text-sm" id="tax-rate" placeholder="e.g. 8.5" step="0.01" type="number" value="8.5"/>
									</div>
									<div class="md:col-span-2">
										<label class="block text-sm font-medium text-white/70 mb-2" for="service-fee">Service Fee (%)</label>
										<input class="form-input w-full rounded-lg text-sm" id="service-fee" placeholder="e.g. 10" step="0.1" type="number" value="10"/>
									</div>
								</div>
							</div>
							<div class="glassmorphism p-6 md:p-8 rounded-2xl">
								<h3 class="text-xl font-semibold mb-6">Localization</h3>
								<div>
									<label class="block text-sm font-medium text-white/70 mb-2" for="language">Language</label>
									<select class="form-input rounded-lg text-sm w-full" id="language">
										<option selected="">English</option>
										<option>Español</option>
										<option>Français</option>
										<option>Deutsch</option>
									</select>
								</div>
							</div>
						</div>
						<div class="glassmorphism p-6 md:p-8 rounded-2xl">
							<div class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-4">
								<h3 class="text-xl font-semibold">Holiday Schedule</h3>
								<button class="bg-white/5 border border-white/10 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-white/10 transition-colors flex items-center space-x-2 self-start sm:self-center">
								<span class="material-symbols-outlined text-base">add</span>
								<span>Add Holiday</span>
								</button>
							</div>
							<div class="space-y-3">
								<div class="grid grid-cols-[1fr,1fr,auto] items-center gap-x-4 gap-y-2 p-3 rounded-lg bg-black/20">
									<input class="form-input rounded-lg text-sm" placeholder="Holiday Name" type="text" value="Christmas Day"/>
									<input class="form-input rounded-lg text-sm" type="date" value="2024-12-25"/>
									<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors">
									<span class="material-symbols-outlined text-xl">delete</span>
									</button>
								</div>
								<div class="grid grid-cols-[1fr,1fr,auto] items-center gap-x-4 gap-y-2 p-3 rounded-lg bg-black/20">
									<input class="form-input rounded-lg text-sm" placeholder="Holiday Name" type="text" value="New Year's Day"/>
									<input class="form-input rounded-lg text-sm" type="date" value="2025-01-01"/>
									<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors">
									<span class="material-symbols-outlined text-xl">delete</span>
									</button>
								</div>
							</div>
						</div>
					</div>
				</main>
				<footer class="sticky bottom-0 z-10 p-4 md:p-6 mt-auto bg-slate-900/50 backdrop-blur-sm border-t border-white/10">
					<div class="max-w-7xl mx-auto flex justify-end space-x-4">
						<button class="bg-white/10 text-white/80 px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/20 transition-colors">Cancel</button>
						<button class="bg-cyan-500 text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-cyan-600 transition-colors shadow-[0_4px_14px_rgba(56,189,248,0.25)]">Save Changes</button>
					</div>
				</footer>
			</div>
		</div>
		<script>
			const menuToggle = document.getElementById('menu-toggle');
			const navMenu = document.getElementById('nav-menu');
			menuToggle.addEventListener('click', () => {
			    const isHidden = navMenu.classList.contains('hidden');
			    if (isHidden) {
			        navMenu.classList.remove('hidden');
			        navMenu.classList.add('flex', 'flex-col', 'absolute', 'top-24', 'left-0', 'w-full', 'p-6', 'sidebar', 'z-20', 'gap-y-3');
			    } else {
			        navMenu.classList.add('hidden');
			        navMenu.classList.remove('flex', 'flex-col', 'absolute', 'top-24', 'left-0', 'w-full', 'p-6', 'sidebar', 'z-20', 'gap-y-3');
			    }
			});
			window.addEventListener('resize', () => {
			    if (window.innerWidth >= 1280) {
			        navMenu.classList.remove('absolute', 'top-24', 'left-0', 'w-full', 'p-6', 'sidebar', 'z-20', 'flex', 'flex-col');
			        navMenu.classList.add('hidden');
			    }
			});
		</script>
	</body>
</html>