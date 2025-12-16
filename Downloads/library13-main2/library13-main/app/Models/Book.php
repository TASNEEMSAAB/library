<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Relations\HasMany;
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
   
public function bookRequests(): HasMany
{
    return $this->hasMany(BookRequest::class);
}
}
