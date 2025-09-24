<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Caffeine · Menü & Ürün Yönetimi</title>

  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="../../assets/css/styles.css">

  <meta name="csrf-token" content="<?= htmlspecialchars(csrfToken() ?? '') ?>">
</head>
<body class="bg-slate-900 bg-cover bg-center min-h-screen text-white/95" style="background-image:url('https://images.hdqwalls.com/wallpapers/dark-abstract-black-minimal-4k-q0.jpg')">
<div class="flex flex-col xl:flex-row h-screen">

  <?php include dirname(__DIR__, 2) . '/Views/partials/sidebar.php'; ?>

  <!-- MAIN -->
  <div class="flex-1 flex flex-col overflow-hidden">
    <main class="flex-1 p-4 md:p-6 overflow-y-auto">
      <div class="max-w-7xl mx-auto space-y-8 pb-24">

        <!-- Header -->
        <header class="mb-2">
          <h2 class="text-3xl font-bold tracking-tight">Menü & Ürünler</h2>
          <p class="text-base text-white/60 mt-1">Kategorileri, ürünleri, opsiyonları, tarifleri ve istasyon yönlendirmelerini yönetin.</p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

          <!-- SOL: Kategoriler -->
          <aside class="lg:col-span-3 glassmorphism p-6 rounded-2xl h-fit lg:sticky lg:top-6">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-xl font-semibold">Kategoriler</h3>
              <button id="btnAddCategory" class="bg-white/10 px-3 py-1.5 rounded-lg text-sm hover:bg-white/20 flex items-center gap-1">
                <span class="material-symbols-outlined text-base">add</span> Ekle
              </button>
            </div>

            <ul id="catList" class="space-y-2">
              <!-- JS doldurur -->
            </ul>

            <div class="mt-5 p-3 rounded-lg bg-white/5 border border-white/10">
              <div class="text-sm text-white/60 mb-2">Kategori Varsayılan İstasyonu</div>
              <div class="flex gap-2">
                <select id="catStationSel" class="flex-1 bg-white/10 border-white/10 rounded px-3 py-2"></select>
                <button id="btnSaveCatStation" class="bg-cyan-500 px-3 py-2 rounded">Kaydet</button>
              </div>
            </div>
          </aside>

          <!-- SAĞ: Ürünler -->
          <section class="lg:col-span-9 glassmorphism p-6 md:p-8 rounded-2xl">
            <!-- Toolbar -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
              <div class="flex items-center gap-3 flex-1">
                <div class="relative flex-1">
                  <span class="material-symbols-outlined absolute left-3 top-2.5 text-white/50 text-lg">search</span>
                  <input id="searchBox" placeholder="Ürün ara..." class="w-full pl-10 rounded-md bg-white/10 border-white/10"/>
                </div>
                <select id="filterCategory" class="bg-white/10 border-white/10 rounded-md px-3 py-2">
                  <option value="">Tüm Kategoriler</option>
                </select>
              </div>
              <div class="flex items-center gap-2">
                <button id="btnBulkPrice" class="bg-white/10 px-3 py-2 rounded-lg text-sm hover:bg-white/20 flex items-center gap-1">
                  <span class="material-symbols-outlined text-base">percent</span> Fiyatları Ayarla
                </button>
                <button id="btnAddProduct" class="bg-cyan-500 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-cyan-600 flex items-center gap-1">
                  <span class="material-symbols-outlined text-base">add</span> Ürün Ekle
                </button>
              </div>
            </div>

            <!-- Grid -->
            <div id="productGrid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
              <!-- JS doldurur -->
            </div>
            <div id="loadMoreHint" class="text-center text-white/50 text-sm mt-4 hidden">Daha fazla yükleniyor…</div>
          </section>
        </div>
      </div>
    </main>
  </div>
</div>

