<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name'];
    protected $append = ['full_name'];

    public function getFullNameAttribute(){
        return $this->first_name . ' ' . $this->last_name;
    }
}