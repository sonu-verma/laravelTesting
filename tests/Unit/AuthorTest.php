<?php

namespace Tests\Unit;

use App\Author;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;
    /** @test */

    function a_author_name_required_only_to_create(){
        Author::truncate();
        Author::firstOrCreate([
            'name' => 'Jogindar Jahirilla'
        ]);

        $this->assertCount(1, Author::all());
    }
}
