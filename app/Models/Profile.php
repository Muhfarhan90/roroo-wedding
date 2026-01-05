<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name',
        'owner_name',
        'email',
        'phone',
        'address',
        'banks',
        'social_media',
        'description',
        'logo_path',
    ];

    protected $casts = [
        'banks' => 'array',
        'social_media' => 'array',
    ];
}
