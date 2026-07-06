<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndexBlog extends Model
{
    use HasFactory;

    protected $table = 'index_articles';

    protected $fillable = [
        'title',
        'meta_description',
        'heading1',
        'heading2',
        'heading3',
        'banner_image',

    ];
}
