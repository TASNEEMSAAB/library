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
        Schema::create('book_customer', function (Blueprint $table) {
            $table->char('book_ISBN' , 13);
            $table->foreign('book_ISBN')->on('books')
            ->references('ISBN')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreignId('customer_id')
            ->onDelete('cascade')
            ->constrained();

            $table->enum('rate' , ['1' , '2' ,'3' , '4' , '5']);

            $table->primary(['book_ISBN','customer_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_customer');
    }
};
