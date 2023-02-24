<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $guarded = [];

    protected $dates = ['dob'];

//    protected $dateFormat = 'Y-m-d';

    public function setDobAttribute($dob){
//        $this->attributes['dob'] = Carbon::createFromFormat('Y-m-d',$dob)->format('Y-m-d');
        $this->attributes['dob'] = Carbon::parse($dob);
    }

//    public function getDobAttribute($dob){
//        $this->attributes['dob'] = Carbon::createFromFormat('Y-m-d',$dob)->format('Y-m-d');
//    }

}
