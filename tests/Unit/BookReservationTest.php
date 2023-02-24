<?php

namespace Tests\Unit;

use App\Book;
use App\Reservation;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;
    /** @test */

    function a_book_can_be_checked_out(){
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();
        $book->checkedOut($user);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals(now(), Reservation::first()->checked_out_at);
    }

    /** @test  */
    function a_book_can_be_return(){
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();

        $book->checkedOut($user);
        $book->checkedIn($user);
        $this->assertCount(1, Reservation::all());
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals(now(), Reservation::first()->checked_in_at);
    }


    // throw error if book not checked out and came for checked in
    /** @test */
    function if_not_checkout_exception_is_thrown(){
        $this->expectException(\Exception::class);
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();
        $book->checkedIn($user);
    }

    //a book can be checked out for twice
    /** @test  */
    function a_book_can_be_checked_out_twice(){

        Reservation::truncate();
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();
        $book->checkedOut($user);
        $book->checkedIn($user);

        $book->checkedOut($user);

        $this->assertCount(2, Reservation::all());

        $this->assertEquals($user->id, Reservation::find(2)->user_id);
        $this->assertEquals($book->id, Reservation::find(2)->book_id);
        $this->assertNull(Reservation::find(2)->checked_in_at);
        $this->assertEquals(now(), Reservation::find(2)->checked_out_at);

        $book->checkedIn($user);

        $this->assertCount(2, Reservation::all());
        $this->assertEquals($user->id, Reservation::find(2)->user_id);
        $this->assertEquals($book->id, Reservation::find(2)->book_id);
        $this->assertNotNull(Reservation::find(2)->checked_in_at);
        $this->assertEquals(now(), Reservation::find(2)->checked_in_at);
    }

}
