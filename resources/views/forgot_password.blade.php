@extends('customer.layout.master')

@section('content')
<header>
    <section>
        <div class="col-md-4 col-md-offset-4 registration-form" >  
            <h1 class="text-center" style="margin-bottom:30px;"> Forgot Password</h1>
            @if (Session::get('status'))
            <div class="alert alert-danger">
                {{Session::get('status')}}
            </div>
            @endif
        <form class="form-horizontal" method="post" action="{{URL::to('forgotPassword')}}">
            {{Csrf_field()}}
            <div class="form-group">
                      <label class="control-label col-sm-2" for="email">Email:</label>
                      <div class="col-sm-10">
                        <input type="email" class="form-control" required name="email" placeholder=" Email">
                      </div>
                    </div>
                   
                    <button type="submit" class="btn btn-danger col-md-offset-2" style="border-radius:5px;">Send</button>
                    <br><br>
        </form>
    </div>
        </section>
</header>
@include('customer.layout.navigation')

@stop
