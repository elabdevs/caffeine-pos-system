<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>Caffeine Admin Dashboard - Donanım Ayarları</title>
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
      <div class="max-w-7xl mx-auto space-y-8 pb-28">

        <!-- Ticket Template -->
        <div class="glassmorphism p-6 md:p-8 rounded-2xl">
          <h3 class="text-xl font-semibold mb-6">Fiş Şablonu</h3>
          <form id="ticket-template-form" class="space-y-5">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
              <div class="space-y-3">
                <label for="tmpl-title" class="block text-sm font-medium text-white/70">Fiş başlığı</label>
                <input type="text" id="tmpl-title" name="title" class="form-input w-full rounded-lg bg-white/5 border-white/10 text-white/90" placeholder="Örn. CAFFEINE" />
                <label class="flex items-center space-x-2 text-sm text-white/70">
                  <input type="checkbox" id="tmpl-uppercase" name="uppercase_title" class="form-checkbox bg-white/5 border-white/20 text-cyan-500" />
                  <span>Başlığı büyük harf ile yaz</span>
                </label>
              </div>
              <div class="space-y-3">
                <label for="tmpl-line-width" class="block text-sm font-medium text-white/70">Satır genişliği</label>
                <input type="number" id="tmpl-line-width" name="line_width" min="16" max="64" step="1" class="form-input w-full rounded-lg bg-white/5 border-white/10 text-white/90" />
                <p class="text-xs text-white/50">Standart termal yazıcılar genelde 32 veya 42 karakter destekler.</p>
              </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
              <div class="space-y-3">
                <label for="tmpl-header" class="block text-sm font-medium text-white/70">Başlık satırları</label>
                <textarea id="tmpl-header" name="header_lines" rows="3" class="form-textarea w-full rounded-lg bg-white/5 border-white/10 text-white/90" placeholder="Her satır için yeni satır kullan"></textarea>
              </div>
              <div class="space-y-3">
                <label for="tmpl-footer" class="block text-sm font-medium text-white/70">Alt bilgi satırları</label>
                <textarea id="tmpl-footer" name="footer_lines" rows="3" class="form-textarea w-full rounded-lg bg-white/5 border-white/10 text-white/90" placeholder="Teşekkür mesajları, sosyal medya vb."></textarea>
              </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
              <div class="space-y-3">
                <label class="flex items-center space-x-2 text-sm text-white/70">
                  <input type="checkbox" id="tmpl-show-table" name="show_table" class="form-checkbox bg-white/5 border-white/20 text-cyan-500" />
                  <span>Masa bilgisini göster</span>
                </label>
                <label for="tmpl-table-label" class="block text-sm font-medium text-white/70">Masa etiketi</label>
                <input type="text" id="tmpl-table-label" name="table_label" class="form-input w-full rounded-lg bg-white/5 border-white/10 text-white/90" placeholder="Örn. Masa" />
              </div>
              <div class="space-y-3">
                <label for="tmpl-item-format" class="block text-sm font-medium text-white/70">Ürün satırı formatı</label>
                <input type="text" id="tmpl-item-format" name="item_format" class="form-input w-full rounded-lg bg-white/5 border-white/10 text-white/90" placeholder="Örn. {qty} x {name}" />
                <label for="tmpl-note-format" class="block text-sm font-medium text-white/70">Not formatı</label>
                <input type="text" id="tmpl-note-format" name="note_format" class="form-input w-full rounded-lg bg-white/5 border-white/10 text-white/90" placeholder="Örn. Not: {note}" />
              </div>
            </div>
            <div class="flex items-center justify-between pt-3">
              <button type="button" id="ticket-template-reset" class="bg-white/10 text-white/80 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-white/20">Varsayılanı Yükle</button>
              <button type="submit" class="bg-cyan-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-cyan-600 shadow">Şablonu Kaydet</button>
            </div>
            <div id="ticket-template-feedback" class="hidden text-sm mt-3 p-2 rounded-lg"></div>
          </form>
        </div>

        <!-- Ticket Preview -->
        <div class="glassmorphism p-6 md:p-8 rounded-2xl">
          <h3 class="text-xl font-semibold mb-6">Fiş Önizleme</h3>
          <div class="bg-black/40 border border-white/10 rounded-xl p-4 overflow-auto">
            <pre id="ticket-template-preview" class="font-mono text-sm leading-6 whitespace-pre-wrap text-white/80">Önizleme hazırlanıyor...</pre>
          </div>
          <p class="text-xs text-white/50 mt-3">Önizleme örnek sipariş verileri (Masa A12, Latte, Cheesecake, Cold Brew) ile oluşturulur.</p>
        </div>

        <!-- Printers -->
        <div class="glassmorphism p-6 md:p-8 rounded-2xl">
          <h3 class="text-xl font-semibold mb-6">Yazıcılar</h3>
          <div class="space-y-4">
            <div class="bg-white/5 p-6 rounded-xl border border-white/10">
              <h4 class="text-lg font-semibold">Kural Önceliği</h4>
              <p class="text-sm text-white/60 mt-1">Ürün override &gt; kategori kuralı &gt; varsayılan istasyon</p>
              <p id="printer-feedback" class="hidden text-sm mt-3 p-2 rounded-lg"></p>
            </div>
            <div id="printer-cards" class="grid grid-cols-1 lg:grid-cols-2 gap-6"></div>
            <p id="printer-empty" class="text-sm text-white/60 hidden">Tanımlı yazıcı bulunamadı.</p>
          </div>
          <template id="printer-card-template">
            <div class="bg-white/5 p-6 rounded-xl border border-white/10 printer-card">
              <div class="flex justify-between items-start">
                <div>
                  <h4 class="text-lg font-semibold" data-printer-name>Yazıcı</h4>
                  <p class="text-sm text-white/60 mt-1" data-printer-station>İstasyon bilgisi yok</p>
                </div>
                <span class="material-symbols-outlined text-4xl text-white/50">print</span>
              </div>
              <dl class="mt-4 space-y-1 text-sm text-white/70">
                <div class="flex justify-between"><dt>Bağlantı</dt><dd class="text-white/80" data-printer-connector>-</dd></div>
                <div class="flex justify-between"><dt>Host</dt><dd class="text-white/80" data-printer-host>-</dd></div>
                <div class="flex justify-between"><dt>Port</dt><dd class="text-white/80" data-printer-port>-</dd></div>
              </dl>
              <div class="flex items-center justify-between mt-6">
                <button type="button" class="bg-cyan-500/80 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-cyan-500 shadow" data-test-button>Test Fişi</button>
                <span class="text-xs text-white/50" data-printer-status></span>
              </div>
            </div>
          </template>
        </div>

      </div>
    </main>
    <footer class="fixed bottom-0 left-0 xl:pl-72 right-0 glassmorphism border-t border-white/10 p-4">
      <div class="max-w-7xl mx-auto flex justify-end gap-4">
        <button class="bg-white/10 text-white/80 px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/20">Değişiklikleri İptal Et</button>
        <button class="bg-cyan-500 text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-cyan-600 shadow">Değişiklikleri Uygula</button>
      </div>
    </footer>
  </div>
