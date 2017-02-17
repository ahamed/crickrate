@extends('layouts.app') 
@section('title','Control panel') 
@section('styles')
    <link rel="stylesheet" type="text/css" href="/css/mystyle.css">
    <link rel="stylesheet" type="text/css" href="/css/navdesign.css">
    <link rel="stylesheet" href="/css/animate.css">
@endsection
@section('content')
<div class="container" id="myContainer">
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
            <h1>Score</h1> @if($pitch
            < 2 ) <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#batsmanModal">
                    Add Batsman
                </button>
                <!-- Modal -->
                <form method="post" action="/add-player/{{$mid}}/{{$inngs}}">
                    {!! csrf_field() !!}
                    <div class="modal animated rollIn" id="batsmanModal" tabindex="999" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color: white;">&times;</span></button>
                                    <h1 class="modal-title" id="myModalLabel">Add a Batsman</h1>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <select class="form-control modal-dropdown" name="playername" required>
                                            <option value="">Select a player</option>
                                            @foreach($batsmen as $batsman)
                                            <option value="{{$batsman->cap.','.$batsman->playername}}">{{$batsman->playername}}</option>
                                            @endforeach
                                        </select>
                                        <!--<input type="submit" name="add" value="add" class="btn btn-primary">    -->
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-modal center-block">Add Batsman</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                @elseif($pitch>=2 && $isTime > 0)
                <form method="POST" action="/add-runs/{{$mid}}/{{$inngs}}">
                    {{csrf_field()}}
                    <div class="form-group">
                        <input type="submit" name="zero" value="0" class="btn btn-primary btn-circle">
                        <input type="submit" name="one" value="1" class="btn btn-primary btn-circle">
                        <input type="submit" name="two" value="2" class="btn btn-primary btn-circle">
                        <input type="submit" name="three" value="3" class="btn btn-primary btn-circle">
                        <input type="submit" name="four" value="4" class="btn btn-primary btn-circle">
                        <input type="submit" name="five" value="5" class="btn btn-primary btn-circle">
                        <input type="submit" name="six" value="6" class="btn btn-primary btn-circle">
                        <a href="/clear/{{$mid}}/{{$inngs}}" class="btn btn-danger btn-circle">clear all</a>
                    </div>
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
                </form>
                @endif
        </div>
        <div class="col-md-6">
            <div class="panel">
                <div class="panel-body">
                    <table class="table table-stripped table-bordered">
                        <tr>
                            <th>Sl.</th>
                            <th>Player</th>
                            <th>Status</th>
                            <th>Runs</th>
                            <th>Ball</th>
                            <th>S/R</th>
                            <th>4's</th>
                            <th>6's</th>
                            <th>Rating</th>
                            <th>Action</th>
                        </tr>
                        @foreach($bats as $bat) @if($bat->isActive)
                        <tr class="success">
                            <td>{{$ind++}}</td>
                            @if($bat->onStrike)
                            <td>{{$bat->name}} <strong style="color: red; font-size: 20px;">*</strong></td>
                            @else
                            <td>{{$bat->name}}</td>
                            @endif
                            <td>{{$bat->outStatus}}</td>
                            <td>{{$bat->run}}</td>
                            <td>{{$bat->ball}}</td>
                            <td>{{$bat->sr}}</td>
                            <td>{{$bat->fours}}</td>
                            <td>{{$bat->sixs}}</td>
                            @if($bat->ball == 0)
                            <td>0</td>
                            @else
                            <td>{{number_format(($bat->rating + (($bat->run / $bat->ball)*0.01)),4,'.','')}}</td>
                            @endif
                            <td><a href="">E</a>/<a href="/delete/{{$bat->id}}">D</a>/
                                <!-- Button trigger modal -->
                                <a type="button" href="" data-toggle="modal" data-target="#myModal{{$bat->id}}">
                                    out
                                </a>
                            </td>
                            <div class="modal animated rollIn" id="myModal{{$bat->id}}" tabindex="" role="dialog" aria-labelledby="myModalLabel" style="z-index: 9999;">
                                <div class="modal-dialog" role="document">
                                    <form action="/out/{{$bat->id}}/{{$mid}}/{{$inngs}}" method="POST">
                                        {{csrf_field()}}
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h1 class="modal-title" id="myModalLabel">How the batsman out?</h1>
                                            </div>
                                            <div class="modal-body">
                                                <div id="form-group">
                                                    <div class="form-group">
                                                        <label class="radio-inline">
                                                            <input type="radio" name="out" value="b"> Bowled
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input type="radio" name="out" value="c"> Catch
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input type="radio" name="out" value="lbw"> LBW
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input type="radio" name="out" value="st"> Stamping
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input type="radio" name="out" value="R"> Runout
                                                        </label>
                                                    </div>
                                                    <div class="form-group " id="outHelper">
                                                        <select class="form-control modal-dropdown" name="helpername" required>
                                                            <option value="">Select a player</option>
                                                            <option value="no">No Helper</option>
                                                            @foreach($bowlers as $bowler)
                                                            <option value="{{$bowler->cap}}">{{$bowler->playername}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" name="endofplayer" class="btn btn-modal center-block">Out</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Out modal write here -->
                            <!-- end modal here-->
                        </tr>
                        @else
                        <tr>
                            <td>{{$ind++}}</td>
                            <td>{{$bat->name}}</td>
                            <td>{{$bat->outStatus}}</td>
                            <td>{{$bat->run}}</td>
                            <td>{{$bat->ball}}</td>
                            <td>{{$bat->sr}}</td>
                            <td>{{$bat->fours}}</td>
                            <td>{{$bat->sixs}}</td>
                            <td>{{number_format($bat->rating,4,'.','')}}</td>
                            <td>
                                <a href="">E</a>/
                                <a href="/delete/{{$bat->id}}">D</a>
                            </td>
                        </tr>
                        @endif @endforeach
                    </table>
                </div>
                <!-- end panel-body-->
            </div>
            <!-- end panel-->
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h2>This over</h2>
            <h4>
                    <!--  Here this over code would be generated -->

                    @for($i = 0; $i < sizeof($thisovers)-1; $i++)

                        <a class="btn btn-danger btn-circle">{{ $thisovers[$i] }}</a>

                    @endfor

                </h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            @if($isTime
            <=0 && $pitch>=2)
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#myModal">
                    Add Bowler
                </button>
                @endif
                <!-- Add a bootstrap modal here -->
                <form method="POST" action="/current-bowler/{{$mid}}/{{$inngs}}">
                    {{csrf_field()}}
                    <div class="modal animated rollIn" tabindex="999" role="dialog" id="myModal">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h1 class="modal-title">Add A bowler here</h1>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <select class="form-control modal-dropdown" name="bowlername" required>
                                            <option value="">Select a player</option>
                                            @foreach($bowlers as $bowler)
                                            <option value="{{$bowler->cap}}">{{$bowler->playername}}</option>
                                            @endforeach
                                        </select>
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
                </form>
        </div>
        <div class="col-md-6">
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
                < sizeof($bowlerNames); $i ++) <tr class="info">
                    @if($all_bowlers[$i]->onStrike == 1)
                    <td style="color: red;">{{$bowlerNames[$i]->playername}}<strong style="color: red; font-size: 20px;">*</strong></td>
                    @else
                    <td>{{$bowlerNames[$i]->playername}}</td>
                    @endif
                    <td>{{$all_bowlers[$i]->run}}</td>
                    <td>{{$all_bowlers[$i]->over.".".$all_bowlers[$i]->ball}}</td>
                    <td>{{$all_bowlers[$i]->maiden}}</td>
                    <td>{{$all_bowlers[$i]->wicket}}</td>
                    <td>{{$all_bowlers[$i]->economy}}</td>
                    </tr>
                    @endfor
            </table>
        </div>
    </div>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#out').click(function() {
            $('#outRow').show('slow');
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        
    });
    </script>
</div>
<!--end container-->
@endsection
