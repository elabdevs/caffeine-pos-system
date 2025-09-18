<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Café Admin Dashboard - Integrations Settings</title>
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
<div class="max-w-7xl mx-auto space-y-8 pb-24">
<header class="mb-8">
<h2 class="text-3xl font-bold tracking-tight">Integrations</h2>
<p class="text-base text-white/60 mt-1">Connect your POS with other services and platforms.</p>
</header>
<div class="glassmorphism p-6 md:p-8 rounded-2xl">
<h3 class="text-xl font-semibold mb-6">Available Integrations</h3>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
<div class="bg-white/5 p-5 rounded-xl flex flex-col">
<div class="flex items-center justify-between mb-3">
<h4 class="font-semibold text-lg">Yemeksepeti</h4>
<div class="flex items-center gap-2 text-sm text-green-400">
<span class="w-2 h-2 rounded-full bg-green-500"></span>
                                        Connected
                                    </div>
</div>
<p class="text-sm text-white/60 flex-grow">Sync your menu and receive orders directly from Yemeksepeti.</p>
<button class="w-full text-center mt-4 bg-red-500/20 text-red-300 text-sm font-semibold py-2 rounded-md hover:bg-red-500/30 transition-colors">Disconnect</button>
</div>
<div class="bg-white/5 p-5 rounded-xl flex flex-col">
<div class="flex items-center justify-between mb-3">
<h4 class="font-semibold text-lg">Getir</h4>
<div class="flex items-center gap-2 text-sm text-white/50">
<span class="w-2 h-2 rounded-full bg-white/40"></span>
                                        Disconnected
                                    </div>
</div>
<p class="text-sm text-white/60 flex-grow">Integrate with Getir for fast delivery services.</p>
<button class="w-full text-center mt-4 bg-cyan-500/80 text-white text-sm font-semibold py-2 rounded-md hover:bg-cyan-500 transition-colors shadow-[0_4px_14px_rgba(56,189,248,0.20)]">Connect</button>
</div>
<div class="bg-white/5 p-5 rounded-xl flex flex-col">
<div class="flex items-center justify-between mb-3">
<h4 class="font-semibold text-lg">Trendyol</h4>
<div class="flex items-center gap-2 text-sm text-white/50">
<span class="w-2 h-2 rounded-full bg-white/40"></span>
                                        Disconnected
                                    </div>
</div>
<p class="text-sm text-white/60 flex-grow">Reach more customers by integrating with Trendyol Food.</p>
<button class="w-full text-center mt-4 bg-cyan-500/80 text-white text-sm font-semibold py-2 rounded-md hover:bg-cyan-500 transition-colors shadow-[0_4px_14px_rgba(56,189,248,0.20)]">Connect</button>
</div>
<div class="bg-white/5 p-5 rounded-xl flex flex-col">
<div class="flex items-center justify-between mb-3">
<h4 class="font-semibold text-lg">Accounting Pro</h4>
<div class="flex items-center gap-2 text-sm text-green-400">
<span class="w-2 h-2 rounded-full bg-green-500"></span>
                                        Connected
                                    </div>
</div>
<p class="text-sm text-white/60 flex-grow">Automatically sync sales data to your accounting software.</p>
<button class="w-full text-center mt-4 bg-red-500/20 text-red-300 text-sm font-semibold py-2 rounded-md hover:bg-red-500/30 transition-colors">Disconnect</button>
</div>
<div class="bg-white/5 p-5 rounded-xl flex flex-col">
<div class="flex items-center justify-between mb-3">
<h4 class="font-semibold text-lg">Loyalty Rewards</h4>
<div class="flex items-center gap-2 text-sm text-white/50">
<span class="w-2 h-2 rounded-full bg-white/40"></span>
                                        Disconnected
                                    </div>
