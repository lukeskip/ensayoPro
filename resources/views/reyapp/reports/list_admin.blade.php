@extends('layouts.reyapp.main')

@section('content')
			
	<div class="row">
		<h2>Reportes</h2>
		@if($week_total > 0)
			<p class="text-left">Esta semana debes depositar = ${{$week_total}}</p>
		@endif
		@if(isset($weeks))
		<form class="filter">
			<select class="input-group-field weeks" name="semana">
				<option value="">Todas</option>
				@foreach($weeks as $week)
					<option @if(request('semana') == $week->period_starts) {{'selected'}} @endif value="{{$week->period_starts}}">{{$week->period_starts_label}}</option>
				@endforeach
			
			</select>
		</form>
		@endif
		
		<div class="medium-12 columns">
				<div class="row list-header show-for-medium">
					<div class="medium-4 columns">
						Periodo:
					</div>
					<div class="medium-4 columns">
						Compañía:
					</div>
					<div class="medium-4 columns">
						Total:
					</div>
					
				</div>
				@if(!$reports->isEmpty())
					@foreach ($reports as $report)
						<div class="row list-item room-item">
							<div class="medium-4 columns">

								<a href="/company/reportes/{{$report->id}}">
									{{$report->period_starts}}
									/{{$report->period_ends}}
								</a>
								
							</div>
							<div class="medium-4 columns text-center">
								
								{{$report->company}}
							</div>
							<div class="medium-4 columns text-center">
								
								${{$report->company_incomings}}
							</div>
						

						</div>
					@endforeach
				@else
					<div class="row list-item">
						<div class="large-12 columnsaa">
							Aún no hay registros
						</div>
					</div>
				@endif
		</div>
		
	</div>
	<div class="row">
		<div class="large-12 columns">
			{!! $reports->appends(Request::capture()->except('page'))->render() !!}
		</div>
	</div>
@endsection

@section('scripts')
<script>
	$(document).ready(function(){
		$( ".weeks" ).change(function() {
  			$('.filter').submit();
		});	
	});
</script>
	
@endsection

