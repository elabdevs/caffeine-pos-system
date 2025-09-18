<?php 
$table = \App\Controllers\TablesController::getTableByCode(
  basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)),
  $_SESSION['waiter_branch_id']
);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8"/>
  <title>Caffeine · Sipariş Gir</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
  <meta name="theme-color" content="#111714"/>
  <meta name="apple-mobile-web-app-capable" content="yes"/>
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?display=swap&family=Epilogue:wght@400;500;700;900&family=Noto+Sans:wght@400;500;700;900"/>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
  <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64,"/>
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="apple-mobile-web-app-title" content="Cafe POS">
  <link rel="manifest" href="/manifest.json">
  <?php if(!empty($_SESSION['csrf_token'])): ?> 
  <meta name="csrf" content="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES) ?>">
  <?php endif; ?> 

  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <style type="text/tailwindcss">
    :root{
      --primary:#38e07b; --bg:#111714; --surface:#1b2520; --surface2:#29382f; --txt:#fff; --muted:#9eb7a8;
    }
    html,body{height:100%} body{min-height:100dvh;background:var(--bg)}
    .safe-top{padding-top:max(env(safe-area-inset-top),14px)}
    .safe-bot{padding-bottom:max(env(safe-area-inset-bottom),12px)}
    .icon{font-variation-settings:'wght' 500}
    .app{ @apply mx-auto w-full max-w-[480px] min-h-dvh bg-[#0f1512] text-white;}
    .chip{ @apply px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap;}
    .chip-active{background:var(--primary); color:var(--bg);}
    .chip-idle{background:var(--surface2); color:var(--txt);}
    .card{ @apply rounded-2xl bg-[var(--surface2)] p-3 active:scale-[0.99];}
    .shadow-soft{ box-shadow:0 10px 30px -12px rgba(0,0,0,.5);}
    .sheet{ @apply fixed inset-x-0 bottom-0 translate-y-full transition-transform duration-300;}
    .sheet.open{ transform:translateY(0);}
    .ticket-pill{ @apply fixed right-4 bottom-24 z-30 h-12 rounded-full px-4 bg-[var(--surface)] flex items-center gap-2 shadow-soft;}
  </style>
</head>
<body style='font-family: Epilogue, "Noto Sans", system-ui, -apple-system, Segoe UI, Roboto, sans-serif;'>

<div class="app relative">
  <header class="safe-top px-4 pt-2 sticky top-0 z-20 bg-gradient-to-b from-[#0f1512]/95 to-transparent backdrop-blur">
    <div class="h-12 flex items-center justify-between">
      <button onclick="window.history.back()" class="size-10 grid place-items-center rounded-xl bg-[var(--surface)] text-[var(--muted)]">
        <span class="material-symbols-outlined icon">arrow_back_ios_new</span>
      </button>
      <div class="text-base font-semibold flex items-center gap-2">
        <span class="material-symbols-outlined icon text-[20px]">table_restaurant</span>
        <span><?= htmlspecialchars($table['label'] ?? 'Masa') ?></span>
        <span class="text-[var(--muted)] text-xs"><?= (int)($table['capacity'] ?? 0) ?> kişilik</span>
      </div>
      <button class="size-10 grid place-items-center rounded-xl bg-[var(--surface)] text-[var(--muted)]" id="openTicket">
        <span class="material-symbols-outlined icon">receipt_long</span>
      </button>
    </div>

    <div class="mt-3 flex gap-2">
      <div class="flex-1 relative">
        <span class="material-symbols-outlined icon absolute left-3 top-1/2 -translate-y-1/2 text-[var(--muted)]">search</span>
        <input id="search" class="w-full h-11 pl-10 pr-3 rounded-xl bg-[var(--surface)] border-0 text-sm placeholder:text-[var(--muted)] focus:ring-2 focus:ring-[var(--primary)]" placeholder="Ürün ara (Ctrl+K)"/>
      </div>
      <button id="toggleFav" class="px-3 rounded-xl bg-[var(--surface)] text-[var(--muted)] text-sm font-medium flex items-center gap-1">
        <span class="material-symbols-outlined icon">star</span><span>Fav</span>
      </button>
    </div>

    <div class="mt-3 overflow-x-auto [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
      <div id="catBar" class="flex gap-2 w-max">
        <button class="chip chip-active" data-cat="all">Tümü</button>
        <?php foreach(\App\Controllers\CategoryController::getAllCategories() as $category): ?>
        <button class="chip chip-idle"  data-cat="<?= (int)$category['id'] ?>"><?= htmlspecialchars($category['name']) ?></button>
        <?php endforeach; ?>
      </div>
    </div>
  </header>

  <main class="px-4 pb-36">
    <section id="grid" class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3">
      <?php foreach(\App\Controllers\ProductsController::getAllProducts() as $product): ?>
      <button class="card shadow-soft" data-item='<?= json_encode($product['json']) ?>'>
        <div class="flex items-center justify-between">
          <p class="font-semibold" style="text-align: center;"><?= htmlspecialchars($product['name']) ?></p>
        </div>
        <p class="text-xs text-[var(--muted)] mt-1"><?= (float)$product['price'] ?>₺</p>
      </button>
      <?php endforeach; ?>
    </section>
  </main>

  <button id="ticketPill" class="ticket-pill hidden">
    <span class="material-symbols-outlined icon text-[20px]">receipt_long</span>
    <span id="pillCount" class="text-sm">0</span>
    <span class="text-[var(--muted)] text-xs">items</span>
  </button>

  <footer class="fixed inset-x-0 bottom-0">
    <div class="mx-auto w-full max-w-[480px] border-t border-white/5 bg-[#1c2620]/95 backdrop-blur safe-bot px-4 pt-2 pb-4">
      <div class="grid grid-cols-3 gap-3">
        <?php if(($table['status'] ?? null) == "cleaning"): ?>
        <button id="btnClear" class="h-12 rounded-2xl bg-[var(--surface)] text-white font-bold flex items-center justify-center gap-2">
          <span class="material-symbols-outlined icon">hourglass_top</span><span>Temizlendi</span>
        </button>
        <?php else: ?>
        <button id="btnHold" class="h-12 rounded-2xl bg-[var(--surface)] text-white font-bold flex items-center justify-center gap-2">
          <span class="material-symbols-outlined icon">hourglass_top</span><span>Siparişler</span>
        </button>
        <?php endif; ?>
        <button id="btnSend" class="h-12 rounded-2xl bg-[var(--primary)] text-[var(--bg)] font-extrabold flex items-center justify-center gap-2">
          <span class="material-symbols-outlined icon">send</span><span>Gönder</span>
        </button>
        <button id="btnPay" class="h-12 rounded-2xl bg-[var(--surface)] text-white font-bold flex items-center justify-center gap-2">
          <span class="material-symbols-outlined icon">credit_card</span><span>Ödeme</span>
        </button>
      </div>
    </div>
  </footer>
</div>

<div id="sheet" class="sheet z-40">
  <div class="mx-auto w-full max-w-[480px] bg-[var(--surface)] rounded-t-3xl shadow-soft">
    <div class="px-4 pt-3 pb-2">
      <div class="mx-auto h-1.5 w-12 rounded-full bg-white/15 mb-2"></div>
      <div class="flex items-center justify-between">
        <p id="sheetTitle" class="font-semibold">Özelleştir</p>
        <button id="closeSheet" class="size-10 grid place-items-center rounded-xl bg-white/10">
          <span class="material-symbols-outlined icon">close</span>
        </button>
      </div>
    </div>
    <div id="sheetBody" class="px-4 pb-3 max-h-[50dvh] overflow-y-auto space-y-4"></div>
    <div class="px-4 pb-4 pt-2 border-t border-white/10">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
          <button id="qtyMinus" class="size-10 grid place-items-center rounded-xl bg-white/10">
            <span class="material-symbols-outlined icon">remove</span>
          </button>
          <span id="qty" class="min-w-6 text-center">1</span>
          <button id="qtyPlus" class="size-10 grid place-items-center rounded-xl bg-white/10">
            <span class="material-symbols-outlined icon">add</span>
          </button>
        </div>
        <button id="addToTicket" class="h-12 px-5 rounded-2xl bg-[var(--primary)] text-[var(--bg)] font-extrabold">Ekle</button>
      </div>
    </div>
  </div>
</div>

<script>
  const CONTEXT = {
    branch_id:  <?= (int)($_SESSION['waiter_branch_id'] ?? 0) ?>,
    user_id:    <?= (int)($_SESSION['waiter_user_id'] ?? 0) ?>,
    table_no:   <?= json_encode($table['code'] ?? basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) ?>,
    table_status: <?= json_encode($table['status'] ?? 'idle') ?>,
  };

  const ORDER_ENDPOINT = '/api/v1/handheld/createOrder';
  const REDIRECT_AFTER = '/handheld/tables';

  const vibrate = (ms=8)=>('vibrate' in navigator)&&navigator.vibrate(ms);
  const $ = sel => document.querySelector(sel);
  const $$ = sel => document.querySelectorAll(sel);

  const state = { ticket: [], currentItem:null, favOnly:false, currentCat:'all', qty:1 };

  $('#toggleFav').addEventListener('click', ()=>{
    state.favOnly = !state.favOnly;
    $('#toggleFav').classList.toggle('bg-[var(--primary)]');
    $('#toggleFav').classList.toggle('text-[var(--bg)]');
    renderFilter();
  });

  $('#search').addEventListener('input', renderFilter);

  $$('#catBar .chip').forEach(ch=>{
    ch.addEventListener('click', ()=>{
      $$('#catBar .chip').forEach(x=>{x.classList.remove('chip-active');x.classList.add('chip-idle')});
      ch.classList.remove('chip-idle'); ch.classList.add('chip-active');
      state.currentCat = ch.dataset.cat;
      renderFilter();
      vibrate(6);
    });
  });

  function renderFilter(){
    const q = $('#search').value.toLowerCase();
    $$('#grid .card').forEach(card=>{
      const item = JSON.parse(card.dataset.item);
      const matchQ = !q || item.name.toLowerCase().includes(q);
      const matchFav = !state.favOnly || item.fav;
      const matchCat = state.currentCat==='all' || item.cat===state.currentCat;
      card.style.display = (matchQ && matchFav && matchCat) ? '' : 'none';
    });
  }

  $$('#grid .card').forEach(card=>{
    card.addEventListener('click', ()=>{
      const item = JSON.parse(card.dataset.item);
      if (item.mods) { openSheet(item); }
      else { quickAdd(item); }
    });
    let t; card.addEventListener('touchstart', ()=>{ t=setTimeout(()=>{ const item=JSON.parse(card.dataset.item); quickAdd(item,2); vibrate(10); },500) });
    ['touchend','touchcancel'].forEach(ev=>card.addEventListener(ev, ()=>clearTimeout(t)));
  });

  function quickAdd(item, qty=1){
    state.ticket.push({ id:item.id, name:item.name, price:+item.price, qty, mods:[], note:'' });
    updatePill();
    toast(`${item.name} ×${qty} eklendi`);
    vibrate(8);
  }

  function openSheet(item){
    state.currentItem = structuredClone(item);
    const cur = state.currentItem;

    state.qty = 1;
    $('#qty').textContent = '1';

    const body = $('#sheetBody');
    body.innerHTML = '';
    $('#sheetTitle').textContent = cur.name;

    (cur.mods || []).forEach((group) => {
      const wrap = document.createElement('div');
      const reqTxt = group.required ? `<span class="text-xs text-red-300 ml-1">(zorunlu)</span>` : '';
      wrap.innerHTML = `<p class="font-medium mb-2">${group.name}${reqTxt}</p>`;

      const list = document.createElement('div');
      list.className = "flex flex-wrap gap-2";

      group.options.forEach((opt) => {
        const btn = document.createElement('button');
        btn.className = "px-3 py-2 rounded-xl bg-white/10 text-sm";
        btn.textContent = opt.n + (opt.p ? ` +₺${opt.p}` : '');

        btn.addEventListener('click', () => {
          if (group.required) {
            [...list.children].forEach(c => c.classList.remove('bg-[var(--primary)]','text-[var(--bg)]'));
            btn.classList.add('bg-[var(--primary)]','text-[var(--bg)]');
            group._picked = [opt];
          } else {
            const on = btn.classList.toggle('bg-[var(--primary)]');
            btn.classList.toggle('text-[var(--bg)]', on);
            group._picked = group._picked || [];
            if (on) group._picked.push(opt);
            else group._picked = group._picked.filter(x => x.n !== opt.n);
          }
          vibrate(5);
        });

        list.appendChild(btn);
      });

      wrap.appendChild(list);
      body.appendChild(wrap);
    });

    const noteWrap = document.createElement('div');
    noteWrap.innerHTML = `
      <p class="font-medium mb-2 mt-2">Not</p>
      <input id="noteInput" class="w-full h-11 px-3 rounded-xl bg-white/10 border-0 text-sm placeholder:text-[var(--muted)]" placeholder="Az şeker, buzsuz..."/>
      <div class="mt-3 flex gap-2">
        <span class="px-3 py-2 rounded-xl bg-white/10 text-sm">Starter</span>
        <span class="px-3 py-2 rounded-xl bg-white/10 text-sm">Main</span>
        <span class="px-3 py-2 rounded-xl bg-white/10 text-sm">Dessert</span>
      </div>`;
    body.appendChild(noteWrap);

    $('#sheet').classList.add('open');
  }

  $('#closeSheet').addEventListener('click', ()=>$('#sheet').classList.remove('open'));
  $('#qtyPlus').addEventListener('click', ()=>{ state.qty++; $('#qty').textContent=state.qty; vibrate(5); });
  $('#qtyMinus').addEventListener('click', ()=>{ if(state.qty>1){ state.qty--; $('#qty').textContent=state.qty; vibrate(5);} });

  $('#addToTicket').addEventListener('click', ()=>{
    const item = state.currentItem;
    let ok = true;
    (item.mods||[]).forEach(g=>{ if(g.required && !(g._picked && g._picked.length)) ok=false; });
    if(!ok){ toast('Zorunlu seçenekleri seç.'); return; }
    const mods = (item.mods||[]).flatMap(g=>g._picked?g._picked:[]).map(m=>m.n);
    const extra = (item.mods||[]).flatMap(g=>g._picked?g._picked:[]).reduce((a,b)=>a+(b.p||0),0);
    const note = (document.querySelector('#noteInput')?.value || '').trim();

    state.ticket.push({
      id:item.id, name:item.name,
      price:(+item.price)+(+extra), qty:state.qty,
      mods, note
    });
    $('#sheet').classList.remove('open');
    updatePill();
    toast(`${item.name} eklendi`);
    vibrate(10);
  });

  const drawer = document.createElement('div');
  drawer.className = "fixed inset-x-0 bottom-0 translate-y-full transition-transform duration-300 z-50";
  drawer.innerHTML = `
    <div class="mx-auto w-full max-w-[480px] bg-[var(--surface)] rounded-t-3xl shadow-soft">
      <div class="px-4 pt-3 pb-2 flex items-center justify-between">
        <div class="mx-auto h-1.5 w-12 rounded-full bg-white/15"></div>
        <button id="closeDrawer" class="absolute right-4 top-2 size-10 grid place-items-center rounded-xl bg-white/10">
          <span class="material-symbols-outlined icon">close</span>
        </button>
      </div>
      <div id="ticketBody" class="px-4 pb-3 max-h-[50dvh] overflow-y-auto space-y-2"></div>
      <div class="px-4 pb-4 pt-2 border-t border-white/10 flex items-center justify-between">
        <p class="text-sm text-[var(--muted)]" id="ticketTotal">Toplam: ₺0</p>
        <div class="flex gap-2">
          <button id="clearTicket" class="h-10 px-3 rounded-xl bg-white/10">Temizle</button>
          <button id="drawerSend" class="h-10 px-4 rounded-xl bg-[var(--primary)] text-[var(--bg)] font-extrabold">Gönder</button>
        </div>
      </div>
    </div>`;
  document.body.appendChild(drawer);

  function renderTicket(){
    const body = drawer.querySelector('#ticketBody');
    body.innerHTML='';
    let total=0;
    state.ticket.forEach((t, idx)=>{
      total += (+t.price) * (+t.qty);
      const row = document.createElement('div');
      row.className = "rounded-2xl bg-white/05 p-3";
      row.innerHTML = `
        <div class="flex items-center justify-between">
          <div>
            <p class="font-medium">${t.name} <span class="text-xs text-[var(--muted)]">×${t.qty}</span></p>
            ${t.mods?.length?`<p class="text-xs text-[var(--muted)] mt-0.5">${t.mods.join(', ')}</p>`:''}
            ${t.note?`<p class="text-xs text-[var(--muted)] mt-0.5">Not: ${t.note}</p>`:''}
          </div>
          <div class="text-sm">₺${((+t.price) * (+t.qty)).toFixed(2)}</div>
        </div>
        <div class="mt-2 flex items-center gap-2">
          <button data-act="minus" data-i="${idx}" class="size-9 grid place-items-center rounded-xl bg-white/10"><span class="material-symbols-outlined icon">remove</span></button>
          <button data-act="plus"  data-i="${idx}" class="size-9 grid place-items-center rounded-xl bg-white/10"><span class="material-symbols-outlined icon">add</span></button>
          <button data-act="del"   data-i="${idx}" class="ml-auto size-9 grid place-items-center rounded-xl bg-white/10"><span class="material-symbols-outlined icon">delete</span></button>
        </div>`;
      body.appendChild(row);
    });
    drawer.querySelector('#ticketTotal').textContent = `Toplam: ₺${total.toFixed(2)}`;
    body.querySelectorAll('button').forEach(b=>{
      b.addEventListener('click', ()=>{
        const i = +b.dataset.i, act=b.dataset.act;
        if(act==='minus' && state.ticket[i].qty>1) state.ticket[i].qty--;
        else if(act==='plus') state.ticket[i].qty++;
        else if(act==='del') state.ticket.splice(i,1);
        renderTicket(); updatePill(); vibrate(6);
      });
    });
  }

  function openDrawer(){ drawer.style.transform='translateY(0)'; }
  function closeDrawer(){ drawer.style.transform=''; }
  $('#openTicket').addEventListener('click', ()=>{ renderTicket(); openDrawer(); });
  $('#ticketPill').addEventListener('click', ()=>{ renderTicket(); openDrawer(); });
  drawer.querySelector('#closeDrawer').addEventListener('click', closeDrawer);
  drawer.querySelector('#clearTicket').addEventListener('click', ()=>{ state.ticket=[]; renderTicket(); updatePill(); });
  drawer.querySelector('#drawerSend').addEventListener('click', ()=>{ vibrate(10); sendOrder(); });

  function updatePill(){
    const count = state.ticket.reduce((a,b)=>a+(+b.qty),0);
    $('#pillCount').textContent = count;
    $('#ticketPill').classList.toggle('hidden', count===0);
  }

  <?php if(($table['status'] ?? null) !== "occupied"): ?>
  $('#btnPay').addEventListener('click', ()=>{ toast('Masa boş, ödeme alınamaz.'); vibrate(6); });
  <?php else: ?>
  $('#btnPay').addEventListener('click', ()=>{ vibrate(6); window.location.href = "/handheld/payment/" + CONTEXT.table_no; });
  <?php endif; ?>
  <?php if(($table['status'] ?? null) == "cleaning"): ?>
  $('#btnClear').addEventListener('click', ()=>{ vibrate(6); window.location.href = "/handheld/asdasd/" + CONTEXT.table_no; });
  <?php endif; ?>

  function calcTotals(){
    const subtotal = state.ticket.reduce((a,t)=> a + ((+t.price) * (+t.qty)), 0);
    const discount = 0;
    const service  = 0;
    const tax      = 0;
    const grand_total = subtotal - discount + service + tax;
    return {
      subtotal: round2(subtotal),
      discount: round2(discount),
      service:  round2(service),
      tax:      round2(tax),
      grand_total: round2(grand_total)
    };
  }

  function round2(n){ return Math.round((+n + Number.EPSILON)*100)/100; }

  function getCsrf(){
    return document.querySelector('meta[name="csrf"]')?.content || window.CSRF || '';
  }

  async function sendOrder(){
    if(!state.ticket.length){ toast('Sepet boş, önce ürün ekle.'); return; }

    const totals = calcTotals();

    const items = state.ticket.map(t=>{
      const qty = +t.qty;
      const unit = +t.price;
      const line = round2(qty * unit);
      return {
        product_id: (+t.id),
        quantity:   qty,
        unit_price: round2(unit),
        line_total: line,
        note:       t.note || ''
      };
    });

    const payload = {
      branch_id:     CONTEXT.branch_id || null,
      user_id:       CONTEXT.user_id   || null,
      table_no:      CONTEXT.table_no  || null,
      total_amount:  totals.grand_total,
      payment_method: null,
      status:        'pending',
      source:        'handheld',
      device_time:   new Date().toISOString(),
      items
    };

    try{
      const res = await fetch(ORDER_ENDPOINT, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-Token': getCsrf()
        },
        body: JSON.stringify(payload),
        credentials: 'same-origin'
      });

      if(!res.ok){
        const txt = await res.text().catch(()=> '');
        throw new Error(txt || `HTTP ${res.status}`);
      }

      // const data = await res.json().catch(()=> ({}));

      toast('Sipariş gönderildi');
      state.ticket = [];
      updatePill();

      setTimeout(()=>{ location.href = REDIRECT_AFTER; }, 300);

    }catch(err){
      console.error(err);
      toast('Gönderilemedi, tekrar dene');
    }
  }

  // “Gönder” butonu
  $('#btnSend').addEventListener('click', ()=>{ vibrate(10); sendOrder(); });
  $('#btnHold').addEventListener('click', ()=>{ vibrate(10); window.location.href = "/handheld/payment/" + CONTEXT.table_no; });

  const toast = (msg)=>{
    let t = document.createElement('div');
    t.className="fixed left-1/2 -translate-x-1/2 bottom-24 z-[60] bg-black/80 text-white text-sm px-3 py-2 rounded-lg";
    t.textContent = msg; document.body.appendChild(t);
    setTimeout(()=>t.remove(),1400);
  };

  window.addEventListener('keydown', (e)=>{ if((e.ctrlKey||e.metaKey)&&e.key.toLowerCase()==='k'){ e.preventDefault(); $('#search').focus(); } });

  renderFilter();
</script>
</body>
</html>
