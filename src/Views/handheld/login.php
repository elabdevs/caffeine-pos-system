<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Caffeine · Giriş</title>
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta name="theme-color" content="#111714" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
  <meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="Cafe POS">
<link rel="manifest" href="/manifest.json">


  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
  <link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css2?display=swap&family=Epilogue:wght@400;500;700;900&family=Noto+Sans:wght@400;500;700;900" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
  <title>Waiter App · Login</title>
  <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

  <style type="text/tailwindcss">
    :root {
      --checkbox-tick-svg: url('data:image/svg+xml,%3csvg viewBox=%270 0 16 16%27 fill=%27rgb(17,23,20)%27 xmlns=%27http://www.w3.org/2000/svg%27%3e%3cpath d=%27M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z%27/%3e%3c/svg%3e');
      --select-button-svg: url('data:image/svg+xml,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 width=%2724%27 height=%2724%27 fill=%27rgb(158,183,168)%27 viewBox=%270 0 256 256%27%3e%3cpath d=%27M181.66,170.34a8,8,0,0,1,0,11.32l-48,48a8,8,0,0,1-11.32,0l-48-48a8,8,0,0,1,11.32-11.32L128,212.69l42.34-42.35A8,8,0,0,1,181.66,170.34Zm-96-84.68L128,43.31l42.34,42.35a8,8,0,0,0,11.32-11.32l-48-48a8,8,0,0,0-11.32,0l-48,48A8,8,0,0,0,85.66,85.66Z%27/%3e%3c/svg%3e');
    }

    html, body { height: 100%; }
    body { min-height: 100dvh; background: #111714; }

    .safe-p {
      padding-top: max(env(safe-area-inset-top), 16px);
      padding-bottom: max(env(safe-area-inset-bottom), 16px);
    }

    .no-tap-delay { touch-action: manipulation; -webkit-tap-highlight-color: transparent; }

    .material-symbols-outlined { font-variation-settings: 'wght' 500; }

    select.form-select {
      background-image: var(--select-button-svg);
      background-repeat: no-repeat;
      background-position: right 1rem center;
      background-size: 20px 20px;
    }
  </style>
</head>
<body class="no-tap-delay" style='font-family: Epilogue, "Noto Sans", system-ui, -apple-system, Segoe UI, Roboto, sans-serif;'>

  <div class="mx-auto w-full max-w-[480px] min-h-dvh bg-[#0f1512]">
    <header class="safe-p px-4 pt-2">
      <div class="h-12 flex items-center justify-between">
      </div>
    </header>

    <main class="px-4 pb-28">
      <section class="mt-3 rounded-3xl border border-white/5 bg-[#121a16]/80 backdrop-blur-xl shadow-[0_6px_40px_-10px_rgba(0,0,0,0.6)]">
        <div class="px-5 py-6">
          <div class="text-center">
            <h1 class="text-white text-2xl font-bold tracking-tight">Tekrar Hoşgeldin!</h1>
            <p class="text-[#9eb7a8] text-sm mt-1.5">Garson hesabınıza giriş yapın</p>
          </div>

          <form class="mt-6 space-y-4" novalidate>
            <label class="block">
              <div class="relative">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-[#9eb7a8]">person</span>
                <input
                  class="form-input w-full rounded-2xl text-white bg-[#1b2520] border border-white/10 h-14 pl-12 pr-4 placeholder:text-[#9eb7a8] focus:ring-2 focus:ring-[#38e07b] focus:border-transparent"
                  placeholder="Kullanıcı Adı"
                  name="username"
                  autocomplete="username"
                  inputmode="text"
                  enterkeyhint="next"
                  required />
              </div>
            </label>

            <label class="block">
              <div class="relative">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-[#9eb7a8]">lock</span>
                <input
                  class="form-input w-full rounded-2xl text-white bg-[#1b2520] border border-white/10 h-14 pl-12 pr-12 placeholder:text-[#9eb7a8] focus:ring-2 focus:ring-[#38e07b] focus:border-transparent"
                  placeholder="Şifre"
                  type="password"
                  name="password"
                  autocomplete="current-password"
                  enterkeyhint="go"
                  required />
                <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-[#9eb7a8] grid place-items-center size-9 rounded-xl hover:bg-white/5" data-toggle-pass>
                  <span class="material-symbols-outlined" aria-hidden="true">visibility</span>
                </button>
              </div>
            </label>

            <label class="block">
              <div class="relative">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-[#9eb7a8]">store</span>
                <select
                  class="form-select w-full appearance-none rounded-2xl text-white bg-[#1b2520] border border-white/10 h-14 pl-12 pr-12 focus:ring-2 focus:ring-[#38e07b] focus:border-transparent"
                  name="branch" required>
                  <option disabled selected class="text-[#9eb7a8]">Şube Seçin</option>
                  <option value="1">İzmir Aliağa Şube</option>
                </select>
              </div>
            </label>

            <label class="block">
              <div class="relative">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-[#9eb7a8]">schedule</span>
                <select
                  class="form-select w-full appearance-none rounded-2xl text-white bg-[#1b2520] border border-white/10 h-14 pl-12 pr-12 focus:ring-2 focus:ring-[#38e07b] focus:border-transparent"
                  name="shift" required>
                  <option disabled selected class="text-[#9eb7a8]">Shift Seçin</option>
                  <option value="1">Sabah (08:00 – 16:00)</option>
                  <option value="2">Akşam (16:00 – 00:00)</option>
                </select>
              </div>
            </label>


            <div class="flex items-center justify-between gap-3 pt-1">
              <label class="flex items-center gap-3 active:scale-[0.99]">
                <input
                  id="remember-me"
                  type="checkbox"
                  class="form-checkbox h-5 w-5 rounded-md border-2 border-[#3d5245] bg-transparent text-[#38e07b] checked:bg-[#38e07b] checked:border-transparent checked:bg-[image:var(--checkbox-tick-svg)] focus:ring-offset-0 focus:ring-2 focus:ring-[#38e07b]" />
                <span class="text-white text-sm">Remember me</span>
              </label>
              <a href="#" class="text-[#9eb7a8] text-sm hover:text-white">Forgot password?</a>
            </div>

            <p id="errorBox" class="hidden text-red-500 text-sm font-normal mt-1">
              Invalid username or password. Please try again.
            </p>
            <input type="hidden" name="csrf" id="csrf" value="<?= htmlspecialchars(csrfToken(), ENT_QUOTES) ?>">
          </form>
        </div>
      </section>
    </main>

    <footer class="fixed inset-x-0 bottom-0">
      <div class="mx-auto w-full max-w-[480px] safe-p px-4 pb-4">
        <button
          class="no-tap-delay w-full h-14 rounded-2xl px-5 bg-[#38e07b] text-[#111714] text-base font-extrabold tracking-wide active:scale-[0.99] shadow-[0_10px_30px_-12px_rgba(56,224,123,0.7)]"
          id="loginBtn">
          Login
        </button>
      </div>
    </footer>
  </div>

<script>
  const $ = (sel, el = document) => el.querySelector(sel);

  async function loginFlow() {
    const username = $('[name="username"]')?.value.trim() ?? '';
    const password = $('[name="password"]')?.value ?? '';
    const branch   = $('[name="branch"]')?.value ?? '';
    const shift    = $('[name="shift"]')?.value ?? '';

    // CSRF token: hidden input veya meta'dan al
    const csrf = $('#csrf')?.value
              || document.querySelector('meta[name="csrf-token"]')?.content
              || '';

    const btn = $('#loginBtn');
    const err = $('#errorBox');

    // Basit doğrulama
    if (!username || !password || !branch || !shift || !csrf) {
      err.textContent = 'Lütfen tüm alanları doldurun.';
      err.classList.remove('hidden');
      return;
    }

    // UI: disable
    btn.disabled = true;
    btn.textContent = 'Giriş yapılıyor…';

    // İsteğe timeout sarmalı
    const controller = new AbortController();
    const t = setTimeout(() => controller.abort(), 15000);

    try {
      const res = await fetch('/api/v1/handheld/login', {
        method: 'POST',
        credentials: 'include',                 // cookie oturumları için
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-Token': csrf                 // header ile gönder
        },
        body: JSON.stringify({
          username,
          password,
          branch,
          shift
        }),
        signal: controller.signal
      });

      clearTimeout(t);

 if (res.ok) {
  /** @type {{status:boolean, message:{message:string, redirect?:string}}} */
  const data = await res.json().catch(() => ({}));

  if (data?.status === true) {
    console.log('Login OK:', data.message?.message || 'ok');

    if ('vibrate' in navigator) navigator.vibrate(10);

    const to = data.message?.redirect || '/handheld/dashboard';
    location.assign(to);
    return;
  } else {
    // Beklenmedik JSON yapısı
    throw new Error('Unexpected response structure');
  }
} else {
  // Hata durumlarında da JSON deneyelim ki mesajı gösterelim
  let errMsg = 'Giriş başarısız. Bilgileri kontrol edin.';
  try {
    const e = await res.json();
    // ör: {status:false, message:"invalid_credentials"} veya benzeri
    errMsg = (e?.message && (e.message.message || e.message)) || errMsg;
  } catch {}
  throw new Error(errMsg);
}


      // Hata durumları
      let msg = 'Giriş başarısız. Bilgileri kontrol edin.';
      if (res.status === 401) msg = 'Hatalı kullanıcı adı veya şifre.';
      if (res.status === 422) msg = 'Eksik/Geçersiz alanlar gönderildi.';
      if (res.status === 419 || res.status === 403) msg = 'Oturum süresi doldu ya da CSRF doğrulaması geçersiz.';
      err.textContent = msg;
      err.classList.remove('hidden');
      if ('vibrate' in navigator) navigator.vibrate(20);
    } catch (e) {
      err.textContent = (e.name === 'AbortError')
        ? 'İstek zaman aşımına uğradı. İnternetini kontrol et.'
        : 'Sunucuya ulaşılamadı.';
      err.classList.remove('hidden');
    } finally {
      btn.disabled = false;
      btn.textContent = 'Login';
    }
  }

  // Şifre göster/gizle (senin kodun kalsın)
  document.querySelector('[data-toggle-pass]')?.addEventListener('click', function () {
    const input = this.previousElementSibling;
    const icon = this.querySelector('.material-symbols-outlined');
    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
    input.setAttribute('type', type);
    icon.textContent = type === 'password' ? 'visibility' : 'visibility_off';
  });

  // Login tıkla → API
  document.getElementById('loginBtn')?.addEventListener('click', (e) => {
    e.preventDefault();
    loginFlow();
  });

  // Enter ile gönderme (password alanındayken)
  document.querySelector('[name="password"]')?.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
      e.preventDefault();
      loginFlow();
    }
  });
</script>

</body>
</html>
