<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Caffeine · Anasayfa</title>

  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta name="theme-color" content="#111714" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="Cafe POS">
<link rel="manifest" href="/manifest.json">

  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?display=swap&family=Epilogue:wght@400;500;700;900&family=Noto+Sans:wght@400;500;700;900" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
  <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

  <style type="text/tailwindcss">
    :root{
      --primary: #38e07b;
      --surface: #1b2520;
      --surface-2:#29382f;
      --bg: #111714;
      --txt: #ffffff;
      --muted: #9eb7a8;
    }
    html, body { height: 100%; }
    body { background: var(--bg); min-height: 100dvh; }

    .safe-top   { padding-top: max(env(safe-area-inset-top), 16px); }
    .safe-bot   { padding-bottom: max(env(safe-area-inset-bottom), 12px); }
    .no-tap     { touch-action: manipulation; -webkit-tap-highlight-color: transparent; }
    .icon       { font-variation-settings: 'wght' 500; }
    .shadow-soft{ box-shadow: 0 10px 30px -12px rgba(0,0,0,.5); }

    .tab-active .material-symbols-outlined { color: var(--primary); }
    .tab-active p { color: var(--primary); }

    @media (min-width: 420px){
      .cards { grid-template-columns: repeat(3,minmax(0,1fr)); }
    }
  </style>
