<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <title>Caffeine · Masalar</title>

  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
  <meta name="theme-color" content="#111714"/>
  <meta name="apple-mobile-web-app-capable" content="yes"/>
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>

  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin/>
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?display=swap&family=Epilogue:wght@400;500;700;900&family=Noto+Sans:wght@400;500;700;900"/>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
  <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64,"/>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

  <style type="text/tailwindcss">
    :root {
      --primary: #38e07b;
      --surface: #1b2520;
      --surface-2: #29382f;
      --bg: #111714;
      --txt: #ffffff;
      --muted: #9eb7a8;
    }
    html,body{height:100%}
    body{background:var(--bg);min-height:100dvh}

    .safe-top { padding-top: max(env(safe-area-inset-top), 14px); }
    .safe-bot { padding-bottom: max(env(safe-area-inset-bottom), 12px); }
    .no-tap   { touch-action: manipulation; -webkit-tap-highlight-color: transparent; }
    .icon     { font-variation-settings: 'wght' 500; }

    .chip { @apply px-4 py-2 rounded-full text-sm font-medium whitespace-nowrap; }
    .chip-active { background: var(--primary); color: var(--bg); }
    .chip-idle { background: var(--surface-2); color: var(--txt); }

    .stat-available      { color: #38e07b; }
    .stat-occupied  { color: #ffc107; }
    .stat-reserved  { color: #64b5f6; }
    .stat-cleaning  { color: #f48fb1; }
    .stat-disabled  { color: #f30b0bff; }

    .app { @apply mx-auto w-full max-w-[480px] min-h-dvh bg-[#0f1512]; }
  </style>
</head>
<body class="no-tap" style='font-family: Epilogue, "Noto Sans", system-ui, -apple-system, Segoe UI, Roboto, sans-serif;'>

  <div class="app text-[var(--txt)] relative">
    <!-- Üst bar -->
    <header class="safe-top px-4 pt-2 sticky top-0 z-20 bg-gradient-to-b from-[#0f1512] to-transparent">
      <div class="h-12 flex items-center justify-between">
      <button onclick="window.location.href ='/handheld/dashboard'" class="size-10 grid place-items-center rounded-xl bg-[var(--surface)] text-[var(--muted)]">
        <span class="material-symbols-outlined icon">arrow_back_ios_new</span>
      </button>
        <div class="text-base font-semibold">Tables</div>
        <div class="size-10 grid place-items-center rounded-xl bg-[var(--surface)] text-[var(--muted)]">
          <span class="material-symbols-outlined icon">search</span>
        </div>
      </div>

      <!-- Filtre çipleri (yatay kaydırılabilir) -->
      <div class="mt-3 overflow-x-auto [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
        <div class="flex gap-2 w-max" id="filterBar">
          <button class="chip chip-active" data-filter="all">All</button>
          <button class="chip chip-idle"  data-filter="available">Boş</button>
          <button class="chip chip-idle"  data-filter="occupied">Dolu</button>
          <button class="chip chip-idle"  data-filter="reserved">Rezerve</button>
          <button class="chip chip-idle"  data-filter="cleaning">Temizlik Gerekiyor</button>
          <button class="chip chip-idle"  data-filter="disabled">Kapalı</button>
        </div>
      </div>
    </header>

    <!-- İçerik -->
    <main class="px-4 pb-36">
      <h2 class="text-lg font-bold mt-4">Table List</h2>

      <!-- Grid -->
      <section id="grid" class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-3">

      <?php foreach(\App\Controllers\TablesController::getAllTables($_SESSION['waiter_branch_id']) as $table): ?>
        
        <button onclick="window.location.href = '/handheld/table/<?=$table['code']?>'" class="rounded-2xl p-4 aspect-square bg-[var(--surface-2)] flex flex-col items-center justify-center active:scale-[0.99]"
                data-status="<?= $table['status'] ?>" data-table="1">
          <span class="material-symbols-outlined icon text-4xl mb-1.5">table_restaurant</span>
          <p class="font-bold text-lg"><?= $table['label'] ?></p>
          <p class="text-sm font-medium stat-<?= $table['status'] ?>"><?= ['available' => 'Boş', 'occupied'  => 'Dolu', 'reserved'  => 'Rezerve', 'cleaning'  => 'Temizlikte', 'disabled'  => 'Devre Dışı', ][$table['status']] ?? 'Bilinmiyor' ?></p>
        </button>
      <?php endforeach; ?>
      </section>
    </main>

    <!-- Alt aksiyon barı (sabit) -->
    <footer class="fixed inset-x-0 bottom-0">
<div class="mx-auto w-full max-w-[480px] border-t border-white/5 bg-[#1c2620]/95 backdrop-blur safe-bot px-4 pt-2 pb-4">
        <div class="grid grid-cols-2 gap-3">
          <button class="h-12 rounded-2xl bg-[var(--primary)] text-[var(--bg)] font-bold flex items-center justify-center gap-2 active:scale-[0.99]" id="btnSplit">
            <span class="material-symbols-outlined icon">call_split</span><span>Böl</span>
          </button>
          <button class="h-12 rounded-2xl bg-[var(--primary)] text-[var(--bg)] font-bold flex items-center justify-center gap-2 active:scale-[0.99]" id="btnMerge">
            <span class="material-symbols-outlined icon">merge_type</span><span>Birleştir</span>
          </button>
        </div>
      </div>
    </footer>
  </div>

  <!-- Basit JS: filtre + haptic + (mock) table action -->
  <script>
    const buzz = (ms=8)=>('vibrate' in navigator)&&navigator.vibrate(ms);

    // Filtre çipleri
    const chips = document.querySelectorAll('#filterBar .chip');
    const cards = document.querySelectorAll('#grid [data-status]');

    function applyFilter(type){
      cards.forEach(c=>{
        const s = c.dataset.status;
        c.style.display = (type==='all'|| s===type) ? '' : 'none';
      });
    }

    chips.forEach(ch=>{
      ch.addEventListener('click', ()=>{
        chips.forEach(x=>{ x.classList.remove('chip-active'); x.classList.add('chip-idle'); });
        ch.classList.remove('chip-idle'); ch.classList.add('chip-active');
        applyFilter(ch.dataset.filter);
        buzz(10);
      });
    });

    // Kartlara tıklayınca örnek aksiyon (gerçekte bottom sheet açarsın)
    cards.forEach(card=>{
      card.addEventListener('click', ()=>{
        const id = card.dataset.table;
        buzz(10);
        // burada gerçek uygulamada: bottom sheet -> View / New Order / Move / Clean / Reserve
        console.log('Open table actions for #'+id);
      });
      // uzun basış mock
      let pressTimer;
      card.addEventListener('touchstart', ()=>{ pressTimer=setTimeout(()=>{ console.log('Long press table #'+card.dataset.table); buzz(15); },500); });
      ['touchend','touchcancel'].forEach(ev=>card.addEventListener(ev, ()=>clearTimeout(pressTimer)));
    });

    // Alt butonlar demo
    ['btnSplit','btnMerge','btnNewOrder'].forEach(id=>{
      document.getElementById(id)?.addEventListener('click', ()=>buzz(10));
    });

    // iOS viewport zıplaması azaltma
    const vhFix=()=>document.documentElement.style.setProperty('--vh', `${window.innerHeight*0.01}px`);
    vhFix(); addEventListener('resize', vhFix);
  </script>
</body>
</html>
