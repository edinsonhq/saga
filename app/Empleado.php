<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table        = "empleados";
	protected $primaryKey   = "id";// por defecto laravel busca id como campo  primary de la tabla 

	protected $fillable = [
	    'id',
	    'dni',
	    'email',
	    'nombres',
	    'apePaterno',
	    'apeMaterno',
	    'sexo',
	    'fechaNacimiento'													
	];

	public function user(){
		return $this->hasOne('App\User','empleado_id','id');
		// personal_id es la llave foranea de user, y id es la llave primaria de user
	}

	public function actividad() {
	   return $this->hasOne('App\Actividad','empleado_id','id');  
	}


}
