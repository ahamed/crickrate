<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    public function replyes(){
    	return $this->hasOne('App\User','id','user_id');
    }
}
