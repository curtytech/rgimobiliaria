<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class About extends Model
{
    use HasFactory;

    protected $table = 'about';

    protected $fillable = [
        'enterprise_name',
        'description',
        'contact',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip',
        'country',
        'logo',
        'banner',
        'video_link',
    ];

    public function getLogoUrlAttribute(): string
    {
        return $this->resolveMediaUrl($this->logo, asset('img/logo.png'));
    }

    public function getBannerUrlAttribute(): ?string
    {
        return $this->resolveMediaUrl($this->banner);
    }

    protected function resolveMediaUrl(?string $path, ?string $fallback = null): ?string
    {
        if (blank($path)) {
            return $fallback;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        $normalizedPath = ltrim($path, '/');

        if (Storage::disk('public')->exists($normalizedPath)) {
            return Storage::disk('public')->url($normalizedPath);
        }

        if (file_exists(public_path($normalizedPath))) {
            return asset($normalizedPath);
        }

        return asset($normalizedPath);
    }
}
