@extends('layouts.reyapp.main')

@section('content')
	
	<div class="row">
		<div class="large-12 columns">
				@foreach ($companies as $companies)
				<div class="row list-item">
					<div class="medium-5 columns name">
						<div class="edit_open">
							<button class="edit hastooltip full_name_text" title="Editar">
								dfgdfgdfg
							</button>
						</div>
						{{-- <div class="edit_form_wrapper">
							<form data-id="{{$guest->id}}" class="edit" action="/guests/{{$guest->id}}">
								<div class="input-group">
								  <input 
								  	class="input-group-field required full_name_input" 
								  	type="text" 
								  	value="{{$guest->full_name}}"
								  	name="full_name"
								  >
								  <div class="input-group-button">
								    <button type="submit" class="button submit hastooltip" title="Guardar">
										<i class="fa fa-floppy-o" aria-hidden="true"></i>
									</button>
								  </div>
								</div>
								<div class="error"></div>
							</form>
						</div> --}}
					</div>
					<div class="medium-5 columns email">
						<div class="edit_open">
							<button class="edit hastooltip email_text" title="Editar">
								sdfsdfsdf
							</button>
						</div>
						{{-- <div class="edit_form_wrapper">
							<form data-id="{{$guest->id}}" class="edit" action="/guests/{{$guest->id}}">
								<div class="input-group">
								  <input 
								  	class="input-group-field required email_input" 
								  	type="email" 
								  	value="{{$guest->email}}"
								  	name="email"
								  >
								  <input 
								  	class="input-group-field" 
								  	type="hidden" 
								  	value="{{$user_name}}"
								  	name="user_id"
								  >

								  <input 
								  	class="input-group-field" 
								  	type="hidden" 
								  	value="{{$day}} de {{$month}} de {{$year}}"
								  	name="date"
								  >
								  <div class="input-group-button">
								    <button type="submit" class="button hastooltip" title="Guardar">
										<i class="fa fa-floppy-o" aria-hidden="true"></i>
									</button>
								  </div>
								</div>
								<div class="error"></div>
							</form>
						</div> --}}
						
					</div>
					<div class="medium-1 columns ">
						<button class="resend"><i class="fa fa-envelope hastooltip" title="Editar Reservación" aria-hidden="true"></i></button>
					</div>
					<div class="medium-1 columns status">
						<i class="fa hastooltip pendiente fa-exclamation-circle" aria-hidden="true" title="Pendiente"></i>
					</div>
				</div>
				@endforeach
		</div>
	</div>
@endsection
