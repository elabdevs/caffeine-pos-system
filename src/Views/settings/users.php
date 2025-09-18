<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Café Yönetim Paneli - Kullanıcılar &amp; Roller</title>
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
<h2 class="text-3xl font-bold tracking-tight">Kullanıcılar &amp; Roller</h2>
<p class="text-base text-white/60 mt-1">Ekip üyelerinizi ve izinlerini yönetin.</p>
</header>
<div class="glassmorphism p-6 md:p-8 rounded-2xl">
<div class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-4">
<h3 class="text-xl font-semibold">Kullanıcı Listesi</h3>
<button class="bg-cyan-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-cyan-600 transition-colors flex items-center space-x-2 self-start sm:self-center">
<span class="material-symbols-outlined text-base">add</span>
<span>Yeni Kullanıcı Ekle</span>
</button>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left">
<thead>
<tr class="border-b border-white/10">
<th class="p-4 text-sm font-semibold text-white/70">ADI</th>
<th class="p-4 text-sm font-semibold text-white/70">ROL</th>
<th class="p-4 text-sm font-semibold text-white/70">DURUM</th>
<th class="p-4 text-sm font-semibold text-white/70 text-right">İŞLEMLER</th>
</tr>
</thead>
<tbody class="divide-y divide-white/5">
<tr>
<td class="p-4 flex items-center space-x-4">
<img alt="Alex Turner" class="w-10 h-10 rounded-full object-cover border-2 border-white/20" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD2NDQneAEYX3eFBPpHIgAevuZeBiW9klOMy2scNLUihCUh5s5snwcnJk7khnog5rBbGutCCkmHPp4mIC8dfCS8_b0N1LReLOj1HeAA44QFtI0ArDvJoSIUMeMDNTjm7Uwn3og7IwFSJg5xcQYCUMReR2ecVBqIPbl4ces_Jsl-fFIefA8fDHLgYwgMjMorqlpijFYhse3jr71bPraeyfj0nrikcNG73YCwFoz75Z960khE-QFEGDWLfYs8ILPlFoUFa-tKsHRx6wmS"/>
<div>
<div class="font-medium">Alex Turner</div>
<div class="text-sm text-white/60">alex.t@example.com</div>
</div>
</td>
<td class="p-4">
<span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-500/30 text-purple-300 border border-purple-500/50">Admin</span>
</td>
<td class="p-4">
<span class="inline-flex items-center space-x-2 text-green-400">
<span class="h-2 w-2 rounded-full bg-green-400"></span>
<span>Aktif</span>
</span>
</td>
<td class="p-4 text-right space-x-2">
<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors" title="Düzenle"><span class="material-symbols-outlined text-xl">edit</span></button>
<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors" title="Devre Dışı Bırak"><span class="material-symbols-outlined text-xl">block</span></button>
<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors" title="Parolayı Sıfırla"><span class="material-symbols-outlined text-xl">lock_reset</span></button>
</td>
</tr>
<tr>
<td class="p-4 flex items-center space-x-4">
<img alt="Mia Wong" class="w-10 h-10 rounded-full object-cover border-2 border-white/20" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDmOW_GdmZKM9GmuwvinsYOPYbcAWj5isfywxBClb976bh6N-qX-XXmXLuDlqiDiaavo65a1TW9l5qVHpK8qislu8oOI00jhwa9E4-I_DQWjRtT4hAVesAQxsUxVkg0xj-9hJwjoH4y1_umn_GIPZfbGPp6DhgffraZElu_8JtOVgh0TP87DgcCt4tUWVUz9xRFDeF1V8qQe6Sp4ZSOJoYnPpCQLqOUqUsKnerfbswGOnaXIG5ei5JAS-y0mUBOlg34lNfD0ymuPyMm"/>
<div>
<div class="font-medium">Mia Wong</div>
<div class="text-sm text-white/60">mia.w@example.com</div>
</div>
</td>
<td class="p-4">
<span class="px-2 py-1 text-xs font-medium rounded-full bg-cyan-500/30 text-cyan-300 border border-cyan-500/50">Manager</span>
</td>
<td class="p-4">
<span class="inline-flex items-center space-x-2 text-green-400">
<span class="h-2 w-2 rounded-full bg-green-400"></span>
<span>Aktif</span>
</span>
</td>
<td class="p-4 text-right space-x-2">
<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors" title="Edit"><span class="material-symbols-outlined text-xl">edit</span></button>
<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors" title="Disable"><span class="material-symbols-outlined text-xl">block</span></button>
<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors" title="Reset Password"><span class="material-symbols-outlined text-xl">lock_reset</span></button>
</td>
</tr>
<tr>
<td class="p-4 flex items-center space-x-4">
<img alt="Ben Carter" class="w-10 h-10 rounded-full object-cover border-2 border-white/20" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA1azd4tmWSQEWBe97v-UGIeTDxxqHA9oZ9j3K_Zx4h57W8yZxy5kwuXQTZs-wtUQgBXlyBDRSTt_AyjlLNnEpHuIRkdbEvxsGDAYyvFL1NjB-hGV2keYR6gz-QZOs_Zqi-VG8vIyegCxsptgu8aYwmm33auOHVyI7P5RJFZAajjNOO7EQ4jNLhzpJXDA4pUcZW99tVfyhd8c-hn8mmfBCj7dMop7dTy6pfXhL-ub6i4S6FWTB1hho9301ZGAqV6v2dvrqQXR-Lhibm"/>
<div>
<div class="font-medium">Ben Carter</div>
<div class="text-sm text-white/60">ben.c@example.com</div>
</div>
</td>
<td class="p-4">
<span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-500/30 text-blue-300 border border-blue-500/50">Cashier</span>
</td>
<td class="p-4">
<span class="inline-flex items-center space-x-2 text-red-400">
<span class="h-2 w-2 rounded-full bg-red-400"></span>
<span>Devre Dışı</span>
</span>
</td>
<td class="p-4 text-right space-x-2">
<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors" title="Edit"><span class="material-symbols-outlined text-xl">edit</span></button>
<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors" title="Etkinleştir"><span class="material-symbols-outlined text-xl">check_circle</span></button>
<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors" title="Reset Password"><span class="material-symbols-outlined text-xl">lock_reset</span></button>
</td>
</tr>
</tbody>
</table>
</div>
</div>
<div class="glassmorphism p-6 md:p-8 rounded-2xl">
<h3 class="text-xl font-semibold mb-6">Roller Yönetimi</h3>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
<div class="p-6 rounded-lg bg-black/20 border border-white/10 space-y-4">
<div class="flex justify-between items-start">
<h4 class="text-lg font-semibold">Yönetici</h4>
<span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-500/30 text-purple-300 border border-purple-500/50">Admin</span>
</div>
<p class="text-sm text-white/60">Tüm özelliklere ve ayarlara tam erişim.</p>
<div class="space-y-3 pt-2">
<div class="flex items-center justify-between">
<label class="text-sm text-white/90" for="admin-discounts">İndirim Uygula</label>
<label class="switch"><input checked="" id="admin-discounts" type="checkbox"/><span class="slider"></span></label>
</div>
<div class="flex items-center justify-between">
<label class="text-sm text-white/90" for="admin-refunds">İadeleri İşle</label>
<label class="switch"><input checked="" id="admin-refunds" type="checkbox"/><span class="slider"></span></label>
</div>
<div class="flex items-center justify-between">
<label class="text-sm text-white/90" for="admin-stock">Stoku Düzenle</label>
<label class="switch"><input checked="" id="admin-stock" type="checkbox"/><span class="slider"></span></label>
</div>
</div>
</div>
<div class="p-6 rounded-lg bg-black/20 border border-white/10 space-y-4">
<div class="flex justify-between items-start">
<h4 class="text-lg font-semibold">Müdür</h4>
<span class="px-2 py-1 text-xs font-medium rounded-full bg-cyan-500/30 text-cyan-300 border border-cyan-500/50">Manager</span>
</div>
<p class="text-sm text-white/60">Siparişleri, menüyü ve stoğu yönetebilir.</p>
<div class="space-y-3 pt-2">
<div class="flex items-center justify-between">
<label class="text-sm text-white/90" for="manager-discounts">İndirim Uygula</label>
<label class="switch"><input checked="" id="manager-discounts" type="checkbox"/><span class="slider"></span></label>
</div>
<div class="flex items-center justify-between">
<label class="text-sm text-white/90" for="manager-refunds">İadeleri İşle</label>
<label class="switch"><input checked="" id="manager-refunds" type="checkbox"/><span class="slider"></span></label>
</div>
<div class="flex items-center justify-between">
<label class="text-sm text-white/90" for="manager-stock">Stoku Düzenle</label>
<label class="switch"><input id="manager-stock" type="checkbox"/><span class="slider"></span></label>
</div>
</div>
</div>
<div class="p-6 rounded-lg bg-black/20 border border-white/10 space-y-4">
<div class="flex justify-between items-start">
<h4 class="text-lg font-semibold">Kasiyer</h4>
<span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-500/30 text-blue-300 border border-blue-500/50">Cashier</span>
</div>
<p class="text-sm text-white/60">Sipariş oluşturabilir ve ödemeleri işleyebilir.</p>
<div class="space-y-3 pt-2">
<div class="flex items-center justify-between">
<label class="text-sm text-white/90" for="cashier-discounts">İndirim Uygula</label>
<label class="switch"><input id="cashier-discounts" type="checkbox"/><span class="slider"></span></label>
</div>
<div class="flex items-center justify-between">
<label class="text-sm text-white/90" for="cashier-refunds">İadeleri İşle</label>
<label class="switch"><input id="cashier-refunds" type="checkbox"/><span class="slider"></span></label>
</div>
<div class="flex items-center justify-between">
<label class="text-sm text-white/90" for="cashier-stock">Stoku Düzenle</label>
<label class="switch"><input id="cashier-stock" type="checkbox"/><span class="slider"></span></label>
</div>
</div>
</div>
</div>
</div>
</div>
</main>
<footer class="sticky bottom-0 z-10 p-4 md:p-6 mt-auto bg-slate-900/50 backdrop-blur-sm border-t border-white/10">
<div class="max-w-7xl mx-auto flex justify-end space-x-4">
<button class="bg-white/10 text-white/80 px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/20 transition-colors">İptal</button>
<button class="bg-cyan-500 text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-cyan-600 transition-colors shadow-[0_4px_14px_rgba(56,189,248,0.25)]">Değişiklikleri Kaydet</button>
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