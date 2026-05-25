<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        About::query()->updateOrCreate(
            ['id' => 1],
            [
                'enterprise_name' => 'RG Imobiliária',
                'description' => 'A RG Imobiliária atua com compra, venda e locação de imóveis, oferecendo atendimento próximo, transparência e suporte em todas as etapas da negociação.',
                'contact' => 'Equipe RG Imobiliária',
                'email' => 'contato@rgimobiliaria.com.br',
                'phone' => '(21) 99999-9999',
                'address' => 'Rua Exemplo, 123',
                'city' => 'Magé',
                'state' => 'RJ',
                'zip' => '25900-000',
                'country' => 'Brasil',
                'logo' => null,
                'banner' => null,
                'video_link' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            ]
        );
    }
}