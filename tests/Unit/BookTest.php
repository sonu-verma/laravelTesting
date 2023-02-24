<?php

namespace Tests\Unit;

use App\Author;
use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
    use RefreshDatabase;
    /** @test */

    function an_author_id_recorded(){
        Book::truncate();
        Book::create([
            "title" => "Last Night Stand",
            "author_id" => 1
        ]);

        $this->assertCount(1, Book::all());
    }
}
