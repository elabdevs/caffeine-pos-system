<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Café Yönetim Paneli - Raporlar &amp; Muhasebe</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600,700&amp;display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body class="bg-slate-900 bg-cover bg-center min-h-screen text-white/95" style="background-image: url('https://images.hdqwalls.com/wallpapers/dark-abstract-black-minimal-4k-q0.jpg');">
<div class="flex flex-col xl:flex-row h-screen">
<?php include dirname(__DIR__, 2) . '/Views/partials/sidebar.php'; ?>
<div class="flex-1 flex flex-col overflow-hidden">
<main class="flex-1 p-4 md:p-6 overflow-y-auto">
<div class="max-w-7xl mx-auto space-y-8">
<header class="mb-8">
<h2 class="text-3xl font-bold tracking-tight">Raporlar &amp; Muhasebe</h2>
<p class="text-base text-white/60 mt-1">Rapor oluşturma, otomatik zamanlamalar ve muhasebe entegrasyonlarını yönetin.</p>
</header>
<div class="grid grid-cols-1 @container xl:grid-cols-3 gap-8">
<div class="xl:col-span-2 space-y-8">
<div class="glassmorphism p-6 md:p-8 rounded-2xl">
<h3 class="text-xl font-semibold mb-6">Rapor Oluştur</h3>
<div class="overflow-x-auto">
<table class="w-full text-left">
<thead>
<tr class="border-b border-white/10">
<th class="p-4"><input class="form-checkbox rounded-md" type="checkbox"/></th>
<th class="p-4 font-medium text-white/80">Rapor Türü</th>
<th class="p-4 font-medium text-white/80">Otomatik Gönderim</th>
</tr>
</thead>
<tbody>
<tr class="border-b border-white/10 hover:bg-white/5">
<td class="p-4"><input class="form-checkbox rounded-md" type="checkbox"/></td>
<td class="p-4">Satış Özeti</td>
<td class="p-4">
<label class="toggle-switch">
<input checked="" type="checkbox"/>
<span class="slider"></span>
</label>
</td>
</tr>
<tr class="border-b border-white/10 hover:bg-white/5">
<td class="p-4"><input class="form-checkbox rounded-md" type="checkbox"/></td>
<td class="p-4">Envanter Raporu</td>
<td class="p-4">
<label class="toggle-switch">
<input type="checkbox"/>
<span class="slider"></span>
</label>
</td>
</tr>
<tr class="border-b border-white/10 hover:bg-white/5">
<td class="p-4"><input class="form-checkbox rounded-md" type="checkbox"/></td>
<td class="p-4">Çalışan Performansı</td>
<td class="p-4">
<label class="toggle-switch">
<input checked="" type="checkbox"/>
<span class="slider"></span>
</label>
</td>
</tr>
<tr class="hover:bg-white/5">
<td class="p-4"><input class="form-checkbox rounded-md" type="checkbox"/></td>
<td class="p-4">Müşteri İçgörüleri</td>
<td class="p-4">
<label class="toggle-switch">
<input type="checkbox"/>
<span class="slider"></span>
</label>
</td>
</tr>
</tbody>
</table>
</div>
<div class="mt-6 flex flex-wrap gap-4">
<button class="form-input px-4 py-2 rounded-lg text-sm font-semibold hover:bg-white/10 transition-colors flex items-center gap-2">
<span class="material-symbols-outlined text-base">picture_as_pdf</span> PDF
                                    </button>
<button class="form-input px-4 py-2 rounded-lg text-sm font-semibold hover:bg-white/10 transition-colors flex items-center gap-2">
<span class="material-symbols-outlined text-base">description</span> Excel
                                    </button>
<button class="form-input px-4 py-2 rounded-lg text-sm font-semibold hover:bg_white/10 transition-colors flex items-center gap-2">
<span class="material-symbols-outlined text-base">email</span> E-posta
                                    </button>
