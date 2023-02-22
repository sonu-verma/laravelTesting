<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(){

    }

    public function store(Request $request){
        $author = Author::create($this->validateAuthor());
        return redirect()->route('authors');
    }

    protected function validateAuthor(){
        return request()->validate([
            "name" => "required",
            "dob" => "required"
        ]);
    }
}