<!-- ÜRÜN MODAL (temel bilgiler) -->
<div id="productModal" class="hidden fixed inset-0 z-50 grid place-items-center bg-black/60 p-4">
  <div class="w-full max-w-xl glassmorphism rounded-2xl overflow-hidden">
    <div class="p-5 border-b border-white/10 flex items-center justify-between">
      <h4 id="pmTitle" class="text-lg font-semibold">Ürün</h4>
      <button data-close="#productModal" class="p-2 hover:bg-white/10 rounded-full"><span class="material-symbols-outlined">close</span></button>
    </div>
    <form id="productForm" class="p-5 space-y-4">
      <input type="hidden" name="id" id="pmId">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="text-sm text-white/70">Ad</label>
          <input name="name" id="pmName" class="bg-white/10 border-white/10 rounded w-full mt-1" required/>
        </div>
        <div>
          <label class="text-sm text-white/70">Kategori</label>
          <select name="category_id" id="pmCategory" class="bg-white/10 border-white/10 rounded w-full mt-1"></select>
        </div>
        <div>
          <label class="text-sm text-white/70">Fiyat</label>
          <input type="number" step="0.01" name="price" id="pmPrice" class="bg-white/10 border-white/10 rounded w-full mt-1" required/>
        </div>
        <div>
          <label class="text-sm text-white/70">SKU</label>
          <input name="sku" id="pmSku" class="bg-white/10 border-white/10 rounded w-full mt-1"/>
        </div>
        <div class="md:col-span-2">
          <label class="text-sm text-white/70">Görsel URL</label>
          <input name="image_url" id="pmImg" class="bg-white/10 border-white/10 rounded w-full mt-1"/>
        </div>
        <label class="inline-flex items-center gap-2 mt-1">
          <input type="checkbox" id="pmActive" class="rounded"> Aktif
        </label>
      </div>
      <div class="flex justify-end gap-2 pt-2">
        <button type="button" data-close="#productModal" class="px-4 py-2 bg-white/10 rounded-lg">Vazgeç</button>
        <button type="submit" class="px-4 py-2 bg-cyan-500 rounded-lg">Kaydet</button>
      </div>
    </form>
  </div>
</div>

<!-- KATEGORİ EKLE/MODAL (sadece ad) -->
<div id="categoryModal" class="hidden fixed inset-0 z-50 grid place-items-center bg-black/60 p-4">
  <div class="w-full max-w-sm glassmorphism rounded-2xl overflow-hidden">
    <div class="p-5 border-b border-white/10 flex items-center justify-between">
      <h4 class="text-lg font-semibold">Kategori</h4>
      <button data-close="#categoryModal" class="p-2 hover:bg-white/10 rounded-full"><span class="material-symbols-outlined">close</span></button>
    </div>
    <form id="categoryForm" class="p-5 space-y-4">
      <input type="hidden" id="cmId">
      <div>
        <label class="text-sm text-white/70">Ad</label>
        <input id="cmName" class="bg-white/10 border-white/10 rounded w-full mt-1" required/>
      </div>
      <div class="flex justify-end gap-2 pt-2">
        <button type="button" data-close="#categoryModal" class="px-4 py-2 bg-white/10 rounded-lg">Vazgeç</button>
        <button type="submit" class="px-4 py-2 bg-cyan-500 rounded-lg">Kaydet</button>
      </div>
    </form>
  </div>
</div>

