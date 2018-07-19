<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table        = "roles";
	protected $primaryKey   = "id";// por defecto laravel busca id como campo  primary de la tabla 

	protected $fillable = [
	    'id',
	    'nombre'												
	];

	public function user() {
	   return $this->hasOne('App\User','rol_id','id');  
	}


}
