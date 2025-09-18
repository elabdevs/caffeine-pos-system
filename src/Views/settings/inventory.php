<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Café Admin Dashboard - Inventory &amp; Stock Settings</title>
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
<h2 class="text-3xl font-bold tracking-tight">Inventory &amp; Stock Settings</h2>
<p class="text-base text-white/60 mt-1">Manage your ingredients, supplies, and purchasing.</p>
</header>
<div class="glassmorphism p-6 md:p-8 rounded-2xl">
<div class="flex flex-col md:flex-row justify-between md:items-center mb-6">
<h3 class="text-xl font-semibold">Stock Overview</h3>
<button class="bg-cyan-500/80 text-white px-4 py-2 mt-4 md:mt-0 rounded-lg text-sm font-semibold hover:bg-cyan-500 transition-colors shadow-[0_4px_14px_rgba(56,189,248,0.20)] flex items-center gap-2">
<span class="material-symbols-outlined text-base">add</span>
                                Add Item
                            </button>
</div>
<div class="overflow-x-auto table-scrollbar">
<table class="w-full text-sm text-left">
<thead class="text-xs text-white/60 uppercase border-b border-white/10">
<tr>
<th class="px-6 py-3" scope="col">Item Name</th>
<th class="px-6 py-3" scope="col">Current Quantity</th>
<th class="px-6 py-3" scope="col">Min. Threshold</th>
<th class="px-6 py-3" scope="col">Unit</th>
<th class="px-6 py-3" scope="col">Supplier</th>
<th class="px-6 py-3" scope="col">
<span class="sr-only">Actions</span>
</th>
</tr>
</thead>
<tbody>
<tr class="border-b border-white/10 hover:bg-white/5">
<th class="px-6 py-4 font-medium whitespace-nowrap flex items-center gap-3" scope="row">
<span class="w-2 h-2 rounded-full bg-green-500"></span>
                                            Coffee Beans - House Blend
                                        </th>
<td class="px-6 py-4">15</td>
<td class="px-6 py-4">5</td>
<td class="px-6 py-4">kg</td>
<td class="px-6 py-4">Nairobi Coffee Co.</td>
<td class="px-6 py-4 text-right">
<a class="font-medium text-cyan-400 hover:underline" href="#">Edit</a>
</td>
</tr>
<tr class="border-b border-white/10 hover:bg-white/5">
<th class="px-6 py-4 font-medium whitespace-nowrap flex items-center gap-3" scope="row">
<span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                                            Whole Milk
                                        </th>
<td class="px-6 py-4">6</td>
<td class="px-6 py-4">5</td>
<td class="px-6 py-4">Liters</td>
<td class="px-6 py-4">Farm Fresh Dairy</td>
<td class="px-6 py-4 text-right">
<a class="font-medium text-cyan-400 hover:underline" href="#">Edit</a>
</td>
</tr>
<tr class="border-b border-white/10 hover:bg-white/5">
<th class="px-6 py-4 font-medium whitespace-nowrap flex items-center gap-3" scope="row">
<span class="w-2 h-2 rounded-full bg-red-500"></span>
                                            Sugar Syrup
                                        </th>
<td class="px-6 py-4">1</td>
<td class="px-6 py-4">2</td>
<td class="px-6 py-4">Bottles</td>
<td class="px-6 py-4">Sweet Sensations Inc.</td>
<td class="px-6 py-4 text-right">
<a class="font-medium text-cyan-400 hover:underline" href="#">Edit</a>
</td>
</tr>
<tr class="border-b border-white/10 hover:bg-white/5">
<th class="px-6 py-4 font-medium whitespace-nowrap flex items-center gap-3" scope="row">
<span class="w-2 h-2 rounded-full bg-green-500"></span>
                                            Croissants
                                        </th>
