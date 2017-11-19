@extends('layouts.reyapp.main')
@section('body_class', 'band_edit')
@section('content')
<div class="form_wrapper">
	<form id="band_data" class="form-horizontal" method="POST" action="{{ route('register') }}">
		{{ csrf_field() }}
						
		<div class="row">
			<div class="large-12 columns">
				<h2>Edita los datos de tu banda</h2>
			</div>
		</div>
		

		<div class="row">
			<div class="large-6 columns input_band_member">
				<label>Nombre</label>
				<input class="input-group-field" name="name" type="text" value="{{$band->name}}" placeholder="ej.  Led Zeppelin">
			</div>

			<div class="large-6 columns input_band_member">
				
				<label>Género</label>
				<select class="input-group-field required" name="genre" id="">
				  <option value="">Selecciona...</option>
				  <option @if($band->genre == 'rock'){{'selected'}}@endif value="rock">
				  	Rock
				  </option>
				  <option @if($band->genre == 'pop'){{'selected'}}@endif value="pop">
				  	Pop
				  </option>
				  <option @if($band->genre == 'latin'){{'selected'}}@endif value="latin">
				  	Ritmos Latinos
				  </option>
				  <option @if($band->genre == 'jazz'){{'selected'}}@endif value="jazz">
				  	Jazz
				  </option>
				  <option @if($band->genre == 'blues'){{'selected'}}@endif value="blues">
				  	Blues
				  </option>
				</select>
				
					
			</div>
		</div>
	
	
	
		<div class="row" class="band_register">
			<div class="large-12 columns">
				<h3>Miembros de tu banda</h3>
			</div>

			<div id="paste" class="members">
				<div class="large-12 columns members_re">
					@foreach($members_re as $user)

						
							<span class="member registered">
								{{$user->name}} {{$user->lastname}}
								<a href="#" class="delete" data-band="{{$band->id}}" data-id="{{$user->id}}">
									<i class="fa fa-times" aria-hidden="true"></i>
								</a>
							</span>
						

					@endforeach
				</div>
				<div class="large-12 columns input_band_member members_un">
					@foreach($members_un as $user)

						
							<div class="input-group">
								<a class="delete hastooltip" data-band="{{$band->id}}" data-id="{{$user->id}}" title="Saca a este miembro de la banda">
									<i class="fa fa-times" aria-hidden="true"></i>
								</a>
								<a class="resend hastooltip" data-band="{{$band->id}}" data-id="{{$user->id}}" title="Reenvía la invitación">
									<i class="fa fa-envelope-o" aria-hidden="true"></i>
								</a>
								<span class="input-group-label">
									Email
								</span>
							  	<input class="input-group-field member old required unregistered" type="email" placeholder="ej. guitarrista@correo.com" name="email" value="{{$user->email}}" data-id="{{$user->id}}">
							</div>
						
						
					@endforeach
				</div>
						
					

				
			</div>

			<div class="large-12 columns">
				<div class="add member hastooltip" title="Registra a todos lo miembros de tu banda para matenerlos informados de reservaciones de ensayo">
					<i class="fa fa-address-card-o" aria-hidden="true"></i> Agregar otro miembro
				</div>
			</div>

		</div>
		
		
		{{-- HIDDEN FIELD TO CLONE --}}
		<div class="hidden">
			<div class="large-12 columns input_band_member_clone">
				<div class="input-group">
					<span class="input-group-label">
						Email
					</span>
				  <input class="input-group-field member new" type="text" placeholder="ej. guitarrista@correo.com" name="email">
				</div>
				
			</div>
		</div>
		{{-- HIDDEN FIELD TO CLONE --}}

		<br><br>
		<div class="row ">
			<div class="large-12 columns">
				<button type="submit" class="button expanded green register_band">
					Registrar
				</button>
			</div>

		</div>
	</form>
</div>	
@endsection
@section('scripts')	
	<script src="{{asset('plugins/validation/jquery.validate.min.js')}}"></script>
	<script src="{{asset('plugins/validation/messages.js')}}"></script>
	
	<script>


		$('.delete').click(function(e){
			e.preventDefault();
			id 		= $(this).data("id");
			band 	= $(this).data("band");

			console.log(band);
			swal({
				title: '¿Estás seguro?',
				text: "No podrás deshacer esta acción",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Sí, Sácalo de la banda!'
			}).then(function (result) {
				
				conection('PUT',{'id':id,'band':band},'/musico/bandas_delete_member',true).then(function(data){
					if(data.success == true){
						location.reload();
					}else{
						show_message('error','¡Error!','Hubo un error');
					}
					
				});
				
			}).catch(swal.noop);
			
			

			
		});
		
		$('#band_data').validate({
			submitHandler: function(form) {
    			edit_band ();
  			},
  			errorPlacement: function(error, element) {
    		if(element[0].name == "days[]"){
    			console.log(element.parent().find('label.error'));

    		}else{
    			error.insertAfter(element);
    		}
    		
		}
		});

		

		function edit_band (){

			// declaramos nuestro array
			var members 	= [];
			var members_old = [];

			// Guardamos la información de los members en el array declarado
			$( "input.member.new" ).each(function( index ) {
				email = $(this).val();
				if(email !=""){
					members.push({
						'email' : email 
					});
				}	
			});

			$( "input.member.old" ).each(function( index ) {
				email = $(this).val();
				if(email !=""){
					members_old.push({
						'id'  :$(this).data('id'),
						'email' : email 
					});
				}	
			});

			// armamos una variable que utilizaremos en nuestro pool de conexiones
			data = $("#band_data").serialize()+"&members="+JSON.stringify(members)+"&members_old="+JSON.stringify(members_old);

			conection('PUT',data,'/musico/bandas/'+{{$band->id}},true).then(function(data) {
					if(data.success == true){
						location.reload();
					}else{
						show_message('error','¡Error!',data.message);
					}
			});
		}
	</script>
	

@endsection
