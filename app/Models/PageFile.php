<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_id',
        'filename',
        'filesize'
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
