<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>Café Admin Dashboard - General Settings</title>
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
            <h2 class="text-3xl font-bold tracking-tight">General Settings</h2>
            <p class="text-base text-white/60 mt-1">Manage your café's general information and settings.</p>
          </header>

          <!-- Café Info -->
          <div class="glassmorphism p-6 md:p-8 rounded-2xl">
            <h3 class="text-xl font-semibold mb-6">Café Information</h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
              <div class="lg:col-span-2 space-y-6">
                <div>
                  <label class="block text-sm font-medium text-white/70 mb-2" for="cafe-name">Café Name</label>
                  <input class="form-input w-full rounded-lg text-sm" id="cafe-name" placeholder="Enter your café name" type="text" value="The Cozy Bean"/>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div>
                    <label class="block text-sm font-medium text-white/70 mb-2" for="address">Address</label>
                    <input class="form-input w-full rounded-lg text-sm" id="address" placeholder="e.g. 123 Coffee Lane" type="text" value="123 Coffee Lane, Brewville"/>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-white/70 mb-2" for="phone">Phone Number</label>
                    <input class="form-input w-full rounded-lg text-sm" id="phone" placeholder="e.g. +1 (555) 123-4567" type="tel" value="+1 (555) 123-4567"/>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Business Hours -->
          <div class="glassmorphism p-6 md:p-8 rounded-2xl">
            <h3 class="text-xl font-semibold mb-6">Business Hours</h3>
            <div id="business-hours-container" class="space-y-4"></div>
            <button type="button" class="mt-6 bg-white/5 border border-white/10 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-white/10 transition-colors flex items-center space-x-2">
              <span class="material-symbols-outlined text-base">add</span>
              <span>Add Hours</span>
            </button>
          </div>

          <!-- Financials + Localization -->
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="glassmorphism p-6 md:p-8 rounded-2xl">
              <h3 class="text-xl font-semibold mb-6">Financials</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-medium text-white/70 mb-2" for="currency">Currency</label>
                  <select class="form-input rounded-lg text-sm w-full" id="currency">
                    <option selected>USD ($)</option>
                    <option>EUR (€)</option>
                    <option>GBP (£)</option>
                    <option>JPY (¥)</option>
                  </select>
                </div>
                <div>
                  <label class="block text-sm font-medium text-white/70 mb-2" for="tax-rate">Tax Rate (%)</label>
                  <input class="form-input w-full rounded-lg text-sm" id="tax-rate" placeholder="e.g. 8.5" step="0.01" type="number" value="8.5"/>
                </div>
                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-white/70 mb-2" for="service-fee">Service Fee (%)</label>
                  <input class="form-input w-full rounded-lg text-sm" id="service-fee" placeholder="e.g. 10" step="0.1" type="number" value="10"/>
                </div>
              </div>
            </div>
            <div class="glassmorphism p-6 md:p-8 rounded-2xl">
              <h3 class="text-xl font-semibold mb-6">Localization</h3>
              <div>
                <label class="block text-sm font-medium text-white/70 mb-2" for="language">Language</label>
                <select class="form-input rounded-lg text-sm w-full" id="language">
                  <option selected>English</option>
                  <option>Español</option>
                  <option>Français</option>
                  <option>Deutsch</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Holidays -->
          <div class="glassmorphism p-6 md:p-8 rounded-2xl">
            <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 gap-4">
              <h3 class="text-xl font-semibold">Holiday Schedule</h3>
              <button type="button" class="bg-white/5 border border-white/10 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-white/10 transition-colors flex items-center space-x-2 self-start sm:self-center">
                <span class="material-symbols-outlined text-base">add</span>
                <span>Add Holiday</span>
              </button>
            </div>
            <div id="holidays-container" class="space-y-3"></div>
          </div>
        </div>
      </main>
      <footer class="sticky bottom-0 z-10 p-4 md:p-6 mt-auto bg-slate-900/50 backdrop-blur-sm border-t border-white/10">
        <div class="max-w-7xl mx-auto flex justify-end space-x-4">
          <button type="button" class="bg-white/10 text-white/80 px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/20 transition-colors">Cancel</button>
          <button type="button" id="save-general-settings" class="bg-cyan-500 text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-cyan-600 transition-colors shadow-[0_4px_14px_rgba(56,189,248,0.25)]">Save Changes</button>
        </div>
      </footer>
    </div>
  </div>

  <script>
    const csrf = "<?= csrfToken() ?>";
    const generalSettingsEndpoint = '/api/v1/saveSettings';
	const branch = <?= $_SESSION['branch_id'] ?>;

    const weekdays = {
      1: "Monday",
      2: "Tuesday",
      3: "Wednesday",
      4: "Thursday",
      5: "Friday",
      6: "Saturday",
      7: "Sunday"
    };

    async function loadBusinessHours() {
      try {
        const res = await fetch("/api/v1/getBusinessHours");
        const json = await res.json();
        if (!json.status) return;

        const container = document.getElementById("business-hours-container");
        container.innerHTML = "";

        json.data.forEach(item => {
          const dayName = weekdays[item.weekday];
          const disabled = item.enabled === 0;

          const row = `
            <div class="grid grid-cols-[100px,1fr,1fr,auto] items-center gap-x-4 gap-y-2 ${disabled ? 'opacity-60' : ''}" data-weekday="${item.weekday}" data-id="${item.id ?? ''}" data-enabled="${disabled ? 0 : 1}">
              <label class="text-sm font-medium ${disabled ? 'text-white/80' : 'text-white/90'}">${dayName}</label>
              <input type="time" class="form-input rounded-lg text-sm w-full" value="${item.open_time}" ${disabled ? 'disabled' : ''}/>
              <input type="time" class="form-input rounded-lg text-sm w-full" value="${item.close_time}" ${disabled ? 'disabled' : ''}/>
              <button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors">
                <span class="material-symbols-outlined">delete</span>
              </button>
            </div>`;
          container.insertAdjacentHTML("beforeend", row);
        });
      } catch (e) {
        console.error("BusinessHours error:", e);
      }
    }

    async function loadHolidays() {
      try {
        const res = await fetch("/api/v1/getBranchHolidays");
        const json = await res.json();
        if (!json.status) return;

        const container = document.getElementById("holidays-container");
        container.innerHTML = "";

        json.data.forEach(item => {
          const row = `
            <div class="grid grid-cols-[1fr,1fr,auto] items-center gap-x-4 gap-y-2 p-3 rounded-lg bg-black/20" data-id="${item.id ?? ''}">
              <input type="text" class="form-input rounded-lg text-sm" value="${item.name}" placeholder="Holiday Name"/>
              <input type="date" class="form-input rounded-lg text-sm" value="${item.holiday_date}"/>
              <button class="p-2 rounded-full hover:bg-white/10 text-white/70 hover:text-white transition-colors">
                <span class="material-symbols-outlined text-xl">delete</span>
              </button>
            </div>`;
          container.insertAdjacentHTML("beforeend", row);
        });
      } catch (e) {
        console.error("Holidays error:", e);
      }
    }

    loadBusinessHours();
    loadHolidays();
    document.getElementById("save-general-settings")?.addEventListener("click", saveGeneralSettings);

    function collectBusinessHours() {
      const rows = Array.from(document.querySelectorAll('#business-hours-container [data-weekday]'));
      return rows.map(row => {
        const [openInput, closeInput] = row.querySelectorAll('input[type="time"]');
        const enabled = !(openInput?.disabled || closeInput?.disabled);
        return {
          id: row.dataset.id ? Number(row.dataset.id) || row.dataset.id : null,
          weekday: Number(row.dataset.weekday) || null,
          open_time: openInput?.value ?? null,
          close_time: closeInput?.value ?? null,
          enabled: enabled ? 1 : 0
        };
      });
    }

    function collectHolidays() {
      const rows = Array.from(document.querySelectorAll('#holidays-container [data-id]'));
      return rows.map(row => {
        const nameInput = row.querySelector('input[type="text"]');
        const dateInput = row.querySelector('input[type="date"]');
        return {
          id: row.dataset.id ? Number(row.dataset.id) || row.dataset.id : null,
          name: nameInput?.value?.trim() ?? "",
          holiday_date: dateInput?.value ?? null
        };
      });
    }

    function collectGeneralSettings() {
      const taxRateRaw = document.getElementById('tax-rate').value;
      const serviceFeeRaw = document.getElementById('service-fee').value;

      const taxRate = Number.parseFloat(taxRateRaw);
      const serviceFee = Number.parseFloat(serviceFeeRaw);

      return {
		branch_id: branch,
        cafe: {
          name: document.getElementById('cafe-name').value.trim(),
          address: document.getElementById('address').value.trim(),
          phone: document.getElementById('phone').value.trim()
        },
        financials: {
          currency: document.getElementById('currency').value,
          tax_rate: Number.isFinite(taxRate) ? taxRate : null,
          service_fee: Number.isFinite(serviceFee) ? serviceFee : null
        },
        localization: {
          language: document.getElementById('language').value
        },
        business_hours: collectBusinessHours(),
        holidays: collectHolidays()
      };
    }

    async function saveGeneralSettings() {
      const button = document.getElementById('save-general-settings');
      if (!button) return;

      const originalText = button.textContent;
      button.disabled = true;
      button.textContent = 'Saving...';

      const payload = collectGeneralSettings();
      let success = false;

      try {
        const response = await fetch(generalSettingsEndpoint, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-Token': csrf
          },
          body: JSON.stringify(payload)
        });

        if (!response.ok) {
          throw new Error('Request failed with status ' + response.status);
        }
        const data = await response.json().catch(() => ({}));
        console.info('General settings saved', data);
        button.textContent = 'Saved!';
        success = true;
      } catch (error) {
        console.error('Saving general settings failed:', error);
        button.textContent = 'Retry';
      } finally {
        button.disabled = false;
        if (success) {
          setTimeout(() => {
            button.textContent = originalText;
          }, 2000);
        } else {
          setTimeout(() => {
            button.textContent = originalText;
          }, 1500);
        }
      }
    }
  </script>
</body>
</html>
