@extends('layouts.app')

@section('title','ACTIVIDADES')

@section('content')
	
	<div class="container-fluid">
		
		<h4 class="text-center">CONTROL DE ASIGNACIONES</h4>
		<hr>
		@if(Session::has('exito'))  <!-- esta Sesion DURA sòlo durante la peticion -->
			<div class="alert alert-success alert-dismissible fade show" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			   {{Session::get('exito')}} 
			   <!-- imprime los mensajes del variable flash ubicado en el CiudadControllador -->
			</div>
		@endif
		@if(count($errors) > 0)
		    <div class="alert alert-danger">
		    	<p>Por favor, corregir siguientes errores:</p>
		        <ul>
		            @foreach ($errors->all() as $message)
		                <li>{{ $message }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif

		{{-- <form> --}}
		  {{-- <div class="form-group row">
		    <label for="staticEmail" class="col-sm-2 col-form-label">Despachador:</label>
		    <div class="col-sm-4">
		       	<select class="form-control" id="cmbDespachadores" name="cmbDespachadores">
		      	  	<option value="esierra@disnovo.com">EDISON SIERRA</option>
		     		<option value="jvillanes@disnovo.com">JOSSY VILLANES</option>
		      	  	<option value="lsanchez@disnovo.com">LUIS SANCHEZ</option>
		      	  	<option value="ngimenez@disnovo.com">NELSON GIMENEZ</option>
		        </select>
		    </div>
		  </div> --}}
	{{-- 	  <div class="form-group row">
		    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
		    <label for="inputPassword" class="col-sm-4 col-form-label">Despachador:</label>
			 <div class="col-sm-8">
			  	          	
			 </div>
		  </div> --}}
		{{-- </form> --}}
		<div class="row" id="actividades">

			{{-- {{ Auth::user()->empleado->id}} --}}
		  {{-- <div class="col-auto mr-auto"> --}}
			  	{{-- <div class="custom-control custom-checkbox"> --}}
			  	{{--   <input type="checkbox" class="custom-control-input" id="customCheck1">
			  	  <label class="custom-control-label" for="customCheck1">Asignar multiple</label> --}}
			  	  {{-- <label for="cmbDespachadores">Despachadores</label>  --}}
			  

{{-- 

			  	    <div class="form-group ">
			  	        
			  	      </div> --}}
			  	{{-- </div> --}}
		{{--   </div>
		  <div class="col-auto">
		  		<a class="btn btn-primary  btn-sm" href="{{ route('actividad.export',['type'=>'xls']) }}" role="button">Exportar registros</a><br><br>
		  </div> --}}
		</div>
		<div id="hola"> </div>
		<div class="table-responsive">
			<table class="table table-sm table-striped" id="actividades_table">
			  <thead>
			    <tr>
			      	<th scope="col"></th>
			      	<th scope="col"></th>
			      	
			     	<th scope="col">Distrito</th>
			     	{{-- <th scope="col"></th> --}}
			     	<th scope="col">Orden</th>
			     	<th scope="col">Producto</th>
			     	<th scope="col">Cantidad</th>
			     	<th scope="col">Hora Inicio</th>
					<th scope="col">Hora Fin</th>
					
			    </tr>
			  </thead>
			  <tbody>
			  	<tr></tr>
			  </tbody>
		
			</table>
			<br><br>
		</div>

	</div>
@endsection


@section("script")

<script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.10.19/api/fnStandingRedraw.js"></script>
{{-- <script type="text/javascript" src="{{ asset('js/toastr.min.js') }}"></script> --}}

{{-- <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> --}}

<script type="text/javascript" >
	function format(d) {
		var caso=0;
		if(d.numero_caso==null){
			caso=0;
		}else{
			caso=d.numero_caso;
		}

	    // `d` is the original data object for the row
	    return '<table class="table-sm" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
	    	'<tr style="background:white">'+
	            '<td>Dirección:</td>'+
	            '<td>'+d.ruta_direccion+'</td>'+
	        '</tr>'+
	       '<tr style="background:white">'+
	            '<td>Teléfono cliente:</td>'+
	            '<td>'+d.cliente_telefono_desp+'</td>'+
	        '</tr>'+
	        '<tr style="background:white">'+
	            '<td>Cantidad:</td>'+
	            '<td>'+d.cantidad+'</td>'+
	        '</tr>'+
	         '<tr style="background:white">'+
	            '<td>Número de caso:</td>'+
	            '<td>'+caso+'</td>'+
	        '</tr>'+
	        '<tr style="background:white">'+
	            '<td>Número de Folio:</td>'+
	            '<td>'+d.ref_orden_externa+'</td>'+
	        '</tr>'+
	        '<tr style="background:white">'+
	            '<td>EAN:</td>'+
	            '<td>'+d.ean+'</td>'+
	        '</tr>'+
	        '<tr style="background:white">'+
	            '<td>Fecha Pactada info:</td>'+
	            '<td>'+d.fecha_pactada+'</td>'+
	        '</tr>'+
	        
	    '</table>';
	}


	    $(document).ready( function () {
	    	var empleadoAsignado = "";
	    	var n = 0;
	    	var i = 0;
	    	var orden= new Array();
	        var table = $('#actividades_table').DataTable({

	        				
	        				ajax: "{{ route('getActividades') }}",
	        				responsive: true,
	        				details: false,
	        				"bLengthChange": false,
	        				processing: true,
	        	            serverSide: true,
	        	            responsive: {
	        	                breakpoints: [
	        	                  {name: 'bigdesktop', width: Infinity},
	        	                  {name: 'meddesktop', width: 1480},
	        	                  {name: 'smalldesktop', width: 1280},
	        	                  {name: 'medium', width: 1188},
	        	                  {name: 'tabletl', width: 1024},
	        	                  {name: 'btwtabllandp', width: 848},
	        	                  {name: 'tabletp', width: 768},
	        	                  {name: 'mobilel', width: 480},
	        	                  {name: 'mobilep', width: 320}
	        	                ]
	        	            },
	        	            {{-- "sAjaxSource": "{{ route('getActividades') }}",  --}}
	        	            
	        	            order: [[ 3, "asc" ]],//ORDENA DE FORMA ASCENDENTE CONSIDERANDO LA CUARTA COLUMNA
		        	            
	        	            columns: [  
	        	            	{
	        	            	                "className":      'details-control',
	        	            	                "orderable":      false,
	        	            	                "data":           null,
	        	            	                "defaultContent": ''
	        	            	},   
	        	            	{
	        	            	      data: null,
	        	            	      targets: [-1], render: function (a, b, data, d) {

	        	            	      			var empleadoRol = '{{ Auth::user()->rol_id }}';
												var empleadoSesion = '{{ Auth::user()->empleado->id }}';
												// alert(data.estado_empleado_id);

	        	            	      			// alert(empleadoRol);

	        	            	      			if(empleadoRol==1){

		        	            	                  



		        	            	                  	if (data.estado_id == 0) {

		        	            	                  		    return "<button class='btn btn-info btn-sm'>Elegir</button>";

		        	            	                  	}else if(data.estado_id==1){
		        	            	                  		   	 
		        	            	                            	return "<button class='btn btn-warning btn-sm'>Desasignar</button>";
		        	            	                            	 
		        	            	                    }

		        	            	        	}else if(empleadoRol==2){

		        	            	        			// if (data.estado_id == 0) {

		        	            	           //        		   return "<span class='badge badge-pill badge-info'>Sin asignar </span>";

		        	            	           //        	}else if(data.estado_id==1){
		        	            	                  		  
		        	            	           //                  	  return "<span class='badge badge-pill badge-danger'>Asignado a otro usuario</span>";
		        	            	                            	
		        	            	           //          }

		        	            	                    if (data.estado_id == 0) {

		        	            	                  		    return "<button class='btn btn-info btn-sm'>Elegir</button>";

		        	            	                  	}else if(data.estado_id==1){
		        	            	                  		   	 
		        	            	                            	return "<button class='btn btn-warning btn-sm'>Desasignar</button>";
		        	            	                            	 
		        	            	                    }
		        	            	        		
		        	            	        		
		        	            	        	}else if(empleadoRol==3){
		        	            	        			if (data.estado_id == 0) {

		        	            	        					

		        	            	                  		   return "<span class='badge badge-pill badge-info'>Sin asignar </span>";

		        	            	                  	}else if(data.estado_id==1){
		        	            	                  		   	{
		        	            	                  		   		// if(data.empleado_id==""){
		        	            	                  		   		// 	console.log("no");
		        	            	                  		   		// }else{
		        	            	                  		   		// 	console.log("si");
		        	            	                  		   		// }

		        	            	                  		   		if(data.empleado_id==null){
		        	            	        							
	        	   	            	    
	        	   	            	     					
		        	            	                  		   		}else{
		        	            	                  		   			{{-- empleadoAsignado= '{{ Auth::user()->rol_id }}'; --}}
		        	            	                  		   			// console.log("no");

		        	            	                  		   			// console.log(getEmpleadoDatos(data.empleado_id))



		        	              	 empleadoAsignado = '{{ App::make('\App\Http\Controllers\ActividadController')->getEmpleadoDatos(7) }}';
								
		        	            	                  		   		}
		        	            	 

		        	            	                            	  // return "<span class='badge badge-pill badge-danger'>"+empleadoAsignado+"Asignado a otro usuario</span>";
		        	            	                            	  return "<span class='badge badge-pill badge-danger'>Asignado a otro usuario </span>";

		        	            	                            }
		        	            	                    }
		        	            	        	}

	        	            	                  // return "";
	        	            	              },
	        	            	      // defaultContent: "<button class='btn btn-danger btn-sm'>Elegir</button>",
	        	            	      orderable: false, searchable: false 
	        	            	},
	        	            	{data: 'ruta_localidad', name: 'ruta_localidad'},
	        	            	{
	        	            		data: 'id', 
	        	            		name: 'id',
	        	            		visible: false
	        	            	},
	        	            	// {
	        	            	// 	data: 'ref_orden_externa', 
	        	            	// 	name: 'ref_orden_externa',
	        	            	// 	visible: true
	        	            	// },
	        	            	//AGREGAR 2 COLUMNAS JUNTAS	   	
	        	  //           	{
	        	  //               	data: {	
	        	  //               				ruta_localidad: 'ruta_localidad', 
	        	  //               				ruta_direccion: 'ruta_direccion'},
				        // 	                	mRender : function(data, type, full) {
				        // 	                	                return data.ruta_direccion+', '+data.ruta_localidad;
				        // 	        			},
												// orderable: false, searchable: false 
	        	  //           	},
	        	            	//FIN AGREGAR 2 COLUMNAS JUNTAS
	        	                
	        	                {data: 'producto_descripcion', name: 'producto_descripcion'},
	        	                {data: 'cantidad', name: 'cantidad'},	        	                
	        	                {data: 'hora_inicio', name: 'hora_inicio'},
	        	                {data: 'hora_fin', name: 'hora_fin'}
	        	                // ,
	        	                // {
	        	                // 	data: null,
	        	            	   //    targets: [-1], render: function (a, b, data, d) {

	        	            	   //    					// // 0	
	        	            	   //    					// // alert(data.ref_orden_externa.count);
	        	            	   //    					// orden[n] = data.ref_orden_externa;
	        	            	   //    					// console.log
	        	            	   //    					// // return 1;
		        	            	  //         //         if (data.ref_orden_externa == orden[1] ) {
		        	            	  //         //         	  n=n+1;
		        	            	  //         //             return n;

		        	            	  //         //         }else if(data.ref_orden_externa != orden[1]){
		        	            	  //         //         		n=1;
		        	            	  //         //         	  // return n;
		        	            	  //         //         }

		        	            	  //         		if(data.ref_orden_externa==orden[0]){
		        	            	  //         			orden[n] = data.ref_orden_externa;
		        	            	  //         			n++;
		        	            	  //         				return n;
		        	            	  //         		}else{
		        	            	  //         			orden[n] = data.ref_orden_externa;
		        	            	  //         			return n;
		        	            	  //         		}
		        	            	        

	        	            	   //                // return n++;
	        	            	   //            },
	        	            	   //    // defaultContent: "<button class='btn btn-danger btn-sm'>Elegir</button>",
	        	            	   //    orderable: false, searchable: false 
	        	                // }  	    
	        	                
	        	                

	        	            ],
	        	            language: {
	        	                        "sProcessing":     "Procesando...",
	        	                           "sLengthMenu":     "Mostrar _MENU_ &nbsp;registros",
	        	                           "sZeroRecords":    "No se encontraron resultados",
	        	                           "sEmptyTable":     "Ningún dato disponible en esta tabla",
	        	                           "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
	        	                           "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
	        	                           "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
	        	                           "sInfoPostFix":    "",
	        	                           "sSearch":         "Buscar:",
	        	                           "sUrl":            "",
	        	                           "sInfoThousands":  ",",
	        	                           "sLoadingRecords": "Cargando...",
	        	                           "oPaginate": {
	        	                               "sFirst":    "Primero",
	        	                               "sLast":     "Último",
	        	                               "sNext":     "Siguiente",
	        	                               "sPrevious": "Anterior"
	        	                           },
	        	                           "oAria": {
	        	                               "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
	        	                               "sSortDescending": ": Activar para ordenar la columna de manera descendente"
	        	                           }
	        	            }	       


	        });




	        // table.buttons( 1, 'csv:name' ).enable();

	        // table = $("#actividades_table").datatable();

	  
	       	$('#actividades_table tbody').on('click', 'button', function () {
	        	   	  var data = table.row( $(this).parents('tr') ).data();

	        	   	  // var con=confirm("¿ Está seguro de enviar el Producto: "+ data['producto_descripcion'] + '?')
	        	   	  //      if(con){
	        	   	                 	  
	        	   	                 	  // table.fnDestroy();
	        	   	                 	  // $('#actividades_table').clear();
	        	   	                 	      // table.draw();
	        	   	                
	        	   	            	      // table.ajax.reload( null,false);
	        	   	            	      sendInfoToController(data['id']);
	        	   	            	     
	        	   	            	      // $('#actividades_table').DataTable().ajax.reload(null,false);
	        	   	            	      // $('#actividades_table').DataTable().draw(false);

	        	   	            	      // $('#actividades_table').DataTable().fnStandingRedraw();

	        	   	            	      // var table = $('#actividades_table').dataTable()
	        	   	            	            // table.fnStandingRedraw();
	        	   	            	      // $('#actividades_table').dataTable().api().ajax.reload(null,false);

	        	   	            	      // $('#actividades_table').DataTable().ajax.reload(null,false);
	        	   	            	         // table.ajax.reload();




	        	   	            	       
	        	   	            	         // table.fnStandingRedraw();
	        	   	            	    
	        	   	       // }
	        	   	       // else
	        	   	       //  {
	        	   	       //  }
	             	  
	        	     
	      	 });




	       		// Add event listener for opening and closing details
	       	$('#actividades_table tbody').on('click', 'td.details-control', function () {
	       	        var tr = $(this).closest('tr');
	       	        var row = table.row( tr );
	       	 
	       	        if ( row.child.isShown() ) {
	       	            // This row is already open - close it
	       	            row.child.hide();
	       	            tr.removeClass('shown');
	       	        }
	       	        else {
	       	            // Open this row
	       	            row.child( format(row.data()) ).show();
	       	            tr.addClass('shown');
	       	        }
	       	});
	       	
	    });
	

	    



function sendInfoToController(itemID){
	var cmbEmail = $('#cmbDespachadores').val();

	var ruta = '{{ route('actividad.sendToNavego',["id"=>":itemID","email"=>":cmbEmail"]) }}';
	var rutaConVariables = ruta.replace(':itemID', itemID).replace(':cmbEmail', cmbEmail);


    $.ajax({
        type: "GET",
        url: rutaConVariables,
        // url: 'index.php/actividad/sendToNavego/id/'+itemID+'/email/'+cmbEmail+'?p='+x,
        // data: { id: itemID },
        // 
        success: function(){
        		 $('#actividades_table').DataTable().ajax.reload(null,false);
            // toastr.success('¡Listo! Se ha realizado la operación con éxito', 'Notificación');
   
            // $('#hola').html(data.html);
    
        },
        error: function (request, status, error) {
               // toastr.error('Algo inesperado ha sucedido', 'Notificación!')
            }
    }).done( 
	    
	    function(data) 
	    {
	    	//respuesta AJAX DEL
	        // $('#hola').html(data.html);
	    }

	);
}

// function getEmpleadoDatos(id){
// 	var ruta = '{{ route('getEmpleadoDatos',["id"=>":id"]) }}';
// 	var rutaConVariables = ruta.replace(':id', id);

// 	$.ajax({
//         type: "GET",
//         url: rutaConVariables,
//         // url: 'index.php/actividad/sendToNavego/id/'+itemID+'/email/'+cmbEmail+'?p='+x,
//         // data: { id: itemID },
//         // 
//         success: function(){

//         		 // $('#actividades_table').DataTable().ajax.reload(null,false);
//             // toastr.success('¡Listo! Se ha realizado la operación con éxito', 'Notificación');
   
//             // $('#hola').html(data.html);
    
//         },
//         error: function (request, status, error) {
//                // toastr.error('Algo inesperado ha sucedido', 'Notificación!')
//             }
//     }).done( 
	    
// 	    function(data) 
// 	    {
// 	    	//respuesta AJAX DEL
// 	        // $('#hola').html(data.html);

// 	        console.log(data.id);
// 	        // alert('data.id');
// 	    }

// 	);
// }








       

</script>


@endsection