<!-- DRAWER (Ayrıntılar: Opsiyonlar / Malzemeler / İstasyon) -->
<aside id="drawer" class="fixed top-0 right-0 w-full max-w-3xl h-full bg-slate-900/95 backdrop-blur-lg border-l border-white/10 translate-x-full transition-transform z-50 overflow-y-auto">
  <div class="p-5 border-b border-white/10 flex items-center justify-between">
    <h3 id="drawerTitle" class="text-xl font-semibold"></h3>
    <button id="drawerClose" class="p-2 hover:bg-white/10 rounded-full"><span class="material-symbols-outlined">close</span></button>
  </div>
  <div class="p-5">
    <div class="flex gap-2 mb-4">
      <button data-tab="opt" class="tabbtn bg-white/10 px-3 py-1.5 rounded">Opsiyonlar</button>
      <button data-tab="ing" class="tabbtn px-3 py-1.5 rounded">Malzemeler</button>
      <button data-tab="st"  class="tabbtn px-3 py-1.5 rounded">İstasyon</button>
    </div>

    <!-- OPSİYONLAR -->
    <section id="tab-opt" class="space-y-3">
      <div class="flex items-center justify-between">
        <h4 class="font-semibold">Opsiyon Grupları</h4>
        <button id="btnAddOption" class="bg-white/10 px-3 py-1.5 rounded">Grup Ekle</button>
      </div>
      <div id="optionList" class="space-y-3"></div>
    </section>

    <!-- MALZEMELER -->
    <section id="tab-ing" class="hidden space-y-3">
      <div class="flex items-center gap-2">
        <input id="ingSearch" placeholder="Malzeme ara..." class="bg-white/10 border-white/10 rounded px-3 py-2 flex-1"/>
        <button id="btnAddIngredient" class="bg-white/10 px-3 py-1.5 rounded">Ekle</button>
      </div>
      <table class="w-full text-sm">
        <thead class="text-white/60 border-b border-white/10">
          <tr><th class="py-2 text-left">Malzeme</th><th class="text-left">Miktar</th><th>Birim</th><th></th></tr>
        </thead>
        <tbody id="ingBody"></tbody>
      </table>
    </section>

    <!-- İSTASYON -->
    <section id="tab-st" class="hidden space-y-4">
      <div class="p-3 bg-white/5 rounded border border-white/10">
        <div class="text-sm text-white/60">Kategori varsayılan istasyon:</div>
        <div id="catStationInfo" class="font-medium mt-1">—</div>
      </div>
      <div class="p-3 bg-white/5 rounded border border-white/10">
        <div class="mb-2">Bu ürün için override:</div>
        <div class="flex gap-2">
          <select id="prodStation" class="bg-white/10 border-white/10 rounded px-3 py-2 flex-1"></select>
          <button id="btnSaveProdStation" class="bg-cyan-500 px-3 py-2 rounded">Kaydet</button>
          <button id="btnClearProdStation" class="bg-white/10 px-3 py-2 rounded">Temizle</button>
        </div>
      </div>
    </section>
  </div>
</aside>

<!-- Toasts -->
<div id="toasts" class="fixed top-4 right-4 z-[60] space-y-3 pointer-events-none"></div>

<script>
/* ================== API PATHS ================== */
const API = {
  cats: '/api/v1/categories',
  catRule: (cid)=> `/api/v1/categories/${cid}/station-rule`,
  stations: '/api/v1/stations',

  prods: '/api/v1/products',
  prod:  (id)=> `/api/v1/products/${id}`,
  clone: (id)=> `/api/v1/products/${id}/clone`,

  opts:  (pid)=> `/api/v1/products/${pid}/options`,
  opt:   (id)=> `/api/v1/product-options/${id}`,
  vals:  (opt)=> `/api/v1/product-options/${opt}/values`,
  val:   (id)=> `/api/v1/product-option-values/${id}`,

  ings:  (pid)=> `/api/v1/products/${pid}/ingredients`,
  ing:   (id)=> `/api/v1/product-ingredients/${id}`,
  ingDict: '/api/v1/ingredients',

  // bulk helpers (opsiyon/values sıralama yapmak istersen)
  optSort:  '/api/v1/product-options/bulk/sort',
  valSort:  '/api/v1/product-option-values/bulk/sort'
};
const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '';

/* =========== Helpers =========== */
const $ = (s,el=document)=>el.querySelector(s);
const $$= (s,el=document)=>[...el.querySelectorAll(s)];
const j = (url)=>fetch(url,{credentials:'same-origin'}).then(r=>r.json());
const send = (url,method,body)=>fetch(url,{method,headers:{'Content-Type':'application/json','X-CSRF-Token':CSRF},body:JSON.stringify(body||{}),credentials:'same-origin'}).then(r=>r.json());
const del  = (url)=>fetch(url,{method:'DELETE',headers:{'X-CSRF-Token':CSRF},credentials:'same-origin'}).then(r=>r.json().catch(()=>({})));

