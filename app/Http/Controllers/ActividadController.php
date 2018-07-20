<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



use Excel;
use App\Actividad;
use App\Empleado;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;

class ActividadController extends Controller
{
    public function __construct(){

        $this->middleware('auth');

    }

    public function getActividades(){
        // $users = User::select(['id', 'name', 'email', 'password', 'created_at', 'updated_at']);

        //        return Datatables::of($users)
        //            ->addColumn('action', function ($user) {
        //                return '<a href="#edit-'.$user->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
        //            })
        //            ->editColumn('id', 'ID: {{$id}}')
        //            ->removeColumn('password')
        //            ->make(true);

        $Fechaactual= Carbon::now();
        $FechaactualFormato = $Fechaactual->format('Y-m-d');
        //formateando a la fecha del excel "2018-07-19T00:00:00"
        $FechaFormato  = $FechaactualFormato."T00:00:00";


               $actividades = Actividad::where('fecha_pactada','=',$FechaFormato)->select(['id',
                                                 'producto_descripcion',
                                                 'ruta_localidad',
                                                 'cantidad',
                                                 'hora_inicio',
                                                 'hora_fin',
                                                 'ean',
                                                 'ruta_direccion',
                                                 'estado_id',
                                                 'cliente_telefono_desp',
                                                 'fecha_pactada',
                                                 'numero_caso',
                                                 'ref_orden_externa',
                                                 'empleado_id'
                                               ])->get();
     
            return Datatables::of($actividades) 
                ->editColumn('fecha_pactada', function ($actividad) {
                                return $actividad->fecha_pactada ? with(new Carbon($actividad->fecha_pactada))->format('Y-m-d') : '';
                            })
                ->editColumn('hora_inicio', function ($actividad) {
                                return $actividad->hora_inicio ? with(new Carbon("0".$actividad->hora_inicio))->format('H:i') : '';
                            })
                ->editColumn('hora_fin', function ($actividad) {
                                return $actividad->hora_fin ? with(new Carbon($actividad->hora_fin))->format('H:i') : '';
                            })
                // ->addColumn('action', function ($user) {
                
                //         return '<button class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-edit"></i> Elegir</button>';
                //    })
                // return '<a href="#edit-'.$user->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Elegir</a>';
                   /*    return '<a href="#edit-'.$user->id.'" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-edit"></i> Elegir</a>';*/
     
                ->make(true); 

                // $tasks = Task::select(['id','name','category','state']);
                 
                //         return Datatables::of($tasks)
                 
                //             ->make(true);


            }

    //
      public function index(){


        // $Fechaactual= Carbon::now();
        // $FechaactualFormato = $Fechaactual->format('Y-m-d');
        
        // //formateando a la fecha del excel "2018-07-19T00:00:00"
        // $FechaFormato  = $FechaactualFormato."T00:00:00";

        $actividades = Actividad::orderBy('id','asc')->paginate(10);
        // dd( $actividades);
        return view("actividad.index",compact("actividades"));
      
      }

      public function formImport(){

        return view("actividad.formImport");
      
      }

        public function importExcel(Request $request)
        {
          /*try
          {*/
          if($request->hasfile("import_file")){

            $path = $request->file("import_file")->getRealPath();

                    // $data = \Excel::load($path)->get();
            // $data = \Excel::load($path, function($reader) {
         //                                        } ,null,true)->get();

                    $data = \Excel::load($path,function($reader) {
                                                    // your code
                                                    } ,null,true)->get();




            if($data->count()){
              foreach($data as $key => $value){
                 $actividades_array[] = [   
                                  
                                                        "orden_id"=>$value->orden_id, 
                                                        "ref_orden_externa"=>$value->ref_orden_externa, 
                                                        "cliente_rut"=>$value->cliente_rut, 
                                                        "cliente_nombre_desp"=>$value->cliente_nombre_desp, 
                                                        "cliente_telefono_desp"=>$value->cliente_telefono_desp, 
                                                        "cliente_celular_desp"=>$value->cliente_celular_desp, 
                                                        "cliente_email"=>$value->cliente_email, 
                                                        "ean"=>$value->ean, 
                                                        "producto_id"=>$value->producto_id, 
                                                        "producto_descripcion"=>$value->producto_descripcion, 
                                                        "bt_mt"=>$value->bt_mt, 
                                                        "cantidad"=>$value->cantidad,
                                                        "tamanio"=>$value->tamanio, 
                                                        "ruta_id"=>$value->ruta_id, 
                                                        "ruta_descripcion"=>$value->ruta_descripcion, 
                                                        "ruta_direccion"=>$value->ruta_direccion, 
                                                        "ruta_localidad"=>$value->ruta_localidad, 
                                                        "orden"=>$value->orden, 
                                                        "hora_inicio"=>$value->hora_inicio, 
                                                        "hora_fin"=>$value->hora_fin, 
                                                        "tiempo_espera"=>$value->tiempo_espera, 
                                                        "visita_inicio"=>$value->visita_inicio, 
                                                        "latitud"=>$value->latitud, 
                                                        "longitud"=>$value->longitud, 
                                                        "visita_fin"=>$value->visita_fin, 
                                                        "local_abastece"=>$value->local_abastece, 
                                                        "fecha_pactada"=>$value->fecha_pactada,
                                                        "estado_id"=>0,
                                                        "numero_caso"=>null
                                                    ];

                // $reporte = new Reporte();
                // $reporte->nombres = $value->nombres;
                // $reporte->apellidos = $value->apellidos;
                // $reporte->estado_id = $value->estado_id;
                // $reporte->save();

            
              }
              if(!empty($actividades_array)){

                // dd($actividades_array);
                Actividad::insert($actividades_array);
                return redirect()->route('actividad.index')->with('exito','¡Listo! Se ha importado las actividades');
                //\Session::flash("success","archivo subido correctamente");
              }   
            }

          }else{
            return redirect()->back()->with('error','No se ha realizado la importación.');
            \Session::flash("warning","no hay archivo a subir");
          }
                    /*
        } catch(\Exception $e){
            return redirect()->back()->with('error','No se ha realizado la importación.');
        } */

               
        }

