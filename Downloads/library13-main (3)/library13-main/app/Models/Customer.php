<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['gender','phone','avatar','user_id'];

    public function ratedBooks()
    {
        return $this->belongsToMany(Book::class, 'books_customer')
                    ->withPivot('rating', 'review', 'created_at')
                    ->wherePivot('rating', '!=', null); 
}
}