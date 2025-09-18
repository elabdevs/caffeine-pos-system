<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Café Yönetim - Giriş</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>

  <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">

  <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body class="bg-slate-900 bg-cover bg-center min-h-screen text-white/95 flex items-center justify-center p-4"style="background-image: url('https://images.hdqwalls.com/wallpapers/dark-abstract-black-minimal-4k-q0.jpg');">
  <div id="toasts" class="fixed top-4 right-4 z-50 space-y-3 pointer-events-none"></div>

  <div class="w-full max-w-md">
    <div class="glassmorphism p-8 md:p-10 rounded-2xl shadow-2xl">
      <div class="text-center mb-8">
        <a class="flex items-center justify-center space-x-3 text-cyan-300" href="#">
          <span class="material-symbols-outlined text-4xl">local_cafe</span>
          <h1 class="text-3xl font-bold">Caffeine</h1>
        </a>
        <p class="text-white/60 mt-2">Hesabınıza giriş yapın</p>
      </div>

      <!-- ALERT -->
      <div id="alert" class="hidden mb-4 rounded-lg border border-red-500/40 bg-red-500/10 px-3 py-2 text-sm text-red-200"></div>
      <!-- Toast Container -->


      <form id="loginForm" class="space-y-6" autocomplete="on">
        <div>
          <label class="block text-sm font-medium text-white/70 mb-2" for="email">E-posta veya Kullanıcı Adı</label>
          <div class="relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-white/40">person</span>
            <input class="form-input rounded-lg w-full pl-10 py-2.5" id="email" name="email" placeholder="you@example.com" required type="text" autocomplete="username"/>
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-white/70 mb-2" for="password">Parola</label>
          <div class="relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-white/40">lock</span>
            <input class="form-input rounded-lg w-full pl-10 py-2.5 pr-10" id="password" name="password" placeholder="••••••••" required type="password" autocomplete="current-password"/>
            <button type="button" id="togglePass" class="absolute right-2 top-1/2 -translate-y-1/2 text-white/50 text-sm px-2">göster</button>
          </div>
        </div>

        <div class="flex items-center justify-between">
          <label class="flex items-center space-x-2">
            <input class="form-checkbox h-4 w-4 rounded text-cyan-500 focus:ring-cyan-500 border-white/20 bg-white/10" id="remember" name="remember" type="checkbox"/>
            <span class="text-sm text-white/70">Beni hatırla</span>
          </label>
          <div class="text-sm">
            <a class="font-medium text-cyan-400 hover:text-cyan-300" href="/forgot-password">Parolanızı mı unuttunuz?</a>
          </div>
        </div>

        <div>
            <button id="submitBtn" class="w-full flex justify-center py-3 px-4 rounded-lg text-sm font-semibold text-white bg-cyan-500 hover:bg-cyan-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 focus:ring-offset-slate-900 transition-transform hover:scale-105 shadow-[0_4px_14px_rgba(56,189,248,0.25)]" type="submit">
            Giriş
          </button>
        </div>
      </form>

      <p class="mt-8 text-center text-sm text-white/50">
        Hesabınız yok mu?
        <a class="font-medium text-cyan-400 hover:text-cyan-300" href="/register">Hesap Oluştur</a>
      </p>
    </div>
  </div>

