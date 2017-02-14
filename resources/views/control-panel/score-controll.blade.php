@extends('layouts.app'); @section('title','Score Controller index'); @section('content')
<div class="container">
    <div class="row row-content">
        <div class="col-md-8 col-md-offset-2">
            <form action="/score" method="POST">
            {{csrf_field()}}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <select name="team1" id="" class="form-control" required="">
                            <option value="">Select Toss winning team</option>
                            <option value="Aus">Australia</option>
                            <option value="Ban">Bangladesh</option>
                            <option value="Eng">England</option>
                            <option value="Ind">India</option>
                            <option value="Ir">Ireland</option>
                            <option value="Nz">Newzeland</option>
                            <option value="Pak">Pakistan</option>
                            <option value="Rsa">South Africa</option>
                            <option value="We">Westindis</option>
                            <option value="Zim">Zimbabwe</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <select name="team2" id="" class="form-control" required="">
                            <option value="">Select Oponent team</option>
                            <option value="Aus">Australia</option>
                            <option value="Ban">Bangladesh</option>
                            <option value="Eng">England</option>
                            <option value="Ind">India</option>
                            <option value="Ir">Ireland</option>
                            <option value="Nz">Newzeland</option>
                            <option value="Pak">Pakistan</option>
                            <option value="Rsa">South Africa</option>
                            <option value="We">Westindis</option>
                            <option value="Zim">Zimbabwe</option>
                        </select>
                    </div>
              	</div>
            </div>
            <div class="row">
            	<div class="col-md-6">
            		<div class="form-group">
            			<input type="text" name="match_id" class="form-control" placeholder="Enter Match Id">
            		</div>
            	</div>
            	<div class="col-md-6">
            		<div class="form-group">
            			<select name="innings" id="" required="" class="form-control">
            				<option value="">Select innings number</option>
            				<option value="1st">1st Innings</option>
            				<option value="2nd">2nd Innings</option>
            			</select>
            		</div>
            	</div>
            </div>
            <div class="row">
            	<div class="col-md-8 col-md-offset-2">
            		<div class="form-group">
            			<input type="submit" value="Go" name="go" class="btn btn-primary btn-block">
            		</div>
            	</div>
            </div>
		</form>
        </div>
    </div>
</div>
@endsection
