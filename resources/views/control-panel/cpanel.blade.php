@extends('layouts.app')
@section('title','Control panel')
@section('content')
	<div class="container">
		<div class="row score affix">
			@if($pitch >= 2)
			<div class="col-md-12 ">
				<h1>
				{{$batting}} :  <strong>{{$total_runs}}/{{$wickets}}</strong>  
				
				@foreach ( $current_batsmen as $batsman)
				<span> |
				@if($batsman->onStrike == 1)  
				<small style="color: red">
				{{$batsman->name}} - {{$batsman->run}}(<small style="color:red;">{{$batsman->ball}}</small>)
				</small>
				@else
				<small>
				{{$batsman->name}} - {{$batsman->run}}(<small>{{$batsman->ball}}</small>)
				</small>
				@endif 
				
				</span>
				@endforeach
				
				<span class="pull-right"> Over: {{$overcount}}</span>
				</h1>
			</div>
			@endif
		</div>
		<div class="row row-body">
			<div class="col-md-6">
				<h1>Score | <small> Control Panel<small></h1>
				<form method="post" action="{{ url('/add-player') }}">
					{!! csrf_field() !!}
					@if($pitch < 2)
					
					<div class="form-group">
						<select class="form-control" name="playername" required>
							<option value="">Select a player</option>
							@foreach($batsmen as $batsman)
								<option value="{{$batsman->playername}}">{{$batsman->playername}}</option>

							@endforeach
						</select>
						<input type="submit" name="add" value="add" class="btn btn-primary">	
					</div>
					@endif
					
				</form>
				@if($pitch >= 2)
				<form method="post" action="/add-runs">
					{!! csrf_field() !!}
					<div class="form-group">
						<!--<input type="number" class="form-control runs" name="runs" placeholder="Run of this ball">-->
						
						<input type="submit" name="zer" value="0" class="btn btn-primary btn-circle">
						<input type="submit" name="one" value="1" class="btn btn-primary btn-circle">
						<input type="submit" name="two" value="2" class="btn btn-primary btn-circle">
						<input type="submit" name="three" value="3" class="btn btn-primary btn-circle">
						<input type="submit" name="four" value="4" class="btn btn-primary btn-circle">
						<input type="submit" name="five" value="5" class="btn btn-primary btn-circle">
						<input type="submit" name="six" value="6" class="btn btn-primary btn-circle">
						<br>
						<div class="form-group">
							<label class="radio-inline">
								<input type="radio" name="extra" value="wide"> Wide
							</label>
							<label class="radio-inline">
								<input type="radio" name="extra" value="noball"> No Ball
							</label>
							<label class="radio-inline">
								<input type="checkbox" name="lb" value="lb"> By/Legby
							</label>
						</div>
					</div>
				</form><!-- end add  run form-->
			@endif
			</div><!--end col-md-8 -->
			<div class="col-md-6">
				
				<h1>Score | <small>View</small></h1>
				<div class="panel">
							
					<div class="panel-body">
						<table class="table table-stripped table-bordered">
							<tr>
								<th>Sl.</th>
								<th>Player</th>
								<th>Runs</th>
								<th>Ball</th>
								<th>S/R</th>
								<th>4's</th>
								<th>6's</th>
								<th>Action</th>

							</tr>

							@foreach($bats as $bat)
								@if($bat->isActive)
								<tr class="success">
									<td>{{$ind++}}</td>
									@if($bat->onStrike)
									<td>{{$bat->name}} <strong style="color: red; font-size: 20px;">*</strong></td>
									@else
									<td>{{$bat->name}}</td>
									@endif
									<td>{{$bat->run}}</td>
									<td>{{$bat->ball}}</td>
									<td>{{$bat->sr}}</td>
									<td>{{$bat->fours}}</td>
									<td>{{$bat->sixs}}</td>
									<td><a href="">E</a>/<a href="/delete/{{$bat->id}}">D</a>/
										<a href="/out/{{$bat->id}}">Out</a>
									</td>
								</tr>
								@else
								<tr>
									<td>{{$ind++}}</td>
									<td>{{$bat->name}}</td>
									<td>{{$bat->run}}</td>
									<td>{{$bat->ball}}</td>
									<td>{{$bat->sr}}</td>
									<td>{{$bat->fours}}</td>
									<td>{{$bat->sixs}}</td>
									<td>
										<a href="">E</a>/
										<a href="/delete/{{$bat->id}}">D</a>
										
									</td>
								</tr>
								@endif
							@endforeach
						</table>
					</div>
				</div>
			</div><!--end col-md-4-->
		</div><!--end first row-->
		<div class="row">
			<div class="col-md-8">
				<h2>This over</h2>
				<h4>
					<!--  Here this over code would be generated -->

					@for($i = 0; $i < sizeof($thisovers); $i++)

						<strong>{{ $thisovers[$i] }} 
						-
						</strong>

					@endfor

				</h4>
			</div>

		</div><!-- end 2nd row-->
		<div class="row">
			<div class="col-md-6">
				<form method="POST" action="{{ url('/current-bowler') }}">
					{{csrf_field()}}
					<div class="form-group">
						<select class="form-control" name="bowlername" required>
							<option value="">Select a player</option>
							@foreach($bowlers as $bowler)
								<option value="{{$bowler->cap}}">{{$bowler->playername}}</option>

							@endforeach
						</select>
						<input type="submit" name="addBowler" value="add" class="btn btn-primary">	
					</div>	
				</form>
				
			</div>
			<div class="col-md-6">
				<table class="table table-bordered table-stripped">
					<tr>
						<th>Player</th>
						<th>Runs</th>
						<th>Over</th>
						<th>Economy</th>
					</tr>
					@for($i = 0; $i < sizeof($all_bowlers); $i ++)
					<tr class="info">
						<td>{{$bowlerNames[$i]->playername}}</td>
						<td>{{$all_bowlers[$i]}}</td>
						<td>{{$totalOver[$i]->over}}</td>
						<td>{{$all_bowlers[$i]/$totalOver[$i]->over}}</td>
					</tr>

					@endfor
				</table>
			</div>
		</div>

	</div><!--end container-->
	

@endsection