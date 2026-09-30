<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_name',
        'school_address',
        'school_phone',
        'school_email',
        'school_website',
        'headmaster_name',
        'headmaster_nip',
        'counselor_name',
        'counselor_nip',
        'city_date',
    ];

    public static function getSetting()
    {
        return self::firstOrCreate([], [
            'school_name' => '',
            'school_address' => '',
            'school_phone' => '',
            'school_email' => '',
            'school_website' => '',
            'headmaster_name' => '',
            'headmaster_nip' => '',
            'counselor_name' => '',
            'counselor_nip' => '',
            'city_date' => '',
        ]);
    }
}