</div>
</div>
<div class="glassmorphism p-6 md:p-8 rounded-2xl">
<h3 class="text-xl font-semibold mb-6">Otomatik Raporlama Zamanlaması</h3>
<div class="space-y-6">
<div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
<span class="w-48 shrink-0 text-white/80">Raporlama Sıklığı</span>
<div class="w-full flex items-center gap-4">
<select class="form-select w-full rounded-lg">
<option>Günlük</option>
<option selected="">Haftalık</option>
<option>Aylık</option>
</select>
</div>
</div>
<div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
<span class="w-48 shrink-0 text-white/80">Haftanın Günü</span>
<div class="w-full flex items-center gap-4">
<select class="form-select w-full rounded-lg">
<option selected="">Pazartesi</option>
<option>Salı</option>
<option>Çarşamba</option>
<option>Perşembe</option>
<option>Cuma</option>
<option>Cumartesi</option>
<option>Pazar</option>
</select>
</div>
</div>
<div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
<span class="w-48 shrink-0 text-white/80">Gün Saati</span>
<div class="w-full flex items-center gap-4">
<input class="form-input w-full rounded-lg" type="time" value="09:00"/>
</div>
</div>
</div>
</div>
</div>
<div class="xl:col-span-1 space-y-8">
<div class="glassmorphism p-6 md:p-8 rounded-2xl">
<h3 class="text-xl font-semibold mb-6">Muhasebe Entegrasyonları</h3>
<div class="space-y-4">
<div class="flex items-center justify-between p-4 bg-black/20 border border-white/10 rounded-xl">
<div class="flex items-center space-x-4">
<img alt="Logo icon" class="w-8 h-8 object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCZ1bbmLsX6p5nOYezSRzsX5fuXNQqb3FfqVz6iHYy6Ie8bGzaMiOyvIFRjAlBbG3xb-6fiRrbZuVcclGJ8lq4djZqULELKIUm-ZP9l53tAwbMQn_SXfogIxtq_WqaJ1EAZGYDnxz-3i2Abj8wL0NAkBvsk0ytK9FY3J9v0m_CWSmFHS2QonvmmrXLpt7nUQ1NCsUVG64PZhi9SVbnsJO2KKzYm7mftaByJPOeBd9A9p-iexKVxzqXp1XRb1ZAo3kQmhfLXBqNNF4Yx"/>
<span class="font-medium">Logo</span>
</div>
<div class="flex items-center space-x-2">
<span class="text-xs text-green-400">Connected</span>
<div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
</div>
</div>
<div class="flex items-center justify-between p-4 bg-black/20 border border-white/10 rounded-xl">
<div class="flex items-center space-x-4">
<img alt="Netsis icon" class="w-8 h-8 object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAjUPjFPSdse7-f3sFbxXvqtyUdB1FGnnJ-_RTahw-8bTJPa_nuHMeKX4v55fHirg6yTueH2MPonypcHZsV_Q8BRzGdFNMj9aLV_-1XRxin3rmkAl6RiHp8r-c07oKh2-NCncGcRCtT4sC4z1tsaSS1GmW42MjCV3h6hhU94DiSCrBrCf3tab3KlNF9Cgz3tjYIppJhlCf64dEZ-0dqFaEAl5J50IpvF0uKXAEMnteytcpeshPm4FmxTDXeZOzRAWFBPHgz-gOR2VL6"/>
<span class="font-medium">Netsis</span>
</div>
<button class="text-sm font-medium text-cyan-400 hover:text-cyan-300 transition-colors">Connect</button>
</div>
<div class="flex items-center justify-between p-4 bg-black/20 border border-white/10 rounded-xl">
<div class="flex items-center space-x-4">
<img alt="QuickBooks icon" class="w-8 h-8 object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDWVTe1L-kiiuxsRosi-GMa5vS9tOVpbRxN8ElYsE985iyGlNlsh97Ve_jDITevQz4dmr0aaBc34rJ1qW5rMhfCP-uFOzCtx4pMnlzFTBBFfXvum0W4gS_ajI2T_KM7UqbA4DgQnfPd1VfP0-D21Bc8i84MQWJheIjZTfize057eS2q3NCA31zPZJGL-tng1VTV23FJfyxuruhw3pH-Ke0AmjB9_pTqv80f-asCwE5XQIM9tvW_sHj_G2-Nf5-e9WTtvdSrtG9kRVQi"/>
<span class="font-medium">QuickBooks</span>
</div>
<button class="text-sm font-medium text-cyan-400 hover:text-cyan-300 transition-colors">Connect</button>
</div>
</div>
<button class="mt-6 w-full bg-white/10 text-white/80 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-white/20 transition-colors flex items-center justify-center space-x-2">
<span class="material-symbols-outlined text-base">add</span>
<span>Entegrasyon Ekle</span>
</button>
</div>
</div>
</div>
<div class="flex justify-end pt-4">
<button class="bg-cyan-500 text-white px-8 py-3 rounded-lg text-base font-semibold hover:bg-cyan-600 transition-colors shadow-[0_4px_14px_rgba(56,189,248,0.25)]">Değişiklikleri Kaydet</button>
</div>
</div>
</main>
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