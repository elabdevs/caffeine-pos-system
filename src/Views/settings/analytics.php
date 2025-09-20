<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
		<title>Caffeine - Analiz</title>
		<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
		<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
		<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
								<h2 class="text-3xl font-bold tracking-tight text-white">Caffeine Analiz Sistemi</h2>
								<p class="text-base text-white/60 mt-1">Satışlarınızı, ürününüzü ve personel performansınızı derinlemesine inceleyin.</p>
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
								<h3 class="text-sm font-medium text-white/60">Toplam Ciro</h3>
								<p class="text-3xl font-bold mt-2" id="kpiRevenue">-</p>
								<p class="text-sm text-green-400 mt-1 flex items-center" id="kpiRevenueDelta"><span class="material-symbols-outlined text-base mr-1">arrow_upward</span>+12.5%</p>
							</div>
							<div class="glassmorphism p-5 rounded-xl">
								<h3 class="text-sm font-medium text-white/60">Toplam Sipariş</h3>
								<p class="text-3xl font-bold mt-2" id="kpiOrders">1,452</p>
								<p class="text-sm text-green-400 mt-1 flex items-center" id="kpiOrdersDelta"><span class="material-symbols-outlined text-base mr-1">arrow_upward</span>+8.2%</p>
							</div>
							<div class="glassmorphism p-5 rounded-xl">
								<h3 class="text-sm font-medium text-white/60">Sipariş Başına Ortalama Değer</h3>
								<p class="text-3xl font-bold mt-2" id="kpiAOV">-</p>
								<p class="text-sm text-red-400 mt-1 flex items-center" id="kpiAOVDelta"><span class="material-symbols-outlined text-base mr-1">arrow_downward</span>-1.1%</p>
							</div>
							<div class="glassmorphism p-5 rounded-xl">
								<h3 class="text-sm font-medium text-white/60">Müşteri İade Oranı</h3>
								<p class="text-3xl font-bold mt-2" id="kpiCRR">0%</p>
								<p class="text-sm text-green-400 mt-1 flex items-center" id="kpiCRRDelta"><span class="material-symbols-outlined text-base mr-1">arrow_upward</span>+3.4%</p>
							</div>
						</div>
							<div class="grid grid-cols-1 xl:grid-cols-5 gap-6">
  <!-- Kategoriye Göre Ciro (Donut) -->
  <div class="glassmorphism p-6 rounded-2xl xl:col-span-2">
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-lg font-semibold">Kategoriye Göre Ciro</h3>
      <span id="catTotal" class="text-white/60 text-sm">—</span>
    </div>
    <div class="h-72 flex items-center justify-center">
      <canvas id="categoryDonut"></canvas>
    </div>
  </div>

  <!-- Masaya Göre Ciro (Bar) -->
  <div class="glassmorphism p-6 rounded-2xl xl:col-span-3">
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-lg font-semibold">Masaya Göre Ciro (Son 30 Gün)</h3>
      <span id="tableTotal" class="text-white/60 text-sm">—</span>
    </div>
    <div class="h-72">
      <canvas id="tableBar"></canvas>
    </div>
  </div>
</div>

						<div class="glassmorphism p-6 rounded-2xl">
							<h3 class="text-lg font-semibold mb-4">Sipariş Dökümü</h3>
							<div class="overflow-x-auto">
								<table class="w-full text-left min-w-[800px]">
									<thead>
										<tr>
											<th class="table-header-cell">Ürün</th>
											<th class="table-header-cell">Kategori</th>
											<th class="table-header-cell">Satılan Adet</th>
											<th class="table-header-cell">Toplam Satış</th>
											<th class="table-header-cell">Toplam Siparişlerin Yüzdesi</th>
											<th class="table-header-cell">İadeler</th>
										</tr>
									</thead>
									<tbody id="breakdownBody">
									</tbody>
								</table>
							</div>
						</div>
						<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
							<div class="glassmorphism p-6 rounded-2xl">
							  <h3 class="text-lg font-semibold mb-4">Ödeme Yöntemleri</h3>
							  <div id="paymentMethodsBox" class="space-y-4"></div>
							</div>

							<div class="glassmorphism p-6 rounded-2xl lg:col-span-2">
								<h3 class="text-lg font-semibold mb-4">Personel Performansı</h3>
								<div class="overflow-x-auto">
									<table class="w-full text-left min-w-[500px]">
										<thead>
											<tr class="border-b border-white/10">
												<th class="py-3 px-4 font-medium text-white/60 text-sm">Personel</th>
												<th class="py-3 px-4 font-medium text-white/60 text-sm">Satış</th>
												<th class="py-3 px-4 font-medium text-white/60 text-sm">Sipariş</th>
												<th class="py-3 px-4 font-medium text-white/60 text-sm">Sipariş Başına Ortalama Satış</th>
											</tr>
										</thead>
										<tbody id="staffBody">
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
  // ---------- Helpers ----------
  let catChart = null;
