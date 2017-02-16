@extends('layouts.app')
@section('title','blog-home')

@section('styles')
	<link rel="stylesheet" href="/css/animate.css">
    <link rel="stylesheet" href="/css/faq/style.css">
    <link href="https://fonts.googleapis.com/css?family=Exo+2|Marcellus|Montserrat+Alternates|Oxygen|Quattrocento|Quicksand|Tangerine|Ubuntu" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/navdesign.css">
    <link rel="stylesheet" href="/css/font-awesome.css">
@endsection

@section('content')


	{{-- include navbar here --}}
	@include('layouts.faq-menu')
	<div class="container" style="margin-top: 100px;">
		<div class="row">
			<div class="col-md-9">
				<div class="list-group">
				@for($i = 0 ; $i < 4; $i++)
					<div  class="list-group-item list-item">
						<div class="row">
							<div class="col-md-2 ">
								<div class="row">
									<div class="col-md-12 info">
										<h4>0 <small>Votes</small></h4>
									</div>
								</div>
								{{-- end vote row --}}
								<div class="row">
									<div class="col-md-12 info">
										<h4>0 <small>Answers</small></h4>
									</div>
								</div>
								{{-- end answers row --}}
								<div class="row">
									<div class="col-md-12 info">
										<h4>0 <small>Comments</small></h4>
									</div>
								</div>
								{{-- end comments row --}}

							</div>
							<div class="col-md-10 ">
								<h4>Question Title</h4>
								<hr>
								<p>Portion of the question[...]</p>
								<a href="/question/1" class="btn btn-modal">Read more</a>
								<div class="keyword-wrapper">
									<a href="#" class="btn btn-keyword ">Keyword1</a><a href="#" class="btn btn-keyword">Keyword2</a><a href="#" class="btn btn-keyword">Keyword3</a>	
								</div>
								
							</div>
							
						</div>
					</div>
					{{-- end the list-group-item --}}
					@endfor
					
			
				</div>
	
			</div>
			{{-- end col-md-10	 --}}
			<div class="col-md-3"></div>
			{{-- end col-md-2 --}}
		</div>
		{{-- end first row --}}
	</div>
	{{-- end container --}}


@endsection