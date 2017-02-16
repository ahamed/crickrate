@extends('layouts.app')
@section('title','blog-home')

@section('styles')
	<link rel="stylesheet" href="/css/animate.css">
    <link rel="stylesheet" href="/css/blog/style.css">
    <link href="https://fonts.googleapis.com/css?family=Exo+2|Marcellus|Montserrat+Alternates|Oxygen|Quattrocento|Quicksand|Tangerine|Ubuntu" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/navdesign.css">
    <link rel="stylesheet" href="/css/font-awesome.css">
@endsection

@section('content')


	{{-- include navbar here --}}
	@include('layouts.menu')
	<div class="container" style="margin-top: 100px;">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<div class="list-group">
					@foreach($stories as $story)
					
					<div  class="list-group-item list-item">
						<div class="row">
							<div class="col-md-4">
								<img src="{{ '/storage/'.$story->image }}" class="img ima-thumbnails" width="100%" height="200" alt="No image found">
							</div>
							<div class="col-md-8">
								<h4>{{$story->title}}</h4>
								<hr>
								<p>{{substr($story->post,0,300)}}...</p>
								<a href="/story/{{$story->id}}" class="btn btn-modal">Read more</a>
							</div>
						</div>
					</div>
					
					@endforeach
				</div>
	
			</div>
			{{-- end col-md-10	 --}}
		</div>
		{{-- end first row --}}
	</div>
	{{-- end container --}}


@endsection