@extends('layouts.app')
@section('title','batsman records')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<table class="table table-stripped table-bordered">
				<tr>
					<th>Country</th>
					<th>Player Name</th>
					<th>Global Average</th>
					<th>Global Strike Rate</th>
					<th>Last Ten Match Average</th>
					<th>Last Ten Match Strike Rate</th>
					<th>Player's Value</th>
				</tr>
				@foreach($states as $state)
				<tr>
					<td>{{$state->country}}</td>
					<td>{{$state->player}}</td>
					<td>{{$state->Gavg}}</td>
					<td>{{$state->Gsr}}</td>
					<td>{{$state->LTavg}}</td>
					<td>{{$state->LTsr}}</td>
					<td>{{$state->value}}</td>
				</tr>


				@endforeach
			</table>


		</div><!--end col-md-8-->
	</div><!--end row-->
</div><!--end container-->

@endsection