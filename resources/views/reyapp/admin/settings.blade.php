@extends('layouts.reyapp.main')
@section('styles')
<link rel="stylesheet" href="{{asset('plugins/swal-forms-master/live-demo/sweet-alert.css')}}">
<link rel="stylesheet" href="{{asset('plugins/swal-forms-master/swal-forms.css')}}">
@endsection
@section('body_class', 'dashboard')
@section('content')
<div class="form_wrapper">
	<div class="row">
		<div class="large-12 columns">
			<h1 class="text-center">AJUSTES GENERALES</h1>
		</div>
	</div>
	<div class="row">
		<form action="">
			@foreach($settings as $setting)
				@if($setting->type == 'text' or $setting->type== 'number')
					<div class="medium-6 columns">
						<label>{{$setting->label}} <i class="fa fa-question-circle hastooltip" title="{{$setting->description}}" aria-hidden="true"></i></label>
						<input class="input-group-field" name="{{$setting->slug}}" type="{{$setting->type}}" value="{{$setting->value}}">
					</div>
				@elseif ($setting->type == 'select')
				<div class="medium-6 columns">
					<label>{{$setting->label}} <i class="fa fa-question-circle hastooltip" title="{{$setting->description}}" aria-hidden="true"></i></label>
					<select name="{{$setting->slug}}" id="">

						@for ($i = 0; $i < count($setting->labels); $i++)
							<option @if($setting->value == $setting->options[$i]) selected @endif value="{{$setting->options[$i]}}">
								{{$setting->labels[$i]}}
							</option>
						@endfor
					</select>
				</div>
				@endif
			@endforeach
		</form>
		
	</div>
	<div class="row">
		<div class="large-12 columns">
			<a href="#" class="button green expanded save">Guardar</a>
		</div>
	</div>
</div>
	


	
@endsection

@section('scripts')
<script>
	$(document).ready(function(){


		$('.save').click(function(e){
			e.preventDefault();
			var data = $('form').serialize(); 
			conection('PUT',data,'/admin/settings_save',true).then(function(answer){
				if(answer.success == true){
					show_message('success','¡Listo!',answer.message);
				}else{
					show_message('error','¡Error!',answer.message);
				}
				
			});
		});
	});
</script>
	
@endsection

