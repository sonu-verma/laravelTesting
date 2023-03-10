<?php

namespace Tests\Feature;

use App\Book;
use App\Reservation;
use App\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookCheckoutTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    function a_book_can_be_checkout_by_signed_in_user(){
        $this->withoutExceptionHandling();

        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user)->post('/checkout/'.$book->id);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals(date('Y-m-d H:i:s'), Reservation::first()->checked_out_at);
    }

    /** @test */
    function only_logged_in_user_can_checkout(){
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();

        $this->post('/checkout/'.$book->id);

        $this->assertCount(0, Reservation::all());

    }

    /** @test  */
    function only_real_book_can_checkout(){
        $this->actingAs($user = factory(User::class)->create())
            ->post('/checkout/2550')
            ->assertStatus(404);

        $this->assertCount(0, Reservation::all());
    }

    /** @test */
    function a_book_can_be_checked_in_by_signed_in_user(){

//        $this->withoutExceptionHandling();

        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user)->post('/checkout/'.$book->id);
        Auth::logout();
        $this->post('/checkin/'.$book->id)
            ->assertRedirect('/login');

        $this->assertCount(1, Reservation::all());
        $this->assertNull(Reservation::first()->checked_in_at);
    }

    /** @test */
    function a_404_is_thrown_if_a_book_can_not_be_checkout_first(){
        $this->withoutExceptionHandling();
        $book = factory(Book::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post('/checkin/'.$book->id)
            ->assertStatus(404);

        $this->assertCount(0,Reservation::all());
    }

}
