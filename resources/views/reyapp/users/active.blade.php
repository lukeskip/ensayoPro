@extends('layouts.reyapp.main')

@section('content')
	@if($active)
		<div class="row">
			<div class="large-12 columns text-center">
				<h2>{{$message}} </h2>
				<a href="/musico/bienvenido" class="button green">Ir al Dashboard</a>
			</div>
		</div>
	@else
		<div class="row">
			<div class="large-12 columns text-center">
				<h2>{{$message}} </h2>
				<a href="#" class="button green send">Reenviar Correo de Bienvenida</a>
			</div>
		</div>
		
	@endif
	
@endsection
@section('scripts')
<script>
	
	$('.send').click(function(e){
		e.preventDefault();
		conection('GET','','/reenviar_bienvenida',true).then(function(data){
			if(data.success){
				show_message('success','¡Listo!',data.message)
			}else{
				show_message('error','¡Error!',data.message)
			}
		});
	});
	
</script>
@endsection
