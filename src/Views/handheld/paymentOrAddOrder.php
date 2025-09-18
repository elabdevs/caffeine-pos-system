<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Café POS - Table Actions</title>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;500;700;900&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<style type="text/tailwindcss">
    :root {
      --primary-color: #38e07b;
      --secondary-color: #29382f;
      --background-color: #111714;
      --text-primary: #ffffff;
      --text-secondary: #9eb7a8;
      --border-color: #2a3c33;
    }
  </style>
<style>
    body {
      font-family: 'Epilogue', sans-serif;
      min-height: max(884px, 100dvh);
    }
  </style>
<style>
    body {
      min-height: max(884px, 100dvh);
    }
  </style>
  </head>
<body class="bg-[var(--background-color)] text-[var(--text-primary)]">
<div class="flex flex-col h-screen justify-center items-center p-4">
<div class="grid grid-cols-2 gap-4 w-full max-w-sm">
<button class="aspect-square flex flex-col items-center justify-center gap-2 rounded-lg bg-[var(--secondary-color)] text-[var(--text-primary)] text-lg font-bold">
<span class="material-symbols-outlined text-5xl">add</span>
<span>Add Order</span>
</button>
<button class="aspect-square flex flex-col items-center justify-center gap-2 rounded-lg bg-[var(--primary-color)] text-[var(--background-color)] text-lg font-bold">
<span class="material-symbols-outlined text-5xl">payments</span>
<span>Receive Payment</span>
</button>
</div>
</div>

</body></html>