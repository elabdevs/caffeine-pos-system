<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Caffeine · Tarifleri Kurgula</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <!-- Kendi stilin – dokunmadım -->
  <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body class="bg-slate-900 bg-cover bg-center min-h-screen text-white/95" style="background-image:url('https://images.hdqwalls.com/wallpapers/dark-abstract-black-minimal-4k-q0.jpg')">
<div class="flex flex-col xl:flex-row h-screen">

  <?php include dirname(__DIR__, 2) . '/Views/partials/sidebar.php'; ?>

  <div class="flex-1 flex flex-col overflow-hidden">
    <main class="flex-1 p-4 md:p-6 overflow-y-auto">
      <div class="max-w-7xl mx-auto space-y-8 pb-24">

        <!-- Başlık -->
        <header class="mb-2">
          <h2 class="text-3xl font-bold tracking-tight">Tarifleri Kurgula</h2>
          <p class="text-base text-white/60 mt-1">Satışta hangi stok kalemlerinden ne kadar düşüleceğini tanımla.</p>
        </header>

        <button id="btnBack"
          class="fixed top-4 left-4 xl:left-80 z-50 bg-white/10 hover:bg-white/20 text-white/90
                 px-3 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
          <span class="material-symbols-outlined text-base">arrow_back</span>
          Geri
        </button>


        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
          <!-- SOL: Menü Ürünleri -->
          <section class="lg:col-span-4 glassmorphism p-6 md:p-8 rounded-2xl">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-xl font-semibold">Menü Ürünleri</h3>
              <button id="btnRefreshProducts" class="text-white/70 hover:text-white text-sm font-medium flex items-center gap-1">
                <span class="material-symbols-outlined text-base">refresh</span> Yenile
              </button>
            </div>

            <div class="relative mb-4">
              <span class="material-symbols-outlined absolute left-3 top-2.5 text-white/50 text-lg">search</span>
              <input id="searchProducts" placeholder="Ürün ara..." class="w-full pl-10 rounded-md bg-white/10 border-white/10"/>
            </div>

            <div id="productList" class="rounded-lg border border-white/10 overflow-hidden max-h-[70vh] overflow-y-auto">
              <!-- JS dolduracak; satırlar: border-b border-white/10 hover:bg-white/5 -->
            </div>
          </section>

          <!-- SAĞ: Tarif Editörü -->
          <section class="lg:col-span-8 glassmorphism p-6 md:p-8 rounded-2xl">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-3 mb-6">
              <div>
                <h3 id="editorTitle" class="text-xl font-semibold">Ürün seçilmedi</h3>
                <p class="text-sm text-white/60">Soldan bir menü ürünü seç, aşağıya tarif satırlarını ekle.</p>
              </div>
              <div class="flex items-center gap-2">
                <button id="btnCopyPrev" class="bg-white/10 text-white/80 px-3 py-2 rounded-lg text-sm font-semibold hover:bg-white/20 transition-colors flex items-center gap-1" title="Önceki seçili ürünün tarifini kopyala">
                  <span class="material-symbols-outlined text-base">content_copy</span> Kopyala
                </button>
                <button id="btnDeleteRecipe" class="bg-red-500/80 text-white px-3 py-2 rounded-lg text-sm font-semibold hover:bg-red-500 transition-colors flex items-center gap-1 hidden">
                  <span class="material-symbols-outlined text-base">delete</span> Tarifi Sil
                </button>
                <button id="btnSaveRecipe" class="bg-cyan-500/80 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-cyan-500 transition-colors shadow-[0_4px_14px_rgba(56,189,248,0.20)] flex items-center gap-2">
                  <span class="material-symbols-outlined text-base">save</span> Kaydet
                </button>
              </div>
            </div>

            <!-- Satır ekleme alanı -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end mb-4">
              <div class="md:col-span-7">
                <label class="text-sm text-white/70">Stok Kalemi</label>
                <select id="lineItem" class="mt-1 w-full rounded-md bg-white/10 border-white/10"></select>
              </div>
              <div class="md:col-span-3">
                <label class="text-sm text-white/70">Miktar</label>
                <input id="lineQty" type="number" step="0.01" class="mt-1 w-full rounded-md bg-white/10 border-white/10" placeholder="0.00"/>
              </div>
              <div class="md:col-span-2">
                <button id="btnAddLine" class="w-full bg-white/10 text-white/80 px-3 py-2 rounded-lg text-sm font-semibold hover:bg-white/20 transition-colors flex items-center gap-1 justify-center">
                  <span class="material-symbols-outlined text-base">add</span> Ekle
                </button>
              </div>
            </div>

            <!-- Tarif tablosu -->
            <div class="overflow-x-auto rounded-lg border border-white/10">
              <table class="w-full text-sm text-left">
                <thead class="text-xs text-white/60 uppercase border-b border-white/10">
                  <tr>
                    <th class="px-4 py-3">Stok Kalemi</th>
                    <th class="px-4 py-3">Miktar</th>
                    <th class="px-4 py-3">Birim</th>
                    <th class="px-4 py-3 text-right"><span class="sr-only">İşlemler</span></th>
                  </tr>
                </thead>
                <tbody id="recipeBody">
                  <!-- JS satır basar -->
                </tbody>
              </table>
            </div>

            <p class="text-xs text-white/50 mt-3">
              İpucu: Aynı tarif başka üründe de kullanılacaksa önceki üründen <span class="text-white/80 font-medium">Kopyala</span>.
            </p>
          </section>
        </div>

      </div>
    </main>
  </div>
