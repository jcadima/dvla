<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'admin_logo',
        'mobile_logo',
        'footer_logo',
        'google_ga',
        'general_scripts',
        'copyright',
        'recipient'
    ];
}
