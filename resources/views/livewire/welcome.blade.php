<?php

use function Livewire\Volt\{state, layout};
use App\Models\Imovel;
use App\Models\TipoImovel;
use App\Models\User;
use App\Models\About;
use Illuminate\Support\Str;

layout('components.layouts.app');

state([
    'imovelCards' => fn() => Imovel::with(['tipoImovel', 'statusImovel', 'corretor'])->where('destaque', true)->limit(6)->get(),
    'imoveisDisponiveis' => fn() => Imovel::where('status_id', 1)->orderBy('created_at', 'desc')->limit(15)->get(),
    'bairrosDisponiveis' => fn() => Imovel::query()
        ->disponiveis()
        ->selectRaw('LOWER(TRIM(bairro)) as bairro_slug')
        ->selectRaw('MIN(TRIM(bairro)) as bairro')
        ->selectRaw('COUNT(*) as total')
        ->whereNotNull('bairro')
        ->whereRaw('TRIM(bairro) <> ""')
        ->groupByRaw('LOWER(TRIM(bairro))')
        ->get()
        ->map(fn(object $bairro): array => [
            'nome' => Str::title(Str::lower($bairro->bairro)),
            'slug' => $bairro->bairro_slug,
            'total' => (int) $bairro->total,
        ])
        ->sortBy('nome', SORT_NATURAL | SORT_FLAG_CASE)
        ->values(),
    'imovelCount' => fn() => Imovel::count(),
    'corretores' => fn() => User::where('role', 'corretor')->get(),
    'tipoImovel' => fn() => TipoImovel::all(),
    'about' => fn() => About::first()
]);

