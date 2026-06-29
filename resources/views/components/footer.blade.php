@php
    $about = \Illuminate\Support\Facades\Cache::remember(
        'site_about_footer',
        now()->addHour(),
        fn () => \App\Models\About::query()->latest()->first()
    );
@endphp

<footer class="bg-secondary-dark text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-8">
            <div class="grid grid-cols-2 md:grid-cols-2 gap-8">
                <!-- <div class="text-center md:text-left">
                    <h3 class="text-lg font-semibold mb-4">Sobre Nós</h3>
                    <p class="text-gray-300">Sua parceira ideal para encontrar o imóvel dos seus sonhos.</p>
                </div> -->
                <div class="text-center">
                    <h3 class="text-lg font-semibold mb-4">Contato</h3>
                    <p class="text-gray-300">Contato: {{ $about->contact ?? 'RG Imóveis' }}</p>
                    <p class="text-gray-300">Tel: {{ $about?->phone ?? '(21) 2523-5959' }}</p>
                    <p class="text-gray-300">Email: {{ $about?->email ?? 'contato@rgimoveis.com.br' }}</p>
                </div>
                <div class="text-center">
                    <h3 class="text-lg font-semibold mb-4">Endereço</h3>
                    <p class="text-gray-300">{{ $about->address ?? 'Av. Presidente Antonio Carlos 54 Gr. 1102' }}</p>
                    <p class="text-gray-300">{{ $about ? "{$about->city} - {$about->state}" : 'Centro - Rj' }}</p>
                    <p class="text-gray-300">Cep: {{ $about?->zip ?? '20020-010' }}</p>

                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-300">&copy; {{ date('Y') }} {{ $about?->enterprise_name ?? 'RG Imóveis' }}. Todos os direitos reservados.</p>
            </div>
        </div>
    </div>
</footer>
