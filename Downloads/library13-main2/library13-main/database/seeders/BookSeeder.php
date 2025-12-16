<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $book = [
            'ISBN' => '1112223334445',
            'title' => 'test book',
            'price' => 0,
            'mortgage' => 0,
            'category_id' => Category::first()->id,
        ];
        Book::create($book);
        Book::factory(100)->create();
    }
}