<td class="px-6 py-4">24</td>
<td class="px-6 py-4">12</td>
<td class="px-6 py-4">Pieces</td>
<td class="px-6 py-4">Parisian Bakehouse</td>
<td class="px-6 py-4 text-right">
<a class="font-medium text-cyan-400 hover:underline" href="#">Edit</a>
</td>
</tr>
</tbody>
</table>
</div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
<div class="glassmorphism p-6 md:p-8 rounded-2xl">
<h3 class="text-xl font-semibold mb-6">Low Stock Alerts</h3>
<div class="space-y-6">
<div class="flex items-center justify-between">
<div>
<p class="font-medium">Enable Low Stock Notifications</p>
<p class="text-sm text-white/60">Get notified when stock is below the minimum threshold.</p>
</div>
<label class="toggle-switch">
<input checked="" type="checkbox"/>
<span class="slider"></span>
</label>
</div>
<div class="pl-4 border-l-2 border-white/10 space-y-3">
<div class="flex items-center justify-between">
<p class="font-medium text-sm">Email Notifications</p>
<label class="toggle-switch !w-10 !h-6"><input checked="" type="checkbox"/><span class="slider before:!w-4 before:!h-4 before:bottom-1 before:left-1 checked:before:translate-x-4"></span></label>
</div>
<div class="flex items-center justify-between">
<p class="font-medium text-sm">SMS Notifications</p>
<label class="toggle-switch !w-10 !h-6"><input type="checkbox"/><span class="slider before:!w-4 before:!h-4 before:bottom-1 before:left-1 checked:before:translate-x-4"></span></label>
</div>
</div>
</div>
</div>
<div class="glassmorphism p-6 md:p-8 rounded-2xl">
<h3 class="text-xl font-semibold mb-6">Auto-Deduction Rules</h3>
<div class="space-y-4">
<div class="flex items-center justify-between">
<div>
<p class="font-medium">Enable Auto-Deduction</p>
<p class="text-sm text-white/60">Automatically deduct stock on each sale.</p>
</div>
<label class="toggle-switch">
<input checked="" type="checkbox"/>
<span class="slider"></span>
</label>
</div>
<a class="text-cyan-400 hover:text-cyan-300 text-sm font-medium flex items-center gap-2" href="#">
                                    Configure Deduction Recipes
                                    <span class="material-symbols-outlined text-base">arrow_forward</span>
</a>
</div>
</div>
</div>
<div class="glassmorphism p-6 md:p-8 rounded-2xl">
<div class="flex flex-col md:flex-row justify-between md:items-center mb-6">
<h3 class="text-xl font-semibold">Suppliers Management</h3>
<button class="bg-white/10 text-white/80 px-4 py-2 mt-4 md:mt-0 rounded-lg text-sm font-semibold hover:bg-white/20 transition-colors flex items-center gap-2">
<span class="material-symbols-outlined text-base">add</span>
                                Add Supplier
                            </button>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
<div class="bg-white/5 p-4 rounded-lg">
<div class="flex justify-between items-start">
<div>
<p class="font-semibold">Nairobi Coffee Co.</p>
<p class="text-sm text-white/60">jane.doe@nairocoffee.co</p>
<p class="text-sm text-white/60">+254 712 345 678</p>
</div>
<button class="text-white/60 hover:text-white"><span class="material-symbols-outlined text-xl">edit</span></button>
</div>
<div class="mt-4 pt-4 border-t border-white/10">
<p class="text-xs uppercase text-white/50 mb-2 font-semibold">Preferred Items</p>
<div class="flex flex-wrap gap-2">
<span class="bg-cyan-500/20 text-cyan-300 text-xs font-medium px-2.5 py-1 rounded-full">House Blend</span>
<span class="bg-cyan-500/20 text-cyan-300 text-xs font-medium px-2.5 py-1 rounded-full">Espresso Roast</span>
</div>
<button class="w-full text-center mt-4 bg-cyan-500/20 text-cyan-300 text-sm font-semibold py-2 rounded-md hover:bg-cyan-500/30 transition-colors">Quick Reorder</button>
</div>
</div>
<div class="bg-white/5 p-4 rounded-lg">
<div class="flex justify-between items-start">
<div>
<p class="font-semibold">Farm Fresh Dairy</p>
<p class="text-sm text-white/60">john.smith@farmfresh.com</p>
<p class="text-sm text-white/60">+1 234 567 890</p>
</div>
<button class="text-white/60 hover:text-white"><span class="material-symbols-outlined text-xl">edit</span></button>
</div>
<div class="mt-4 pt-4 border-t border-white/10">
<p class="text-xs uppercase text-white/50 mb-2 font-semibold">Preferred Items</p>
<div class="flex flex-wrap gap-2">
<span class="bg-cyan-500/20 text-cyan-300 text-xs font-medium px-2.5 py-1 rounded-full">Whole Milk</span>
<span class="bg-cyan-500/20 text-cyan-300 text-xs font-medium px-2.5 py-1 rounded-full">Oat Milk</span>
</div>
<button class="w-full text-center mt-4 bg-cyan-500/20 text-cyan-300 text-sm font-semibold py-2 rounded-md hover:bg-cyan-500/30 transition-colors">Quick Reorder</button>
</div>
</div>
</div>
</div>
<div class="glassmorphism p-6 md:p-8 rounded-2xl">
<h3 class="text-xl font-semibold mb-4">Purchase Orders</h3>
<p class="text-white/60 mb-6 max-w-2xl">Create and manage your purchase orders. When stock is low for an item, you can quickly generate a new order for its supplier.</p>
<button class="bg-cyan-500/80 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-cyan-500 transition-colors shadow-[0_4px_14px_rgba(56,189,248,0.20)] flex items-center gap-2">
<span class="material-symbols-outlined text-base">add_shopping_cart</span>
                            Create Purchase Order
                        </button>
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