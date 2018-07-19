@extends('layouts.app')
@section('title','IMPORTAR EXCEL')
@section('content')

	<div class="container">
		<h3 class="text-center">Importar Excel</h3>
		<hr>
		<div class="row">		
			<hr>
			<br>
			<div class="col-md-12">
				<form action="{{ URL::to('importExcel') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
					<input type="file" name="import_file" id="import_file"/>
					<button class="btn btn-primary">Import File</button>

					@csrf
				</form>
			</div>
		
	</div>

@endsection