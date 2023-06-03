<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'author_id',
        'added_by',
        'published_date'
    ];

    /**
     * Summary of author
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author(){
        return $this->belongsTo(Author::class, 'author_id', 'id');
    }

    /**
     * Summary of category
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function category(){
        return $this->belongsToMany(Category::class, 'book_category','book_id','category_id');
    }

    /**
     * Summary of added
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function added(){
        return $this->belongsTo(User::class, 'added_by','id');
    }
}