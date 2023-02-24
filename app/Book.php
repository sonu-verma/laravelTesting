<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = [];

    public function path(){
        return '/book/'.$this->id;
    }

    public function setAuthorIdAttribute($author){
        $this->attributes['author_id'] = (Author::firstOrCreate([
            "name" => $author,
            "dob" => date('Y-m-d H:i:s')
        ]))->id;
    }

    public function checkedOut($user){
        $this->reservation()->create([
            'user_id' => $user->id,
            'checked_out_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function checkedIn($user){
        $reservation = $this->reservation()->where('user_id',$user->id)
                            ->whereNotNull('checked_out_at')
                            ->whereNull('checked_in_at')
                            ->first();
        if(is_null($reservation)){
            throw new \Exception();
        }
        $reservation->update([
            'checked_in_at' =>date('Y-m-d H:i:s')
        ]);

    }

    public function reservation(){
        return $this->hasMany(Reservation::class);
    }

}
