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
        Schema::create('books', function (Blueprint $table) {
            $table->char('ISBN' , 13)->primary();
            $table->string('title' , 50);
            $table->decimal('price' , 4, 2);
            $table->decimal('mortgage' , 5, 2);
            $table->date('authorship_date')->nullable();
            $table->foreignId('category_id');
            $table->foreign('category_id')->on('categories')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
