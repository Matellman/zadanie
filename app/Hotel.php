<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $table = 'hotels';
    protected $fillable = [
        'name'
    ];
       
    public function comments()
    {
        return $this->hasMany('App\Comments', 'id', 'hotel_id');        
    }
}
