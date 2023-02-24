<?php

namespace Tests\Feature;

use App\Author;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class authorManagementTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    function a_author_should_register_in_system(){

        Author::truncate();
        $this->withoutExceptionHandling();

        $response = $this->post('/author',[
            'name' => 'Sonu Verma',
            'dob' => "07/15/1995"
        ]);

        $author = Author::all();
        $this->assertEquals(1, $author->count());
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);
        $this->assertEquals('1995/07/15',$author->first()->dob->format('Y/m/d'));
        $response->assertRedirect('/authors');
    }
}
