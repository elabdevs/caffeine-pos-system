<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Caffeine · Envanter & Stok Ayarları</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body class="bg-slate-900 bg-cover bg-center min-h-screen text-white/95" style="background-image:url('https://images.hdqwalls.com/wallpapers/dark-abstract-black-minimal-4k-q0.jpg')">
<div class="flex flex-col xl:flex-row h-screen">

  <?php include dirname(__DIR__, 2) . '/Views/partials/sidebar.php'; ?>

  <div class="flex-1 flex flex-col overflow-hidden">
    <main class="flex-1 p-4 md:p-6 overflow-y-auto">
      <div class="max-w-7xl mx-auto space-y-8 pb-24">

        <header class="mb-8">
          <h2 class="text-3xl font-bold tracking-tight">Envanter & Stok Ayarları</h2>
          <p class="text-base text-white/60 mt-1">İçerikler, malzemeler ve tedarik süreçlerini yönetin.</p>
        </header>

        <!-- STOK ÖZETİ -->
        <div class="glassmorphism p-6 md:p-8 rounded-2xl">
          <div class="flex flex-col md:flex-row justify-between md:items-center mb-6">
            <h3 class="text-xl font-semibold">Stok Özeti</h3>
            <button id="btnOpenAddItem" class="bg-cyan-500/80 text-white px-4 py-2 mt-4 md:mt-0 rounded-lg text-sm font-semibold hover:bg-cyan-500 transition-colors flex items-center gap-2">
              <span class="material-symbols-outlined text-base">add</span>
              Ürün Ekle
            </button>
          </div>

          <div class="overflow-x-auto table-scrollbar">
            <table class="w-full text-sm text-left" id="inventoryTable" data-endpoint="/api/v1/inventory/items">
              <thead class="text-xs text-white/60 uppercase border-b border-white/10">
                <tr>
                  <th class="px-6 py-3">Ürün Adı</th>
                  <th class="px-6 py-3">Mevcut Miktar</th>
                  <th class="px-6 py-3">Alt Eşik</th>
                  <th class="px-6 py-3">Birim</th>
                  <th class="px-6 py-3">Tedarikçi</th>
                  <th class="px-6 py-3"><span class="sr-only">İşlemler</span></th>
                </tr>
              </thead>
              <tbody id="inventoryTbody">
                <!-- JS ile doldurulacak -->
              </tbody>
            </table>
          </div>
        </div>

        <!-- DÜŞÜK STOK UYARILARI & OTOMATİK DÜŞÜM -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <div class="glassmorphism p-6 md:p-8 rounded-2xl">
            <h3 class="text-xl font-semibold mb-6">Düşük Stok Uyarıları</h3>
            <div class="space-y-6">
              <div class="flex items-center justify-between">
                <div>
                  <p class="font-medium">Düşük Stok Bildirimlerini Aç</p>
                  <p class="text-sm text-white/60">Miktar alt eşik seviyesinin altına düştüğünde uyarı gönder.</p>
                </div>
                <label class="toggle-switch">
                  <input id="lowStockEnabled" type="checkbox"/>
                  <span class="slider"></span>
                </label>
              </div>
              <div class="pl-4 border-l-2 border-white/10 space-y-3">
                <div class="flex items-center justify-between">
                  <p class="text-sm font-medium">E-posta Bildirimleri</p>
                  <label class="toggle-switch !w-10 !h-6"><input id="lowStockEmail" type="checkbox"/><span class="slider"></span></label>
                </div>
                <div class="flex items-center justify-between">
                  <p class="text-sm font-medium">SMS Bildirimleri</p>
                  <label class="toggle-switch !w-10 !h-6"><input id="lowStockSms" type="checkbox"/><span class="slider"></span></label>
                </div>
              </div>
              <button id="btnSaveNotify" class="bg-white/10 px-4 py-2 rounded-lg">Kaydet</button>
            </div>
          </div>

          <div class="glassmorphism p-6 md:p-8 rounded-2xl">
            <h3 class="text-xl font-semibold mb-6">Otomatik Düşüm Kuralları</h3>
            <div class="space-y-4">
              <div class="flex items-center justify-between">
                <div>
                  <p class="font-medium">Otomatik Düşüm</p>
                  <p class="text-sm text-white/60">Her satışta malzemeleri tarifine göre otomatik düş.</p>
                </div>
                <label class="toggle-switch">
                  <input id="autoDeductEnabled" type="checkbox"/>
                  <span class="slider"></span>
                </label>
              </div>
              <a id="btnOpenRecipeModal" href="./inventory/recipes" class="text-cyan-400 hover:text-cyan-300 cursor-pointer flex items-center gap-2">
                Tarifleri Kurgula <span class="material-symbols-outlined">arrow_forward</span>
              </a>
            </div>
          </div>
        </div>

        <!-- TEDARİKÇİLER -->
        <div class="glassmorphism p-6 md:p-8 rounded-2xl">
          <div class="flex flex-col md:flex-row justify-between md:items-center mb-6">
            <h3 class="text-xl font-semibold">Tedarikçiler</h3>
            <button id="btnOpenAddSupplier" class="bg-white/10 px-4 py-2 rounded-lg">Tedarikçi Ekle</button>
          </div>
          <div id="suppliersGrid" class="grid grid-cols-1 lg:grid-cols-2 gap-6" data-endpoint="/api/v1/suppliers">
            <!-- JS ile doldurulacak -->
          </div>
        </div>

        <!-- ALIŞ FATURASI -->
        <div class="glassmorphism p-6 md:p-8 rounded-2xl">
          <h3 class="text-xl font-semibold mb-4">Alış Faturası</h3>
          <p class="text-white/60 mb-6">Düşük stok için hızlıca alış faturası oluşturun.</p>
          <button id="btnGoCreatePI" class="bg-cyan-500/80 px-5 py-2.5 rounded-lg">Alış Faturası Oluştur</button>
        </div>

      </div>
    </main>
  </div>
