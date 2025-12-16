<?php 

namespace App\Http\Controllers;

use App\Models\BookRequest;
use App\Http\Requests\StoreBookRequestRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Requests\UpdateBookRequestRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        if (Auth::user()->role === 'admin') {
            $bookRequests = BookRequest::with(['user', 'book'])->get();
        } else {
             
            $bookRequests = BookRequest::where('user_id', Auth::id())
                ->with('book')
                ->get();
        }

        return response()->json([
            'success' => true,
            'message' => 'Book requests retrieved successfully',
            'data' => $bookRequests
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
       
        $existingRequest = BookRequest::where('user_id', Auth::id())
            ->where('book_id', $request->book_id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($existingRequest) {
            return response()->json([
                'success' => false,
                'message' => 'You already have a pending or approved request for this book'
            ], 400);
        }

        $bookRequest = BookRequest::create([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
            'request_date' => $request->request_date,
            'return_date' => $request->return_date,
            'status' => 'pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Book request created successfully',
            'data' => $bookRequest->load('book')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(BookRequest $bookRequest)
    {
        if (Auth::user()->role !== 'admin' && $bookRequest->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Book request retrieved successfully',
            'data' => $bookRequest->load(['user', 'book'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, BookRequest $bookRequest)
    {
        
        if (Auth::user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Only admins can update book requests'
            ], 403);
        }

        $bookRequest->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Book request updated successfully',
            'data' => $bookRequest->load(['user', 'book'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookRequest $bookRequest)
    {
         
        if (Auth::user()->role !== 'admin' && $bookRequest->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

      
        if ($bookRequest->status === 'approved' && Auth::user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete approved requests'
            ], 400);
        }

        $bookRequest->delete();

        return response()->json([
            'success' => true,
            'message' => 'Book request deleted successfully',
            'data' => null
        ]);
    }}

   