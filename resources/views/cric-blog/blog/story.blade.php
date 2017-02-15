@extends('layouts.app')

@section('title','Cric Blog')
	
@section('styles')

	
    <link rel="stylesheet" href="/css/animate.css">
    <link rel="stylesheet" href="/css/blog/style.css">
    <link href="https://fonts.googleapis.com/css?family=Exo+2|Marcellus|Montserrat+Alternates|Oxygen|Quattrocento|Quicksand|Tangerine|Ubuntu|Sahitya" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="/css/navdesign.css">
    <link rel="stylesheet" href="/css/font-awesome.css">
@endsection

@section('content')

	{{-- make a navbar first --}}
	{{-- Include navbar here --}}
	@include('layouts.menu')
	
	{{-- start container named blogContainer --}}
	<div class="container" id="blogContainer">
		{{-- start first row --}}
		<div class="row">
			<div class="col-md-2 left-bar">
				<h1 class="brand">Option Pane</h1>
				<ul>
					@foreach($contents as $content)
					<li><a href="/story/{{$content->id}}">{{$content->title}}</a></li>
					@endforeach
				</ul>
			</div>
			{{-- end col-md-4 --}}


			{{-- this column would be the main content part. --}}
			{{-- every other rows are inside this --}}
			<div class="col-md-10 right-bar ">
				<h1 class=" brand">Blog Contents</h1>
				<div class="row">
					
					<div class="col-md-12">
						<h2 class="lead">{{$stories->title}}</h2>
						<figure class="cap-left">
							<img src="{{'/storage/'.$stories->image}}" alt="" class="blog-img">
							<figcaption><h5 class="blog-img-title">{{$stories->caption}}</h5>	</figcaption>
						</figure>	
					</div>
					<div class="row" id="feature">
						<div class="col-md-1 col01">
							<div class="share-icon">
								<span class="brand">232 Shares</span><hr>

								<ul class="nav share-nav">
									<li><a href="#" class="btn btn-link"><span class="fa fa-facebook fa-2x"></span></a></li><hr>
									<li><a href="#" class="btn btn-link"><span class="fa fa-twitter fa-2x"></span></a></li><hr>
									<li><a href="#" class="btn btn-link"><span class="fa fa-google-plus fa-2x"></span></a></li><hr>
									
								</ul>
							</div>
							
						
						</div>
						<div class="col-md-11 col02 ">
							<div>{!! $stories->post !!}</div>

						</div>
					</div>
					
					
				</div>
				{{-- end first row inside the blog content --}}
				{{-- Check if the logged in or not --}}
				@if(Auth::check())
				{{-- start 2nd row which may called the comment row --}}
				<div class="row">
					<div class="col-md-1"></div>

					<div class="col-md-11">
						<hr>
						<h2 class="brand">Leave a comment.</h2>
						<form action="/comment/{{$stories->id}}" method="POST">
							{{csrf_field()}}
							<div class="form-group">
								<textarea name="comment" id="comment" cols="30" rows="10" class="form-control"></textarea>
							</div>
							<div class="form-group">
								<input type="submit" value="Submit" class="btn btn-modal pull-right" style="width: 200px;">
							</div>
							
						</form>
					</div>
				</div>

				{{-- end of comment row --}}
				{{-- start a row for displaying comments and replys --}}
				<div class="row">

					<div class="col-md-2">
						
					</div>
					{{-- end left side col 2 --}}
					<div class="col-md-10">
						<h4 class="brand">Comments</h4>	
						<hr>
						@if($comments->isEmpty())
						<h5 class="brand">No Comment found</h5>

						@else
						@foreach($comment_user as $comment)
						
							<div class="commenter">
								<h4 class="brand"><a href="#">{{$comment->username->name}}</a> <small>on {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$comment->created_at)->format('l jS \\of F Y h:i:s A')}}</small></h4>
							</div>
							<div class="reply-content">
								<p>{!! $comment->comment !!}</p>
							</div>
							<blockquote class="blockquote">
								@foreach($reply_user as $reply)
								@if($comment->id == $reply->comment_id)
								<div class="replyer">
									<h6 class="brand replyer">
										
										<a href="#">{{$reply->replyes->name}}</a>  <small>on {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$reply->created_at)->format('l jS \\of F Y h')}}</small>

										
									</h6>
								</div>
								<div class="reply-content">
									<p>{!! $reply->reply !!}</p>
								</div>
								<hr>
								@endif
								@endforeach
								<form action="/reply/{{$comment->post_id}}/{{$comment->id}}" method="POST">
								{{csrf_field()}}
								<div class="form-group">
									<input type="text" name="reply" placeholder="Reply and hit return" class="form-control reply">
									<input type="submit" name="go" class="hidden">
								</div>
							</form>
							
							</blockquote>
							
						
						
						@endforeach
						@endif
					</div>
					{{-- ends right side col 10 --}}
				</div>


				{{-- end displaying comments and replies --}}
				@endif
			</div>
			{{-- end col-md-8 --}}
		</div>
		{{-- end first row --}}
		{{-- start footer here	 --}}
		<div class="footer">
			
		</div>
		{{-- end of footer --}}
	</div>
	{{-- End blogContainer --}}

	<script>
		$(window).scroll(function(){
			var top = $(window).scrollTop();
			

			if(top > 650){
				$('.col01').addClass('share');
				$('.col02').addClass('context');
			}else{
				$('.col01').removeClass('share');
				$('.col02').removeClass('context');
			}
		});
	</script>

	

@endsection