?>
<main>
    <!-- Hero Section -->
    <section id="hero" class="relative min-h-[70vh] md:min-h-[80vh] flex items-center justify-center text-white">
        <div class="absolute inset-0 z-0 bg-center bg-no-repeat bg-cover"
            style="background-image: url('{{ asset('hero.png') }}');">
            <div class="absolute inset-0 bg-black/50"></div>
        </div>
        <div class="relative z-10 px-4 text-center">
            <!-- <h1 class="mb-4 text-4xl font-extrabold drop-shadow-lg md:text-6xl">O seu imóvel dos sonhos em Rio de Janeiro</h1> -->
            <!-- <p class="mx-auto mb-8 max-w-3xl text-lg drop-shadow-md md:text-xl">Especializado em venda e locação de
                imóveis residenciais e comerciais na cidade de Rio de Janeiro.</p> -->
            <livewire:hero-search-form />
        </div>
    </section>
    <!-- Feature Highlights Section -->
    <section class="container relative z-20 px-4 mx-auto -mt-12 mb-12">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <div class="flex flex-col items-center p-6 text-center bg-white rounded-xl shadow-lg gap-2">
                <h3 class="mb-2 text-lg font-bold">CONECTANDO PESSOAS AOS IMÓVEIS</h3>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6" style="width: 3rem; height: 3rem;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m6.115 5.19.319 1.913A6 6 0 0 0 8.11 10.36L9.75 12l-.387.775c-.217.433-.132.956.21 1.298l1.348 1.348c.21.21.329.497.329.795v1.089c0 .426.24.815.622 1.006l.153.076c.433.217.956.132 1.298-.21l.723-.723a8.7 8.7 0 0 0 2.288-4.042 1.087 1.087 0 0 0-.358-1.099l-1.33-1.108c-.251-.21-.582-.299-.905-.245l-1.17.195a1.125 1.125 0 0 1-.98-.314l-.295-.295a1.125 1.125 0 0 1 0-1.591l.13-.132a1.125 1.125 0 0 1 1.3-.21l.603.302a.809.809 0 0 0 1.086-1.086L14.25 7.5l1.256-.837a4.5 4.5 0 0 0 1.528-1.732l.146-.292M6.115 5.19A9 9 0 1 0 17.18 4.64M6.115 5.19A8.965 8.965 0 0 1 12 3c1.929 0 3.716.607 5.18 1.64" />
                </svg>
                <p class="text-gray-600 mt-2">Com uma trajetória marcada por credibilidade, atendimento personalizado e paixão pelo mercado imobiliário. Unimos experiência, visão moderna e compromisso em cada negociação, oferecendo segurança e confiança do primeiro contato até a realização do seu sonho.</p>
            </div>
            <div class="flex flex-col items-center p-6 text-center bg-white rounded-xl shadow-lg gap-2">
                <h3 class="mb-2 text-lg font-bold">IMÓVEIS DE ALTO PADRÃO</h3>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6" style="width: 3rem; height: 3rem;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                </svg>

                <p class="text-gray-600 mt-2">Casas, coberturas, apartamentos e hotéis no mais alto padrão de sofisticação e exclusividade.</p>
                <a href="#featured" class="inline-flex items-center px-6 py-2 mt-4 font-semibold text-white bg-primary rounded-lg transition  gap-2 hover:bg-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6" style="width: 1.5rem; height: 1.5rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                    </svg>
                    Veja nosso imóveis
                </a>
            </div>
            <div class="flex flex-col items-center p-6 text-center bg-white rounded-xl shadow-lg gap-2">
                <h3 class="mb-2 text-lg font-bold">ENTRE EM CONTATO</h3>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3" style="width: 3rem; height: 3rem;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                </svg>
                <p class="text-gray-600 mt-2">Quer vender ou comprar seu imóvel com segurança e confiança? Entre em contato com a nossa equipe.</p>
                <a href="https://wa.me/5521964729156" target="_blank" class="inline-flex items-center px-6 py-2 mt-4 font-semibold text-white bg-primary rounded-lg transition hover:bg-secondary">
                    <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    WhatsApp
                </a>

            </div>
        </div>
    </section>
    <!-- Featured Properties Section -->
    <section id="featured" class="py-16 md:py-24">
        <div class="container px-4 mx-auto">
            <div class="mb-12 text-center">
                <h2 class="text-3xl font-bold text-gray-800 md:text-4xl">Imóveis em Destaque</h2>
                <p class="mt-2 text-lg text-gray-600">Confira as melhores oportunidades que selecionamos para você.</p>
            </div>
            <!-- Bento Grid Start -->
            <div class="grid gap-8 md:grid-cols-4 bento-grid">
                @if (count($imovelCards) >= 6)
                <!-- Primeira linha: 1 largo, 2 estreitos -->
                <div class="md:col-span-2 bento-card">
                    @livewire('imovel-card', ['imovel' => $imovelCards[0]])
                </div>
                <div class="md:col-span-1 bento-card">
                    @livewire('imovel-card', ['imovel' => $imovelCards[1]])
                </div>
                <div class="md:col-span-1 bento-card">
                    @livewire('imovel-card', ['imovel' => $imovelCards[2]])
                </div>
                <!-- Segunda linha: 2 estreitos, 1 largo -->
                <div class="md:col-span-1 bento-card">
                    @livewire('imovel-card', ['imovel' => $imovelCards[3]])
                </div>
                <div class="md:col-span-1 bento-card">
                    @livewire('imovel-card', ['imovel' => $imovelCards[4]])
                </div>
                <div class="md:col-span-2 bento-card">
                    @livewire('imovel-card', ['imovel' => $imovelCards[5]])
                </div>
                @else
                <!-- Grid adaptável para menos de 6 cards -->
                @foreach ($imovelCards as $index => $card)
                <div class="md:col-span-{{ $index === 0 || $index === 5 ? '2' : '1' }} bento-card">
                    @livewire('imovel-card', ['imovel' => $card])
                </div>
                @endforeach
                @endif
            </div>
            <!-- Bento Grid End -->
        </div>
    </section>
    <!-- Filter Chips Section -->
    <section class="py-12 bg-white">
        <div class="container px-4 mx-auto">
            <h2 class="mb-4 text-2xl font-bold text-gray-800">+ de {{ $imovelCount - 1 }} Imóveis</h2>
            <p class="mb-6 text-gray-600">Para Comprar ou Alugar, são várias opções de escolha em diversos bairros</p>
            <div class="flex flex-wrap gap-3">

                @foreach ($imoveisDisponiveis as $imovel)
                <a href="/imovel/{{$imovel->id}}" class="cursor-pointer">
                    <span class="px-4 py-2 rounded-full bg-secondary text-white font-semibold hover:bg-primary inline-block cursor-pointer">
                        {{ $imovel->titulo }}
                    </span>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Imóveis por Bairro Section -->
{{--
<section class="py-12 bg-gray-50">
    <div class="container px-4 mx-auto">
        <h2 class="mb-8 text-2xl font-bold text-gray-800">Imóveis disponíveis por bairro</h2>
        <div class="grid grid-cols-2 gap-6 md:grid-cols-3 lg:grid-cols-6">
            @forelse ($bairrosDisponiveis as $bairro)
                <a href="{{ route('search', ['neighborhood' => $bairro['nome']]) }}"
                    wire:key="bairro-{{ $bairro['slug'] }}"
                    class="flex flex-col justify-between p-5 bg-white rounded-xl shadow transition hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex items-center justify-center mb-4 w-14 h-14 rounded-full bg-primary/10 text-primary">
                        ...
                    </div>
                    <span class="text-lg font-bold text-gray-800">{{ $bairro['nome'] }}</span>
                    <span class="mt-2 text-sm font-semibold text-primary">
                        {{ $bairro['total'] }} {{ $bairro['total'] === 1 ? 'imóvel' : 'imóveis' }}
                    </span>
                </a>
            @empty
                <div class="col-span-full p-6 text-center bg-white rounded-xl shadow">
                    <p class="text-gray-600">Nenhum imóvel disponível com bairro informado no momento.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
--}}

    <section class="py-12 bg-white">
        <div class="container px-4 mx-auto">
            <div class="flex flex-col md:flex-row items-center p-4 bg-white rounded-xl shadow gap-4">
                <div class="flex flex-col w-full md:w-1/2">
                    <p class="text-2xl font-bold text-gray-800 mb-4">Sobre nós</p>
                    <p class="text-gray-600 text-base leading-relaxed">{{ $about->description }}</p>                  
                </div>
                <div class="flex flex-col w-full md:w-1/2">
                    <div class="relative w-full h-0 pb-[56.25%]">
                        <!-- src="https://www.youtube.com/embed/CEGr2_p6haA?si=2Y19fzaFpVvySfQc" -->
                        <!-- <iframe
                            class="absolute top-0 left-0 w-full h-full rounded-lg"
                            src="https://www.youtube.com/embed/RH_V2rtFqYM"
                            title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin"
                            allowfullscreen>
                        </iframe> -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Loan Simulator Section -->
    {{-- <livewire:loan-simulator />  --}}

    {{--
    <section id="agents" class="py-16 md:py-24">
        <div class="container px-4 mx-auto">
            <div class="mb-12 text-center">
                <h2 class="text-3xl font-bold text-gray-800 md:text-4xl">Nossos Corretores</h2>
                <p class="mt-2 text-lg text-gray-600">Uma equipe de especialistas pronta para te atender.</p>
            </div>
            <div class="relative">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse ($corretores as $corretor)
                    <div class="p-8 text-center bg-white rounded-xl shadow-lg transition-shadow duration-300 hover:shadow-xl group">
                        <img src="{{ 'storage/' . $corretor->foto ?? 'https://placehold.co/128x128/EFEFEF/777777?text=Foto' }}"
    alt="Corretor {{ $corretor->name }}"
    class="mx-auto mb-4 w-32 h-32 rounded-full border-4 border-white transition-colors duration-300 group-hover:border-primary">
    <h3 class="text-xl font-bold text-gray-800">{{ $corretor->name }} </h3>
    <p class="mb-4 font-semibold text-primary">{{ $corretor->creci }}</p>
    <p class="mb-4 text-gray-600">{{ $corretor->descricao }}</p>
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $corretor->celular) }}" target="_blank"
        class="inline-flex items-center px-6 py-2 font-semibold text-white bg-green-500 rounded-lg transition hover:bg-green-600">
        <x-whatsapp />
        WhatsApp
    </a>
    </div>
    @empty
    <div class="col-span-3 p-8 text-center">
        <p class="text-gray-600">Nenhum corretor cadastrado no momento.</p>
    </div>
    @endforelse
    </div>
    {{-- <button
                    class="absolute left-0 top-1/2 p-2 bg-white rounded-full border border-gray-300 shadow transition -translate-y-1/2 hover:bg-primary hover:text-white lg:-left-12"
                    aria-label="Anterior"><i data-lucide="arrow-left"></i></button>
                <button
                    class="absolute right-0 top-1/2 p-2 bg-white rounded-full border border-gray-300 shadow transition -translate-y-1/2 hover:bg-primary hover:text-white lg:-right-12"
                    aria-label="Próximo"><i data-lucide="arrow-right"></i></button> 
    </div>
    </div>
    </section>
    --}}
</main>