</div>
<p class="text-sm text-white/60 flex-grow">Integrate a customer loyalty and rewards program.</p>
<button class="w-full text-center mt-4 bg-cyan-500/80 text-white text-sm font-semibold py-2 rounded-md hover:bg-cyan-500 transition-colors shadow-[0_4px_14px_rgba(56,189,248,0.20)]">Connect</button>
</div>
<div class="bg-white/5 p-5 rounded-xl flex flex-col">
<div class="flex items-center justify-between mb-3">
<h4 class="font-semibold text-lg">GlobalPay</h4>
<div class="flex items-center gap-2 text-sm text-green-400">
<span class="w-2 h-2 rounded-full bg-green-500"></span>
                                        Connected
                                    </div>
</div>
<p class="text-sm text-white/60 flex-grow">Accept various payment methods with a secure payment gateway.</p>
<button class="w-full text-center mt-4 bg-red-500/20 text-red-300 text-sm font-semibold py-2 rounded-md hover:bg-red-500/30 transition-colors">Disconnect</button>
</div>
</div>
</div>
<div class="glassmorphism p-6 md:p-8 rounded-2xl">
<div class="flex flex-col md:flex-row justify-between md:items-center mb-6">
<div>
<h3 class="text-xl font-semibold">API Keys &amp; Webhooks</h3>
<p class="text-sm text-white/60 mt-1">For custom integrations and development.</p>
</div>
<button class="bg-cyan-500/80 text-white px-4 py-2 mt-4 md:mt-0 rounded-lg text-sm font-semibold hover:bg-cyan-500 transition-colors shadow-[0_4px_14px_rgba(56,189,248,0.20)] flex items-center gap-2">
<span class="material-symbols-outlined text-base">add</span>
                                Generate New Key
                            </button>
</div>
<div class="space-y-4">
<div class="bg-white/5 p-4 rounded-lg flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
<div class="flex-grow">
<p class="font-medium">Main Production Key</p>
<div class="flex items-center gap-2 mt-2">
<p class="text-sm text-white/70 font-mono bg-black/20 px-2 py-1 rounded-md">prod_sk_******************xyz</p>
<button class="text-white/60 hover:text-white" title="Copy to clipboard">
<span class="material-symbols-outlined text-lg">content_copy</span>
</button>
</div>
</div>
<div class="flex items-center gap-4 shrink-0">
<p class="text-xs text-white/50">Created: 2023-08-15</p>
<button class="text-red-400/80 hover:text-red-400 flex items-center gap-1 text-sm font-medium" title="Revoke Key">
<span class="material-symbols-outlined text-lg">delete</span> Revoke
                                    </button>
</div>
</div>
<div class="bg-white/5 p-4 rounded-lg flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
<div class="flex-grow">
<p class="font-medium">Staging Test Key</p>
<div class="flex items-center gap-2 mt-2">
<p class="text-sm text-white/70 font-mono bg-black/20 px-2 py-1 rounded-md">test_sk_******************abc</p>
<button class="text-white/60 hover:text-white" title="Copy to clipboard">
<span class="material-symbols-outlined text-lg">content_copy</span>
</button>
</div>
</div>
<div class="flex items-center gap-4 shrink-0">
<p class="text-xs text-white/50">Created: 2024-01-20</p>
<button class="text-red-400/80 hover:text-red-400 flex items-center gap-1 text-sm font-medium" title="Revoke Key">
<span class="material-symbols-outlined text-lg">delete</span> Revoke
                                    </button>
</div>
</div>
</div>
<div class="mt-8 pt-6 border-t border-white/10">
<h4 class="font-semibold text-lg mb-4">Webhooks</h4>
<div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
<p class="text-sm text-white/60 max-w-xl">Configure webhooks to receive real-time notifications about events like new orders or payments.</p>
<button class="bg-white/10 text-white/80 px-4 py-2 mt-2 md:mt-0 rounded-lg text-sm font-semibold hover:bg-white/20 transition-colors flex items-center gap-2 shrink-0">
<span class="material-symbols-outlined text-base">add</span>
                                Add Webhook Endpoint
                            </button>
</div>
</div>
</div>
</div>
</main>
<footer class="fixed bottom-0 left-0 xl:pl-72 right-0 glassmorphism border-t border-white/10 p-4">
<div class="max-w-7xl mx-auto flex justify-end gap-4">
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