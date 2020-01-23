<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title', 'description', 'begin_date', 'close_date'];

    // function user() {
    //     return $this->belongsTo('App\User');
    // }
}
