<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('author_book', function (Blueprint $table) {
            // $table->foreignId('category_id')->constrained('categories' , 'id');
            $table->foreignId('author_id')->onDelete('cascade')->constrained();
            
            $table->char('book_ISBN' , 13);
            
            $table->foreign('book_ISBN')->on('books')
            ->references('ISBN')->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['author_id' , 'book_ISBN']);            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('author_book');
    }
};
