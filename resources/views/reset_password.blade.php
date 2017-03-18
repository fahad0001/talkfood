@extends('customer.layout.master')

@section('content')
<header>
    <section>
        <div class="col-md-4 col-md-offset-4 registration-form" >  
            <h1 class="text-center" style="margin-bottom:30px;"> Reset Password</h1>
            @if (Session::get('status'))
            <div class="alert alert-danger">
                {{Session::get('status')}}
            </div>
            @endif
        <form class="form-horizontal" method="post" action="{{URL::to('resetPassword')}}/{{$token}}">
            {{Csrf_field()}}
            <div class="form-group">
                      <label class="control-label col-sm-2" for="password">Password:</label>
                      <div class="col-sm-10">
                        <input type="password" class="form-control" required name="password">
                      </div>
                    </div>
            <div class="form-group">
                      <label class="control-label col-sm-2" for="password">Confirm Password:</label>
                      <div class="col-sm-10">
                        <input type="password" class="form-control" required name="confirm_password">
                      </div>
                    </div>
                   <input type="hidden" class="form-control" name="email" value="@if(isset($user->email)){{$user->email}}@endif">
                    <button type="submit" class="btn btn-danger col-md-offset-2" style="border-radius:5px;">Submit</button>
                    <br><br>
        </form>
    </div>
        </section>
</header>
@include('customer.layout.navigation')

@stop
