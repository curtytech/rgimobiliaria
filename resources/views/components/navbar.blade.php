<?php 
use App\Models\About;
$about = About::first();
?>

<nav class="bg-white shadow">
  <div class="container mx-auto px-4 py-4 flex justify-between items-center">
    <a href="/" class="text-xl font-bold text-primary">
      <!-- <img src="{{ $about->logo ?? asset('img/logo.png') }}" alt="Mc Imóveis" class="h-20 w-auto"> -->
    </a>
    <!-- Botão hamburguer (mobile) -->
    <button id="menu-toggle" class="lg:hidden text-primary focus:outline-none">
      <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>

    <!-- Menu (desktop) -->
    <ul class="hidden lg:flex gap-6">
      <li><a href="/search" class="text-primary text-lg font-base hover:text-secondary hover:font-bold">Buscar Imóveis</a></li>
      @if (request()->routeIs('welcome'))
        <li><a href="#featured" class="text-primary text-lg font-base hover:text-secondary hover:font-bold">Imóveis em Destaque</a></li>
      @endif
      <!-- <li><a href="#simulator" class="text-primary text-lg font-base hover:text-secondary hover:font-bold">Simulador de Financiamento</a></li> -->
      <!-- <li><a href="#agents" class="text-primary text-lg font-base hover:text-secondary hover:font-bold">Corretores</a></li> -->
    </ul>
  </div>

  <!-- Menu (mobile) -->
  <div id="mobile-menu" class="hidden lg:hidden bg-white border-t border-gray-100">
    <ul class="flex flex-col px-4 py-2 space-y-2">
      <li><a href="/search" class="block text-primary text-lg font-base hover:text-secondary hover:font-bold">Buscar Imóveis</a></li>
      @if (request()->routeIs('welcome'))
        <li><a href="#featured" class="block text-primary text-lg font-base hover:text-secondary hover:font-bold">Imóveis em Destaque</a></li>
      @endif
      <!-- <li><a href="#simulator" class="block text-primary text-lg font-base hover:text-secondary hover:font-bold">Simulador de Financiamento</a></li> -->
      <!-- <li><a href="#agents" class="block text-primary text-lg font-base hover:text-secondary hover:font-bold">Corretores</a></li> -->
    </ul>
  </div>
</nav>

<script>
  const menuToggle = document.getElementById('menu-toggle');
  const mobileMenu = document.getElementById('mobile-menu');

  menuToggle.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
  });
</script>