        public function export($type){

            $asignados = Actividad::select("*",
                                        DB::raw("CASE WHEN 
                                                    estado_id=1 THEN 'ASIGNADOS'
                                                 END AS ESTADO"))->where('estado_id',1)->get()->toArray();
            


            $desasignados = Actividad::select("*",
                                        DB::raw("CASE WHEN 
                                                    estado_id=0 THEN 'NO ASIGNADOS'
                                                 END AS ESTADO"))->where('estado_id',0)->get()->toArray();

            // dd($desasignados);
            
            return \Excel::create("actividades", function($excel) use ($asignados,$desasignados){
                        $excel->sheet('Asignados', function($sheet) use ($asignados){
                                $sheet->fromArray($asignados);
                            });

                        $excel->sheet("No asignados", function ($sheet) use ($desasignados)
                        {
                            $sheet->fromArray($desasignados);
                        });
            })->download($type);

        }

        public function sendToNavego($id,$email){

        try{

            $empleado_id = Auth::user()->empleado->id;

            // verificar si esta o no asignado
            $actividad = Actividad::find($id);

            // echo count($actividad);
            if($actividad->exists){

                            if($actividad->estado_id==0){ //ASIGNAR Y ENVIAR A NAVEGO

                                // $token = "disnovoToken";
                                $token = "5793DB6FD9B85CBDCDEE98F5A8A18";
                                $latitud = $actividad->latitud;
                                $latidudSet = substr_replace($latitud, '.',3,0);
                                $longitud = $actividad->longitud;
                                $longitudSet = substr_replace($longitud, '.', 3,0);


                                if($actividad->cliente_celular_desp==""){
                                    $cliente_declular_desp="";
                                }else{
                                    $cliente_declular_desp = $actividad->cliente_celular_desp;
                                }



                                                              
 
                                                                // echo $fechaPactadaOk->toDateTimeString();

                                                                $hora_inicio = new Carbon("0".$actividad->hora_inicio);
                                                                $hora_inicio_format = $hora_inicio->format('H:i:s');

                                                                $time = new Carbon($hora_inicio_format);
                                                                 $horasRestadas =  $time->addHours(5);
                                                                $horaFormatoRestado = $horasRestadas->format('H:i:s');
                                                                // echo $x= Carbon::create($hora_inicio_format);

                                                                // ->subHours(5);


                                                                $hora_fin = new Carbon($actividad->hora_fin);
                                                                $hora_fin_format = $hora_fin->format('H:i');


                                                                $fechaPactada= new Carbon($actividad->fecha_pactada);
                                                                $fechaPactadaFormato = $fechaPactada->format('Y-m-d');

                                                                $horaPactada="T".$horaFormatoRestado.".000Z";
                                                                //juntamos fecha y hora restada
                                                                 $fechaProgramadaOficial = $fechaPactadaFormato.$horaPactada;


                                                                // "2016-12-03T15:39:00.000Z",
                                $body = 
                                    [    
                                       'user_name' => Auth::user()->empleado->email,
                                        "codigo_tipo_servicio" => "A1",
                                        "fecha_programada" => $fechaProgramadaOficial,
                                                              
                                                           // "2016-12-03T15:39:00.000Z"//formato ejemplo
                                                           // 2018-06-08T05:00:00.000Z //equivale a 12 AM y sólo a partir de esa hora se puede enviar, 
                                                            //En el caso pdddara que se muestre en el celular 8 am
                                                            // la hora tendria que ser 13pm 
                                        "cliente_nombre" => $actividad->cliente_nombre_desp,
                                        "cliente_apepat" => "Cantidad: ".(string)$actividad->cantidad,
                                        "cliente_apemat" => "Entrega: ".$hora_inicio_format.", Hasta: ". $hora_fin_format,
                                        "cliente_direccion" => $actividad->ruta_direccion." ".$actividad->ruta_localidad,
                                        "cliente_telefono" => (string)$actividad->cliente_telefono_desp,
                                        "cliente_latitud" => $latidudSet,
                                        "cliente_longitud" => $longitudSet,
                                        "cliente_observaciones"=> $actividad->ref_orden_externa." - ".$actividad->producto_descripcion,
                                        "codigo_referencia" => (string)$actividad->ref_orden_externa,
                                        "codigo_grupo_trabajo" => (string)$actividad->cantidad,
                                        "form_adds" => 
                                            [
                                                [
                                                "f"   =>"538",
                                                "efs" =>  
                                                        [
                                                            "1" => $actividad->ean,
                                                            "3" => $actividad->producto_descripcion,
                                                            "5" => (string)$actividad->cantidad,
                                                            "7" => $actividad->ruta_direccion
                                                        ]
                                                ],
                                                [
                                                 "f"   =>"537",
                                                 "efs" =>  
                                                        [
                                                            "1" => (string)$actividad->cliente_telefono_desp,
                                                            "2" => $actividad->cliente_email,
                                                            "3" => $actividad->ruta_localidad,
                                                            "5" => '.'
                                                        ]
                                                ]
                                            ]
                                ];

                                // dd($body);
                  
                                // return json_encode($body);//MUESTRA EL JSON DE LA RESPUESTA
                                    
                                $base_url_navego = 'https://api.navego360.com/api/servicio/create';   
                                $headerName = 'apitoken';
                                $jsonBody = json_encode($body);

                                // dd($jsonBody);


                                $ch = curl_init($base_url_navego);     
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);                                              

                                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');                                                  
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);
                                                                       
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                    
                                curl_setopt($ch, CURLOPT_HTTPHEADER, array(                  
                                    'Content-Type: application/json',                                                    
                                    'Content-Length: ' .strlen($jsonBody),
                                    $headerName.': '.$token )                                
                                ); 

                                //EJECUTAR ENVIO
                                 $resultJson = curl_exec($ch);



                                //codificacion
                                // $json = json_encode(json_decode($resultJson),JSON_PRETTY_PRINT);

                                // MUESTRA EL ERROR DE CURL
                                // $error = curl_error($ch);
                                // echo $error;

                                 $resultado=json_decode($resultJson,true);
                                 $numero_caso = $resultado['data']['numero_caso'];

                                if($resultJson == false){
                                    return ("respuesta: ".$resultJson);
                                }else{
                                    
                                }

                    $actividadUpdate = DB::table('actividades')
                                    ->where('id', $id)
                                    ->update(array('estado_id' => 1,
                                                    'numero_caso' => $numero_caso,
                                                    'despachador' => $email,
                                                    'empleado_id' => $empleado_id
                                    ));

                }elseif($actividad->estado_id==1){//DESASIGNAR

                    if($actividad->empleado_id==$empleado_id){

                        $actividadUpdate = DB::table('actividades')
                                    ->where('id', $id)
                                    ->update(array(
                                                    'estado_id' => 0,
                                                    'numero_caso' => null,                                               
                                                    'empleado_id' => null
                                    ));
                    }

                }
            }
         
            } catch(\Exception $e){

                // return redirect()->back()->with('error','No se ha realizado la importación.');
                 return response()->json(['msg' => 'ERROR!', 'success' => false], 201);
            } 
            
        }













        public function getEmpleadoDatos($id){
            echo $id;
            // $empleado = Empleado::findOrFail($id);
            // echo $empleado->nombres;
            // echo $id;
               // return response()->json( 
               //                              array('success' => true, 
               //                                    'id'=>$id) 
               //                        );

        }

     
        public function diaFormat($fecha){

            setlocale(LC_TIME, 'Spanish');
            Carbon::setUtf8(true);
            $fechaParse = Carbon::parse($fecha);
            $fechaFormat=$fechaParse->format('d-m-Y');
            // $diaActual=$today->formatLocalized('%A %d %B %Y');
            return $fechaFormat;
        }

         public function horaFormat($hora){

            setlocale(LC_TIME, 'Spanish');
            Carbon::setUtf8(true);
            $fechaParse = Carbon::parse($hora);
            $fechaFormat=$fechaParse->format('H:i');
            // $diaActual=$today->formatLocalized('%A %d %B %Y');
            return $fechaFormat;
        }

        public function horaFormat2($hora){

            setlocale(LC_TIME, 'Spanish');
            Carbon::setUtf8(true);
            $fechaParse = Carbon::parse($hora);
            $fechaFormat=$fechaParse->format('H:i');
            // $diaActual=$today->formatLocalized('%A %d %B %Y');
            return $fechaFormat;
        }
}
