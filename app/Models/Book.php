<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['author_id', 'category_id', 'title', 'pages', 'published_at'];

    protected $casts = [
        'published_at' => 'date',
    ];
}
