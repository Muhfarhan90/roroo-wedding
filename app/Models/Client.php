<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'bride_name',
        'groom_name',
        'bride_phone',
        'groom_phone',
        'bride_address',
        'groom_address',
        'bride_parents',
        'groom_parents',
        'akad_date',
        'akad_time',
        'akad_end_time',
        'reception_date',
        'reception_time',
        'reception_end_time',
        'event_location',
        'email',
        'venue',
    ];

    protected $casts = [
        'akad_date' => 'date',
        'reception_date' => 'date',
    ];

    /**
     * Convert phone number from 0xxx to 62xxx format
     */
    private function formatPhoneNumber($phone)
    {
        if (empty($phone)) {
            return $phone;
        }

        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // If starts with 0, replace with 62
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        // If doesn't start with 62, add it
        if (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }

        return $phone;
    }

    /**
     * Set bride phone attribute
     */
    public function setBridePhoneAttribute($value)
    {
        $this->attributes['bride_phone'] = $this->formatPhoneNumber($value);
    }

    /**
     * Set groom phone attribute
     */
    public function setGroomPhoneAttribute($value)
    {
        $this->attributes['groom_phone'] = $this->formatPhoneNumber($value);
    }
}