</head>
<body class="no-tap" style='font-family: Epilogue, "Noto Sans", system-ui, -apple-system, Segoe UI, Roboto, sans-serif;'>

  <div class="mx-auto w-full max-w-[480px] min-h-dvh bg-[#0f1512] text-[var(--txt)] relative">

    <header class="safe-top px-4 pt-2">
      <div class="h-12 flex items-center justify-between">
        <button aria-label="Open menu"
                class="size-10 grid place-items-center rounded-xl bg-[var(--surface)] text-[var(--muted)] active:scale-[0.98]">
          <span class="material-symbols-outlined icon text-[22px]">menu</span>
        </button>
        <div class="text-base font-semibold">Caffeine</div>
        <button aria-label="Notifications"
                class="size-10 grid place-items-center rounded-xl bg-[var(--surface)] text-[var(--muted)] active:scale-[0.98]">
          <span class="material-symbols-outlined icon text-[22px]">notifications</span>
        </button>
      </div>
    </header>

    <main class="px-4 pb-28">
      <section class="mt-4 grid cards grid-cols-2 gap-4">
        <div class="rounded-2xl bg-[var(--surface-2)] p-4 shadow-soft">
          <p class="text-sm text-white/90">Aktif Masalar</p>
          <p class="mt-1 text-3xl font-extrabold">12</p>
        </div>
        <div class="rounded-2xl bg-[var(--surface-2)] p-4 shadow-soft">
          <p class="text-sm text-white/90">Bekleyen Siparişler</p>
          <p class="mt-1 text-3xl font-extrabold">5</p>
        </div>
        <div class="rounded-2xl bg-[var(--surface-2)] p-4 shadow-soft">
          <p class="text-sm text-white/90">Avg. Prep Time</p>
          <p class="mt-1 text-3xl font-extrabold">11<span class="text-lg align-top ml-1">min</span></p>
        </div>
      </section>

      <section class="mt-8">
        <h2 class="text-lg font-bold">Hızlı İşlemler</h2>
        <div class="mt-4 grid grid-cols-2 gap-4">
          <button class="h-14 rounded-2xl bg-[var(--primary)] text-[var(--bg)] text-sm font-extrabold active:scale-[0.99] shadow-[0_10px_30px_-12px_rgba(56,224,123,0.7)]" id="btnNewOrder">
            Yeni Sipariş
          </button>
          <button class="h-14 rounded-2xl bg-[var(--surface-2)] text-[var(--txt)] text-sm font-bold active:scale-[0.99]" id="btnTables">
            Masalar
          </button>
          <button class="h-14 rounded-2xl bg-[var(--surface-2)] text-[var(--txt)] text-sm font-bold active:scale-[0.99]" id="btnOrders">
            Siparişler
          </button>
          <button class="h-14 rounded-2xl bg-[var(--surface-2)] text-[var(--txt)] text-sm font-bold active:scale-[0.99]" id="btnPayments">
            Profil
          </button>
        </div>
      </section>

      <section class="mt-8">
        <h2 class="text-lg font-bold">Shift Bilgisi</h2>
        <div class="mt-4 space-y-4">
          <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[var(--surface)] text-[var(--txt)]">
              <span class="material-symbols-outlined icon">storefront</span>
            </div>
            <div>
              <p class="text-sm font-medium">Şube</p>
              <p class="text-sm text-[var(--muted)]"><?= \App\Controllers\BranchController::getBrancByBranchId($_SESSION['waiter_branch_id'])['name'] ?></p>
            </div>
          </div>
          <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[var(--surface)] text-[var(--txt)]">
              <span class="material-symbols-outlined icon">person</span>
            </div>
            <div>
              <p class="text-sm font-medium">Kullanıcı</p>
              <p class="text-sm text-[var(--muted)]"><?= \App\Controllers\UsersController::getUserById($_SESSION['waiter_user_id'])['username'] ?></p>
            </div>
          </div>
          <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[var(--surface)] text-[var(--txt)]">
              <span class="material-symbols-outlined icon">schedule</span>
            </div>
            <div>
              <p class="text-sm font-medium">Aralık</p>
              <p class="text-sm text-[var(--muted)]">10:00 – 18:00</p>
            </div>
          </div>
        </div>
      </section>
    </main>

    <footer class="fixed inset-x-0 bottom-0">
      <nav class="mx-auto w-full max-w-[480px] border-t border-white/5 bg-[#1c2620]/95 backdrop-blur safe-bot px-2">
        <ul class="grid grid-cols-5 py-1.5">
          <li>
            <a class="tab-active flex flex-col items-center gap-0.5 py-1 rounded-xl"
               href="#" aria-label="Home">
              <span class="material-symbols-outlined icon">home</span>
              <p class="text-[11px] font-medium text-[var(--muted)]">Aansayfa</p>
            </a>
          </li>
          <li>
            <a class="flex flex-col items-center gap-0.5 py-1 rounded-xl text-[var(--muted)]"
               href="/handheld/tables" aria-label="Tables">
              <span class="material-symbols-outlined icon">table_restaurant</span>
              <p class="text-[11px] font-medium">Masalar</p>
            </a>
          </li>
          <li>
            <a class="flex flex-col items-center gap-0.5 py-1 rounded-xl text-[var(--muted)]"
               href="#" aria-label="Orders">
              <span class="material-symbols-outlined icon">receipt_long</span>
              <p class="text-[11px] font-medium">Siparişler</p>
            </a>
          </li>
          <li>
            <a class="flex flex-col items-center gap-0.5 py-1 rounded-xl text-[var(--muted)]"
               href="#" aria-label="Payments">
              <span class="material-symbols-outlined icon">credit_card</span>
              <p class="text-[11px] font-medium">Ödemeler</p>
            </a>
          </li>
          <li>
            <a class="flex flex-col items-center gap-0.5 py-1 rounded-xl text-[var(--muted)]"
               href="#" aria-label="Profile">
              <span class="material-symbols-outlined icon">account_circle</span>
              <p class="text-[11px] font-medium">Profil</p>
            </a>
          </li>
        </ul>
      </nav>
    </footer>
  </div>

  <script>
    const buzz = (ms=8)=>('vibrate' in navigator)&&navigator.vibrate(ms);

    document.querySelectorAll('footer nav a').forEach(a=>{
      a.addEventListener('click', e=>{
        document.querySelectorAll('footer nav a').forEach(x=>x.classList.remove('tab-active'));
        a.classList.add('tab-active');
        buzz(10);
      });
    });

    ['btnNewOrder','btnTables','btnOrders','btnPayments'].forEach(id=>{
      const el = document.getElementById(id);
      el?.addEventListener('click', ()=>buzz(10));
    });

    const vhFix=()=>document.documentElement.style.setProperty('--vh', `${window.innerHeight*0.01}px`);
    vhFix(); addEventListener('resize', vhFix);
  </script>
</body>
</html>
