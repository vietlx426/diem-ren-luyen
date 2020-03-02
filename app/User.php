<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function usergroup()
    {
        return $this->hasMany('App\UserGroup', 'idUser');
    }

    public function trangthaiuser()
    {
        return $this->belongsTo('App\TrangThaiUser', 'idtrangthaiuser');
    }
}
