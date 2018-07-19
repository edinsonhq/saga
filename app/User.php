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
        'dni', 'email', 'password','empleado_id','rol_id'
    ];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];

    public $timestamps = false;


    public function empleado() {
        return $this->belongsTo('App\Empleado','empleado_id','id');    
    }

    public function rol() {
        return $this->belongsTo('App\Rol','rol_id','id');    
    }
}
