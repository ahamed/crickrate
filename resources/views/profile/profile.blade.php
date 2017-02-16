@extends('layouts.app')
@section('title')
	{{Auth::user()->name}}'s Profile
@endsection
@section('styles')
	<link rel="stylesheet" href="/css/animate.css">
    <link rel="stylesheet" href="/css/blog/style.css">
    <link href="https://fonts.googleapis.com/css?family=Exo+2|Marcellus|Montserrat+Alternates|Oxygen|Quattrocento|Quicksand|Tangerine|Ubuntu|Sahitya" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="/css/navdesign.css">
    <link rel="stylesheet" href="/css/font-awesome.css">
@endsection
@section('content')
	
	<div class="container">
		<div class="row wrapper">
			<div class="col-md-5 col-md-offset-1 wrap-left">
				<h4>name of the woner</h4>
				<img src="/images/2.jpg" alt="" class="img-circle">
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum, explicabo. Incidunt adipisci aperiam neque. Aspernatur rem sint eum qui repellat commodi atque voluptatibus nostrum dolore nesciunt iste ea, vitae soluta!</p>
				<button class="btn-circle"><span class="fa fa-envelope-o fa-3x"></span></button>
			</div>
			{{-- end left side --}}
			<div class="col-md-5 col-md-offset-1 wrap-right">
				<h1>Right side</h1>
			</div>
			{{-- end right side --}}
		</div>
		{{-- End first row --}}
	</div>
	{{-- end container	 --}}


@endsection