function toast(type='info', msg='Bilgi', ms=2200){
  const root = $('#toasts'); if(!root) return;
  const c = {success:'border-emerald-500/40 bg-emerald-500/10 text-emerald-100',
             error:'border-red-500/40 bg-red-500/10 text-red-100',
             info:'border-cyan-500/40 bg-cyan-500/10 text-cyan-100'}[type]||'bg-white/10';
  const w=document.createElement('div');
  w.className=`pointer-events-auto w-80 sm:w-96 rounded-xl border ${c} backdrop-blur-lg shadow-2xl px-4 py-3 transition-all opacity-0 translate-y-2`;
  w.innerHTML=`<div class="text-sm">${msg}</div>`;
  root.appendChild(w);
  requestAnimationFrame(()=>{w.classList.remove('opacity-0','translate-y-2')});
  setTimeout(()=>{w.classList.add('opacity-0'); setTimeout(()=>w.remove(),200)},ms);
}
const money=(n)=>new Intl.NumberFormat('tr-TR',{style:'currency',currency:'TRY'}).format(Number(n||0));

/* =========== State =========== */
let CATS=[], STATIONS=[];
let CAT_SELECTED=null;       // sol listede seçili
let CAT_STATION_MAP=new Map(); // category_id -> station_id|null
let PRODUCTS=[], PAGE=1, MORE=true, Q='';

let CURRENT_PRODUCT=null; // drawer

/* =========== Kategori Bölümü =========== */
async function loadCategories(){
  const res = await j(API.cats); CATS = res?.data || res || [];
  const list = $('#catList'); list.innerHTML='';
  CATS.forEach(c=>{
    const li=document.createElement('li');
    const active = CAT_SELECTED? (Number(CAT_SELECTED)===Number(c.id)) : false;
    li.innerHTML=`
      <div class="flex items-center gap-2">
        <button class="flex-1 text-left p-3 rounded-lg ${active?'bg-cyan-500/20 text-cyan-300 border border-cyan-500/30':'hover:bg-white/10 text-white/80'}" data-cat="${c.id}">
          <div class="font-semibold">${c.name}</div>
        </button>
        <button class="p-2 rounded hover:bg-white/10" title="Düzenle" data-cat-edit="${c.id}">
          <span class="material-symbols-outlined text-base">edit</span>
        </button>
        <button class="p-2 rounded hover:bg-white/10 text-red-300" title="Sil" data-cat-del="${c.id}">
          <span class="material-symbols-outlined text-base">delete</span>
        </button>
      </div>`;
    list.appendChild(li);
  });
  // filtre select
  const sel = $('#filterCategory');
  sel.innerHTML = `<option value="">Tüm Kategoriler</option>` + CATS.map(c=>`<option value="${c.id}">${c.name}</option>`).join('');
  // modal select
  const psel = $('#pmCategory'); psel.innerHTML = CATS.map(c=>`<option value="${c.id}">${c.name}</option>`).join('');

  // varsayılan istasyon seçicisi
  const stSel = $('#catStationSel'); stSel.innerHTML = `<option value="">(Yok)</option>` + STATIONS.map(s=>`<option value="${s.id}">${s.name}</option>`).join('');
  updateCatStationUI();
}
function updateCatStationUI(){
  const info = $('#catStationInfo');
  if(!CURRENT_PRODUCT){ info.textContent='—'; return; }
  const catId = CURRENT_PRODUCT.category_id;
  const sid = CAT_STATION_MAP.get(Number(catId));
  const st = STATIONS.find(s=>s.id==sid);
  info.textContent = st ? `${st.name} (#${st.id})` : '—';
  $('#catStationSel').value = sid || '';
}