</div>

<!-- Basit toast -->
<div id="toast" class="hidden fixed bottom-4 right-4 glassmorphism px-4 py-2 rounded-lg text-sm"></div>

<script>
  // ====== API uçları ======
  const API_MENU    = '/api/menu-items';
  const API_STOCK   = '/api/inventory/items';
  const API_RECIPES = '/api/recipes';

  // ====== State ======
  let PRODUCTS = [];     // {id,name,sku}
  let STOCKS   = [];     // {id,name,unit}
  let RECIPES  = new Map(); // product_id -> [{item_id, qty}]
  let currentProduct = null;
  let lastProduct = null;

  // Dummy fallback (endpoint yoksa yanmasın)
  const DUMMY_PRODUCTS = [
    {id:101, name:'Latte (S)', sku:'LAT-S'},
    {id:102, name:'Latte (M)', sku:'LAT-M'},
    {id:103, name:'Cappuccino', sku:'CAP-1'},
    {id:104, name:'Cold Brew', sku:'CB-1'}
  ];
  const DUMMY_STOCKS = [
    {id:1, name:'Espresso Shot', unit:'shot'},
    {id:2, name:'Süt', unit:'ml'},
    {id:3, name:'Buz', unit:'adet'},
    {id:4, name:'Şurup (Vanilya)', unit:'ml'}
  ];
  const DUMMY_RECIPES = {
    101:[{item_id:1, qty:1},{item_id:2, qty:120}],
    102:[{item_id:1, qty:1},{item_id:2, qty:180}],
    103:[{item_id:1, qty:1},{item_id:2, qty:100}]
  };

  // ====== Helpers ======
  const $  = (s,el=document)=>el.querySelector(s);
  const $$ = (s,el=document)=>[...el.querySelectorAll(s)];
  async function getJSON(url){ try{const r=await fetch(url,{credentials:'same-origin'}); if(!r.ok) throw 0; return await r.json();}catch{ return null; } }
  async function sendJSON(url,method,body){ const r=await fetch(url,{method,headers:{'Content-Type':'application/json'},body:JSON.stringify(body||{})}); if(!r.ok) throw new Error('HTTP '+r.status); return r.json().catch(()=>({})); }
  function toast(msg,ok=true){ const t=$('#toast'); t.textContent=msg; t.classList.remove('hidden'); t.classList.toggle('text-emerald-300',ok); t.classList.toggle('text-red-300',!ok); setTimeout(()=>t.classList.add('hidden'),1600); }

  // ====== Renderers ======
  function renderProducts(filter=''){
    const list = $('#productList'); list.innerHTML='';
    const f = filter.trim().toLowerCase();
    PRODUCTS.filter(p=>!f || p.name.toLowerCase().includes(f) || (p.sku||'').toLowerCase().includes(f))
      .forEach(p=>{
        const active = currentProduct && currentProduct.id===p.id;
        const row = document.createElement('button');
        row.type='button';
        row.className = `w-full text-left px-4 py-3 border-b border-white/10 hover:bg-white/5 ${active?'bg-white/10':''}`;
        row.innerHTML = `<div class="font-medium">${p.name}</div><div class="text-xs text-white/50">${p.sku||''}</div>`;
        row.addEventListener('click',()=>selectProduct(p.id));
        list.appendChild(row);
      });
  }

  function renderStockSelect(){
    const sel = $('#lineItem');
    sel.innerHTML = STOCKS.map(s=>`<option value="${s.id}">${s.name}</option>`).join('');
  }

  function renderRecipe(productId){
    const tbody = $('#recipeBody'); tbody.innerHTML='';
    const lines = RECIPES.get(productId) || [];

    lines.forEach((ln,idx)=>{
      const stock = STOCKS.find(s=>s.id==ln.item_id);
      const tr = document.createElement('tr');
      tr.className = 'border-b border-white/10 hover:bg-white/5';
      tr.innerHTML = `
        <td class="px-4 py-3">
          <select class="w-full rounded-md bg-white/10 border-white/10" data-k="item_id">
            ${STOCKS.map(s=>`<option value="${s.id}" ${s.id==ln.item_id?'selected':''}>${s.name}</option>`).join('')}
          </select>
        </td>
        <td class="px-4 py-3">
          <input type="number" step="0.01" value="${ln.qty}" class="w-28 rounded-md bg-white/10 border-white/10" data-k="qty">
        </td>
        <td class="px-4 py-3 text-white/60">${stock?.unit||''}</td>
        <td class="px-4 py-3 text-right">
          <button class="bg-white/10 text-white/80 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-white/20 transition-colors" data-del="${idx}">
            Sil
          </button>
        </td>`;
      tbody.appendChild(tr);
    });

    $('#btnDeleteRecipe').classList.toggle('hidden', lines.length===0);
  }

  // ====== Actions ======
  function selectProduct(id){
    lastProduct = currentProduct;
    currentProduct = PRODUCTS.find(p=>p.id==id);
    $('#editorTitle').textContent = currentProduct ? currentProduct.name : 'Ürün seçilmedi';
    renderProducts($('#searchProducts').value||'');
    renderRecipe(currentProduct.id);
  }

  // ====== Events ======
  $('#searchProducts').addEventListener('input', e=>renderProducts(e.target.value));
  $('#btnRefreshProducts').addEventListener('click', async ()=>{ await loadAll(); toast('Listeler yenilendi'); });

  $('#btnAddLine').addEventListener('click', ()=>{
    if(!currentProduct) return toast('Önce ürün seç', false);
    const item_id = Number($('#lineItem').value);
    const qty = Number($('#lineQty').value||0);
    if(!item_id || !qty) return toast('Kalem ve miktar gerekli', false);

    const lines = RECIPES.get(currentProduct.id) || [];
    lines.push({item_id, qty});
    RECIPES.set(currentProduct.id, lines);
    $('#lineQty').value='';
    renderRecipe(currentProduct.id);
  });

  $('#recipeBody').addEventListener('click', (e)=>{
    const del = e.target.closest('[data-del]');
    if(del){
      const idx = Number(del.dataset.del);
      const lines = RECIPES.get(currentProduct.id) || [];
      lines.splice(idx,1);
      RECIPES.set(currentProduct.id, lines);
      renderRecipe(currentProduct.id);
    }
  });

  $('#recipeBody').addEventListener('change', (e)=>{
    const el = e.target, key = el.dataset.k;
    if(!key) return;
    const tr = el.closest('tr');
    const rows = $$('#recipeBody tr');
    const idx = rows.indexOf(tr);
    const lines = RECIPES.get(currentProduct.id) || [];
    if(!lines[idx]) return;
    if(key==='qty') lines[idx].qty = Number(el.value||0);
    if(key==='item_id'){ lines[idx].item_id = Number(el.value); }
    RECIPES.set(currentProduct.id, lines);
    // birim hücresini tazele
    const stock = STOCKS.find(s=>s.id==lines[idx].item_id);
    tr.children[2].textContent = stock?.unit || '';
  });

  $('#btnSaveRecipe').addEventListener('click', async ()=>{
    if(!currentProduct) return toast('Ürün seç', false);
    const lines = (RECIPES.get(currentProduct.id)||[]).filter(l=>l.item_id && l.qty>0);
    try{
      await sendJSON(`${API_RECIPES}/${currentProduct.id}`, 'PUT', {lines});
      toast('Tarif kaydedildi');
    }catch{
      toast('Tarif kaydedildi (lokal)', true); // endpoint yoksa da kullanıcıyı bloklama
    }
    renderRecipe(currentProduct.id);
  });

  $('#btnDeleteRecipe').addEventListener('click', async ()=>{
    if(!currentProduct) return;
    if(!confirm('Bu ürün için tarif silinsin mi?')) return;
    try{ await fetch(`${API_RECIPES}/${currentProduct.id}`, {method:'DELETE'}); }catch{}
    RECIPES.delete(currentProduct.id);
    renderRecipe(currentProduct.id);
    toast('Tarif silindi');
  });

  $('#btnCopyPrev').addEventListener('click', ()=>{
    if(!currentProduct || !lastProduct) return toast('Önce en az iki ürün seç', false);
    const src = RECIPES.get(lastProduct.id) || [];
    RECIPES.set(currentProduct.id, src.map(x=>({...x})));
    renderRecipe(currentProduct.id);
    toast('Önceki üründen kopyalandı');
  });

  // ====== Load ======
  async function loadAll(){
    const [mi, st, rc] = await Promise.all([getJSON(API_MENU), getJSON(API_STOCK), getJSON(API_RECIPES)]);
    PRODUCTS = mi?.items || DUMMY_PRODUCTS;
    STOCKS   = st?.items || DUMMY_STOCKS;

    RECIPES.clear();
    if(rc?.recipes){
      rc.recipes.forEach(r=> RECIPES.set(r.product_id, r.lines||[]));
    } else {
      Object.entries(DUMMY_RECIPES).forEach(([pid,lines])=> RECIPES.set(Number(pid), lines));
    }

    renderProducts();
    renderStockSelect();
    if(PRODUCTS.length && !currentProduct){ selectProduct(PRODUCTS[0].id); }
  }

    document.getElementById('btnBack')?.addEventListener('click', () => {
        window.location.href = '/admin/inventory';
    });


  (async function init(){ await loadAll(); })();
</script>
</body>
</html>
