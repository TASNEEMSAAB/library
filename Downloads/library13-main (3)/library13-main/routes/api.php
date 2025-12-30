<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('test', function () {
    return "this test action";
});
Route::middleware('auth:sanctum')->group(function () {
    Route::controller(CategoryController::class)->group(
        function () {
            Route::get('categories', 'index');
            Route::post('categories',  'store');
            Route::put('categories/{id1}',  'update');
            Route::delete('categories/{id}',  'destroy');
            Route::get('categories/{id}',  'show');
        }
    );

    // Route::apiResource('books' , BookController::class)->except('show');
    // Route::apiResource('books' , BookController::class)->only('index' ,'show');
    Route::apiResource('books', BookController::class);
    Route::get('books-by-title', [BookController::class, 'getByTitle']);
    Route::get('books-by-category', [BookController::class, 'getByCategory']);

    Route::apiResource('authors', AuthorController::class);

    
    Route::post('logout', [AuthController::class, 'logout']);

});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->apiResource('books.ratings', RatingController::class)
    ->except(['index', 'show'])
    ->parameters(['books' => 'isbn']); 
/** ************ test **************/
Route::middleware('auth:sanctum')->get('current-user', function () {
    // return ['user' => Auth::user()];
    // return ['user' => Auth::user()->tokens];
    return ['user' => Auth::user()->currentAccessToken()];
});