/* =========== Ürün Grid =========== */
async function loadProducts(reset=false){
  if(reset){ PAGE=1; MORE=true; PRODUCTS=[]; $('#productGrid').innerHTML=''; }
  if(!MORE) return;
  $('#loadMoreHint').classList.remove('hidden');

  const url = new URL(API.prods, location.origin);
  url.searchParams.set('page', PAGE);
  url.searchParams.set('limit', 24);
  if(Q) url.searchParams.set('q', Q);
  if(CAT_SELECTED) url.searchParams.set('category_id', CAT_SELECTED);

  const res = await j(url);
  const items = res?.data || res?.items || [];
  MORE = items.length===24;
  PAGE += 1;

  items.forEach(p=>{ PRODUCTS.push(p); renderProductCard(p); });
  $('#loadMoreHint').classList.toggle('hidden', true);
}
function renderProductCard(p){
  const el = document.createElement('div');
  el.className='bg-black/20 border border-white/10 rounded-xl overflow-hidden flex flex-col';
  el.innerHTML=`
    <img src="${p.image_url||'https://picsum.photos/600/300?blur=2'}" class="w-full h-40 object-cover" alt="">
    <div class="p-4 flex-grow">
      <h4 class="font-semibold text-lg line-clamp-1">${p.name}</h4>
      <p class="text-cyan-400 font-medium mt-1">${money(p.price)}</p>
    </div>
    <div class="p-4 bg-black/30 flex justify-end gap-2">
      <button class="p-2 hover:bg-white/10 rounded-full" title="Ayrıntılar" data-open-drawer="${p.id}">
        <span class="material-symbols-outlined">settings</span>
      </button>
      <button class="p-2 hover:bg-white/10 rounded-full" title="Düzenle" data-prod-edit="${p.id}">
        <span class="material-symbols-outlined">edit</span>
      </button>
      <button class="p-2 hover:bg-white/10 rounded-full text-red-300" title="Sil" data-prod-del="${p.id}">
        <span class="material-symbols-outlined">delete</span>
      </button>
    </div>`;
  $('#productGrid').appendChild(el);
}

/* =========== Drawer =========== */
function openDrawer(){ $('#drawer').classList.remove('translate-x-full'); }
function closeDrawer(){ $('#drawer').classList.add('translate-x-full'); }
$('#drawerClose').addEventListener('click', closeDrawer);
document.addEventListener('keydown', e=>{ if(e.key==='Escape') closeDrawer(); });

$$('.tabbtn').forEach(b=>b.addEventListener('click',()=>openTab(b.dataset.tab)));
function setActiveTab(which){
  $('#tab-opt').classList.add('hidden');
  $('#tab-ing').classList.add('hidden');
  $('#tab-st').classList.add('hidden');
  $(`.tabbtn[data-tab="${which}"]`).classList.add('bg-white/10');
}
async function openTab(which){
  $$('.tabbtn').forEach(b=>b.classList.remove('bg-white/10'));
  setActiveTab(which);
  if(which==='opt'){ $('#tab-opt').classList.remove('hidden'); await loadOptions(); }
  if(which==='ing'){ $('#tab-ing').classList.remove('hidden'); await loadIngredients(); }
  if(which==='st'){  $('#tab-st').classList.remove('hidden'); await loadStationsTab(); }
}

