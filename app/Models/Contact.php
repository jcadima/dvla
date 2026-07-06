<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['page_id', 'contact_data'];

    protected $casts = [
        'contact_data' => 'array',
    ];
}
