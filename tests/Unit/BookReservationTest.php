<?php

namespace Tests\Unit;

use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    function a_book_can_be_added_to_the_library(){
        $this->withoutExceptionHandling();

        $response = $this->post("/books",[
            'title' => 'One night stand',
            'author' => 'Sonu'
        ]);
        $book = Book::first();
        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
    }

    /** @test */
    function a_book_title_should_be_required(){

//        $this->withoutExceptionHandling();

        $response = $this->post("/books",[
            "title" => 'test',
            "author" => "sonu"
        ]);

        $book = Book::first();
        $this->assertCount(1,Book::all());
        $response->assertRedirect($book->path());
    }

    /** @test */

    function a_book_info_should_be_update(){
        $this->post('/books',[
            'title' => 'Cool Test',
            'author' => 'Sonu'
        ]);

        $book = Book::first();
        $response = $this->patch('/book/'.$book->id,[
           'title' => 'Fun Test',
           'author' => 'Demo',
        ]);

//        $response->isOk();
        $this->assertEquals('Fun Test', $book->fresh()->title);
        $this->assertEquals('Demo', $book->fresh()->author);
        $response->assertRedirect($book->path());
    }

    /** @test */

    function a_book_can_be_deleted(){

        $this->withoutExceptionHandling();

        $this->post('/books',[
            'title' => 'Cool Test',
            'author' => 'Sonu'
        ]);

        $this->assertCount(1, Book::all());
        $response = $this->delete('/book/'.Book::first()->id);
        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }
}