</div>

<!-- ÜRÜN MODALI -->
<div id="modalItem" class="hidden fixed inset-0 z-50 grid place-items-center bg-black/60 p-4">
  <div class="w-full max-w-lg glassmorphism rounded-2xl p-6">
    <h4 class="text-lg font-semibold mb-4">Ürün</h4>
    <form id="formItem">
      <input type="hidden" name="id" id="itemId">
      <div class="grid grid-cols-2 gap-4">
        <input name="name" placeholder="Ürün Adı" class="bg-white/10 rounded-md p-2"/>
        <select name="unit" id="itemUnit" class="bg-white/10 rounded-md p-2">
          <option value="ml">ml</option>
          <option value="l">l</option>
          <option value="gr">gr</option>
          <option value="kg">kg</option>
          <option value="pcs">pcs</option>
        </select>
        <input name="qty" type="number" placeholder="Miktar" class="bg-white/10 rounded-md p-2"/>
        <input name="min_threshold" type="number" placeholder="Alt Eşik" class="bg-white/10 rounded-md p-2"/>
      </div>
      <div class="mt-4 flex justify-end gap-2">
        <button type="button" data-close="#modalItem" class="px-4 py-2 bg-white/10 rounded-lg">Vazgeç</button>
        <button type="submit" class="px-4 py-2 bg-cyan-500 rounded-lg">Kaydet</button>
      </div>
    </form>
  </div>
</div>

<!-- TEDARİKÇİ MODALI -->
<div id="modalSupplier" class="hidden fixed inset-0 z-50 grid place-items-center bg-black/60 p-4">
  <div class="w-full max-w-lg glassmorphism rounded-2xl p-6">
    <h4 class="text-lg font-semibold mb-4">Tedarikçi</h4>
    <form id="formSupplier">
      <input type="hidden" name="id" id="supplierId">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <input name="name" id="supplierName" placeholder="Tedarikçi Adı" class="bg-white/10 rounded-md p-2"/>
        <input name="email" id="supplierEmail" placeholder="E-posta" class="bg-white/10 rounded-md p-2"/>
        <input name="phone" id="supplierPhone" placeholder="Telefon" class="bg-white/10 rounded-md p-2"/>
      </div>
      <div class="mt-4 flex justify-end gap-2">
        <button type="button" data-close="#modalSupplier" class="px-4 py-2 bg-white/10 rounded-lg">Vazgeç</button>
        <button type="submit" class="px-4 py-2 bg-cyan-500 rounded-lg">Kaydet</button>
      </div>
    </form>
  </div>
</div>

<!-- ÜRÜN SİLME MODALI -->
<div id="modalDelete" class="hidden fixed inset-0 z-50 grid place-items-center bg-black/60 p-4">
  <div class="w-full max-w-sm glassmorphism rounded-2xl p-6">
    <h4 class="text-lg font-semibold mb-2">Ürünü Sil</h4>
    <p class="text-sm text-white/70 mb-4">“<span id="delItemName"></span>” kalemi silinsin mi? Bu işlem geri alınamaz.</p>
    <div class="flex justify-end gap-2">
      <button type="button" data-close="#modalDelete" class="px-4 py-2 bg-white/10 rounded-lg">Vazgeç</button>
      <button type="button" id="btnConfirmDelete" class="px-4 py-2 bg-red-500 rounded-lg">Sil</button>
    </div>
  </div>
