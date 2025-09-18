<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Café Yönetim Paneli - Güvenlik Ayarları</title>
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
<h2 class="text-3xl font-bold tracking-tight">Güvenlik Ayarları</h2>
<p class="text-base text-white/60 mt-1">Hesap güvenliğinizi, erişimi ve veri tercihlerinizi yönetin.</p>
</header>
<div class="glassmorphism p-6 md:p-8 rounded-2xl">
<h3 class="text-xl font-semibold mb-6">Kimlik Doğrulama Kontrolleri</h3>
<div class="space-y-6">
<div class="flex flex-col md:flex-row md:items-center justify-between">
<div>
<h4 class="font-medium">Parola Politikası</h4>
<p class="text-sm text-white/60 mt-1">Parolalar en az 12 karakter olmalıdır.</p>
</div>
<button class="bg-white/10 text-white/80 px-4 py-2 mt-3 md:mt-0 rounded-lg text-sm font-semibold hover:bg-white/20 transition-colors">Politikayı Değiştir</button>
</div>
<div class="border-t border-white/10"></div>
<div class="flex flex-col md:flex-row md:items-center justify-between">
<div>
<h4 class="font-medium">İki Faktörlü Kimlik Doğrulama (2FA)</h4>
<p class="text-sm text-white/60 mt-1">Güvenliği artırmak için ikinci doğrulama adımı gerektir.</p>
</div>
<label class="toggle-switch mt-3 md:mt-0">
<input checked="" type="checkbox"/>
<span class="slider"></span>
</label>
</div>
<div class="border-t border-white/10"></div>
<div>
<h4 class="font-medium mb-2">Oturum Zaman Aşımı</h4>
<p class="text-sm text-white/60 mb-3">Belirli bir süre etkinlik olmadığında otomatik olarak çıkış yap.</p>
<select class="form-select rounded-lg w-full md:w-64">
<option>30 dakika</option>
<option selected="">1 saat</option>
<option>8 saat</option>
<option>24 saat</option>
</select>
</div>
</div>
</div>
<div class="glassmorphism p-6 md:p-8 rounded-2xl">
<h3 class="text-xl font-semibold mb-6">Erişim Kısıtlamaları</h3>
<div class="space-y-6">
<div>
<h4 class="font-medium mb-2">IP Beyaz/ Kara Listesi</h4>
<p class="text-sm text-white/60 mb-4">Hangi IP adreslerinin yönetim panelinize erişebileceğini kontrol edin.</p>
<div class="flex flex-col space-y-3">
<input class="form-input rounded-lg w-full" placeholder="Beyazlisteye eklenecek IP adresini girin (örn. 192.168.1.1)" type="text"/>
<input class="form-input rounded-lg w-full" placeholder="Kara listeye eklenecek IP adresini girin (örn. 10.0.0.5)" type="text"/>
</div>
</div>
<div class="border-t border-white/10"></div>
<div class="flex flex-col md:flex-row md:items-center justify-between">
<div>
<h4 class="font-medium">Cihaz Kaydı</h4>
<p class="text-sm text-white/60 mt-1">Yeni cihazların giriş yapmadan önce onaylanmasını gerektir.</p>
</div>
<button class="bg-white/10 text-white/80 px-4 py-2 mt-3 md:mt-0 rounded-lg text-sm font-semibold hover:bg-white/20 transition-colors">Cihazları Yönet</button>
</div>
</div>
</div>
<div class="glassmorphism p-6 md:p-8 rounded-2xl">
<h3 class="text-xl font-semibold mb-6">Veri Güvenliği</h3>
<div class="space-y-6">
<div>
<h4 class="font-medium mb-2">Yedekleme Seçenekleri</h4>
<div class="flex items-center space-x-6 mt-4">
<label class="flex items-center space-x-2 cursor-pointer">
<input checked="" class="form-radio bg-white/10 border-white/20 text-cyan-500 focus:ring-cyan-500" name="backup-option" type="radio"/>
<span>Yerel Yedek</span>
</label>
<label class="flex items-center space-x-2 cursor-pointer">
<input class="form-radio bg-white/10 border-white/20 text-cyan-500 focus:ring-cyan-500" name="backup-option" type="radio"/>
<span>Bulut Yedek</span>
</label>
</div>
</div>
<div class="border-t border-white/10"></div>
<div>
<h4 class="font-medium mb-2">Otomatik Yedekleme Zamanlaması</h4>
<select class="form-select rounded-lg w-full md:w-64">
<option>Devre Dışı</option>
<option>Her 6 saatte bir</option>
<option selected="">Günlük</option>
<option>Haftalık</option>
</select>
</div>
<div class="border-t border-white/10"></div>
<div class="flex flex-col md:flex-row md:items-center gap-4">
<button class="w-full md:w-auto flex-1 bg-cyan-500/80 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-cyan-500 transition-colors shadow-[0_4px_14px_rgba(56,189,248,0.20)]">Şimdi Yedekle</button>
<button class="w-full md:w-auto flex-1 bg-orange-500/20 text-orange-300 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-orange-500/30 transition-colors">Yedekten Geri Yükle</button>
</div>
</div>
</div>
<div class="glassmorphism p-6 md:p-8 rounded-2xl">
<h3 class="text-xl font-semibold mb-6">Denetim Kayıtları</h3>
<div class="overflow-x-auto">
<table class="w-full text-left text-sm">
<thead class="border-b border-white/10 text-white/60">
<tr>
<th class="p-3 font-medium">Kullanıcı</th>
<th class="p-3 font-medium">İşlem</th>
<th class="p-3 font-medium">Zaman Damgası</th>
</tr>
</thead>
<tbody class="divide-y divide-white/5">
<tr>
<td class="p-3">Admin</td>
<td class="p-3">Giriş yaptı</td>
<td class="p-3 text-white/60">2024-07-21 10:30</td>
</tr>
<tr>
<td class="p-3">Jane Doe</td>
<td class="p-3 text-red-400">Parola sıfırlandı</td>
<td class="p-3 text-white/60">2024-07-21 09:15</td>
</tr>
<tr>
<td class="p-3">Admin</td>
<td class="p-3">"Espresso" menü öğesi güncellendi</td>
<td class="p-3 text-white/60">2024-07-20 16:55</td>
</tr>
<tr>
<td class="p-3">John Smith</td>
<td class="p-3">2FA etkinleştirildi</td>
<td class="p-3 text-white/60">2024-07-20 11:20</td>
</tr>
<tr>
<td class="p-3">Admin</td>
<td class="p-3 text-orange-400">Veri geri yükleme başlatıldı</td>
<td class="p-3 text-white/60">2024-07-19 08:00</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</main>
<footer class="fixed bottom-0 left-0 xl:pl-72 right-0 glassmorphism border-t border-white/10 p-4">
<div class="max-w-7xl mx-auto flex justify-end gap-4">
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