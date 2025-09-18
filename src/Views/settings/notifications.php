<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Café Admin Dashboard - Notification Settings</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body class="bg-slate-900 bg-cover bg-center min-h-screen text-white/95" style="background-image: url('https://images.hdqwalls.com/wallpapers/dark-abstract-black-minimal-4k-q0.jpg');">
<div class="flex flex-col xl:flex-row h-screen">
<?php include dirname(__DIR__, 2) . '/Views/partials/sidebar.php'; ?>
<div class="flex-1 flex flex-col overflow-hidden">
<main class="flex-1 p-4 md:p-6 overflow-y-auto">
<div class="max-w-4xl mx-auto space-y-8 pb-24">
<header class="mb-8">
<h2 class="text-3xl font-bold tracking-tight">Notification Settings</h2>
<p class="text-base text-white/60 mt-1">Manage how you receive notifications from the system.</p>
</header>
<div class="glassmorphism p-6 rounded-2xl">
<h3 class="text-xl font-semibold mb-4">Active Notifications Summary</h3>
<div class="flex flex-wrap gap-2">
<span class="bg-cyan-500/20 text-cyan-300 text-xs font-medium px-2.5 py-1 rounded-full">Low Stock Warnings</span>
<span class="bg-cyan-500/20 text-cyan-300 text-xs font-medium px-2.5 py-1 rounded-full">Daily Closing Report</span>
<span class="bg-cyan-500/20 text-cyan-300 text-xs font-medium px-2.5 py-1 rounded-full">New Order Alerts</span>
<span class="bg-cyan-500/20 text-cyan-300 text-xs font-medium px-2.5 py-1 rounded-full">Promotional Reminders</span>
</div>
</div>
<div class="glassmorphism p-6 md:p-8 rounded-2xl">
<h3 class="text-xl font-semibold mb-6">Notification Channels</h3>
<div class="space-y-6">
<div class="flex items-center justify-between">
<div class="flex items-center space-x-4">
<span class="material-symbols-outlined text-cyan-400">email</span>
<div>
<p class="font-medium">Email Notifications</p>
<p class="text-sm text-white/60">Receive notifications directly to your inbox.</p>
</div>
</div>
<label class="toggle-switch">
<input checked="" type="checkbox"/>
<span class="slider"></span>
</label>
</div>
<div class="flex items-center justify-between">
<div class="flex items-center space-x-4">
<span class="material-symbols-outlined text-cyan-400">sms</span>
<div>
<p class="font-medium">SMS Notifications</p>
<p class="text-sm text-white/60">Get critical alerts via text message.</p>
</div>
</div>
<label class="toggle-switch">
<input type="checkbox"/>
<span class="slider"></span>
</label>
</div>
<div class="flex items-center justify-between">
<div class="flex items-center space-x-4">
<span class="material-symbols-outlined text-cyan-400">notifications_active</span>
<div>
<p class="font-medium">Push Notifications</p>
<p class="text-sm text-white/60">Real-time alerts on your desktop or mobile.</p>
</div>
</div>
<label class="toggle-switch">
<input checked="" type="checkbox"/>
<span class="slider"></span>
</label>
</div>
</div>
</div>
<div class="glassmorphism p-6 md:p-8 rounded-2xl">
<h3 class="text-xl font-semibold mb-6">Operational Alerts</h3>
<div class="space-y-6 divide-y divide-white/10">
<div class="pt-6 first:pt-0">
<div class="flex items-center justify-between">
<div>
<p class="font-medium">Low Stock Warning</p>
<p class="text-sm text-white/60">Notify when inventory for an item drops below a threshold.</p>
</div>
<label class="toggle-switch">
<input checked="" type="checkbox"/>
<span class="slider"></span>
</label>
</div>
<div class="mt-4 pl-4 border-l-2 border-white/10 space-y-3">
<p class="text-sm font-medium text-white/80">Notify Roles:</p>
<div class="flex items-center justify-between text-sm">
<p>Manager</p>
<label class="toggle-switch !w-10 !h-6"><input checked="" type="checkbox"/><span class="slider before:!w-4 before:!h-4 before:bottom-1 before:left-1 checked:before:translate-x-4"></span></label>
</div>
<div class="flex items-center justify-between text-sm">
<p>Kitchen Staff</p>
<label class="toggle-switch !w-10 !h-6"><input checked="" type="checkbox"/><span class="slider before:!w-4 before:!h-4 before:bottom-1 before:left-1 checked:before:translate-x-4"></span></label>
</div>
<div class="flex items-center justify-between text-sm text-white/50">
<p>Barista</p>
<label class="toggle-switch !w-10 !h-6"><input disabled="" type="checkbox"/><span class="slider before:!w-4 before:!h-4 before:bottom-1 before:left-1 checked:before:translate-x-4"></span></label>
</div>
</div>
</div>
<div class="pt-6">
<div class="flex items-center justify-between">
<div>
<p class="font-medium">Daily Closing Report Auto-send</p>
<p class="text-sm text-white/60">Automatically send the closing report at the end of day.</p>
</div>
<label class="toggle-switch">
<input checked="" type="checkbox"/>
<span class="slider"></span>
</label>
</div>
<div class="mt-4 pl-4 border-l-2 border-white/10 space-y-3">
<p class="text-sm font-medium text-white/80">Notify Roles:</p>
<div class="flex items-center justify-between text-sm">
<p>Manager</p>
<label class="toggle-switch !w-10 !h-6"><input checked="" type="checkbox"/><span class="slider before:!w-4 before:!h-4 before:bottom-1 before:left-1 checked:before:translate-x-4"></span></label>
</div>
<div class="flex items-center justify-between text-sm text-white/50">
<p>Kitchen Staff</p>
<label class="toggle-switch !w-10 !h-6"><input disabled="" type="checkbox"/><span class="slider before:!w-4 before:!h-4 before:bottom-1 before:left-1 checked:before:translate-x-4"></span></label>
</div>
</div>
</div>
<div class="pt-6">
<div class="flex items-center justify-between">
<div>
<p class="font-medium">New Order Alerts</p>
<p class="text-sm text-white/60">Real-time alert for every new incoming order.</p>
</div>
<label class="toggle-switch">
<input checked="" type="checkbox"/>
<span class="slider"></span>
</label>
</div>
</div>
<div class="pt-6">
<div class="flex items-center justify-between">
<div>
<p class="font-medium">Payment Failure Alerts</p>
<p class="text-sm text-white/60">Get notified immediately if a customer payment fails.</p>
</div>
<label class="toggle-switch">
<input type="checkbox"/>
<span class="slider"></span>
</label>
</div>
</div>
</div>
</div>
<div class="glassmorphism p-6 md:p-8 rounded-2xl">
<h3 class="text-xl font-semibold mb-6">Marketing Alerts</h3>
<div class="space-y-6 divide-y divide-white/10">
<div class="pt-6 first:pt-0">
<div class="flex items-center justify-between">
<div>
<p class="font-medium">Promotional Reminders</p>
<p class="text-sm text-white/60">Send out reminders about ongoing promotions.</p>
</div>
<label class="toggle-switch">
<input checked="" type="checkbox"/>
<span class="slider"></span>
</label>
</div>
<div class="mt-4 pl-4 border-l-2 border-white/10 space-y-3">
<p class="text-sm font-medium text-white/80">Notify Roles:</p>
<div class="flex items-center justify-between text-sm">
<p>Marketing Team</p>
<label class="toggle-switch !w-10 !h-6"><input checked="" type="checkbox"/><span class="slider before:!w-4 before:!h-4 before:bottom-1 before:left-1 checked:before:translate-x-4"></span></label>
</div>
<div class="flex items-center justify-between text-sm">
<p>Manager</p>
<label class="toggle-switch !w-10 !h-6"><input type="checkbox"/><span class="slider before:!w-4 before:!h-4 before:bottom-1 before:left-1 checked:before:translate-x-4"></span></label>
</div>
</div>
</div>
<div class="pt-6">
<div class="flex items-center justify-between">
<div>
<p class="font-medium">Customer Loyalty Messages</p>
<p class="text-sm text-white/60">Automated messages for loyalty program members.</p>
</div>
<label class="toggle-switch">
<input type="checkbox"/>
<span class="slider"></span>
</label>
</div>
</div>
</div>
</div>
</div>
</main>
<footer class="fixed bottom-0 left-0 xl:pl-72 right-0 glassmorphism border-t border-white/10 p-4">
<div class="max-w-4xl mx-auto flex justify-end gap-4">
<button class="bg-white/10 text-white/80 px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-white/20 transition-colors">Cancel</button>
<button class="bg-cyan-500 text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-cyan-600 transition-colors shadow-[0_4px_14px_rgba(56,189,248,0.25)]">Save Changes</button>
</div>
</footer>
</div>
</div>
<script>
        const menuToggle = document.getElementById('menu-toggle');
        const navMenu = document.getElementById('nav-menu');
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
    </script>

</body></html>