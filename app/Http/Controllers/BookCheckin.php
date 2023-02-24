<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookCheckin extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
   public function store(Book $book){

       try {
           $book->checkedIn(auth()->user());
       }catch (\Exception $e){
           return response([],404);
       }

   }
}
