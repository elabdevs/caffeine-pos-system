<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Café Yönetim Paneli - Ödemeler &amp; Faturalama</title>
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
<h2 class="text-3xl font-bold tracking-tight">Ödemeler &amp; Faturalama</h2>
<p class="text-base text-white/60 mt-1">Ödeme yöntemleri, bahşişler, fişler ve politikaları yapılandırın.</p>
</header>
<div class="grid grid-cols-1 @container xl:grid-cols-3 gap-8">
<div class="xl:col-span-2 space-y-8">
<div class="glassmorphism p-6 md:p-8 rounded-2xl">
<h3 class="text-xl font-semibold mb-6">Ödeme Yöntemleri</h3>
<div class="grid grid-cols-1 @md:grid-cols-2 gap-6">
<div class="flex items-center justify-between p-4 bg-black/20 border border-white/10 rounded-xl">
<div class="flex items-center space-x-4">
<span class="material-symbols-outlined text-3xl text-cyan-400">payments</span>
<span class="font-medium">Nakit</span>
</div>
<label class="toggle-switch">
<input checked="" type="checkbox"/>
<span class="slider"></span>
</label>
</div>
<div class="flex items-center justify-between p-4 bg-black/20 border border-white/10 rounded-xl">
<div class="flex items-center space-x-4">
<span class="material-symbols-outlined text-3xl text-cyan-400">credit_card</span>
<span class="font-medium">Kart</span>
</div>
<label class="toggle-switch">
<input checked="" type="checkbox"/>
<span class="slider"></span>
</label>
</div>
<div class="flex items-center justify-between p-4 bg-black/20 border border-white/10 rounded-xl">
<div class="flex items-center space-x-4">
<span class="material-symbols-outlined text-3xl text-cyan-400">qr_code_2</span>
<span class="font-medium">QR Kod</span>
</div>
<label class="toggle-switch">
<input type="checkbox"/>
<span class="slider"></span>
</label>
</div>
<div class="flex items-center justify-between p-4 bg-black/20 border border-white/10 rounded-xl">
<div class="flex items-center space-x-4">
<span class="material-symbols-outlined text-3xl text-cyan-400">card_membership</span>
<span class="font-medium">Yemek Kartları</span>
</div>
<label class="toggle-switch">
<input checked="" type="checkbox"/>
<span class="slider"></span>
</label>
</div>
</div>
</div>
<div class="glassmorphism p-6 md:p-8 rounded-2xl">
<h3 class="text-xl font-semibold mb-6">Fiş &amp; Fiskal Yazıcı Ayarları</h3>
<div class="space-y-6">
<div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
<span class="w-40 shrink-0 text-white/80">Mağaza Logosu</span>
<div class="w-full flex items-center gap-4">
<div class="w-16 h-16 bg-black/20 border border-white/10 rounded-lg flex items-center justify-center">
<span class="material-symbols-outlined text-4xl text-white/50">image</span>
</div>
<button class="form-input px-4 py-2 rounded-lg text-sm font-semibold hover:bg-white/10 transition-colors">Logo Yükle</button>
</div>
</div>
<div>
<label class="block text-white/80 mb-2" for="receiptHeader">Fiş Başlığı</label>
<textarea class="form-input w-full rounded-lg h-24" id="receiptHeader" placeholder="örn. Café'yi ziyaret ettiğiniz için teşekkürler!">Özel başlık mesajınız buraya gelecek.</textarea>
</div>
<div>
<label class="block text-white/80 mb-2" for="receiptFooter">Fiş Altbilgisi</label>
<textarea class="form-input w-full rounded-lg h-24" id="receiptFooter" placeholder="örn. Bizi takip edin @CafeSocial">Wi-Fi: CafeGuest | Şifre: deliciouscoffee</textarea>
</div>
</div>
</div>
</div>
<div class="xl:col-span-1 space-y-8">
<div class="glassmorphism p-6 md:p-8 rounded-2xl">
<h3 class="text-xl font-semibold mb-6">Bahşiş Oranları</h3>
<p class="text-white/60 text-sm mb-4">Kart ödemeleri için ön ayarlı bahşiş oranlarını belirleyin.</p>
<div class="space-y-4">
<div class="flex items-center gap-4">
<input class="form-input w-20 rounded-lg text-center" type="number" value="15"/>
<span class="text-lg text-white/80">%</span>
<input class="form-input w-full rounded-lg" placeholder="Etiket (opsiyonel)" type="text" value="İyi"/>
</div>
<div class="flex items-center gap-4">
<input class="form-input w-20 rounded-lg text-center" type="number" value="18"/>
<span class="text-lg text-white/80">%</span>
<input class="form-input w-full rounded-lg" placeholder="Label (optional)" type="text" value="Great"/>
</div>
<div class="flex items-center gap-4">
<input class="form-input w-20 rounded-lg text-center" type="number" value="20"/>
<span class="text-lg text-white/80">%</span>
<input class="form-input w-full rounded-lg" placeholder="Label (optional)" type="text" value="Excellent"/>
</div>
</div>
<button class="mt-6 w-full bg-white/10 text-white/80 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-white/20 transition-colors flex items-center justify-center space-x-2">
<span class="material-symbols-outlined text-base">add</span>
<span>Ön Ayar Ekle</span>
</button>
</div>
<div class="glassmorphism p-6 md:p-8 rounded-2xl">
<h3 class="text-xl font-semibold mb-6">Refund &amp; Void Policy</h3>
<div>
<label class="block text-white/80 mb-2" for="refundPolicy">Politika Detayları</label>
<textarea class="form-input w-full rounded-lg h-40" id="refundPolicy" placeholder="İadeler ve iptal edilen işlemler için politikayı tanımlayın...">Satın alma sonrası 15 dakika içinde yanlış siparişler için iade mümkündür. İptal edilen işlemler bir yönetici tarafından onaylanmalıdır.</textarea>
</div>
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