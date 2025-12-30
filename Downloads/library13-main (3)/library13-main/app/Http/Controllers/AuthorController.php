<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authers=Author::all();
        return[
           'success'=>true,
           'message'=>'all Authores',
           'data'=>$authers
        ];


    }

   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $author=Author::create($request->all());
        return[
           'success'=>true,
           'message'=>'Author added successfully',
           'data'=>$author
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $author->update($request->all());
        return[
           'success'=>true,
           'message'=>'Author updated successfully',
           'data'=>$author
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();
        return[
           'success'=>true,
           'message'=>'Author deleted successfully',
           'data'=>null
        ];
    }
}
