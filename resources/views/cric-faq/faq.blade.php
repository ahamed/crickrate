@extends('layouts.app')

@section('title','Cric Blog')
	
@section('styles')

	
    <link rel="stylesheet" href="/css/animate.css">
    <link rel="stylesheet" href="/css/faq/style.css">
    <link href="https://fonts.googleapis.com/css?family=Exo+2|Marcellus|Montserrat+Alternates|Oxygen|Quattrocento|Quicksand|Tangerine|Ubuntu|Sahitya" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="/css/navdesign.css">
    <link rel="stylesheet" href="/css/font-awesome.css">
@endsection

@section('content')

	{{-- make a navbar first --}}
	{{-- Include navbar here --}}
	@include('layouts.faq-menu')
	
	{{-- start container named blogContainer --}}
	<div class="container" id="blogContainer">
		
		<div class="row first-row">
			<div class="col-md-9">
				<h3>While fetching Chat History I am Not getting Both user History from Openfire</h3>
				<hr>
				<div class="row">
					<div class="col-md-2 point">
						<a href="#" class="btn"><span class="fa fa-caret-up fa-3x"></span></a><br>
						<strong class="lead">1200</strong><br>
						<a href="#" class="btn"><span class="fa fa-caret-down fa-3x"></span></a><br>
						<a href="#" class="btn"><span class="fa fa-star fa-2x"></span></a>
					</div>
					<div class="col-md-10">
						<p class="lead">We load Google Analytics (Universal) via Google Tag Manager and I can't find any way to force it to load the analytics.js script itself over SSL; we set forceSSL via the fields to set options, but by the time it applies that it has already loaded the initial script over plain HTTP.<br><br>It looks like GTM checks whether it's on an HTTPS URL and then loads GA over HTTP if so, but I'd prefer to force it over HTTPS instead. Is there any way to do this?</p>
					</div>
					{{-- end inner cols --}}
				</div>
				{{-- end inner row --}}
				<div class="row keyword-row">
					<div class="col-md-2"></div>
					<div class="col-md-10">
						<div class="keyword-wrapper">
							<a href="#" class="btn btn-keyword ">Keyword1</a><a href="#" class="btn btn-keyword">Keyword2</a><a href="#" class="btn btn-keyword">Keyword3</a>	
						</div>
					</div>
				</div>
				<div class="row comment-row">
					<div class="col-md-2"></div>
					<div class="col-md-10">
						<ul class="list-group">
							<li class="list-group-item">Comment 1</li>
							<li class="list-group-item">Comment 2</li>
							<li class="list-group-item">Comment 3</li>
							<li class="list-group-item">Comment 4</li>
						</ul>
						<div class="form-group" id="comment">
							<textarea  id="" name="comment" class="form-control" rows="6"></textarea>
							<input type="button" class="btn btn-modal" value="Add Comment" style="margin-top: 5px;">	
						</div>
						
						<a href="#" class="btn btn-link" id='addcomment'>Add a comment</a>

					</div>
				</div>

				{{-- end row --}}

				{{-- start answer list --}}
				<div class="row answer-list">
					<h3 class="brand">Answers</h3><hr>
					<div class="col-md-2 point">
						<a href="#" class="btn"><span class="fa fa-caret-up fa-3x"></span></a><br>
						<strong class="lead">1200</strong><br>
						<a href="#" class="btn"><span class="fa fa-caret-down fa-3x"></span></a><br>
						<a href="#" class="btn"><span class="fa fa-star fa-2x"></span></a>
					</div>
					<div class="col-md-10">
						<p class="lead">
							As of Bootstrap 3.0.1 there is a new center-block helper class.<br><br>Reference URL: http://getbootstrap.com/css/#helper-classes-center<br><br>You can still use text-center to center text.<br><br>Demo URL: http://bootply.com/91632<br><br>EDIT As mentioned in the comments, center-block works on column contents and block elements but won't work on the column itself (col-* divs) because Bootstrap uses float. Generally, the preferred method of centering columns is to use the Bootstrap grid and offsets like this..<br><br>Bootstrap 3.x centering examples<br><br>Bootstrap 4.x centering examples<br><br><b>UPDATE</b><br><br>In Bootstrap 4, center-block is replaced by mx-auto
						</p>
						{{-- add comment row for each answers --}}
						<div class="row comment-row">
							<h5 class="brand">Comments</h5><hr>
							<div class="col-md-12">
								<ul class="list-group">
									<li class="list-group-item">Comment 1</li>
									<li class="list-group-item">Comment 2</li>
									<li class="list-group-item">Comment 3</li>
									<li class="list-group-item">Comment 4</li>
								</ul>
								<div class="form-group" id="comment">
									<textarea  id="" name="comment" class="form-control" rows="6"></textarea>
									<input type="button" class="btn btn-modal" value="Add Comment" style="margin-top: 5px;">	
								</div>
								
								<a href="#" class="btn btn-link" id='addcomment'>Add a comment</a>

							</div>
						</div>

						{{-- end comment row  for each answer --}}
					</div>
				</div>

			</div>
			{{-- end col-md-9 --}}
			<div class="col-md-3">
				
			</div>
			{{-- end col-md-3 --}}
		</div>
		{{-- end first row --}}
	


		{{-- start answer here --}}
		{{-- start 2nd row which may called the comment row --}}
				<div class="row">
					<div class="col-md-1"></div>

					<div class="col-md-8">
						<hr>
						<h2 class="brand">Your Answer</h2>
						<form action="/comment/1" method="POST">
							{{csrf_field()}}
							<div class="form-group">
								<textarea name="answer" id="answer" cols="30" rows="10" class="form-control"></textarea>
							</div>
							<div class="form-group">
								<input type="submit" value="Submit" class="btn btn-modal pull-right" style="width: 200px;">
							</div>
							
						</form>
					</div>
					<div class="col-md-3"></div>
				</div>

				{{-- end of comment row --}}

		
		{{-- start footer here	 --}}
		<div class="footer">
			
		</div>
		{{-- end of footer --}}
	</div>
	{{-- End blogContainer --}}

	

	<script>

		$('#addcomment').click(function(){
			$('#comment').show('slow');
		});

	</script>

@endsection