</div>

<script>
// ===== API & ROUTE SABİTLERİ =====
const API_ITEMS      = '/api/v1/inventory/items';
const API_SUPPLIERS  = '/api/v1/suppliers';
const API_NOTIFY     = '/api/v1/inventory/settings/notifications';
const API_AUTODEDUCT = '/api/v1/inventory/settings/auto-deduct';
const ROUTE_PURCHASE_INVOICE_CREATE = '/admin/purchases/create';
const csrf = "<?= csrfToken() ?>";

// ---- modal yardımcıları ----
function openModal(id){ document.querySelector(id).classList.remove('hidden'); }
function closeModal(id){ document.querySelector(id).classList.add('hidden'); }
document.addEventListener('click',(e)=>{
  const closeBtn = e.target.closest('[data-close]');
  if(closeBtn){ closeModal(closeBtn.dataset.close); }
});

// ---- Tek seferlik fetch cache ----
let suppliersPromise = null;
let itemsPromise = null;

function fetchSuppliersOnce() {
  if (!suppliersPromise) {
    suppliersPromise = fetch(API_SUPPLIERS, {credentials:'same-origin'}).then(r => r.json());
  }
  return suppliersPromise;
}
function fetchItemsOnce() {
  if (!itemsPromise) {
    itemsPromise = fetch(API_ITEMS, {credentials:'same-origin'}).then(r => r.json());
  }
  return itemsPromise;
}

// ---- Map ve render yardımcıları ----
let SUPPLIER_MAP = {};
let SUPPLIER_BY_ID = {};
function buildSupplierMaps(arr) {
  SUPPLIER_MAP = {};
  SUPPLIER_BY_ID = {};
  for (const s of (arr || [])) {
    SUPPLIER_MAP[String(s.id)] = s.name || '';
    SUPPLIER_BY_ID[String(s.id)] = s;
  }
}

// Tedarikçiler grid'i
async function loadSuppliers() {
  const json = await fetchSuppliersOnce();
  const data = Array.isArray(json?.data) ? json.data : [];
  buildSupplierMaps(data);

  const grid = document.getElementById('suppliersGrid');
  if (!grid) return;
  grid.innerHTML = '';

  data.forEach(s => {
    const phone = s?.contact_info?.phone || '';
    const email = s?.contact_info?.email || '';
    const card = document.createElement('div');
    card.className = 'bg-white/5 p-4 rounded-lg';
    card.innerHTML = `
      <div class="flex justify-between items-start">
        <div>
          <p class="font-semibold">${s.name}</p>
          <p class="text-sm text-white/60">${email}</p>
          <p class="text-sm text-white/60">${phone}</p>
        </div>
        <button class="text-white/60 hover:text-white" data-edit-supplier="${s.id}">
          <span class="material-symbols-outlined text-xl">edit</span>
        </button>
      </div>
      <div class="mt-4 pt-4 border-t border-white/10">
        <p class="text-xs uppercase text-white/50 mb-2 font-semibold">Tercih Edilen Ürünler</p>
        <div class="flex flex-wrap gap-2"></div>
        <button class="w-full text-center mt-4 bg-cyan-500/20 text-cyan-300 text-sm font-semibold py-2 rounded-md hover:bg-cyan-500/30 transition-colors" data-quick-po="${s.id}">
          Hızlı Sipariş
        </button>
      </div>`;
    grid.appendChild(card);
  });
}