<script>
(function(){
  const form = document.getElementById('loginForm');
  const submitBtn = document.getElementById('submitBtn');
  const alertBox = document.getElementById('alert');
  const togglePass = document.getElementById('togglePass');
  const pass = document.getElementById('password');

  function notify(type='info', message='Bilgi', {duration=3500} = {}){
    const root = document.getElementById('toasts');
    if (!root) return;

    const palette = {
      success: 'border-emerald-500/40 bg-emerald-500/10 text-emerald-100',
      error:   'border-red-500/40 bg-red-500/10 text-red-100',
      warning: 'border-amber-500/40 bg-amber-500/10 text-amber-100',
      info:    'border-cyan-500/40 bg-cyan-500/10 text-cyan-100'
    };
    const iconMap = {
      success: 'check_circle',
      error:   'error',
      warning: 'warning',
      info:    'info'
    };

    const wrap = document.createElement('div');
    wrap.setAttribute('role','alert');
    wrap.className = `
      pointer-events-auto w-80 sm:w-96 rounded-xl border ${palette[type]||palette.info}
      backdrop-blur-lg shadow-2xl ring-1 ring-black/5
      transition-all duration-300 ease-out opacity-0 translate-x-3
    `;

    wrap.innerHTML = `
      <div class="p-4 pr-10 relative">
        <div class="flex items-start gap-3">
          <span class="material-symbols-outlined mt-0.5">${iconMap[type]||iconMap.info}</span>
          <div class="text-sm leading-5">${message}</div>
        </div>
        <button type="button" class="absolute top-2.5 right-2.5 text-white/60 hover:text-white">
          <span class="material-symbols-outlined text-base">close</span>
        </button>
      </div>
    `;

    const closeBtn = wrap.querySelector('button');
    const dismiss = () => {
      wrap.classList.add('opacity-0','translate-x-3');
      setTimeout(() => wrap.remove(), 250);
    };
    closeBtn.addEventListener('click', dismiss);

    root.appendChild(wrap);
    requestAnimationFrame(() => {
      wrap.classList.remove('opacity-0','translate-x-3');
      wrap.classList.add('opacity-100','translate-x-0');
    });

    if (duration > 0) setTimeout(dismiss, duration);
  }

  (function showReasonToast(){
    const params = new URLSearchParams(location.search);
    const r = params.get('reason');
    if (!r) return;

    const REASONS = {
      ua_mismatch: {
        type: 'warning',
        msg: 'Güvenlik nedeniyle oturum kapatıldı (tarayıcı değişikliği algılandı). Lütfen tekrar giriş yap.'
      },
    
      idle_timeout: {
        type: 'warning',
        msg: 'Uzun süre işlem yapmadığın için oturumun sonlandırıldı.'
      },
    
      absolute_timeout: {
        type: 'warning',
        msg: 'Oturum süren dolduğu için çıkış yapıldı. Güvenlik amacıyla yeniden giriş yap.'
      },
    
      csrf_failed: {
        type: 'error',
        msg: 'Güvenlik doğrulaması (CSRF) başarısız oldu. Sayfayı yenileyip tekrar deneyin.'
      },
    
      session_version_mismatch: {
        type: 'warning',
        msg: 'Oturumun başka bir yerden sıfırlandı (şifre değişimi veya zorunlu çıkış). Lütfen yeniden giriş yap.'
      },
    
      forbidden: {
        type: 'error',
        msg: 'Bu işlemi yapmak için yetkin yok (403). Gerekli role sahip misin kontrol et.'
      }
    };


    const item = REASONS[r];
    notify(item?.type || 'info', item?.msg || 'Lütfen tekrar giriş yap.', { duration: item ? 5000 : 4000 });

    const url = new URL(location.href);
    url.searchParams.delete('reason');
    history.replaceState({}, '', url.pathname + (url.searchParams.toString() ? '?' + url.searchParams.toString() : '') + url.hash);
  })();

  if (togglePass && pass){
    togglePass.addEventListener('click', () => {
      const isPw = pass.type === 'password';
      pass.type = isPw ? 'text' : 'password';
      togglePass.textContent = isPw ? 'gizle' : 'göster';
    });
  }

  function showError(msg){
    if (alertBox){
      alertBox.classList.add('hidden');
      alertBox.textContent = '';
    }
    notify('error', msg || 'Giriş başarısız.');
  }

  function clearError(){
    if (alertBox){
      alertBox.classList.add('hidden');
      alertBox.textContent = '';
    }
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    clearError();

    const username = document.getElementById('email').value.trim();
    const password = pass.value;
    const remember = document.getElementById('remember').checked;

    if (!username || !password){
      showError('Lütfen tüm alanları doldurun.');
      return;
    }

    const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';
    submitBtn.disabled = true; submitBtn.textContent = 'Signing in...';

    try {
      const res = await fetch('/api/v1/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-Token': csrf,
          'Accept': 'application/json'
        },
        credentials: 'same-origin',
        body: JSON.stringify({ username, password, remember })
      });

      const data = await res.json().catch(()=> ({}));

      if (!res.ok || data.ok === false) {
        showError(data.error || `HTTP ${res.status}`);
      } else {
        notify('success', 'Giriş başarılı! Yönlendiriliyorsun...', { duration: 1200 });
        const target = data.redirect || '/admin';
        setTimeout(() => window.location.assign(target), 750);
      }
    } catch (err){
      showError('Ağ hatası. Tekrar deneyin.');
    } finally {
      submitBtn.disabled = false; submitBtn.textContent = 'Giriş';
    }
  });
})();
</script>


</body>
</html>
