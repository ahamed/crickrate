@extends('layouts.app')
@section('title','Add records')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<form method="post" action="/records">
				{{csrf_field()}}
				<div class="form-group">
					<label for="player">Player</label>
					<input type="text" name="player" class="form-control">
				</div>
				<div class="form-group">
					<label for="Gavg">Global Average</label>
					<input type="number" name="Gavg" class="form-control" step='0.1'>
				</div>
				<div class="form-group">
					<label for="Gsr">Global S/R</label>
					<input type="number" name="Gsr" class="form-control" step='0.1'>
				</div>
				<div class="form-group">
					<label for="Lavg">Last Ten Match Average</label>
					<input type="number" name="Lavg" class="form-control" step='0.1'>
				</div>
				<div class="form-group">
					<label for="Lsr">Last Ten Match S/R</label>
					<input type="number" name="Lsr" class="form-control" step='0.1'>
				</div>
				<div class="form-group">
					<label for="country">Country</label>
					<input type="text" name="country" class="form-control" step='0.1'>
				</div>
				<input type="submit" name="" class="btn btn-primary pull-right" value="Add record" style="margin-top: 8px;">
			</form>
		</div><!--end col -->
	</div><!--end row-->
</div><!--end container-->


@endsection