/* -------- Opsiyonlar -------- */
async function loadOptions(){
  const res = await j(API.opts(CURRENT_PRODUCT.id));
  const groups = res?.data||[];
  const list = $('#optionList'); list.innerHTML='';
  groups.forEach(g=>{
    const box = document.createElement('div');
    box.className='p-3 rounded border border-white/10 bg-white/5';
    box.innerHTML = `
      <div class="flex items-center gap-2">
        <input class="bg-white/10 border-white/10 rounded px-2 py-1 flex-1" value="${g.name}" data-opt-name="${g.id}">
        <label class="ml-2 text-sm"><input type="checkbox" ${g.required?'checked':''} data-opt-req="${g.id}"> Zorunlu</label>
        <label class="ml-2 text-sm"><input type="checkbox" ${g.multiple?'checked':''} data-opt-mul="${g.id}"> Çoklu</label>
        <button class="ml-auto text-red-300 hover:underline" data-opt-del="${g.id}">sil</button>
      </div>
      <div class="mt-3 space-y-2" data-values="${g.id}">
        ${(g.values||[]).map(v=>`
          <div class="flex items-center gap-2" data-val-row="${v.id}">
            <input class="bg-white/10 border-white/10 rounded px-2 py-1 flex-1" value="${v.label}" data-val-label="${v.id}">
            <input type="number" step="0.01" class="w-28 bg-white/10 border-white/10 rounded px-2 py-1" value="${v.price_delta}" data-val-price="${v.id}">
            <button class="text-red-300 hover:underline" data-val-del="${v.id}">sil</button>
          </div>`).join('')}
        <button class="mt-2 bg-white/10 px-2 py-1 rounded text-sm" data-val-add="${g.id}">seçenek ekle</button>
      </div>`;
    list.appendChild(box);
  });
}
document.addEventListener('change', async (e)=>{
  const t=e.target;
  if(t.matches('[data-opt-name]')){ await send(API.opt(t.dataset.optName),'PATCH',{name:t.value}); }
  if(t.matches('[data-opt-req]')) { await send(API.opt(t.dataset.optReq),'PATCH',{required:t.checked?1:0}); }
  if(t.matches('[data-opt-mul]')) { await send(API.opt(t.dataset.optMul),'PATCH',{multiple:t.checked?1:0}); }
  if(t.matches('[data-val-label]')){ await send(API.val(t.dataset.valLabel),'PATCH',{label:t.value}); }
  if(t.matches('[data-val-price]')){ await send(API.val(t.dataset.valPrice),'PATCH',{price_delta:Number(t.value||0)}); }
});
document.addEventListener('click', async (e)=>{
  const add = e.target.closest('[data-val-add]');
  if(add){ await send(API.vals(add.dataset.valAdd),'POST',{label:'Yeni',price_delta:0}); await loadOptions(); return; }
  const vd = e.target.closest('[data-val-del]');
  if(vd){ await del(API.val(vd.dataset.valDel)); vd.closest('[data-val-row]')?.remove(); return; }
  const od = e.target.closest('[data-opt-del]');
  if(od){ if(!confirm('Grup silinsin mi?')) return; await del(API.opt(od.dataset.optDel)); await loadOptions(); return; }
  if(e.target.id==='btnAddOption'){ await send(API.opts(CURRENT_PRODUCT.id),'POST',{name:'Yeni Grup',required:0,multiple:0}); await loadOptions(); }
});

/* -------- Malzemeler (Tarif) -------- */
async function loadIngredients(){
  const res = await j(API.ings(CURRENT_PRODUCT.id));
  const rows = res?.data||[];
  const tbody = $('#ingBody'); tbody.innerHTML='';
  rows.forEach(r=>{
    const tr=document.createElement('tr');
    tr.innerHTML=`
      <td class="py-2">${r.ingredient_name}</td>
      <td><input type="number" step="0.01" value="${r.quantity_used}" class="bg-white/10 border-white/10 rounded px-2 py-1 w-28" data-ing-qty="${r.id}"></td>
      <td class="text-white/60">${r.unit||''}</td>
      <td class="text-right"><button class="text-red-300 hover:underline" data-ing-del="${r.id}">sil</button></td>`;
    tbody.appendChild(tr);
  });
}
document.addEventListener('change', async (e)=>{
  if(e.target.matches('[data-ing-qty]')){
    const id=e.target.dataset.ingQty;
    await send(API.ing(id),'PATCH',{quantity_used:Number(e.target.value||0)});
  }
});
document.addEventListener('click', async (e)=>{
  const delBtn = e.target.closest('[data-ing-del]');
  if(delBtn){ await del(API.ing(delBtn.dataset.ingDel)); await loadIngredients(); }
});
$('#btnAddIngredient').addEventListener('click', async ()=>{
  const q = $('#ingSearch').value.trim(); if(!q) return;
  const dict = await j(`${API.ingDict}?q=${encodeURIComponent(q)}`);
  const first = (dict?.data||[])[0];
  if(!first) { toast('error','Bulunamadı'); return; }
  await send(API.ings(CURRENT_PRODUCT.id),'POST',{ingredient_id:first.id, quantity_used:1});
  $('#ingSearch').value=''; await loadIngredients(); toast('success','Eklendi');
});

