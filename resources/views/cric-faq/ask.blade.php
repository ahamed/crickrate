@extends('layouts.app')
@section('title','Ask your Question')
@section('styles')
	<link rel="stylesheet" href="/css/animate.css">
    <link rel="stylesheet" href="/css/faq/style.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway|Exo+2|Marcellus|Montserrat+Alternates|Oxygen|Quattrocento|Quicksand|Tangerine|Ubuntu" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/navdesign.css">
    <link rel="stylesheet" href="/css/font-awesome.css">

@endsection

@section('content')
	<div class="container">
		<div class="row" style="margin-top: 150px;">
			<div class="col-md-2">
				
			</div>
			{{-- ends col md 2 --}}
			<div class="col-md-10">
				<form action="/post/question" method="POST" >
					{{csrf_field()}}
					<div class="form-group">
						<input type="text" class="form-control" name="title" placeholder="Give a title of your question.">
					</div>
					<div class="editor-control">
						<ul class=" editor-nav">
							<li><a href="#" class="embolden"><b>B</b></a></li>
							<li><a href="#" class="italic"><b><i>I</i></b></a></li>
							<li><a href="#" class="underline"><b><u>U</i></u></a></li>
						</ul>
					
					</div>
					
					<div class="form-group">
						<textarea class="form-control textEditor" name="story" id="story" cols="30" rows="10">Some default text</textarea>
					</div>
					<div class="form-group">
						<input type="text" name="caption" placeholder="Add tags seperated by COMMA (,)" class="form-control pull-left" style="width: 60%;">
						<button type="submit" id="postbtn" name="postbtn" class="btn btn-modal pull-right" style="width: 150px;">Save Story</button>
					</div>
				</form>
					
			</div>
			{{-- ends col md 10 --}}
		</div>
		{{-- end first row	 --}}
		<div class="row" style="margin-top: 40px;">
			<div class="col-md-2">
				
			</div>
			<div class="col-md-10">
				<div class="display"></div>
			</div>
		</div>
		{{-- end of 2nd row --}}
	</div>
	{{-- end of container --}}

	<script>
		
			

	$(document).ready(function() {
		$('.textEditor').keyup(function(){
			$('.display').html($(this).val());
		});
    $('.embolden').click(function(){
        var highlight = getSelectionText();  
        var span = '<strong>' + highlight + '</strong>';
        var text = $('.textEditor').val();
        //alert(highlight);
        $('.textEditor').val(text.replace(highlight, span));
        $('.display').html($('.textEditor').val());

    });
     $('.italic').click(function(){
        var highlight = getSelectionText();  
        var span = '<i>' + highlight + '</i>';
        var text = $('.textEditor').val();
        //alert(highlight);
        $('.textEditor').val(text.replace(highlight, span));
        $('.display').html($('.textEditor').val());

    });
      $('.underline').click(function(){
        var highlight = getSelectionText();  
        var span = '<u>' + highlight + '</u>';
        var text = $('.textEditor').val();
        //alert(highlight);
        $('.textEditor').val(text.replace(highlight, span));
        $('.display').html($('.textEditor').val());

    });


   function getSelectionText() {
	    if (window.getSelection) {
	        try {
	            var ta = $('textarea').get(0);
	            return ta.value.substring(ta.selectionStart, ta.selectionEnd);
	        } catch (e) {
	            console.log('Cant get selection text')
	        }
	    } 
	    // For IE
	    if (document.selection && document.selection.type != "Control") {
	        return document.selection.createRange().text;
	    }
	}
       	 
});
		
	</script>

	<script language="javascript" type="text/javascript">
	    $(function() {
	       $("form").submit(function(e) {
	          $.post($(this).attr("action"), // url 
			  $(this).serialize(), // data
	 		 function (data) { //success callback function
	     		alert("Edit successful");
	 		 }).error(function () {
	     		 alert('failure'); 
	  			});
	             e.preventDefault();
	          });
	       });
	</script>

@endsection