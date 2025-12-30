<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\ProfileController;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


/* ********************* my routes *******************/
Route::get('categories' , [CategoryController::class , 'index']);

Route::get('lang' , [LangController::class , 'setLang']);

/* ********************* test route *******************
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

/* ===============view================ */
Route::get('view-test' , function(){
    // return view('categories.index');  
    return view('categories.index' , ['x' => 5 , 'y' => 10]);
});

/* compact */
Route::get('compact' , function(){
    $x = 5;
    $y = 10;
    // return view('categories.index' , ['x' => $x , 'y' => $y]);
    // return compact('x' , 'y');
    return view('categories.index' ,  compact('x' , 'y'));
    
});



Route::get('master' , function(){
    return view('layouts.master');
});
