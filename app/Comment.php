<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $fillable = [
        'hotel_id',
        'comment',
        'rating',
        'know_from'
    ];
    protected $with = ['know_from_select'];
       
    public function sub_comments()
    {
        return $this->hasMany('App\SubComment', 'comment_id', 'id');        
    }
       
    public function know_from_select()
    {
        return $this->hasOne('App\KnowFromSelect', 'id', 'know_from');        
    }
}
