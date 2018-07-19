@extends('layouts.app')

@section('title','IMPORTAR EXCEL')

@section('content')

	<div class="container">
		<h3 class="text-center">IMPORTAR ACTIVIDADES</h3>
		<hr>
		
		<div class="row">		
			
			<hr>
			<br>
			<div class="col-md-4">
				<form action="{{ URL::to('importExcel') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
				
					<div class="input-group mb-3">
					  <div class="input-group-prepend">
					    <span class="input-group-text">
					    		<i class="far fa-file-excel "></i>
					    </span>
					  </div>
					  <div class="custom-file">
					    <input type="file" class="custom-file-input" id="import_file" name="import_file" required="">
					    <label class="custom-file-label" for="import_file">Click aquí para subir archivo</label>
					  </div>
					</div>

					<button class="btn btn-primary">Subir archivos</button>

					@csrf
				</form>
			</div>
			<div class="col-md-8">
			</div>
		</div>
	</div>

@endsection


