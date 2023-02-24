<?php

namespace Tests\Feature;

use App\Author;
use App\Book;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    function a_book_can_be_added_to_the_library(){
        $this->withoutExceptionHandling();

        $response = $this->post("/books", $this->data());
        $book = Book::first();
        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
    }

    /** @test */
    function a_book_title_should_be_required(){

//        $this->withoutExceptionHandling();
        $this->post("/books",array_merge($this->data(),['author_id' => '']));
        $this->assertCount(0,Book::all());
    }

    /** @test */

    function a_book_info_should_be_update(){
        Author::truncate();
        $this->post('/books',$this->data());

        $book = Book::first();
        $response = $this->patch('/book/'.$book->id,[
           'title' => 'Fun Test',
            'author_id' => 'Ramesh'
        ]);

//        $response->isOk();
        $this->assertEquals('Fun Test', $book->fresh()->title);
        $this->assertEquals(2, $book->fresh()->author_id);
        $response->assertRedirect($book->path());
    }

    /** @test */

    function a_book_can_be_deleted(){
        Book::truncate();
        $this->withoutExceptionHandling();

        $this->post('/books',$this->data());

        $this->assertCount(1, Book::all());
        $response = $this->delete('/book/'.Book::first()->id);
        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }

    /** @test */

    function a_new_author_is_automatically_added(){
//        $this->withoutExceptionHandling();
        Author::truncate();
        $this->post('/books',[
            'title' => 'Cool Test',
            'author_id' => 'Sonu Verma'
        ]);

        $book = Book::first();
        $author = Author::first();

        $this->assertEquals($book->author_id, $author->id);
        $this->assertCount(1, Book::all());
    }

    protected function data(){
        return [
            'title' => 'One night stand',
            'author_id' => 'Ram'
        ];
    }
}
