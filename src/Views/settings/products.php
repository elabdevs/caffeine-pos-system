<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Café Yönetim Paneli - Ürünler</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="../../assets/css/styles.css">
</head>
</head>
<body class="bg-slate-900 bg-cover bg-center min-h-screen text-white/95" style="background-image: url('https://images.hdqwalls.com/wallpapers/dark-abstract-black-minimal-4k-q0.jpg');">
<div class="flex flex-col xl:flex-row h-screen">
<?php include dirname(__DIR__, 2) . '/Views/partials/sidebar.php'; ?>
<div class="flex-1 flex flex-col overflow-hidden">
<main class="flex-1 p-4 md:p-6 overflow-y-auto">
<div class="max-w-7xl mx-auto space-y-8">
<header class="mb-8">
<h2 class="text-3xl font-bold tracking-tight">Menü &amp; Ürünler</h2>
<p class="text-base text-white/60 mt-1">Menü kategorilerinizi ve ürün öğelerinizi yönetin.</p>
</header>
<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
<div class="lg:col-span-1">
<div class="glassmorphism p-6 rounded-2xl">
<h3 class="text-xl font-semibold mb-6">Kategoriler</h3>
<ul class="space-y-2">
<li><a class="flex justify-between items-center p-3 rounded-lg bg-cyan-500/20 text-cyan-300 font-semibold border border-cyan-500/30" href="#">Kahve <span class="text-xs text-white/70">12</span></a></li>
<li><a class="flex justify-between items-center p-3 rounded-lg hover:bg-white/10 text-white/80 hover:text-white transition-colors" href="#">Çay <span class="text-xs text-white/70">8</span></a></li>
<li><a class="flex justify-between items-center p-3 rounded-lg hover:bg-white/10 text-white/80 hover:text-white transition-colors" href="#">Hamur İşleri <span class="text-xs text-white/70">6</span></a></li>
<li><a class="flex justify-between items-center p-3 rounded-lg hover:bg-white/10 text-white/80 hover:text-white transition-colors" href="#">Tatlılar <span class="text-xs text-white/70">5</span></a></li>
<li><a class="flex justify-between items-center p-3 rounded-lg hover:bg-white/10 text-white/80 hover:text-white transition-colors" href="#">Sandviçler <span class="text-xs text-white/70">7</span></a></li>
</ul>
<button class="w-full mt-6 bg-white/10 text-white/80 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-white/20 transition-colors flex items-center justify-center space-x-2">
<span class="material-symbols-outlined text-base">add</span>
<span>Yeni Kategori</span>
</button>
</div>
</div>
<div class="lg:col-span-3">
<div class="glassmorphism p-6 md:p-8 rounded-2xl">
<div class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-4">
<h3 class="text-xl font-semibold">Kahve Ürünleri</h3>
<div class="flex items-center gap-4">
<button class="bg-white/10 text-white/80 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-white/20 transition-colors flex items-center space-x-2">
<span class="material-symbols-outlined text-base">percent</span>
<span>Fiyatları Ayarla</span>
</button>
<button class="bg-cyan-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-cyan-600 transition-colors flex items-center space-x-2">
<span class="material-symbols-outlined text-base">add</span>
<span>Ürün Ekle</span>
</button>
</div>
</div>
<div class="grid grid-cols-1 @md:grid-cols-2 @xl:grid-cols-3 gap-6">
<div class="bg-black/20 border border-white/10 rounded-xl overflow-hidden flex flex-col">
<img alt="Espresso" class="w-full h-40 object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA_yyeWz_l83Q96hWPJVsBIQamdRpFjW7jJtFdER2R5EagEFJ2CTRNLGEMemQb96Jhr9NFN91k742EWCo-KJBkqnpzmcExtcuANExQcR6Gtl_fcbh3YX488utjJ01Zy1nAuBEd6YmXw_JfOujmPZRb4bF5xZQ4P88EJIKMGmqJeKHOEK0Cujm3vIxwq8XNfwf7U-waNmtk9rnGs0ZTfnQZWecwiHY6KsYbg4aVmBeVpGaHg34on94-eXABbUq_wBobvOSQnJGQ15lJz"/>
<div class="p-4 flex-grow">
<h4 class="font-semibold text-lg">Espresso</h4>
<p class="text-cyan-400 font-medium text-base mt-1">$2.50</p>
</div>
<div class="p-4 bg-black/30 flex justify-end items-center space-x-2">
<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors modal-open" title="Düzenle"><span class="material-symbols-outlined text-xl">edit</span></button>
<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors" title="Sil"><span class="material-symbols-outlined text-xl">delete</span></button>
</div>
</div>
<div class="bg-black/20 border border-white/10 rounded-xl overflow-hidden flex flex-col">
<img alt="Latte" class="w-full h-40 object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuClYwFXp5ntHdOUl3O_BJrDN5-ctLiyyZXEwkXsFhUtkO_qvLAjRolMr2jBoNJ7AC79-EgTTmsoSeutHfKaXuDddHI5U1edwFVhfFDdema2I2FVqpirRG5R4OZ2rk4Qoh6tmrtdhjfPUKBmkJkmUovahZlPg-8tcyW1UmOO8_l9YbxIn-0PFziGYmz9Po754naUzQNlC_M58PwMj8QFRLL3KUgNkPdOIYJQ3c1KGEIrN1lmnd2_OUDlqLLgun9PEs_ucnnxvxgUKndQ"/>
<div class="p-4 flex-grow">
<h4 class="font-semibold text-lg">Latte</h4>
<p class="text-cyan-400 font-medium text-base mt-1">$4.00</p>
</div>
<div class="p-4 bg-black/30 flex justify-end items-center space-x-2">
<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors modal-open" title="Edit"><span class="material-symbols-outlined text-xl">edit</span></button>
<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors" title="Delete"><span class="material-symbols-outlined text-xl">delete</span></button>
</div>
</div>
<div class="bg-black/20 border border-white/10 rounded-xl overflow-hidden flex flex-col">
<img alt="Cappuccino" class="w-full h-40 object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAPQ-24hzF2LVIj_201uIOwQxtDSPJIDYfUfXy7h9-10QhxQSp6Eq_BUIpJ2TrVxiSwlhE46j75doVbFT0Codj6arfij4qvf1y5X0oyatfgWt3h9T6TAZZsM8Vz_191sb_flv6i3jQLsWQGM71X4XoActaAV9nm7MFEvZr6xyMUNLohvsZfaNa49rG-b9k17CQIateFqaHCJ2fMSmubHgkfYHRP1x2dD1gV47FNIK24tj7uQ838BKq6NALR6OuWoNvvq6v6n_SlX9R9"/>
<div class="p-4 flex-grow">
<h4 class="font-semibold text-lg">Cappuccino</h4>
<p class="text-cyan-400 font-medium text-base mt-1">$3.75</p>
</div>
<div class="p-4 bg-black/30 flex justify-end items-center space-x-2">
<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors modal-open" title="Edit"><span class="material-symbols-outlined text-xl">edit</span></button>
<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors" title="Delete"><span class="material-symbols-outlined text-xl">delete</span></button>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</main>
</div>
</div>
<div class="modal fixed inset-0 bg-black/70 items-center justify-center p-4 z-50" id="editProductModal">
<div class="glassmorphism w-full max-w-2xl rounded-2xl shadow-2xl flex flex-col overflow-hidden">
<div class="p-6 border-b border-white/10 flex justify-between items-center">
<h3 class="text-xl font-semibold">Ürün Tarifini Düzenle: Espresso</h3>
<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors modal-close">
<span class="material-symbols-outlined">close</span>
</button>
</div>
<div class="p-6 md:p-8 space-y-6 overflow-y-auto max-h-[70vh]">
<div>
<h4 class="text-lg font-semibold mb-4">Malzemeler</h4>
<div class="space-y-4">
<div class="flex items-center gap-4">
<input class="form-input w-full rounded-lg" placeholder="Malzeme Adı" type="text" value="Coffee Beans"/>
<input class="form-input w-24 rounded-lg" placeholder="Adet" type="number" value="18"/>
<input class="form-input w-20 rounded-lg" placeholder="Birim" type="text" value="g"/>
<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors" title="Malzemeyi Sil"><span class="material-symbols-outlined text-xl">delete</span></button>
</div>
<div class="flex items-center gap-4">
<input class="form-input w-full rounded-lg" placeholder="Ingredient Name" type="text" value="Hot Water"/>
<input class="form-input w-24 rounded-lg" placeholder="Qty" type="number" value="40"/>
<input class="form-input w-20 rounded-lg" placeholder="Unit" type="text" value="ml"/>
<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors" title="Delete Ingredient"><span class="material-symbols-outlined text-xl">delete</span></button>
</div>
</div>
<button class="mt-4 bg-white/10 text-white/80 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-white/20 transition-colors flex items-center space-x-2">
<span class="material-symbols-outlined text-base">add</span>
<span>Malzeme Ekle</span>
</button>
</div>
<div>
<h4 class="text-lg font-semibold mb-4">Hazırlama Talimatları</h4>
<textarea class="form-input w-full rounded-lg h-32" placeholder="Bu ürünü hazırlama adımlarını açıklayın...">1. 18g kahve çekirdeğini ince öğütün.
2. Öğütülmüş kahveyi eşit şekilde sıkıştırın.
3. 25-30 saniye boyunca çekim yaparak 40ml espresso elde edin.</textarea>
</div>
</div>
<div class="p-6 bg-slate-900/50 backdrop-blur-sm border-t border-white/10 flex justify-end space-x-4">
<button class="bg-white/10 text-white/80 px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/20 transition-colors modal-close">İptal</button>
<button class="bg-cyan-500 text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-cyan-600 transition-colors shadow-[0_4px_14px_rgba(56,189,248,0.25)]">Tarifi Kaydet</button>
</div>
</div>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const menuToggle = document.getElementById('menu-toggle');
  const navMenu = document.getElementById('nav-menu');

  // Menü toggle sadece elemanlar varsa çalışsın
  if (menuToggle && navMenu) {
    menuToggle.addEventListener('click', () => {
      const isHidden = navMenu.classList.contains('hidden');
      if (isHidden) {
        navMenu.classList.remove('hidden');
        navMenu.classList.add('flex','flex-col','absolute','top-24','left-0','w-full','p-6','sidebar','z-20','gap-y-3');
      } else {
        navMenu.classList.add('hidden');
        navMenu.classList.remove('flex','flex-col','absolute','top-24','left-0','w-full','p-6','sidebar','z-20','gap-y-3');
      }
    });

    window.addEventListener('resize', () => {
      if (window.innerWidth >= 1280) {
        navMenu.classList.remove('absolute','top-24','left-0','w-full','p-6','sidebar','z-20','flex','flex-col');
        if (!navMenu.classList.contains('xl:flex')) {
          navMenu.classList.add('hidden');
        }
      }
    });
  }

  // Modal logic (güvenli)
  const modal = document.getElementById('editProductModal');
  if (modal) {
    const openModalButtons = document.querySelectorAll('.modal-open');
    const closeModalButtons = document.querySelectorAll('.modal-close');

    openModalButtons.forEach(btn => {
      btn.addEventListener('click', () => modal.classList.add('is-open'));
    });
    closeModalButtons.forEach(btn => {
      btn.addEventListener('click', () => modal.classList.remove('is-open'));
    });
    modal.addEventListener('click', (e) => {
      if (e.target === modal) modal.classList.remove('is-open');
    });
  }
});
</script>


</body></html>