<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;
    
    protected $primaryKey = "ISBN";
    public $incrementing = false;
    protected $fillable = ['ISBN' , 'title' , 'price' , 'mortgage' ,'authorship_date' ,'category_id'];

    function category(){
        return $this->belongsTo(Category::class);
    }
    function authors(){
        return $this->belongsToMany(Author::class);
    }
}
   function ratedBy()
    {
        return $this->belongsToMany(Customer::class, 'books_customer')
                    ->withPivot('rating', 'review', 'created_at')
                    ->wherePivot('rating', '!=', null); // فقط الذين قيموا
    }
    
    
     function avgRating()
    {
        return $this->ratedBy()->avg('rating');
    }
       
     function ratingsCount()
    {
        return $this->ratedBy()->count();
    }
