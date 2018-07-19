<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table        = "actividades";
	protected $primaryKey   = "id";// por defecto laravel busca id como campo  primary de la tabla 

    protected $fillable = [
        'id',
    	'orden_id',
        'ref_orden_externa', 
        'cliente_rut',
        'cliente_nombre_desp', 
        'cliente_telefono_desp' ,
        'cliente_celular_desp',
        'cliente_email',
        'ean' ,
        'producto_id',
        'producto_descripcion',
        'bt_mt',
        'cantidad', 
        'tamanio',  
        'ruta_id',
        'ruta_descripcion', 
        'ruta_direccion', 
        'ruta_localidad', 
        'orden',
        'hora_inicio', 
        'hora_fin',
        'tiempo_espera', 
        'visita_inicio',
        'latitud',
        'longitud', 
        'visita_fin',
        'local_abastece',  
        'fecha_pactada',
        'estado_id',
        'numero_caso',
        'despachador',
        'empleado_id'
        														
    ];


    public $timestamps = false;

    public function user(){
        return $this->hasOne('App\User','empleado_id','id');
    }

    public function empleado() {
        return $this->belongsTo('App\Empleado','empleado_id','id');    
    }

}