// Envanter tablosu
async function loadInventory() {
  const [supJson, itemsJson] = await Promise.all([ fetchSuppliersOnce(), fetchItemsOnce() ]);
  if (!Object.keys(SUPPLIER_MAP).length) {
    buildSupplierMaps(Array.isArray(supJson?.data) ? supJson.data : []);
  }

  const rows = Array.isArray(itemsJson?.data) ? itemsJson.data : [];
  const tbody = document.getElementById('inventoryTbody');
  tbody.innerHTML = '';

  rows.forEach(item => {
    const rawQty = item.stock_quantity ?? item.qty ?? 0;
    const rawMin = item.min_threshold ?? 0;
    const qty = typeof rawQty === 'string' ? parseFloat(rawQty.replace(',', '.')) : Number(rawQty);
    const min = typeof rawMin === 'string' ? parseFloat(rawMin.replace(',', '.')) : Number(rawMin);
    const supplierName = SUPPLIER_MAP[String(item.supplier_id)] || '-';
    const statusDot = (Number.isFinite(qty) && Number.isFinite(min) && qty <= min) ? 'bg-red-500' : 'bg-green-500';

    const tr = document.createElement('tr');
    tr.className = 'border-b border-white/10 hover:bg-white/5';
    tr.innerHTML = `
      <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap flex items-center gap-3">
        <span class="w-2 h-2 rounded-full ${statusDot}"></span>
        ${item.name}
      </th>
      <td class="px-6 py-4">${Number.isFinite(qty) ? qty : '-'}</td>
      <td class="px-6 py-4">${Number.isFinite(min) ? min : '-'}</td>
      <td class="px-6 py-4">${item.unit || ''}</td>
      <td class="px-6 py-4">${supplierName}</td>
      <td class="px-6 py-4">
        <div class="flex items-center justify-end gap-3">
          <a class="font-medium text-cyan-400 hover:underline" href="#" data-edit-id="${item.id}">Düzenle</a>
          <button class="font-medium text-red-400 hover:underline" type="button"
                  data-delete-id="${item.id}" data-delete-name="${item.name}">
            Sil
          </button>
        </div>
      </td>`;
    tbody.appendChild(tr);
  });
}

// ========= ÜRÜN EKLE/DÜZENLE =========
document.getElementById('btnOpenAddItem')?.addEventListener('click', () => {
  document.getElementById('formItem').reset();
  document.getElementById('itemId').value = '';
  openModal('#modalItem');
});

document.getElementById('formItem')?.addEventListener('submit', async (e) => {
  e.preventDefault();
  const fd   = new FormData(e.target);
  const id   = fd.get('id');
  const body = {
    name:            fd.get('name'),
    unit:            fd.get('unit'),
    stock_quantity:  Number(fd.get('qty') || 0),
    min_threshold:   Number(fd.get('min_threshold') || 0),
  };
  try {
    const url    = id ? `${API_ITEMS}/${id}` : API_ITEMS;
    const method = id ? 'PUT' : 'POST';
    const res = await fetch(url, {
      method,
      headers: {'Content-Type':'application/json', 'X-CSRF-Token': csrf},
      body: JSON.stringify(body),
      credentials:'same-origin'
    });
    if (!res.ok) throw new Error('HTTP '+res.status);
    closeModal('#modalItem');
    itemsPromise = null; // cache reset
    await loadInventory();
  } catch (err) {
    console.error(err);
    alert('Ürün kaydedilemedi!');
  }
});

// tablo: düzenle linki
document.addEventListener('click', async (e) => {
  const a = e.target.closest('[data-edit-id]');
  if (!a) return;
  e.preventDefault();
  const id = a.getAttribute('data-edit-id');

  const itemsJson = await fetchItemsOnce();
  const rows = Array.isArray(itemsJson?.data) ? itemsJson.data : [];
  const item = rows.find(r => String(r.id) === String(id));
  if (!item) return;

  document.getElementById('itemId').value = item.id;
  document.querySelector('#formItem [name=name]').value = item.name || '';
  const unitSel = document.getElementById('itemUnit');
  if (item.unit && ![...unitSel.options].some(o => o.value === item.unit)) {
    const opt = document.createElement('option');
    opt.value = item.unit;
    opt.textContent = item.unit;
    unitSel.appendChild(opt);
  }
  unitSel.value = item.unit || 'ml';
  document.querySelector('#formItem [name=qty]').value  = (item.stock_quantity ?? item.qty ?? '').toString().replace(',', '.');
  document.querySelector('#formItem [name=min_threshold]').value = (item.min_threshold ?? '').toString().replace(',', '.');

  openModal('#modalItem');
});

// ========= ÜRÜN SİL =========
let deleteTarget = { id: null, name: '' };

document.addEventListener('click', (e)=>{
  const btn = e.target.closest('[data-delete-id]');
  if (!btn) return;
  deleteTarget.id   = btn.getAttribute('data-delete-id');
  deleteTarget.name = btn.getAttribute('data-delete-name') || 'Ürün';
  document.getElementById('delItemName').textContent = deleteTarget.name;
  openModal('#modalDelete');
});

