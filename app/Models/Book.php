<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'description',
        'category',
        'published_year',
        'isbn',
        'image',
        'stock',
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
