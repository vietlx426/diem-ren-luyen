<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    protected $table = 'user_groups';

    public function group()
    {
    	return $this->belongsTo('App\Group', 'idGroup');
    }
}