document.getElementById('btnConfirmDelete')?.addEventListener('click', async ()=>{
  if (!deleteTarget.id) return;
  try{
    const res = await fetch(`${API_ITEMS}/${encodeURIComponent(deleteTarget.id)}`, {
      method: 'DELETE',
      headers: { 'X-CSRF-Token': csrf, 'Accept':'application/json' },
      credentials: 'same-origin'
    });
    if (!res.ok) {
      const msg = `Silme başarısız (HTTP ${res.status})`;
      throw new Error(msg);
    }
    closeModal('#modalDelete');
    deleteTarget = { id:null, name:'' };
    itemsPromise = null; // cache reset
    await loadInventory();
    alert('Ürün silindi.');
  } catch (err){
    console.error(err);
    alert(err.message || 'Ürün silinemedi!');
  }
});

// ========= TEDARİKÇİ EKLE/DÜZENLE =========
document.getElementById('btnOpenAddSupplier')?.addEventListener('click', ()=>{
  document.getElementById('formSupplier').reset();
  document.getElementById('supplierId').value = '';
  openModal('#modalSupplier');
});

// kart edit
document.addEventListener('click', (e) => {
  const btn = e.target.closest('[data-edit-supplier]');
  if (!btn) return;
  const id = btn.getAttribute('data-edit-supplier');
  const s  = SUPPLIER_BY_ID[String(id)];
  if (!s) return;

  document.getElementById('supplierId').value   = s.id;
  document.getElementById('supplierName').value = s.name || '';
  document.getElementById('supplierEmail').value = s?.contact_info?.email || '';
  document.getElementById('supplierPhone').value = s?.contact_info?.phone || '';
  openModal('#modalSupplier');
});

document.getElementById('formSupplier')?.addEventListener('submit', async (e)=>{
  e.preventDefault();
  const fd = new FormData(e.target);
  const id = fd.get('id');
  const body = {
    name: fd.get('name'),
    contact_info: {
      email: fd.get('email') || '',
      phone: fd.get('phone') || ''
    }
  };
  try{
    const url    = id ? `${API_SUPPLIERS}/${id}` : API_SUPPLIERS;
    const method = id ? 'PUT' : 'POST';
    const res = await fetch(url, {
      method,
      headers: {'Content-Type':'application/json', 'X-CSRF-Token': csrf},
      body: JSON.stringify(body),
      credentials:'same-origin'
    });
    if(!res.ok) throw new Error('HTTP '+res.status);

    closeModal('#modalSupplier');
    suppliersPromise = null; // cache reset
    await Promise.all([loadSuppliers(), loadInventory()]);
  }catch(err){
    console.error(err);
    alert('Tedarikçi kaydedilemedi!');
  }
});

// ========= DÜŞÜK STOK BİLDİRİMLERİ =========
document.getElementById('btnSaveNotify')?.addEventListener('click', async ()=>{
  const body = {
    enabled: document.getElementById('lowStockEnabled').checked,
    email:   document.getElementById('lowStockEmail').checked,
    sms:     document.getElementById('lowStockSms').checked
  };
  try{
    const res = await fetch(API_NOTIFY, {
      method:'PUT',
      headers:{'Content-Type':'application/json'},
      body: JSON.stringify(body),
      credentials:'same-origin'
    });
    if(!res.ok) throw new Error('HTTP '+res.status);
    alert('Bildirim ayarları kaydedildi.');
  }catch(err){
    console.error(err);
    alert('Bildirim ayarları kaydedilemedi!');
  }
});

// ========= OTOMATİK DÜŞÜM (toggle anında) =========
document.getElementById('autoDeductEnabled')?.addEventListener('change', async (e)=>{
  const body = { enabled: !!e.target.checked };
  try{
    const res = await fetch(API_AUTODEDUCT, {
      method:'PUT',
      headers:{'Content-Type':'application/json'},
      body: JSON.stringify(body),
      credentials:'same-origin'
    });
    if(!res.ok) throw new Error('HTTP '+res.status);
  }catch(err){
    console.error(err);
    alert('Otomatik düşüm ayarı güncellenemedi!');
    e.target.checked = !e.target.checked; // rollback
  }
});

// ========= Hızlı Sipariş & Genel Alış Faturası =========
document.addEventListener('click', (e)=>{
  const btn = e.target.closest('[data-quick-po]');
  if(!btn) return;
  const sid = btn.getAttribute('data-quick-po');
  window.location.href = `${ROUTE_PURCHASE_INVOICE_CREATE}?supplier_id=${encodeURIComponent(sid)}`;
});

document.getElementById('btnGoCreatePI')?.addEventListener('click', ()=>{
  window.location.href = ROUTE_PURCHASE_INVOICE_CREATE;
});

// ---- Init (tek kez) ----
if (!window.__inv_init__) {
  window.__inv_init__ = true;
  (async function init(){
    await Promise.all([loadSuppliers(), loadInventory()]);
  })();
}
</script>

</body>
</html>