let tblChart = null;

  const fmtTRY = n =>
    new Intl.NumberFormat('tr-TR', { style: 'currency', currency: 'TRY', maximumFractionDigits: 0 })
      .format(Number(n || 0));
  const fmtInt = n => new Intl.NumberFormat('tr-TR').format(Number(n || 0));
  const pickColor = i => ([
    'rgba(168,85,247,0.9)','rgba(99,102,241,0.9)','rgba(20,184,166,0.9)',
    'rgba(56,189,248,0.9)','rgba(34,197,94,0.9)','rgba(234,179,8,0.9)','rgba(244,63,94,0.9)'
  ][i % 7]);

  const setDelta = (el, v) => {
    if (!el) return;
    const up = Number(v) >= 0;
    el.className = `text-sm ${up ? 'text-green-400' : 'text-red-400'} mt-1 flex items-center`;
    el.innerHTML = `<span class="material-symbols-outlined text-base mr-1">${up ? 'arrow_upward' : 'arrow_downward'}</span>${up?'+':''}${(Number.isFinite(v)?Number(v).toFixed(1):'0.0')}%`;
  };

function color(i){
  const c = ['#38bdf8','#a78bfa','#f472b6','#22c55e','#f59e0b','#ef4444','#14b8a6','#60a5fa','#eab308','#fb7185'];
  return c[i % c.length];
}

async function loadCategoryDonut(days=30, branchId=null){
  const q = new URLSearchParams({days:String(days)});
  if (branchId !== null) q.set('branchId', String(branchId));
  const res = await fetch('/api/v1/revenueByCategory?'+q.toString(), {headers:{'Accept':'application/json'}, cache:'no-store'});
  if(!res.ok) return;
  const raw = await res.json(); const d = raw?.data ?? raw;

  document.getElementById('catTotal').textContent = fmtTRY(d.total || 0);

  const ctx = document.getElementById('categoryDonut').getContext('2d');
  if (catChart) catChart.destroy();
  catChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: d.labels || [],
      datasets: [{
        data: d.data || [],
        backgroundColor: (d.labels||[]).map((_,i)=>color(i)),
        borderWidth: 0
      }]
    },
    options: {
      maintainAspectRatio:false,
      plugins:{
        legend:{ position:'bottom', labels:{ color:'rgba(255,255,255,.8)' } },
        tooltip:{ callbacks:{ label: (ctx)=> `${ctx.label}: ${fmtTRY(ctx.parsed)}` } }
      },
      cutout: '55%'
    }
  });
}

