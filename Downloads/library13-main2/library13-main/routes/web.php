<?php

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


/* *****  test routes **********/
/* =============== 1-m ================ */
// use as property
Route::get('1-m-child', function () {
    $category = Category::first();
    return $category->books;
});

Route::get('1-m-parent', function () {
    $book = Book::find('1112223334445');
    return $book->category;
});
// use as method that return instance of elquent
Route::get('1-m-update/{category}', function (Category $category) {
    // dd($category->books());
    $category->books()->update(['price' => 0]);
    return "recs updated";
});
Route::get('1-m-select/{category}', function (Category $category) {
    $books = $category->books()->where('price', '<', 50)->get();
    return $books;
});

Route::get('1-m-delete/{category}', function (Category $category) {
    $books = $category->books()->delete();
    $category->delete();
    return Category::all();
});

Route::get('1-m-create', function () {
    $category = Category::create(['name' => 'new category']);
    $category->books()->create([
        'ISBN' => '1111111111111',
        'title' => 'test book2',
        'price' => 0,
        'mortgage' => 0,
    ]);
    return [
        'categories' => Category::all(),
        'books' => Book::all()
    ];
});

/* =============== env- config ================ */
Route::get('env' , function(){
    // return env('APP_NAME');
    return env('APP_NAME' , 'Not Found');
});

Route::get('config' , function(){
    return config('app.name');
});

/* =============== m-m ================ */
Route::get('m-m-1', function () {
    $book = Book::find('1112223334445');
    return $book->authors;
});
Route::get('m-m-2', function () {
    $author = Author::find(2);
    return $author->books;
});

Route::get('book-attach', function () {
    $book = Book::find('1112223334445');
    $book->authors()->attach([10 , 2 ]);
   return redirect('m-m-1') ;
});
Route::get('book-detach', function () {
    $book = Book::find('1112223334445');
    $book->authors()->detach([ 2]);
    return redirect('m-m-1') ;
});

/* ===============storage================ */
Route::get('storage-path', function () {
    // return storage_path();
    return storage_path('app\\private');
});
Route::get('public-path', function () {
    return public_path();
});