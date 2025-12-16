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
        Schema::create('book_requests', function (Blueprint $table) {
            $table->id();
            $table->string('title' , 50);
            $table->foreignId('customer_id')->constrained();
            $table->timestamps();
         $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('book_id')->constrained()->onDelete('cascade');
        $table->date('request_date');
        $table->date('return_date');
        $table->enum('status', ['pending', 'approved', 'rejected', 'returned'])->default('pending');
      
        });
    }


    
    public function down(): void
    {
        Schema::dropIfExists('book_requests');
    }
};