</div>

<script>
  const csrf = "<?= csrfToken() ?>";

  async function apiFetch(url, options = {}) {
    const res = await fetch(url, {
      headers: { 'Accept': 'application/json', 'X-CSRF-Token': csrf, ...options.headers },
      cache: 'no-store',
      ...options
    });
    if (!res.ok) throw new Error('HTTP ' + res.status);
    return await res.json();
  }

  // ---- Ticket Template Manager ----
  const templateForm = document.getElementById('ticket-template-form');
  const templatePreviewEl = document.getElementById('ticket-template-preview');
  const templateFeedbackEl = document.getElementById('ticket-template-feedback');

  const TicketTemplateManager = {
    async load() {
      try {
        const body = await apiFetch('/api/v1/printers/template');
        const template = body?.data?.template ?? body?.template ?? {};
        const preview  = body?.data?.preview  ?? body?.preview  ?? [];
        TicketTemplateManager.populate(template);
        TicketTemplateManager.preview(Array.isArray(preview) ? preview : []);
      } catch (err) {
        TicketTemplateManager.status('Şablon yüklenemedi: ' + err.message, true);
      }
    },
    async save(event) {
      event.preventDefault();
      try {
        const payload = TicketTemplateManager.collect();
        const body = await apiFetch('/api/v1/printers/template', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': csrf, },
          body: JSON.stringify(payload)
        });
        TicketTemplateManager.populate(body?.data?.template ?? {});
        TicketTemplateManager.preview(body?.data?.preview ?? []);
        TicketTemplateManager.status('Şablon kaydedildi.');
      } catch (err) {
        TicketTemplateManager.status('Şablon kaydedilemedi: ' + err.message, true);
      }
    },
    collect() {
      return {
        title: document.getElementById('tmpl-title').value,
        uppercase_title: document.getElementById('tmpl-uppercase').checked,
        header_lines: document.getElementById('tmpl-header').value.split('\n'),
        footer_lines: document.getElementById('tmpl-footer').value.split('\n'),
        show_table: document.getElementById('tmpl-show-table').checked,
        table_label: document.getElementById('tmpl-table-label').value,
        item_format: document.getElementById('tmpl-item-format').value,
        note_format: document.getElementById('tmpl-note-format').value,
        line_width: parseInt(document.getElementById('tmpl-line-width').value || '32')
      };
    },
    populate(template) {
      document.getElementById('tmpl-title').value = template.title ?? '';
      document.getElementById('tmpl-uppercase').checked = template.uppercase_title ?? false;
      document.getElementById('tmpl-header').value = (template.header_lines ?? []).join('\n');
      document.getElementById('tmpl-footer').value = (template.footer_lines ?? []).join('\n');
      document.getElementById('tmpl-show-table').checked = template.show_table ?? true;
      document.getElementById('tmpl-table-label').value = template.table_label ?? 'Masa';
      document.getElementById('tmpl-item-format').value = template.item_format ?? '{qty} x {name}';
      document.getElementById('tmpl-note-format').value = template.note_format ?? 'Not: {note}';
      document.getElementById('tmpl-line-width').value = template.line_width ?? 32;
    },
    preview(lines) {
      const text = Array.isArray(lines) && lines.length
        ? lines.join('\n')
        : (typeof lines === 'string' && lines ? lines : 'Önizleme bulunamadı.');
      templatePreviewEl.textContent = text;
    },
    status(msg, isError = false) {
      templateFeedbackEl.textContent = msg;
      templateFeedbackEl.className = `text-sm mt-3 p-2 rounded-lg ${isError ? 'bg-red-500/20 text-red-300' : 'bg-green-500/20 text-green-300'}`;
      templateFeedbackEl.classList.remove('hidden');
    }
  };

  templateForm?.addEventListener('submit', TicketTemplateManager.save);
  TicketTemplateManager.load();

  // ---- Printer Manager ----
  const printerCardsEl = document.getElementById('printer-cards');
  const printerTemplate = document.getElementById('printer-card-template');
  const printerFeedbackEl = document.getElementById('printer-feedback');

  const PrinterManager = {
    async load() {
      try {
        const body = await apiFetch('/api/v1/printers');
        PrinterManager.render(body?.data?.items ?? []);
      } catch (err) {
        PrinterManager.status('Yazıcılar yüklenemedi: ' + err.message, true);
      }
    },
    render(items) {
      printerCardsEl.innerHTML = '';
      if (!items.length) {
        document.getElementById('printer-empty').classList.remove('hidden');
        return;
      }
      items.forEach(item => {
        const fragment = document.importNode(printerTemplate.content, true);
        fragment.querySelector('[data-printer-name]').textContent = item.name;
        fragment.querySelector('[data-printer-station]').textContent = item.station_name ?? 'İstasyon atanmamış';
        fragment.querySelector('[data-printer-connector]').textContent = item.connector ?? '-';
        fragment.querySelector('[data-printer-host]').textContent = item.host ?? '-';
        fragment.querySelector('[data-printer-port]').textContent = item.port ?? '-';
        fragment.querySelector('[data-printer-status]').textContent = item.is_active ? 'Aktif' : 'Pasif';
        fragment.querySelector('[data-test-button]')?.addEventListener('click', () => PrinterManager.test(item));
        printerCardsEl.appendChild(fragment);
      });
    },
    async test(item) {
      try {
        const body = await apiFetch(`/api/v1/printers/${item.id}/test`, { method: 'POST' });
        PrinterManager.status(`Test fişi kuyruğa alındı (#${body?.data?.job_id ?? '?'})`);
      } catch (err) {
        PrinterManager.status('Test başarısız: ' + err.message, true);
      }
    },
    status(msg, isError = false) {
      printerFeedbackEl.textContent = msg;
      printerFeedbackEl.className = `text-sm mt-3 p-2 rounded-lg ${isError ? 'bg-red-500/20 text-red-300' : 'bg-cyan-500/20 text-cyan-300'}`;
      printerFeedbackEl.classList.remove('hidden');
    }
  };

  PrinterManager.load();
</script>
</body>
</html>
