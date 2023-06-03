<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BookCategory extends Pivot
{
    use HasFactory;

    protected $table = 'book_category';

    protected $fillable = ['book_id','category_id'];
}