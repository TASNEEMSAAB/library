<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $books = Book::all();
        // return $books;
        $books = Book::with('category')->get();
        return [
            'success' => true,
            'message' => "all books ",
            'data' => BookResourse::collection( $books)
        ];
    }

    function getByTitle(Request $request)
    {
        $title = $request->title;
        $books =  Book::where('title', 'like', "%$title%")->get();
        //    return $books;
        return [
            'success' => true,
            'message' => "books contain  $title",
            'data' => $books
        ];
    }

    function getByCategory(Request $request)
    {
        $category_id = $request->category_id;
        $books = Book::where('category_id', $category_id)->get();
        return $books;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        // return $request;
        $book =  Book::create($request->all());
        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $filename = "$book->ISBN." . $file->extension();
            // Storage::putFileAs('book-images' , $file , $filename , "public");
            Storage::putFileAs('book-images', $file, $filename);
            $book->cover = $filename;
            $book->save();
        }

        return [
            'success' => true,
            'message' => "book added successfully ",
            'data' => $book
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return [
            'success' => true,
            'message' => "one added",
            'data' => new BookResourse($book)
        ];
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->all());
        if ($request->hasFile('cover')) {
            if ($book->cover)
                // Storage::disk('public')->delete("book-images/$book->cover");           
                Storage::delete("book-images/$book->cover");
            $file = $request->file('cover');
            $filename = "$book->ISBN." . $file->extension();
            // Storage::putFileAs('book-images' , $file , $filename , "public");
            Storage::putFileAs('book-images', $file, $filename);
            $book->cover = $filename;
            $book->save();
        }
        return [
            'success' => true,
            'message' => "book updated successfully ",
            'data' => $book
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        if ($book->cover)
            Storage::delete("book-images/$book->cover");
        $book->delete();
        return [
            'success' => true,
            'message' => "book deleted successfully ",
            'data' => null
        ];
    }
}