/* -------- İstasyon -------- */
async function loadStationsTab(){
  // kategori varsayılanını getir/cache
  const catId = CURRENT_PRODUCT.category_id;
  if(!CAT_STATION_MAP.has(Number(catId))){
    const r = await j(API.catRule(catId));
    CAT_STATION_MAP.set(Number(catId), r?.station_id ?? null);
  }
  updateCatStationUI();

  // ürün override select
  const sel = $('#prodStation');
  sel.innerHTML = `<option value="">(Kategori varsayılanını kullan)</option>` + STATIONS.map(s=>`<option value="${s.id}">${s.name}</option>`).join('');
  const ov = await j(`/api/v1/products/${CURRENT_PRODUCT.id}/station-override`); // same as API.prodRule
  sel.value = ov?.station_id || '';

  $('#btnSaveProdStation').onclick = async ()=>{
    await send(`/api/v1/products/${CURRENT_PRODUCT.id}/station-override`,'PUT',{station_id: sel.value?Number(sel.value):null});
    toast('success','Ürün istasyonu kaydedildi');
  };
  $('#btnClearProdStation').onclick = async ()=>{
    await send(`/api/v1/products/${CURRENT_PRODUCT.id}/station-override`,'PUT',{station_id:null});
    sel.value=''; toast('success','Override temizlendi');
  };
}
// sol panel: kategori varsayılan istasyon kaydet
$('#btnSaveCatStation').addEventListener('click', async ()=>{
  if(!CAT_SELECTED){ toast('error','Önce kategori seç'); return; }
  const sid = $('#catStationSel').value? Number($('#catStationSel').value): null;
  await send(API.catRule(CAT_SELECTED),'PUT',{station_id:sid});
  CAT_STATION_MAP.set(Number(CAT_SELECTED), sid);
  if(CURRENT_PRODUCT) updateCatStationUI();
  toast('success','Kategori varsayılan istasyon güncellendi');
});

/* =========== Event Delegation (grid + sol panel) =========== */
document.addEventListener('click', async (e)=>{
  const catBtn = e.target.closest('[data-cat]');
  if(catBtn){
    CAT_SELECTED = Number(catBtn.dataset.cat);
    // UI refresh
    $$('#catList [data-cat]').forEach(b=>b.parentElement.parentElement.querySelector('[data-cat]').classList.remove('bg-cyan-500/20','text-cyan-300','border','border-cyan-500/30'));
    catBtn.classList.add('bg-cyan-500/20','text-cyan-300','border','border-cyan-500/30');
    $('#filterCategory').value = CAT_SELECTED;
    await loadProducts(true);
  }

  const catEdit = e.target.closest('[data-cat-edit]');
  if(catEdit){
    const id = Number(catEdit.dataset.catEdit);
    const c  = CATS.find(x=>x.id==id);
    $('#cmId').value = id;
    $('#cmName').value = c?.name||'';
    openModal('#categoryModal');
  }

  const catDel = e.target.closest('[data-cat-del]');
  if(catDel){
    if(!confirm('Kategori silinsin mi?')) return;
    await del(`${API.cats}/${catDel.dataset.catDel}`);
    await loadCategories(); await loadProducts(true);
    toast('success','Kategori silindi');
  }

  const pEdit = e.target.closest('[data-prod-edit]');
  if(pEdit){
    const id = Number(pEdit.dataset.prodEdit);
    const p  = PRODUCTS.find(x=>x.id==id);
    $('#pmId').value = p.id;
    $('#pmName').value = p.name || '';
    $('#pmCategory').value = p.category_id || '';
    $('#pmPrice').value = p.price || 0;
    $('#pmSku').value   = p.sku || '';
    $('#pmImg').value   = p.image_url || '';
    $('#pmActive').checked = !!p.active;
    $('#pmTitle').textContent = 'Ürün Düzenle';
    openModal('#productModal');
  }

  const pDel = e.target.closest('[data-prod-del]');
  if(pDel){
    if(!confirm('Ürün silinsin mi?')) return;
    await del(API.prod(pDel.dataset.prodDel));
    await loadProducts(true);
    toast('success','Ürün silindi');
  }

  const openD = e.target.closest('[data-open-drawer]');
  if(openD){
    const id = Number(openD.dataset.openDrawer);
    CURRENT_PRODUCT = PRODUCTS.find(x=>x.id==id);
    $('#drawerTitle').textContent = `Ayrıntılar: ${CURRENT_PRODUCT.name}`;
    openDrawer(); await openTab('opt');
  }
});

