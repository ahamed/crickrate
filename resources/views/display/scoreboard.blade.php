@extends('layouts.app') 
@section('title','Scoreboard') 
@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/mystyle.css">
    <link rel="stylesheet" type="text/css" href="/css/navdesign.css">
    <link rel="stylesheet" href="/css/animate.css">
@endsection
@section('content') {{-- add a jumbotron here --}}
<div class="container" id="myContainer">
    <div class="row" id="myJumbo">
        <div class="col-md-6">
            <h3>{{$batting1st}} : {{$total_runs1st}}/{{$wickets1st}}</h3> @foreach ( $current_batsmen1st as $batsman)
            <span> 
                @if($batsman->onStrike == 1)  
                <strong style="color: yellow">
                {{$batsman->name}} - {{$batsman->run}}(<strong style="color:yellow;">{{$batsman->ball}}</strong>)
                </strong>
                @else
                <strong>
                <span class="fa fa-ravelry glyphicon glyphicon-gear"></span>{{$batsman->name}} - {{$batsman->run}}(<strong>{{$batsman->ball}}</strong>)
            </strong>
            @endif
            </span>
            <br> @endforeach
        </div>
        {{-- end left side column --}} {{-- start right side col --}}
        <div class="col-md-6 ">
            <div class="pull-right">
                <h3>Over : {{$overcount1st}}</h3>
                <h4>Extra : {{$extra1st}}</h4>
            </div>
        </div>
        {{-- end col-md-12 of first row --}}
    </div>
    {{-- end first row --}}
    <div class="row">
        <div class="col-md-8">
            {{-- make a nav tab here --}}
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#1st" aria-controls="1st" role="tab" data-toggle="tab">1st Innings</a></li>
                <li role="presentation"><a href="#2nd" aria-controls="2nd" role="tab" data-toggle="tab">2nd Innings</a></li>
            </ul>
            {{-- end of nav tab here --}}
            <div class="tab-content" id="myTabContent">
                <div id="1st" role="tabpanel" class="tab-pane fade in active">
                    @if($start1st>0)
                    <div class="row">
                        <div class="col-md-12">
                            <h4><strong>{{$batting1st}} 1st innings</strong></h4>
                            <table class="table table-responsive table-bordered table-stripped" id="scoreboard">
                                <tr>
                                    <th>Name</th>
                                    <th colspan="3">Status</th>
                                    <th>R</th>
                                    <th>B</th>
                                    <th>4's</th>
                                    <th>6's</th>
                                    <th>S/R</th>
                                </tr>
                                {{-- get data and display here --}} @foreach( $bats1st as $bat) 
                                @if($bat->isActive == 1)
                                <tr class="success">
                                    @if($bat->onStrike == 1)
                                    <td><button type="button" class="btn btn-link" data-toggle="modal" data-target="#batsman{{$bat->id}}" style="color: red;">{{$bat->name}}</button></td>
                                    @else
                                    <td><button type="button" class="btn btn-link" data-toggle="modal" data-target="#batsman{{$bat->id}}">{{$bat->name}}</button></td>
                                    @endif
                                    <td colspan="3">{{$bat->outStatus}}</td>
                                    <td>{{$bat->run}}</td>
                                    <td>{{$bat->ball}}</td>
                                    <td>{{$bat->fours}}</td>
                                    <td>{{$bat->sixs}}</td>
                                    <td>{{$bat->sr}}</td>
                                </tr>
                                @else
                                <tr>
                                    <td><button type="button" class="btn btn-link" data-toggle="modal" data-target="#batsman{{$bat->id}}">{{$bat->name}}</button></td>
                                    <td colspan="3">{{$bat->outStatus}}</td>
                                    <td>{{$bat->run}}</td>
                                    <td>{{$bat->ball}}</td>
                                    <td>{{$bat->fours}}</td>
                                    <td>{{$bat->sixs}}</td>
                                    <td>{{$bat->sr}}</td>
                                </tr>
                                @endif 
                                {{-- start modal for batsman information --}}
                                

                                <div class="modal animated rollIn" tabindex="999" role="dialog" id="batsman{{$bat->id}}">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h1 class="modal-title">{{$bat->name}}</h1>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" name="addBowler" class="btn btn-modal center-block">Change Bowler</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                                {{-- end modal for batsman information --}} 



                                @endforeach
                            </table>
                            {{-- end table here --}}
                        </div>
                        <!--end col-md-8-->
                    </div>
                    <!--end row-->
                    <div class="row">
                        <div class="col-md-12">
                            <h4><strong>{{$bowling1st}} bowling 1st innings</strong></h4>
                            <table class="table table-bordered table-stripped">
                                <tr>
                                    <th>Player</th>
                                    <th>Runs</th>
                                    <th>Over</th>
                                    <th>Maiden</th>
                                    <th>Wicket</th>
                                    <th>Economy</th>
                                </tr>
                                @for($i = 0; $i
                                < sizeof($bowlerNames1st); $i ++) <tr class="info">
                                    @if($all_bowlers1st[$i]->onStrike == 1)
                                    <td style="color: red;"><a href="" style="color: red;">{{$bowlerNames1st[$i]->playername}}<strong >*</strong></a></td>
                                    @else
                                    <td><a href="">{{$bowlerNames1st[$i]->playername}}</a></td>
                                    @endif
                                    <td>{{$all_bowlers1st[$i]->run}}</td>
                                    <td>{{$all_bowlers1st[$i]->over.".".$all_bowlers1st[$i]->ball}}</td>
                                    <td>{{$all_bowlers1st[$i]->maiden}}</td>
                                    <td>{{$all_bowlers1st[$i]->wicket}}</td>
                                    <td>{{$all_bowlers1st[$i]->economy}}</td>
                                    </tr>
                                    @endfor
                            </table>
                        </div>
                        {{-- end 2nd row's col md 9 --}}
                    </div>
                    @else
                    <h2><strong style="color:red">The Match is not start yet . Wait untill it starts.</strong></h2> @endif {{-- end 1st column --}} {{-- start column for 2nd innigs --}}
                </div>
                <div id="2nd" role="tabpanel" class="tab-pane fade">
                    @if($start2nd>0) @if($pitch1st>=2)
                    <div class="row">
                        <div class="col-md-12">
                            <h4><strong>{{$batting1st}} 2nd innings</strong></h4>
                            <table class="table table-responsive table-bordered table-stripped" id="scoreboard">
                                <tr>
                                    <th>Name</th>
                                    <th colspan="3">Status</th>
                                    <th>R</th>
                                    <th>B</th>
                                    <th>4's</th>
                                    <th>6's</th>
                                    <th>S/R</th>
                                </tr>
                                {{-- get data and display here --}} @foreach( $bats1st as $bat) @if($bat->isActive == 1)
                                <tr class="success">
                                    @if($bat->onStrike == 1)
                                    <td><a href="" style="color: red;">{{$bat->name}}</a></td>
                                    @else
                                    <td><a href="">{{$bat->name}}</a></td>
                                    @endif
                                    <td colspan="3">{{$bat->outStatus}}</td>
                                    <td>{{$bat->run}}</td>
                                    <td>{{$bat->ball}}</td>
                                    <td>{{$bat->fours}}</td>
                                    <td>{{$bat->sixs}}</td>
                                    <td>{{$bat->sr}}</td>
                                </tr>
                                @else
                                <tr>
                                    @if($bat->onStrike == 1)
                                    <td><a href="" style="color: red;">{{$bat->name}}</a></td>
                                    @else
                                    <td><a href="">{{$bat1st->name}}</a></td>
                                    @endif
                                    <td colspan="3">{{$bat1st->outStatus}}</td>
                                    <td>{{$bat->run}}</td>
                                    <td>{{$bat->ball}}</td>
                                    <td>{{$bat->fours}}</td>
                                    <td>{{$bat->sixs}}</td>
                                    <td>{{$bat->sr}}</td>
                                </tr>
                                @endif @endforeach
                            </table>
                            {{-- end table here --}}
                        </div>
                        <!--end col-md-8-->
                    </div>
                    <!--end row-->
                    <div class="row">
                        <div class="col-md-12">
                            <h4><strong>{{$bowling1st}} bowling {{$inngs}} innings</strong></h4>
                            <table class="table table-bordered table-stripped">
                                <tr>
                                    <th>Player</th>
                                    <th>Runs</th>
                                    <th>Over</th>
                                    <th>Maiden</th>
                                    <th>Wicket</th>
                                    <th>Economy</th>
                                </tr>
                                @for($i = 0; $i
                                < sizeof($bowlerNames1st); $i ++) <tr class="info">
                                    @if($all_bowlers1st[$i]->onStrike == 1)
                                    <td style="color: red;"><a href="" style="color: red;">{{$bowlerNames1st[$i]->playername}}<strong >*</strong></a></td>
                                    @else
                                    <td><a href="">{{$bowlerNames1st[$i]->playername}}</a></td>
                                    @endif
                                    <td>{{$all_bowlers1st[$i]->run}}</td>
                                    <td>{{$all_bowlers1st[$i]->over.".".$all_bowlers1st[$i]->ball}}</td>
                                    <td>{{$all_bowlers1st[$i]->maiden}}</td>
                                    <td>{{$all_bowlers1st[$i]->wicket}}</td>
                                    <td>{{$all_bowlers1st[$i]->economy}}</td>
                                    </tr>
                                    @endfor
                            </table>
                        </div>
                        {{-- end 2nd row's col md 9 --}}
                    </div>
                    {{-- end 2nd row --}} @else {!! "<strong>Match not started yet!</strong>" !!} @endif @else
                    <h2><strong style="color:red">The Match is not start yet or 1st innings is not ends. Wait untill it starts.</strong></h2> @endif
                </div>
                {{-- end 1st column --}} {{-- end of column for 2nd innigs --}}
            </div>
        </div>
        <div class="col-md-4">
            <h1>Commentaries</h1> {{-- make nav tab for commentary here --}} {{-- start nav tab for commentary here --}}
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#1stcmntry" aria-controls="1stcmntry" role="tab" data-toggle="tab">1st Innings</a></li>
                <li role="presentation"><a href="#2ndcmntry" aria-controls="2ndcmntry" role="tab" data-toggle="tab">2nd Innings</a></li>
            </ul>
            {{-- end nav tab for commentary here --}}
            <div class="tab-content">
                <div class="tabpane fade in active" role="tabpanel" id="1stcmntry">
                    @if($start1st>0) {{-- whrite commentry code here --}} @foreach($commentaries1st as $commentary)
                    <ul class="list-group">
                        <li class="list-group-item">
                            <button class="btn btn-danger btn-circle">{{$commentary->over}}</button>
                            {{$commentary->commentary}}, <strong style="color: red; font-size: 20px;">{{$commentary->run}}</strong>
                        </li>
                    </ul>
                    @endforeach {{$commentaries1st->render()}} @else
                    <h2><strong style="color:red">The Match is not start yet. Wait untill it starts.</strong></h2> @endif
                </div>
                <div class="tabpane fade" role="tabpanel" id="2ndcmntry">
                    @if($start2nd>0) {{-- whrite commentry code here --}} @foreach($commentaries2nd as $commentary)
                    <ul class="list-group">
                        <li class="list-group-item">
                            <button class="btn btn-danger btn-circle">{{$commentary->over}}</button>
                            {{$commentary->commentary}}, <strong style="color: red; font-size: 20px;">{{$commentary->run}}</strong>
                        </li>
                    </ul>
                    @endforeach {{$commentaries2nd->render()}} @else
                    <ul class="list-group">
                        <li class="list-group-item"><strong style="color:red">The Match is not start yet or 1st innings is not ends. Wait untill it starts.</strong></li>
                    </ul>
                    @endif
                </div>
            </div>
        </div>
        {{-- end 2nd column --}}
    </div>
    {{-- end of 1st row --}}
</div>
<script>
$(document).ready(function() {
	

		
		setInterval(function() {
        if ($('.tab-pane').hasClass('active')) {
            var id = "#" + $('.tab-pane').attr('id');
            $(id).load(document.URL + " " + id);
        } else {
            console.log("failed");
        }
        //$("#myContainer").load(document.URL+" #myContainer");


    }, 3000);	

    

});
</script>
<!--end container-->. @endsection
