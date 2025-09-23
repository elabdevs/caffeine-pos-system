<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Café Yönetim Paneli - Ödemeler &amp; Faturalama</title>

  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body class="bg-slate-900 bg-cover bg-center min-h-screen text-white/95" style="background-image: url('https://images.hdqwalls.com/wallpapers/dark-abstract-black-minimal-4k-q0.jpg');">
  <div class="flex flex-col xl:flex-row h-screen">
    <?php include dirname(__DIR__, 2) . '/Views/partials/sidebar.php'; ?>

    <div class="flex-1 flex flex-col overflow-hidden">
      <main class="flex-1 p-4 md:p-6 overflow-y-auto">
        <div class="max-w-7xl mx-auto space-y-8">

          <header class="mb-8">
            <h2 class="text-3xl font-bold tracking-tight">Ödemeler &amp; Faturalama</h2>
            <p class="text-base text-white/60 mt-1">Ödeme yöntemlerini aktif/pasif yap ve kaydet.</p>
          </header>

          <div class="grid grid-cols-1 @container xl:grid-cols-2 gap-8">
            <div class="xl:col-span-2 space-y-8">
              <div class="glassmorphism p-6 md:p-8 rounded-2xl">
                <h3 class="text-xl font-semibold mb-6">Ödeme Yöntemleri</h3>

                <!-- Payment methods grid -->
                <div id="payment-methods" class="grid grid-cols-1 @md:grid-cols-2 gap-6">
                  <!-- cash -->
                  <div class="flex items-center justify-between p-4 bg-black/20 border border-white/10 rounded-xl">
                    <div class="flex items-center space-x-4">
                      <span class="material-symbols-outlined text-3xl text-cyan-400">payments</span>
                      <span class="font-medium">Nakit</span>
                    </div>
                    <label class="toggle-switch">
                      <input type="checkbox" data-code="cash" checked>
                      <span class="slider"></span>
                    </label>
                  </div>

                  <!-- card -->
                  <div class="flex items-center justify-between p-4 bg-black/20 border border-white/10 rounded-xl">
                    <div class="flex items-center space-x-4">
                      <span class="material-symbols-outlined text-3xl text-cyan-400">credit_card</span>
                      <span class="font-medium">Kredi/Banka Kartı</span>
                    </div>
                    <label class="toggle-switch">
                      <input type="checkbox" data-code="card" checked>
                      <span class="slider"></span>
                    </label>
                  </div>

                  <!-- bank_transfer -->
                  <div class="flex items-center justify-between p-4 bg-black/20 border border-white/10 rounded-xl">
                    <div class="flex items-center space-x-4">
                      <span class="material-symbols-outlined text-3xl text-cyan-400">account_balance</span>
                      <span class="font-medium">Havale/EFT</span>
                    </div>
                    <label class="toggle-switch">
                      <input type="checkbox" data-code="bank_transfer">
                      <span class="slider"></span>
                    </label>
                  </div>

                  <!-- qr -->
                  <div class="flex items-center justify-between p-4 bg-black/20 border border-white/10 rounded-xl">
                    <div class="flex items-center space-x-4">
                      <span class="material-symbols-outlined text-3xl text-cyan-400">qr_code_2</span>
                      <span class="font-medium">QR Kod</span>
                    </div>
                    <label class="toggle-switch">
                      <input type="checkbox" data-code="qr">
                      <span class="slider"></span>
                    </label>
                  </div>

                  <!-- meal_card -->
                  <div class="flex items-center justify-between p-4 bg-black/20 border border-white/10 rounded-xl">
                    <div class="flex items-center space-x-4">
                      <span class="material-symbols-outlined text-3xl text-cyan-400">card_membership</span>
                      <span class="font-medium">Yemek Kartı</span>
                    </div>
                    <label class="toggle-switch">
                      <input type="checkbox" data-code="meal_card" checked>
                      <span class="slider"></span>
                    </label>
                  </div>

                  <!-- crypto -->
                  <div class="flex items-center justify-between p-4 bg-black/20 border border-white/10 rounded-xl">
                    <div class="flex items-center space-x-4">
                      <span class="material-symbols-outlined text-3xl text-cyan-400">currency_bitcoin</span>
                      <span class="font-medium">Kripto</span>
                    </div>
                    <label class="toggle-switch">
                      <input type="checkbox" data-code="crypto">
                      <span class="slider"></span>
                    </label>
                  </div>
                </div>
                <!-- /grid -->
              </div>
            </div>
          </div>

          <div class="flex justify-end pt-4">
            <button id="saveBtn" class="bg-cyan-500 text-white px-8 py-3 rounded-lg text-base font-semibold hover:bg-cyan-600 transition-colors shadow-[0_4px_14px_rgba(56,189,248,0.25)]">
              Değişiklikleri Kaydet
            </button>
          </div>

          <!-- toast -->
          <div id="toast" class="fixed bottom-6 right-6 hidden">
            <div id="toastInner" class="px-5 py-3 rounded-lg shadow-lg text-sm"></div>
          </div>

        </div>
      </main>
    </div>
  </div>

  <script>
    // Mobil menü (senin mevcut kodun)
    const menuToggle = document.getElementById('menu-toggle');
    const navMenu = document.getElementById('nav-menu');
    const csrf = "<?= csrfToken() ?>";
    if (menuToggle && navMenu) {
      menuToggle.addEventListener('click', () => {
        const isHidden = navMenu.classList.contains('hidden');
        if (isHidden) {
          navMenu.classList.remove('hidden');
          navMenu.classList.add('flex', 'flex-col', 'absolute', 'top-24', 'left-0', 'w-full', 'p-6', 'sidebar', 'z-20', 'gap-y-3');
        } else {
          navMenu.classList.add('hidden');
          navMenu.classList.remove('flex', 'flex-col', 'absolute', 'top-24', 'left-0', 'w-full', 'p-6', 'sidebar', 'z-20', 'gap-y-3');
        }
      });
      window.addEventListener('resize', () => {
        if (window.innerWidth >= 1280) {
          navMenu.classList.remove('absolute', 'top-24', 'left-0', 'w-full', 'p-6', 'sidebar', 'z-20', 'flex', 'flex-col');
          if (!navMenu.classList.contains('xl:flex')) {
            navMenu.classList.add('hidden');
          }
        }
      });
    }

    // Basit toast helper
    const toast = (msg, type = 'success') => {
      const box = document.getElementById('toast');
      const inner = document.getElementById('toastInner');
      inner.textContent = msg;
      inner.className = 'px-5 py-3 rounded-lg shadow-lg text-sm ' +
        (type === 'success' ? 'bg-emerald-600' : 'bg-rose-600');
      box.classList.remove('hidden');
      setTimeout(() => box.classList.add('hidden'), 2500);
    };

    // Save
    document.getElementById('saveBtn').addEventListener('click', async () => {
      const btn = document.getElementById('saveBtn');
      const payload = {
        // Eğer kasiyer/şube bağlamak istersen buraya ekle: cashier_id, branch_id...
        payment_methods: {}
      };

      document.querySelectorAll('#payment-methods input[type="checkbox"][data-code]')
        .forEach(el => {
          payload.payment_methods[el.dataset.code] = el.checked;
        });

      // buton durumu
      const origText = btn.textContent;
      btn.disabled = true;
      btn.textContent = 'Kaydediliyor...';

      try {
        const res = await fetch('/api/v1/payment-methods/save', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': csrf },
          body: JSON.stringify(payload)
        });

        if (!res.ok) {
          const text = await res.text().catch(() => '');
          throw new Error('Sunucu hatası: ' + res.status + (text ? (' - ' + text) : ''));
        }

        await res.json().catch(() => ({}));
        toast('Değişiklikler kaydedildi ✅', 'success');
      } catch (err) {
        console.error(err);
        toast('Kaydedilirken hata oluştu ❌', 'error');
      } finally {
        btn.disabled = false;
        btn.textContent = origText;
      }
    });
  </script>
</body>
</html>