/* =========== Modallar =========== */
function openModal(id){ $(id).classList.remove('hidden'); }
function closeModal(id){ $(id).classList.add('hidden'); }
document.addEventListener('click',(e)=>{
  const c = e.target.closest('[data-close]'); if(c) closeModal(c.dataset.close);
});

/* Ürün oluştur */
$('#btnAddProduct').addEventListener('click', ()=>{
  $('#pmId').value = '';
  $('#pmName').value = '';
  $('#pmCategory').value = CAT_SELECTED || $('#pmCategory option')?.[0]?.value || '';
  $('#pmPrice').value = '0';
  $('#pmSku').value = '';
  $('#pmImg').value = '';
  $('#pmActive').checked = true;
  $('#pmTitle').textContent = 'Ürün Ekle';
  openModal('#productModal');
});
$('#productForm').addEventListener('submit', async (e)=>{
  e.preventDefault();
  const id = $('#pmId').value;
  const body = {
    name: $('#pmName').value.trim(),
    category_id: Number($('#pmCategory').value),
    price: Number($('#pmPrice').value||0),
    sku: $('#pmSku').value.trim() || null,
    image_url: $('#pmImg').value.trim() || null,
    active: $('#pmActive').checked ? 1 : 0
  };
  const url = id ? API.prod(id) : API.prods;
  const method = id ? 'PATCH' : 'POST';
  await send(url,method,body);
  closeModal('#productModal');
  await loadProducts(true);
  toast('success', id?'Ürün güncellendi':'Ürün eklendi');
});

/* Kategori ekle/düzenle */
$('#btnAddCategory').addEventListener('click', ()=>{
  $('#cmId').value = '';
  $('#cmName').value = '';
  openModal('#categoryModal');
});
$('#categoryForm').addEventListener('submit', async (e)=>{
  e.preventDefault();
  const id = $('#cmId').value;
  const name = $('#cmName').value.trim();
  if(!name) return;
  const url = id ? `${API.cats}/${id}` : API.cats;
  const method = id ? 'PATCH' : 'POST';
  await send(url,method,{name});
  closeModal('#categoryModal');
  await loadCategories();
  await loadProducts(true);
  toast('success','Kategori kaydedildi');
});

/* Filtre / arama */
$('#filterCategory').addEventListener('change', (e)=>{
  CAT_SELECTED = e.target.value || null;
  loadProducts(true);
});
$('#searchBox').addEventListener('input', (e)=>{
  Q = e.target.value.trim();
  loadProducts(true);
});

/* Sonsuz scroll */
window.addEventListener('scroll', ()=>{
  if(!MORE) return;
  if(window.innerHeight + window.scrollY > document.body.offsetHeight - 300){
    loadProducts(false);
  }
});

/* Stations + Categories bootstrap */
(async function init(){
  STATIONS = (await j(API.stations))?.data || [];
  // kategori varsayılan istasyon cache’ini tohumlamak için (isteğe bağlı)
  await loadCategories();
  await loadProducts(true);
})();
</script>
</body>
</html>
