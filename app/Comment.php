<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    
    public function username(){
    	return $this->hasOne('App\User','id','user_id'); // First one is the model name and 2nd one is the foreign key
    }
}
