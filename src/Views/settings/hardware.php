<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Café Admin Dashboard - Hardware Settings</title>
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
<div class="max-w-7xl mx-auto space-y-8 pb-24">
<header class="mb-8">
<h2 class="text-3xl font-bold tracking-tight">Hardware Settings</h2>
<p class="text-base text-white/60 mt-1">Manage connected printers, scanners, and terminals.</p>
</header>
<div class="glassmorphism p-6 md:p-8 rounded-2xl">
<h3 class="text-xl font-semibold mb-6">Printers</h3>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
<div class="bg-white/5 p-6 rounded-xl border border-white/10">
<div class="flex justify-between items-start">
<div>
<h4 class="text-lg font-semibold">Receipt Printer</h4>
<div class="flex items-center mt-1">
<div class="w-3 h-3 rounded-full bg-green-500 mr-2 shadow-[0_0_8px_rgba(34,197,94,0.7)]"></div>
<span class="text-sm text-green-400">Connected</span>
</div>
</div>
<span class="material-symbols-outlined text-4xl text-white/50">print</span>
</div>
<div class="mt-6 space-y-4">
<div>
<label class="block text-sm font-medium text-white/70 mb-1" for="receipt-printer-model">Model</label>
<select class="form-select rounded-lg w-full" id="receipt-printer-model">
<option>Star TSP100</option>
<option>Epson TM-T88VI</option>
</select>
</div>
<div class="flex items-center justify-between pt-2">
<button class="bg-white/10 text-white/80 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-white/20 transition-colors">Test Print</button>
<div class="flex items-center space-x-2">
<input checked="" class="form-radio bg-white/10 border-white/20 text-cyan-500 focus:ring-cyan-500" id="default-receipt" name="default-printer" type="radio"/>
<label class="text-sm text-white/70" for="default-receipt">Set as Default</label>
</div>
</div>
</div>
</div>
<div class="bg-white/5 p-6 rounded-xl border border-white/10">
<div class="flex justify-between items-start">
<div>
<h4 class="text-lg font-semibold">Kitchen Printer</h4>
<div class="flex items-center mt-1">
<div class="w-3 h-3 rounded-full bg-red-500 mr-2 shadow-[0_0_8px_rgba(239,68,68,0.7)]"></div>
<span class="text-sm text-red-400">Disconnected</span>
</div>
</div>
<span class="material-symbols-outlined text-4xl text-white/50">print</span>
</div>
<div class="mt-6 space-y-4">
<div>
<label class="block text-sm font-medium text-white/70 mb-1" for="kitchen-printer-model">Model</label>
<select class="form-select rounded-lg w-full" id="kitchen-printer-model">
<option>Epson TM-U220B</option>
<option>Bixolon SRP-275III</option>
</select>
</div>
<div class="flex items-center justify-between pt-2">
<button class="bg-white/10 text-white/80 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-white/20 transition-colors">Reconnect</button>
<div class="flex items-center space-x-2">
<input class="form-radio bg-white/10 border-white/20 text-cyan-500 focus:ring-cyan-500" id="default-kitchen" name="default-printer" type="radio"/>
<label class="text-sm text-white/70" for="default-kitchen">Set as Default</label>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="glassmorphism p-6 md:p-8 rounded-2xl">
<h3 class="text-xl font-semibold mb-6">Scanners</h3>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
<div class="bg-white/5 p-6 rounded-xl border border-white/10">
<div class="flex justify-between items-start">
<div>
<h4 class="text-lg font-semibold">Barcode Scanner</h4>
<div class="flex items-center mt-1">
<div class="w-3 h-3 rounded-full bg-green-500 mr-2 shadow-[0_0_8px_rgba(34,197,94,0.7)]"></div>
<span class="text-sm text-green-400">Connected</span>
</div>
</div>
<span class="material-symbols-outlined text-4xl text-white/50">barcode_scanner</span>
</div>
<div class="mt-6 flex items-center justify-end space-x-3">
<button class="bg-white/10 text-white/80 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-white/20 transition-colors">Test Scan</button>
<button class="bg-white/10 text-white/80 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-white/20 transition-colors">Configure</button>
</div>
</div>
<div class="bg-white/5 p-6 rounded-xl border border-white/10">
<div class="flex justify-between items-start">
<div>
<h4 class="text-lg font-semibold">RFID Reader</h4>
<div class="flex items-center mt-1">
<div class="w-3 h-3 rounded-full bg-green-500 mr-2 shadow-[0_0_8px_rgba(34,197,94,0.7)]"></div>
<span class="text-sm text-green-400">Connected</span>
</div>
</div>
<span class="material-symbols-outlined text-4xl text-white/50">contactless</span>
</div>
<div class="mt-6 flex items-center justify-end space-x-3">
<button class="bg-white/10 text-white/80 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-white/20 transition-colors">Test Reader</button>
<button class="bg-white/10 text-white/80 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-white/20 transition-colors">Calibrate</button>
</div>
</div>
</div>
</div>
<div class="glassmorphism p-6 md:p-8 rounded-2xl">
<h3 class="text-xl font-semibold mb-6">Terminals &amp; Devices</h3>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
<div class="bg-white/5 p-6 rounded-xl border border-white/10">
<div class="flex justify-between items-start">
<div>
<h4 class="text-lg font-semibold">Server's Tablet</h4>
<div class="flex items-center mt-1">
<div class="w-3 h-3 rounded-full bg-green-500 mr-2 shadow-[0_0_8px_rgba(34,197,94,0.7)]"></div>
<span class="text-sm text-green-400">Connected</span>
</div>
</div>
<span class="material-symbols-outlined text-4xl text-white/50">tablet_mac</span>
</div>
<div class="mt-8 flex justify-end">
<button class="bg-white/10 text-white/80 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-white/20 transition-colors">Configure</button>
</div>
</div>
<div class="bg-white/5 p-6 rounded-xl border border-white/10">
<div class="flex justify-between items-start">
<div>
<h4 class="text-lg font-semibold">Self-Service Kiosk</h4>
<div class="flex items-center mt-1">
<div class="w-3 h-3 rounded-full bg-red-500 mr-2 shadow-[0_0_8px_rgba(239,68,68,0.7)]"></div>
<span class="text-sm text-red-400">Disconnected</span>
</div>
</div>
<span class="material-symbols-outlined text-4xl text-white/50">kiosk</span>
</div>
<div class="mt-8 flex justify-end">
<button class="bg-white/10 text-white/80 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-white/20 transition-colors">Reconnect</button>
</div>
</div>
<div class="bg-white/5 p-6 rounded-xl border border-white/10">
<div class="flex justify-between items-start">
<div>
<h4 class="text-lg font-semibold">POS Terminal</h4>
<div class="flex items-center mt-1">
<div class="w-3 h-3 rounded-full bg-green-500 mr-2 shadow-[0_0_8px_rgba(34,197,94,0.7)]"></div>
<span class="text-sm text-green-400">Paired</span>
</div>
</div>
<span class="material-symbols-outlined text-4xl text-white/50">point_of_sale</span>
</div>
<div class="mt-8 flex justify-end">
<button class="bg-cyan-500/80 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-cyan-500 transition-colors shadow-[0_4px_14px_rgba(56,189,248,0.20)]">Pair New Device</button>
</div>
</div>
</div>
</div>
</div>
</main>
<footer class="fixed bottom-0 left-0 xl:pl-72 right-0 glassmorphism border-t border-white/10 p-4">
<div class="max-w-7xl mx-auto flex justify-end gap-4">
<button class="bg-white/10 text-white/80 px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/20 transition-colors">Discard Changes</button>
<button class="bg-cyan-500 text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-cyan-600 transition-colors shadow-[0_4px_14px_rgba(56,189,248,0.25)]">Apply Changes</button>
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
                if (!navMenu.classList.contains('xl:flex')) {
                    navMenu.classList.add('hidden');
                }
            }
        });
    </script>

</body></html>