<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeBlog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'meta_description', 'page_content'
    ];
}
