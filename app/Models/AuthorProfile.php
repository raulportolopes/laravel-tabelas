<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthorProfile extends Model
{
    protected $fillable = ['author_id', 'bio', 'birth_date', 'birth_city'];

    protected $casts = [
        'birth_date' => 'date',
    ];
}
