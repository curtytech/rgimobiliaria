<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
