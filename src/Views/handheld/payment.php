<?php
use App\Controllers\PaymentController;

$branchId = (int)($_SESSION['waiter_branch_id'] ?? 0);
$tableNo  = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$payload  = PaymentController::getPaymentPayloadForTable($tableNo, $branchId);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8"/>
  <title>Caffeine · Ödeme</title>
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
    :root { --primary:#38e07b; --bg:#111714; --surface:#1b2520; --surface2:#29382f; --txt:#fff; --muted:#9eb7a8; }
    html,body{height:100%} body{min-height:100dvh;background:var(--bg)}
    .safe-top{padding-top:max(env(safe-area-inset-top),14px)}
    .safe-bot{padding-bottom:max(env(safe-area-inset-bottom),12px)}
    .icon{font-variation-settings:'wght' 500}
    .app{ @apply mx-auto w-full max-w-[480px] min-h-dvh bg-[#0f1512] text-white;}
    .chip{ @apply px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap;}
    .chip-active{ background:var(--primary); color:var(--bg); }
    .chip-idle{ background:var(--surface2); color:var(--txt); }
    .card{ @apply rounded-2xl bg-[var(--surface2)] p-4;}
    .shadow-soft{ box-shadow:0 10px 30px -12px rgba(0,0,0,.5); }
    .key{ @apply h-12 rounded-xl bg-[var(--surface)] grid place-items-center text-lg active:scale-[0.98]; }
    .btn{ @apply h-12 rounded-2xl font-bold grid place-items-center active:scale-[0.99]; }
    .row{ @apply flex items-center justify-between gap-3; }
  </style>

  <!-- Backend'den gelen payload'ı JS'e ver -->
  <script>
    const payload = <?= json_encode($payload, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) ?> || null;
  </script>
</head>
<body style='font-family: Epilogue, "Noto Sans", system-ui, -apple-system, Segoe UI, Roboto, sans-serif;'>

<div class="app relative">
  <!-- HEADER -->
  <header class="safe-top px-4 pt-2 sticky top-0 z-20 bg-gradient-to-b from-[#0f1512]/95 to-transparent backdrop-blur">
    <div class="h-12 flex items-center justify-between">
      <button onclick="window.history.back()" class="size-10 grid place-items-center rounded-xl bg-[var(--surface)] text-[var(--muted)]">
        <span class="material-symbols-outlined icon">arrow_back_ios_new</span>
      </button>
      <div class="text-base font-semibold">Ödemeler</div>
      <div class="size-10 grid place-items-center rounded-xl bg-[var(--surface)] text-[var(--muted)]">
        <span class="material-symbols-outlined icon">print</span>
      </div>
    </div>
  </header>

  <main class="px-4 pb-40">
    <!-- SİPARİŞ ÖZETİ -->
    <section class="mt-3 card shadow-soft">
      <div class="row">
        <div>
          <p class="text-lg font-medium">Sipariş <span id="lblOrder">#—</span></p>
          <p class="text-sm text-[var(--muted)]"><span id="lblTable">Masa —</span> · <span id="lblGuests">— kişi</span></p>
        </div>
        <div class="text-right">
          <p class="text-lg font-extrabold" id="lblTotal">₺0</p>
          <p class="text-xs text-[var(--muted)]">Ara toplam + servis - indirim</p>
        </div>
      </div>

      <!-- ÜRÜN SATIRLARI -->
      <div id="items" class="mt-3 space-y-2 text-sm"></div>

      <div class="mt-3 grid grid-cols-2 gap-2 text-sm">
        <div class="row"><span class="text-[var(--muted)]">Ara Toplam</span><span id="lblSub">₺0</span></div>
        <div class="row"><span class="text-[var(--muted)]">Servis (%10)</span><span id="lblService">₺0</span></div>
        <div class="row"><span class="text-[var(--muted)]">İndirim</span><span id="lblDisc">-₺0</span></div>
        <div class="row"><span class="text-[var(--muted)]">Bahşiş</span><span id="lblTip">₺0</span></div>
      </div>
      <div class="mt-3 row text-base">
        <span class="">Genel Toplam</span><span class="font-extrabold" id="lblGrand">₺0</span>
      </div>
      <div class="mt-2 row">
        <span class="text-[var(--muted)] text-sm">Kalan</span>
        <span class="text-lg font-extrabold" id="lblRemain">₺0</span>
      </div>
    </section>

    <!-- YÖNTEM + TUTAR -->
    <section class="mt-4">
      <h3 class="text-lg font-bold mb-2">Ödeme Yöntemi</h3>
      <div id="methods" class="flex gap-2 overflow-x-auto w-max">
        <button class="chip chip-active" data-m="cash"><span class="align-middle">💵</span> Nakit</button>
        <button class="chip chip-idle"  data-m="card"><span class="align-middle">💳</span> Kart</button>
        <button class="chip chip-idle"  data-m="qr"><span class="align-middle">🔳</span> QR</button>
        <button class="chip chip-idle"  data-m="meal"><span class="align-middle">🍽️</span> Yemek Kartı</button>
      </div>

      <div class="mt-4 grid grid-cols-2 gap-3">
        <div class="card">
          <p class="text-sm text-[var(--muted)] mb-2">Tutar</p>
          <input id="amount" inputmode="decimal" class="w-full h-12 rounded-xl bg-[var(--surface)] border-0 px-3 text-lg"
                 placeholder="₺0" />
          <div class="mt-2 grid grid-cols-3 gap-2 text-sm">
            <button class="chip chip-idle" data-quick="remain">Kalan</button>
            <button class="chip chip-idle" data-quick="half">Yarı</button>
            <button class="chip chip-idle" data-quick="round">Yuvarla</button>
            <button class="chip chip-idle" data-quick="50">₺50</button>
            <button class="chip chip-idle" data-quick="100">₺100</button>
            <button class="chip chip-idle" data-quick="200">₺200</button>
          </div>
        </div>

        <!-- Tuş Takımı -->
        <div class="card">
          <p class="text-sm text-[var(--muted)] mb-2">Tuş Takımı</p>
          <div class="grid grid-cols-3 gap-2">
            <button class="key" data-k="1">1</button>
            <button class="key" data-k="2">2</button>
            <button class="key" data-k="3">3</button>
            <button class="key" data-k="4">4</button>
            <button class="key" data-k="5">5</button>
            <button class="key" data-k="6">6</button>
            <button class="key" data-k="7">7</button>
            <button class="key" data-k="8">8</button>
            <button class="key" data-k="9">9</button>
            <button class="key" data-k=",">,</button>
            <button class="key" data-k="0">0</button>
            <button class="key" data-k="del"><span class="material-symbols-outlined icon">backspace</span></button>
          </div>
          <div class="mt-2 grid grid-cols-2 gap-2">
            <button id="btnClear" class="btn bg-white/10">Temizle</button>
            <button id="btnAdd" class="btn bg-[var(--primary)] text-[var(--bg)]">Ödemeye Ekle</button>
          </div>
        </div>
      </div>
    </section>

    <!-- BAHŞİŞ & İNDİRİM -->
    <section class="mt-4">
      <div class="row mb-2">
        <h3 class="text-lg font-bold">Bahşiş</h3>
        <span class="text-sm text-[var(--muted)]">Opsiyonel</span>
      </div>
      <div id="tips" class="flex gap-2">
        <button class="chip chip-idle" data-tip="0">0%</button>
        <button class="chip chip-idle" data-tip="5">5%</button>
        <button class="chip chip-idle" data-tip="10">10%</button>
        <button class="chip chip-idle" data-tip="custom">Özel</button>
      </div>
      <div id="tipCustomWrap" class="hidden mt-2">
        <input id="tipCustom" type="number" min="0" step="0.5"
               class="h-11 w-28 rounded-xl bg-[var(--surface)] border-0 px-3 text-sm" placeholder="% oran"/>
      </div>

      <div class="mt-4">
        <div class="row mb-2">
          <h3 class="text-lg font-bold">İndirim / Kupon</h3>
          <span class="text-sm text-[var(--muted)]">Opsiyonel</span>
        </div>
        <div class="grid grid-cols-2 gap-2">
          <button id="btnDiscPct" class="btn bg-[var(--surface)]">% İndirim</button>
          <button id="btnDiscAmt" class="btn bg-[var(--surface)]">Tutar İndirimi</button>
        </div>
      </div>
    </section>

    <!-- EKLENEN ÖDEMELER -->
    <section class="mt-6 card">
      <div class="row mb-2">
        <h3 class="text-lg font-bold">Ödeme Satırları</h3>
        <span class="text-sm text-[var(--muted)]" id="linesInfo">0 satır</span>
      </div>
      <div id="lines" class="space-y-2"></div>
    </section>

    <!-- PARA ÜSTÜ / KALAN -->
    <section class="mt-3">
      <div class="row text-sm"><span class="text-[var(--muted)]">Kalan</span><span id="lblRemain2">₺0</span></div>
      <div class="row text-sm"><span class="text-[var(--muted)]">Para Üstü</span><span id="lblChange">₺0</span></div>
    </section>
  </main>

  <!-- FOOTER -->
  <footer class="fixed inset-x-0 bottom-0">
    <div class="mx-auto w-full max-w-[480px] border-t border-white/5 bg-[#1c2620]/95 backdrop-blur safe-bot px-4 pt-2 pb-4">
      <div class="grid grid-cols-2 gap-3">
        <button id="btnPrint" class="btn bg-[var(--surface)] text-white"><span class="material-symbols-outlined icon mr-1">print</span>Fiş Yazdır</button>
        <button id="btnSettle" disabled class="btn bg-[var(--primary)] text-[var(--bg)] opacity-50"><span class="material-symbols-outlined icon mr-1">done</span>Ödemeyi Tamamla</button>
      </div>
    </div>
  </footer>
</div>

<script>
  // ===== Helpers =====
  const $  = s => document.querySelector(s);
  const $$ = s => document.querySelectorAll(s);
  const vibrate = (ms=8)=>('vibrate' in navigator)&&navigator.vibrate(ms);
  const fmt = v => new Intl.NumberFormat('tr-TR', {style:'currency', currency:'TRY', maximumFractionDigits:2}).format(v);
  const safeNum = v => Math.max(0, +(v ?? 0));
  const API_BASE = '/api/v1/handheld/settle'; // <— backend endpoint kökün

  async function postJSON(url, data){
    const res = await fetch(url, {
      method:'POST',
      headers:{
        'Content-Type':'application/json',
        'X-CSRF-Token': getCsrf()
      },
      credentials:'include',
      body: JSON.stringify(data)
    });
    if(!res.ok){
      const text = await res.text().catch(()=> '');
      throw new Error(text || ('HTTP '+res.status));
    }
    return res.json().catch(()=> ({}));
  }

  // ===== State =====
  const state = {
    sub: 40.91,
    servicePct: 0,
    discount: 0,
    tipPct: 0,
    payments: [],
    currentMethod: 'cash',
  };

  // ===== UI: ürün satırları =====
  function renderItems(list){
    const box = $('#items'); box.innerHTML='';
    if(!list || !list.length){
      box.innerHTML = `<div class="rounded-xl bg-white/5 p-3 text-[var(--muted)]">Bu siparişte ürün yok</div>`;
      return;
    }
    list.forEach(it=>{
      const qty  = safeNum(it.qty || it.quantity || 1);
      const unit = fmt(it.unit_price);
      const line = fmt(it.line_total);
      const row  = document.createElement('div');
      row.className = 'rounded-xl bg-white/5 p-3';
      row.innerHTML = `
        <div class="flex items-center justify-between">
          <div>
            <p class="font-medium">${it.name || ('Ürün #' + (it.product_id ?? it.id))}</p>
            <p class="text-xs text-[var(--muted)]">${qty} × ${unit}</p>
          </div>
          <div class="text-sm font-semibold">${line}</div>
        </div>`;
      box.appendChild(row);
    });
  }

  function getCsrf(){
    return document.querySelector('meta[name="csrf"]')?.content || window.CSRF || '';
  }
  
  // ===== Totaller =====
  function totals(){
    const service = state.sub * state.servicePct / 100;
    const tip = (state.sub + service - state.discount) * state.tipPct / 100;
    const grand = state.sub + service - state.discount + tip;
    const paid = state.payments.reduce((a,b)=>a + b.amount, 0);
    const remain = +(grand - paid).toFixed(2);
    const change = remain < 0 ? -remain : 0;
    return {service, tip, grand, paid, remain: remain>0?remain:0, change};
  }

  // ===== Settlement payload =====
  function buildSettlementPayload(){
    const t = totals();
    const orderId  = payload?.order_id ?? null;
    const branchId = payload?.branch.id ?? null;
    const tableNo  = payload?.table?.no ?? payload?.table_no ?? null;

    return {
      order_id: orderId,
      branch_id: branchId,
      table_no: tableNo,

      items: (payload?.items || []).map(it => ({
        product_id: it.product_id ?? it.id ?? null,
        name: it.name ?? null,
        quantity: +(it.qty ?? it.quantity ?? 1),
        unit_price: +Number(it.unit_price || 0).toFixed(2),
        line_total: +Number(it.line_total || 0).toFixed(2),
        note: it.note ?? ''
      })),

      subtotal: +Number(state.sub).toFixed(2),
      service_pct: +Number(state.servicePct).toFixed(2),
      service_amount: +Number(t.service).toFixed(2),
      discount_amount: +Number(state.discount).toFixed(2),
      tip_pct: +Number(state.tipPct).toFixed(2),
      tip_amount: +Number(t.tip).toFixed(2),
      grand_total: +Number(t.grand).toFixed(2),

      payments: state.payments.map(p => ({
        method: p.method, // 'cash' | 'card' | 'qr' | 'meal'
        amount: +Number(p.amount).toFixed(2)
      })),
      paid_total: +Number(t.paid).toFixed(2),
      change: +Number(t.change).toFixed(2),
      remain: +Number(t.remain).toFixed(2),

      status: t.remain === 0 ? 'paid' : 'partial',
      client_meta: {
        settled_at: new Date().toISOString(),
        device: 'handheld-pos',
        ua: navigator.userAgent
      }
    };
  }

  // ===== Seed (payload'tan doldur) =====
  function seed(){
    if (payload) {
      $('#lblOrder').textContent  = `#${payload.order_id ?? '—'}`;
      $('#lblTable').textContent  = payload.table?.name || payload.table?.no || 'Masa —';
      $('#lblGuests').textContent = payload.table?.guests ? `${payload.table.guests} kişi` : '— kişi';

      renderItems(payload.items || []);

      const t = payload.totals || {};
      state.sub        = safeNum(t.subtotal) || state.sub;
      state.servicePct = safeNum(payload.service_pct) || state.servicePct;
      state.tipPct     = safeNum(payload.tip_pct) || state.tipPct;
      state.discount   = safeNum(t.discount_amount);

      state.payments = (payload.payments || []).map(p=>({
        method: p.method || 'cash',
        amount: +Number(p.amount || 0).toFixed(2),
      }));
    }

    updateUI();
  }

  // ===== UI refresh =====
  function updateUI(){
    const t = totals();
    $('#lblSub').textContent    = fmt(state.sub);
    $('#lblService').textContent= fmt(t.service);
    $('#lblDisc').textContent   = '-' + fmt(state.discount);
    $('#lblTip').textContent    = fmt(t.tip);
    $('#lblGrand').textContent  = fmt(t.grand);
    $('#lblTotal').textContent  = fmt(t.grand);
    $('#lblRemain').textContent = fmt(t.remain);
    $('#lblRemain2').textContent= fmt(t.remain);
    $('#lblChange').textContent = fmt(t.change);

    $('#btnSettle').disabled = !(t.remain===0);
    $('#btnSettle').style.opacity = t.remain===0 ? 1 : 0.5;

    const box = $('#lines'); box.innerHTML='';
    state.payments.forEach((p, i)=>{
      const row = document.createElement('div');
      row.className = 'rounded-xl bg-white/10 p-3';
      const icon = p.method==='cash'?'💵':p.method==='card'?'💳':p.method==='qr'?'🔳':'🍽️';
      row.innerHTML = `
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-2">
            <span>${icon}</span>
            <div>
              <p class="font-medium">${labelOf(p.method)}</p>
              <p class="text-xs text-[var(--muted)]">${new Date().toLocaleTimeString('tr-TR',{hour:'2-digit',minute:'2-digit'})}</p>
            </div>
          </div>
          <div class="flex items-center gap-2">
            <span class="text-sm font-semibold">${fmt(p.amount)}</span>
            <button class="size-9 grid place-items-center rounded-lg bg-white/10" data-del="${i}">
              <span class="material-symbols-outlined icon">delete</span>
            </button>
          </div>
        </div>`;
      box.appendChild(row);
    });
    $('#linesInfo').textContent = `${state.payments.length} satır`;
    box.querySelectorAll('[data-del]').forEach(b=>{
      b.addEventListener('click', ()=>{
        state.payments.splice(+b.dataset.del,1);
        updateUI();
      });
    });
  }

  function labelOf(m){
    return m==='cash'?'Nakit': m==='card'?'Kart': m==='qr'?'QR Kod':'Yemek Kartı';
  }

  // ===== Events =====
  $$('#methods .chip').forEach(ch=>{
    ch.addEventListener('click', ()=>{
      $$('#methods .chip').forEach(x=>{x.classList.remove('chip-active');x.classList.add('chip-idle')});
      ch.classList.remove('chip-idle'); ch.classList.add('chip-active');
      state.currentMethod = ch.dataset.m;
      vibrate(6);
    });
  });

  $$('#amount ~ .grid [data-quick]').forEach(q=>{
    q.addEventListener('click', ()=>{
      const t = totals();
      let val = 0;
      const k = q.dataset.quick;
      if(k==='remain') val = t.remain;
      else if(k==='half') val = +(t.remain/2).toFixed(2);
      else if(k==='round') val = Math.ceil(t.remain/10)*10;
      else val = +k;
      $('#amount').value = val.toString().replace('.', ',');
      vibrate(6);
    });
  });

  $$('.key').forEach(k=>{
    k.addEventListener('click', ()=>{
      const cur = $('#amount').value || '';
      const key = k.dataset.k;
      if(key==='del') $('#amount').value = cur.slice(0,-1);
      else $('#amount').value = cur + key;
    });
  });
  $('#btnClear').addEventListener('click', ()=> $('#amount').value='');

  $('#btnAdd').addEventListener('click', ()=>{
    const raw = ($('#amount').value||'').replace('.',',');
    const num = +raw.replace(/\./g,'').replace(',','.');
    if(!num || num<=0) { toast('Tutar gir'); return; }
    state.payments.push({ method: state.currentMethod, amount: +num.toFixed(2) });
    $('#amount').value='';
    updateUI(); vibrate(10);
    // İstersen burada partial sync yapabilirsin:
    // postJSON(`${API_BASE}/partial`, {...buildSettlementPayload(), status:'partial'}).catch(()=>{});
  });

  $$('#tips .chip').forEach(ch=>{
    ch.addEventListener('click', ()=>{
      $$('#tips .chip').forEach(x=>{x.classList.remove('chip-active');x.classList.add('chip-idle')});
      ch.classList.remove('chip-idle'); ch.classList.add('chip-active');
      const v = ch.dataset.tip;
      if(v==='custom'){
        $('#tipCustomWrap').classList.remove('hidden');
        $('#tipCustom').focus();
      }else{
        $('#tipCustomWrap').classList.add('hidden');
        state.tipPct = +v;
        updateUI();
      }
    });
  });
  $('#tipCustom').addEventListener('input', (e)=>{ state.tipPct = Math.max(0, +e.target.value||0); updateUI(); });

  $('#btnDiscPct').addEventListener('click', ()=>{
    const pct = prompt('% indirim oranı (örn 10)'); if(pct===null) return;
    const t = state.sub * (+pct||0) / 100;
    state.discount = +t.toFixed(2); updateUI();
  });
  $('#btnDiscAmt').addEventListener('click', ()=>{
    const amt = prompt('Tutar indirimi (₺)'); if(amt===null) return;
    state.discount = Math.max(0, +(amt.replace(',','.'))||0); updateUI();
  });

  // —— Ödeme tamamla: API'ye gönder ——
  $('#btnSettle').addEventListener('click', async ()=>{
    const t = totals();
    if(t.remain !== 0){
      toast('Kalan tutar var'); return;
    }
    const out = buildSettlementPayload();
    try{
      $('#btnSettle').disabled = true;
      $('#btnSettle').style.opacity = .5;

      const res = await postJSON(API_BASE, out);

      toast('Ödeme tamamlandı ✅');
      vibrate(12);

      setTimeout(()=>{ location.href = "/handheld/tables"; }, 300);

      // ör: backend receipt_id döndürüyorsa yönlendirebilirsin
      // if(res?.data?.receipt_id){ window.location.href = `/receipts/${res.data.receipt_id}`; }
    }catch(err){
      console.error(err);
      toast('Ödeme gönderilemedi ❌');
      $('#btnSettle').disabled = false;
      $('#btnSettle').style.opacity = 1;
    }
  });

  $('#btnPrint').addEventListener('click', ()=>{ toast('Fiş yazdırılıyor…'); });

  function toast(msg){
    const t = document.createElement('div');
    t.className="fixed left-1/2 -translate-x-1/2 bottom-24 z-[60] bg-black/80 text-white text-sm px-3 py-2 rounded-lg";
    t.textContent = msg; document.body.appendChild(t);
    setTimeout(()=>t.remove(),1400);
  }

  // start
  seed();
</script>
</body>
</html>