async function loadTableBar(days=30, branchId=null){
  const q = new URLSearchParams({days:String(days)});
  if (branchId !== null) q.set('branchId', String(branchId));
  const res = await fetch('/api/v1/revenueByTable?'+q.toString(), {headers:{'Accept':'application/json'}, cache:'no-store'});
  if(!res.ok) return;
  const raw = await res.json(); const d = raw?.data ?? raw;

  document.getElementById('tableTotal').textContent = fmtTRY(d.total || 0);

  const ctx = document.getElementById('tableBar').getContext('2d');
  if (tblChart) tblChart.destroy();
  tblChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: d.labels || [],
      datasets: [{
        label: 'Ciro',
        data: d.data || [],
        backgroundColor: (d.labels||[]).map((_,i)=>color(i)),
        borderWidth: 0
      }]
    },
    options: {
      maintainAspectRatio:false,
      plugins:{
        legend:{ display:false },
        tooltip:{ callbacks:{ label: (ctx)=> fmtTRY(ctx.parsed.y) } }
      },
      scales:{
        x:{ ticks:{ color:'rgba(255,255,255,.8)' }, grid:{ color:'rgba(255,255,255,.08)' } },
        y:{ beginAtZero:true, ticks:{ color:'rgba(255,255,255,.8)', callback:v=>fmtTRY(v) }, grid:{ color:'rgba(255,255,255,.08)' } }
      }
    }
  });
}

  // ---------- KPI (cards) ----------
  async function loadKPI(days = 30, branchId = null) {
    try {
      const qs = new URLSearchParams({ days: String(days) });
      if (branchId !== null) qs.set('branchId', String(branchId));
      const res = await fetch('/api/v1/kpiStats?' + qs.toString(), { headers: {Accept:'application/json'}, cache:'no-store' });
      if (!res.ok) throw new Error('HTTP '+res.status);
      const raw = await res.json();
      const d = raw?.data ?? raw;

      const totals = d.totals || {};
      const deltas = d.deltas || {};
      const ccy    = d.currency || 'TRY';

      // values
      const revenueEl = document.getElementById('kpiRevenue');
      const ordersEl  = document.getElementById('kpiOrders');
      const aovEl     = document.getElementById('kpiAOV');
      const crrEl     = document.getElementById('kpiCRR');

      if (revenueEl) revenueEl.textContent = new Intl.NumberFormat('tr-TR', {style:'currency', currency: ccy}).format(Number(totals.revenue||0));
      if (ordersEl)  ordersEl.textContent  = fmtInt(totals.orders);
      if (aovEl)     aovEl.textContent     = new Intl.NumberFormat('tr-TR', {style:'currency', currency: ccy}).format(Number(totals.avg_order_value||0));
      if (crrEl)     crrEl.textContent     = ((d.customer_return_rate ?? 68)) + '%';

      // deltas
      setDelta(document.getElementById('kpiRevenueDelta'), deltas.revenue_pct);
      setDelta(document.getElementById('kpiOrdersDelta'),  deltas.orders_pct);
      setDelta(document.getElementById('kpiAOVDelta'),     deltas.avg_pct);
      setDelta(document.getElementById('kpiCRRDelta'),     d.customer_return_rate_delta ?? 3.4);
    } catch (e) {
      console.error('KPI yüklenemedi:', e);
      ['kpiRevenue','kpiOrders','kpiAOV','kpiCRR'].forEach(id => { const el = document.getElementById(id); if (el) el.textContent = '—'; });
    }
  }

  // ---------- Detailed Breakdown ----------
  async function loadProductBreakdown(days = 30, branchId = null, onlyPaid = 1) {
    try {
      const p = new URLSearchParams({ days: String(days), onlyPaid: String(onlyPaid) });
      if (branchId !== null) p.set('branchId', String(branchId));
      const res = await fetch('/api/v1/productBreakdown?' + p.toString(), { headers:{Accept:'application/json'}, cache:'no-store' });
      if (!res.ok) throw new Error('HTTP ' + res.status);

      const raw = await res.json();
      const items = (raw?.data ?? raw)?.items ?? [];

      const tbody = document.getElementById('breakdownBody');
      if (!tbody) return;
      tbody.innerHTML = '';

      const bar = pct =>
        `<div class="w-24 bg-white/10 rounded-full h-1.5"><div class="bg-cyan-400 h-1.5 rounded-full" style="width:${Math.min(100, pct)}%"></div></div>`;

      for (const it of items) {
        const tr = document.createElement('tr');
        tr.className = 'table-row';
        tr.innerHTML = `
          <td class="table-body-cell font-medium">${it.product_name}</td>
          <td class="table-body-cell text-white/70">${it.category ?? '—'}</td>
          <td class="table-body-cell">${fmtInt(it.units_sold)}</td>
          <td class="table-body-cell">${fmtTRY(it.net_sales)}</td>
          <td class="table-body-cell">
            <div class="flex items-center gap-2">${bar(it.pct ?? 0)}<span>${(it.pct ?? 0).toFixed(2)}%</span></div>
          </td>
          <td class="table-body-cell text-red-400">${fmtInt(it.refunds ?? 0)}</td>`;
        tbody.appendChild(tr);
      }
      if(items.length===0){
        tbody.innerHTML = `<tr><td colspan="6" class="py-6 px-4 text-white/60">Seçilen aralıkta veri yok.</td></tr>`;
      }
    } catch (e) {
      console.error('Breakdown yüklenemedi:', e);
    }
  }

  // ---------- Payment Methods ----------
  async function loadPaymentMethods(days = 30, branchId = null) {
    try {
      const p = new URLSearchParams({ days: String(days) });
      if (branchId !== null) p.set('branchId', String(branchId));
      const res = await fetch('/api/v1/paymentMethods?' + p.toString(), { headers:{Accept:'application/json'}, cache:'no-store' });
      if (!res.ok) throw new Error('HTTP ' + res.status);

      const raw   = await res.json();
      const items = (raw?.data ?? raw)?.items ?? [];
      const box   = document.getElementById('paymentMethodsBox');
      if (!box) return;
      box.innerHTML = '';

      items.forEach((it, i) => {
        const pct = Number(it.pct || 0);
        const div = document.createElement('div');
        div.innerHTML = `
          <div class="flex items-center justify-between text-sm mb-2">
            <span class="font-medium">${it.label}</span>
            <span class="text-white/70">${fmtTRY(it.total)} (${pct.toFixed(0)}%)</span>
          </div>
          <div class="w-full bg-white/10 rounded-full h-2 mb-4">
            <div class="h-2 rounded-full" style="width:${Math.min(100,pct)}%; background:${pickColor(i)}"></div>
          </div>`;
        box.appendChild(div);
      });
      if(items.length===0) box.innerHTML = `<p class="text-white/60 text-sm">Seçilen aralıkta ödeme bulunamadı.</p>`;
    } catch (e) {
      console.error('Payment methods yüklenemedi:', e);
    }
  }

  // ---------- Staff Performance ----------
  async function loadStaffPerformance(days = 30, branchId = null){
    try{
      const p = new URLSearchParams({ days: String(days) });
      if (branchId !== null) p.set('branchId', String(branchId));
      const res = await fetch('/api/v1/staffPerformance?' + p.toString(), { headers:{Accept:'application/json'}, cache:'no-store' });
      if(!res.ok) throw new Error('HTTP ' + res.status);

      const raw  = await res.json();
      const list = (raw?.data ?? raw)?.items ?? [];
      // toplam satışa göre azalan
      list.sort((a,b)=> Number(b.sales||0) - Number(a.sales||0));

      const tbody = document.getElementById('staffBody');
      if(!tbody) return;
      tbody.innerHTML = '';

      list.forEach(it => {
        const initials = (it.name || '?').split(' ').map(s=>s[0]).slice(0,2).join('');
        const tr = document.createElement('tr');
        tr.className = 'border-b border-white/10 hover:bg-white/5 transition-colors';
        tr.innerHTML = `
          <td class="py-3 px-4">
            <div class="flex items-center gap-3">
              <div class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center text-xs">${initials}</div>
              <div><p class="font-medium text-sm">${it.name}</p><p class="text-xs text-white/60">${it.role ?? ''}</p></div>
            </div>
          </td>
          <td class="py-3 px-4">${fmtTRY(it.sales)}</td>
          <td class="py-3 px-4">${fmtInt(it.orders)}</td>
          <td class="py-3 px-4">${fmtTRY(it.avg_sale)}</td>`;
        tbody.appendChild(tr);
      });
      if(list.length===0){
        tbody.innerHTML = `<tr><td colspan="4" class="py-6 px-4 text-white/60">Bu aralıkta kayıt bulunamadı.</td></tr>`;
      }
    }catch(err){
      console.error('Staff performance yüklenemedi:', err);
    }
  }

  // ---------- UI (sidebar/mobile) + boot ----------
  document.addEventListener('DOMContentLoaded', () => {
    // dropdowns
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    dropdownToggles.forEach(toggle => {
      if (toggle.title === 'Analytics') {
        const content = toggle.nextElementSibling;
        toggle.classList.add('open');
        toggle.querySelector('.material-symbols-outlined:last-child').classList.add('rotate-180');
        content.style.maxHeight = content.scrollHeight + 'px';
      }
      toggle.addEventListener('click', () => {
        const icon = toggle.querySelector('.material-symbols-outlined:last-child');
        const content = toggle.nextElementSibling;
        toggle.classList.toggle('open');
        icon.classList.toggle('rotate-180');
        content.style.maxHeight = content.style.maxHeight ? null : (content.scrollHeight + 'px');
      });
    });

    // mobile menu
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenuClose  = document.getElementById('mobile-menu-close');
    const mobileMenu       = document.getElementById('mobile-menu');
    if (mobileMenuToggle && mobileMenuClose && mobileMenu) {
      mobileMenuToggle.addEventListener('click', () => { mobileMenu.classList.remove('hidden'); mobileMenu.classList.add('flex'); });
      mobileMenuClose.addEventListener('click',  () => { mobileMenu.classList.add('hidden');    mobileMenu.classList.remove('flex'); });
    }

    // data loads
    loadKPI(30, null);
    loadProductBreakdown(30, null, 1);
    loadPaymentMethods(30, null);
    loadStaffPerformance(30, null);
  loadCategoryDonut(30, null);
  loadTableBar(30, null);
  });
</script>

	</body>
</html>