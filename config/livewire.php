<?php

return [
    'class_namespace' => 'App\\Livewire',
    'view_path' => resource_path('views/livewire'),
    'layout' => 'components.layouts.app',

    'temporary_file_upload' => [
        'disk' => env('LIVEWIRE_UPLOAD_DISK', 'local'),
        'directory' => env('LIVEWIRE_UPLOAD_DIRECTORY', 'livewire-tmp'),
        // Regras espelham as do Filament; max em MB (via validação do Livewire)
        'rules' => 'mimes:webp,png,jpg,jpeg|max:20480',
        'middleware' => 'web',
        'file_name' => null,
        'keep_alive' => false,
    ],
];
