
@extends('customer.layout.master')
@section('content')
<header>
    <section>
        <div class="col-md-4 col-md-offset-4 registration-form" >  
            <h1 class="text-center" style="margin-bottom:30px;"> Login</h1>
            @if ($errors->has())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>        
                @endforeach
            </div>
            @endif
        <form class="form-horizontal" method="post" action="{{URL::to('login')}}">
            {{Csrf_field()}}
            <div class="form-group">
                      <label class="control-label col-sm-2" for="email">Email:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" name="email" placeholder=" Email">
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="password"> Password:</label>
                      <div class="col-sm-10">
                        <input type="password" class="form-control" name="password" placeholder=" Password">
                      </div>
                    </div>
                   
                    <button type="submit" class="btn btn-danger col-md-offset-2" style="border-radius:5px;">Submit</button>
        </form>

    </div>
        </section>
</header>
@include('customer.layout.navigation')

@endsection

