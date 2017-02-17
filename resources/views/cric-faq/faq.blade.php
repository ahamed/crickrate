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
				<h3>{{$resources->title}}</h3>
				<hr>
				<div class="row">
					<div class="col-md-2 point">
						<a href="#" class="btn"><span class="fa fa-caret-up fa-3x"></span></a><br>
						<strong class="lead">{{$resources->vote}}</strong><br>
						<a href="#" class="btn"><span class="fa fa-caret-down fa-3x"></span></a><br>
						@if($resources->favorit > 0)
						<a href="#" class="btn" ><i class="fa fa-star fa-2x highlight" ></i></a><br>
						<a><i>{{$resources->favorit}}</i></a>
						@else
						<a href="#" class="btn" ><span class="fa fa-star fa-2x"></span></a>
						@endif
					</div>
					<div class="col-md-10">
						<p class="lead">{{$resources->question}}</p>
					</div>
					{{-- end inner cols --}}
				</div>
				{{-- end inner row --}}
				<div class="row keyword-row">
					<div class="col-md-2"></div>
					<div class="col-md-10">
						<div class="keyword-wrapper">
							@foreach(explode(',',$resources->tag) as $tag)
							<a href="#" class="btn btn-keyword ">{{$tag}}</a>
							@endforeach
						</div>
					</div>
				</div>
				<!--<div class="row comment-row">
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
				</div>-->

				{{-- end row --}}
				@foreach($answers as $answer)
				{{-- start answer list --}}
				<div class="row answer-list">
					<h3 class="brand">Answers</h3><hr>
					<div class="col-md-2 point">
						<a href="#" class="btn"><span class="fa fa-caret-up fa-3x"></span></a><br>
						<strong class="lead">{{$answer->vote}}</strong><br>
						<a href="#" class="btn"><span class="fa fa-caret-down fa-3x"></span></a><br>
						<a href="#" class="btn" ><span class="fa fa-star fa-2x"></span></a>
					</div>
					<div class="col-md-10">
						<p class="lead">
							{{$answer->answer}}
						</p>

						<div class="answer-profile">
							<h6 class="lead">{{$answer->user_id}} at <small>{{$answer->created_at}}</small></h6>
						</div>
						{{-- add comment row for each answers --}}
						<div class="row comment-row">
							<h5 class="brand">Comments</h5><hr>
							@foreach($answer_comments as $comment)
							@if($comment->question_id == $answer->id)
								<div class="replyer">
									<h6 class="brand replyer">
										
										<a href="#">{{$comment->user_id}}</a>  <small>on {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$comment->created_at)->format('l jS \\of F Y h')}}</small>

										
									</h6>
								</div>
								<div class="reply-content">
									<p>{!! $comment->comment !!}</p>
								</div>
								@endif
								@endforeach
								<hr>
								
								<form action="/answer-comment/{{$resources->id}}/{{$answer->id}}" method="POST">
									{{csrf_field()}}
									<div class="form-group">
										<input type="text" name="anscomment" placeholder="Reply and hit return" class="form-control reply">
										<input type="submit" name="go" class="hidden">
									</div>
								</form>
								
								
						</div>
						

						{{-- end comment row  for each answer --}}
					</div>


				</div>
				@endforeach
				{{-- end  answer section here --}}

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
						<form action="/answer/{{$resources->id}}" method="POST">
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