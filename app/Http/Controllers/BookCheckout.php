<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BookCheckout extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function store(Book $book){
        if(!$book){
            return respone()->json([

            ],400);
        }
        $book->checkedOut(auth()->user());
    }
}
