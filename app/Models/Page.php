<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'meta_description',
        'page_content'
    ];

    // public function domain() {
    //     return $this->belongsTo(Domain::class);
    // }

    public function file()
    {
        return $this->hasMany(PageFile::class);
    }


    public static function filterBySearch($searchTerm)
    {
        $pageQuery = static::query();

        if ($searchTerm) {
            $pageQuery = $pageQuery->where('title', 'like', '%' . $searchTerm . '%');
        }

        return $pageQuery;
    }
}
