<aside class="sidebar w-full xl:w-64 p-6 flex flex-col justify-between shrink-0">
	<div>
		<div class="flex items-center justify-between xl:justify-start space-x-3 mb-6 xl:mb-10">
			<div class="flex items-center space-x-3">
				<span class="material-symbols-outlined text-4xl text-cyan-300">bubble_chart</span>
				<h1 class="text-2xl font-bold">Caffeine</h1>
			</div>
			<button class="xl:hidden p-2 rounded-md hover:bg-white/10" id="menu-toggle">
			<span class="material-symbols-outlined">menu</span>
			</button>
		</div>
		<nav class="hidden xl:block space-y-3" id="nav-menu">
			<a class="flex items-center space-x-3 px-4 py-3 rounded-lg <?php if($_SERVER['REQUEST_URI'] == '/admin/dashboard'){ echo 'bg-white/20 text-white font-semibold'; } else { echo "hover:bg-white/10 transition-colors"; } ?>" href="/admin/">
			<span class="material-symbols-outlined">dashboard</span>
					<span>Anasayfa</span>
			</a>
			<a class="flex items-center space-x-3 px-4 py-3 rounded-lg <?php if($_SERVER['REQUEST_URI'] == '/admin/analytics'){ echo 'bg-white/20 text-white font-semibold'; } else { echo "hover:bg-white/10 transition-colors"; } ?>" href="/admin/analytics">
			<span class="material-symbols-outlined">bar_chart</span>
					<span>Analizler</span>
			</a>
			<a class="flex items-center space-x-3 px-4 py-3 rounded-lg <?php if($_SERVER['REQUEST_URI'] == '/admin/users'){ echo 'bg-white/20 text-white font-semibold'; } else { echo "hover:bg-white/10 transition-colors"; } ?>" href="/admin/users">
			<span class="material-symbols-outlined">group</span>
					<span>Kullanıcılar</span>
			</a>
			<a class="flex items-center space-x-3 px-4 py-3 rounded-lg  <?php if($_SERVER['REQUEST_URI'] == '/admin/orders'){ echo 'bg-white/20 text-white font-semibold'; } else { echo "hover:bg-white/10 transition-colors"; } ?>" href="/admin/orders">
			<span class="material-symbols-outlined">shopping_cart</span>
					<span>Siparişler</span>
			</a>
			<a class="flex items-center space-x-3 px-4 py-3 rounded-lg  <?php if($_SERVER['REQUEST_URI'] == '/admin/products'){ echo 'bg-white/20 text-white font-semibold'; } else { echo "hover:bg-white/10 transition-colors"; } ?>" href="/admin/products">
			<span class="material-symbols-outlined">inventory_2</span>
					<span>Ürünler</span>
			</a>
			<div>
			<button class="dropdown-toggle flex items-center justify-between space-x-4 p-3 rounded-lg bg-white/10 text-white shadow-lg w-full" title="Settings">
			<div class="flex items-center space-x-4">
			<span class="material-symbols-outlined">settings</span>
					<span class="font-medium">Ayarlar</span>
			</div>
			<span class="material-symbols-outlined transition-transform">expand_more</span>
			</button>
			<div class="dropdown-content ml-4 mt-2 space-y-1">
				<a class="block p-2 pl-8 rounded-lg text-sm text-white/60 hover:bg-white/5 hover:text-white transition-colors" href="#">Genel</a>
				<a class="block p-2 pl-8 rounded-lg text-sm text-white/60 hover:bg-white/5 hover:text-white transition-colors" href="#">Kullanıcılar &amp; Roller</a>
				<a class="block p-2 pl-8 rounded-lg text-sm bg-white/10 text-white font-semibold transition-colors" href="#">Disk</a>
				<a class="block p-2 pl-8 rounded-lg text-sm text-white/60 hover:bg-white/5 hover:text-white transition-colors" href="#">Ödemeler</a>
				<a class="block p-2 pl-8 rounded-lg text-sm text-white/60 hover:bg-white/5 hover:text-white transition-colors" href="#">Envanter</a>
				<a class="block p-2 pl-8 rounded-lg text-sm text-white/60 hover:bg-white/5 hover:text-white transition-colors" href="#">Bildirimler</a>
				<a class="block p-2 pl-8 rounded-lg text-sm text-white/60 hover:bg-white/5 hover:text-white transition-colors" href="#">Ürünler</a>
				<a class="block p-2 pl-8 rounded-lg text-sm text-white/60 hover:bg-white/5 hover:text-white transition-colors" href="#">Raporlar</a>
				<a class="block p-2 pl-8 rounded-lg text-sm text-white/60 hover:bg-white/5 hover:text-white transition-colors" href="#">Güvenlik</a>
			</div>
			</div>
		</nav>
	</div>
	<div class="hidden xl:block space-y-3">
		<a class="flex items-center space-x-3 px-4 py-3 rounded-lg  <?php if($_SERVER['REQUEST_URI'] == '/dashboard'){ echo 'bg-white/20 text-white font-semibold'; } else { echo "hover:bg-white/10 transition-colors"; } ?>" href="#">
		<span class="material-symbols-outlined">help</span>
				<span>Destek</span>
		</a>
		<a class="flex items-center space-x-3 px-4 py-3 rounded-lg  <?php if($_SERVER['REQUEST_URI'] == '/dashboard'){ echo 'bg-white/20 text-white font-semibold'; } else { echo "hover:bg-white/10 transition-colors"; } ?>" href="#">
		<span class="material-symbols-outlined">logout</span>
				<span>Çıkış Yap</span>
		</a>
	</div>
</aside>
<script>
document.addEventListener('DOMContentLoaded', () => {
  // -------- Dropdown / Accordion --------
  const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

  dropdownToggles.forEach(toggle => {
    const icon = toggle.querySelector('.material-symbols-outlined:last-child');
    const content = toggle.nextElementSibling;

    // Açılışta açık olsun istiyorsan: <button class="dropdown-toggle" data-open="true">
    if (toggle.dataset.open === 'true' && content) {
      toggle.classList.add('open');
      if (icon) icon.classList.add('rotate-180');
      content.style.maxHeight = content.scrollHeight + 'px';
    }

    // Güvenli click
    toggle.addEventListener('click', () => {
      const iconEl = icon || toggle.querySelector('.material-symbols-outlined:last-child');
      const contentEl = content || toggle.nextElementSibling;
      toggle.classList.toggle('open');
      if (iconEl) iconEl.classList.toggle('rotate-180');

      if (contentEl) {
        if (contentEl.style.maxHeight) {
          contentEl.style.maxHeight = null;
        } else {
          contentEl.style.maxHeight = contentEl.scrollHeight + 'px';
        }
      }
    });
  });

  // -------- Mobile Menu --------
  const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
  const mobileMenuClose  = document.getElementById('mobile-menu-close');
  const mobileMenu       = document.getElementById('mobile-menu');

  // Elemanlar varsa bağla (yoksa sessiz geç)
  if (mobileMenuToggle && mobileMenu) {
    mobileMenuToggle.addEventListener('click', () => {
      mobileMenu.classList.remove('hidden');
      mobileMenu.classList.add('flex');
    });
  }

  if (mobileMenuClose && mobileMenu) {
    mobileMenuClose.addEventListener('click', () => {
      mobileMenu.classList.add('hidden');
      mobileMenu.classList.remove('flex');
    });
  }

  // (Opsiyonel) ESC ile kapatma
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && mobileMenu && mobileMenu.classList.contains('flex')) {
      mobileMenu.classList.add('hidden');
      mobileMenu.classList.remove('flex');
    }
  });
});
</script>
