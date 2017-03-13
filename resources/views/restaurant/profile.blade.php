@extends('layout.master')
@section('title')
Restaurant Dashboard
@endsection

@section('content')
<div class="row">
    <!-- PAGE CONTENT BEGINS -->


    <!---form start-->
    <div class="col-xs-8 container">
        <!-- left column -->
      <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Profile Info</h3>
            </div>

            <form class="form-horizontal" action="{{URL::to('/restaurant/edit')}}" role="form" method="POST">
            {!! csrf_field() !!}
                <div class="form-group">
                    <label class="col-md-3 control-label">First Name:</label>
                    <div class="col-md-8">
                        <input class="form-control" name="fname" type="text" value="{{$user->first_name}}">
                </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Last Name:</label>
                    <div class="col-lg-8">
                        <input class="form-control" name="lname" type="text" value="{{$user->last_name}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Restaurant Name:</label>
                    <div class="col-lg-8">
                        <input class="form-control" name="rname" type="text" value="{{$restInfo->rest_name}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Kitchen Type:</label>
                    <div class="col-lg-8">
                        <input class="form-control" name="ktype" type="text" value="{{$restInfo->kitchen_type}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Street No.</label>
                    <div class="col-md-8">
                        <input class="form-control" name="rstreet" type="text" value="{{$restInfo->rest_street}}">
                    </div>
                </div>
               <div class="form-group">
                    <label class="col-md-3 control-label">State/Province:</label>
                    <div class="col-md-8">
                        <input class="form-control" name="rstpr" type="text" value="{{$restInfo->rest_state_province}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">City:</label>
                    <div class="col-md-8">
                        <input class="form-control" name="rcity" type="text" value="{{$restInfo->rest_city}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Country:</label>
                    <div class="col-md-8">
                        <input class="form-control" name="rcountry" type="text" value="{{$restInfo->rest_country}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Postal Code: </label>
                    <div class="col-md-8">
                        <input class="form-control" name="rpostal" type="text" value="{{$restInfo->rest_postal_code}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Email:</label>
                    <div class="col-lg-8">
                        <input class="form-control" type="email" name="email" value="{{$user->email}}">
                    </div>
                </div>
               
                <div class="form-group">
                    <label class="col-md-3 control-label">Change Logo:</label>
                    <div class="col-md-8">
                        <input type="file" name="rlogo" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        <input type="submit" class="btn btn-primary" value="Save Changes">
                        <span></span>
                        <input type="reset" class="btn btn-default" value="Cancel">
                    </div>
                </div>
            </form>
      </div>
        </div>
    <!--</div>-->
    <!-- end form -->
</div>

@endsection

