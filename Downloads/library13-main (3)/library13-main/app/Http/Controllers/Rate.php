<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
   
    public function rateBook(Request $request, $isbn)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:500'
        ]);
        
        $customer = Auth::user()->customer;
        $book = Book::where('ISBN', $isbn)->first();
        
        if (!$book) {
            return ResponseHelper::error('الكتاب غير موجود');
        }
        
       
        $customer->ratedBooks()->syncWithoutDetaching([
            $isbn => [
                'rating' => $request->rating,
                'review' => $request->review
            ]
        ]);
        
        return ResponseHelper::success('تم إضافة تقييمك بنجاح', [
            'book_title' => $book->title,
            'your_rating' => $request->rating,
            'average_rating' => $book->avgRating()
        ]);
    }
    
   
    public function getMyRating($isbn)
    {
        $customer = Auth::user()->customer;
        
        $rating = $customer->ratedBooks()
            ->where('ISBN', $isbn)
            ->first();
        
        if (!$rating) {
            return ResponseHelper::error('لم تقم بتقييم هذا الكتاب');
        }
        
        return ResponseHelper::success('تقييمك للكتاب', [
            'rating' => $rating->pivot->rating,
            'review' => $rating->pivot->review,
            'rated_at' => $rating->pivot->created_at
        ]);
    }
    
   
    public function getBookRatings($isbn)
    {
        $book = Book::where('ISBN', $isbn)->first();
        
        if (!$book) {
            return ResponseHelper::error('الكتاب غير موجود');
        }
        
        $ratings = $book->ratedBy()
            ->select('customers.id', 'users.name', 'books_customer.rating', 
                    'books_customer.review', 'books_customer.created_at')
            ->join('users', 'customers.user_id', '=', 'users.id')
            ->paginate(10);
        
        return ResponseHelper::success('تقييمات الكتاب', [
            'book_title' => $book->title,
            'average_rating' => $book->avgRating(),
            'total_ratings' => $book->ratingsCount(),
            'ratings' => $ratings
        ]);
    }
    
    
    public function deleteRating($isbn)
    {
        $customer = Auth::user()->customer;
        
        
        $customer->ratedBooks()->updateExistingPivot($isbn, [
            'rating' => null,
            'review' => null
        ]);
        
        return ResponseHelper::success('تم حذف تقييمك');
    }
}