@extends('layouts.reyapp.main')
@section('content')
	<h1>{{$company->name}}</h1>
	<div class="row">
		<div class="large-12 columns">
			<div class="show-edit-wrapper">
				<div class="show">
					<div class="text">
						{{$company->name}}	
					</div>
				</div>
				<div class="edit">
					<form action="/company/companies/{{$company->id}}" method="PUT">
						{{ csrf_field() }}
						<div class="input-group">
						  <input class="input-group-field" type="text" name="name" value="{{$company->name}}">
						  <div class="input-group-button">
						    <button class="button black"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
						  </div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
@endsection


