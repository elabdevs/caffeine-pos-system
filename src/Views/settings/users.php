<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
		<title>Café Yönetim Paneli - Kullanıcılar &amp; Roller</title>
		<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
		<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600,700&amp;display=swap" rel="stylesheet"/>
		<link rel="stylesheet" href="../../assets/css/styles.css">
		<style>
			/* toggle switch */
			.switch{ position:relative; display:inline-block; width:42px; height:24px; }
			.switch input{ opacity:0; width:0; height:0; }
			.switch .slider{
			position:absolute; inset:0; cursor:pointer;
			background:rgba(255,255,255,.2);
			border-radius:9999px; transition:background .2s ease;
			}
			.switch .slider:before{
			content:""; position:absolute; top:3px; left:3px;
			width:18px; height:18px; background:#fff;
			border-radius:9999px; transition:transform .2s ease;
			}
			.switch input:checked + .slider{ background:#22d3ee; }      /* tailwind: cyan-400 */
			.switch input:checked + .slider:before{ transform:translateX(18px); }
			.switch input:focus + .slider{ outline:2px solid rgba(34,211,238,.5); outline-offset:2px; }
			.switch input:disabled + .slider{ opacity:.5; cursor:not-allowed; }
		</style>
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
                                        <?php use \App\Models\User; foreach(User::all() as $user): $primayRole = User::getPrimaryRole($user['id']); ?>
										<tr>
											<td class="p-4 flex items-center space-x-4">
												<img alt="Alex Turner" class="w-10 h-10 rounded-full object-cover border-2 border-white/20" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD2NDQneAEYX3eFBPpHIgAevuZeBiW9klOMy2scNLUihCUh5s5snwcnJk7khnog5rBbGutCCkmHPp4mIC8dfCS8_b0N1LReLOj1HeAA44QFtI0ArDvJoSIUMeMDNTjm7Uwn3og7IwFSJg5xcQYCUMReR2ecVBqIPbl4ces_Jsl-fFIefA8fDHLgYwgMjMorqlpijFYhse3jr71bPraeyfj0nrikcNG73YCwFoz75Z960khE-QFEGDWLfYs8ILPlFoUFa-tKsHRx6wmS"/>
												<div>
													<div class="font-medium"><?= $user['name'] ?></div>
													<div class="text-sm text-white/60"><?= $user['email'] ?></div>
												</div>
											</td>
											<td class="p-4">
                                            <?php
                                            $roles = [
                                                "admin"   => ["class" => "bg-purple-500/30 text-purple-300 border border-purple-500/50", "label" => "Yönetici"],
                                                "cashier" => ["class" => "bg-cyan-500/30 text-cyan-300 border border-cyan-500/50", "label" => "Kasiyer"],
                                                "waiter"  => ["class" => "bg-blue-500/30 text-blue-300 border border-blue-500/50", "label" => "Garson"],
                                            ];

                                            $role = $roles[$primayRole] ?? ["class" => "bg-gray-500/30 text-gray-300 border border-gray-500/50", "label" => ucfirst($primayRole)];
                                            ?>
                                            <span class="px-2 py-1 text-xs font-medium rounded-full <?= $role['class'] ?>">
                                                <?= $role['label'] ?>
                                            </span>
											</td>
											<td class="p-4">
												<span class="inline-flex items-center space-x-2 text-<?= $user['status'] == "active" ? "green" : "gray" ?>-400">
												<span class="h-2 w-2 rounded-full bg-<?= $user['status'] == "active" ? "green" : "gray" ?>-400"></span>
                                                <span><?= $user['status'] == "active" ? "Aktif" : "İnaktif" ?></span>
												</span>
											</td>
											<td class="p-4 text-right space-x-2">
												<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors" title="Düzenle"><span class="material-symbols-outlined text-xl">edit</span></button>
												<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors" title="Devre Dışı Bırak"><span class="material-symbols-outlined text-xl">block</span></button>
												<button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors" title="Parolayı Sıfırla"><span class="material-symbols-outlined text-xl">lock_reset</span></button>
											</td>
										</tr>
                                        <?php endforeach; ?>
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
			const navMenu    = document.getElementById('nav-menu');
			
			menuToggle?.addEventListener('click', () => {
			  if (!navMenu) return;
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
			  if (!navMenu) return;
			  if (window.innerWidth >= 1280) {
			    navMenu.classList.remove('absolute','top-24','left-0','w-full','p-6','sidebar','z-20','flex','flex-col');
			    if (!navMenu.classList.contains('xl:flex')) navMenu.classList.add('hidden');
			  }
			});
		</script>
	</body>
</html>