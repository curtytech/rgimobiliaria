<?php

use App\Models\About;
use Illuminate\Support\Facades\Storage;

it('returns the default logo when no custom logo is defined', function () {
    $about = new About([
        'logo' => null,
    ]);

    expect($about->logo_url)->toBe(asset('img/logo.png'));
});

it('returns the public disk url when the logo is stored on the public filesystem', function () {
    Storage::fake('public');
    Storage::disk('public')->put('about/logo.png', 'fake-image-content');

    $about = new About([
        'logo' => 'about/logo.png',
    ]);

    expect($about->logo_url)->toBe(Storage::disk('public')->url('about/logo.png'));
});

it('returns the asset url when the logo path points to a public asset', function () {
    $about = new About([
        'logo' => 'img/logo.png',
    ]);

    expect($about->logo_url)->toBe(asset('img/logo.png'));
});
