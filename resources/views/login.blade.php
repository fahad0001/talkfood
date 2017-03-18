
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
            @if (Session::get('status'))
            <div class="alert alert-danger">
                {{Session::get('status')}}
            </div>
            @endif
            @if (Session::get('success'))
            <div class="alert alert-success">
                {{Session::get('success')}}
            </div>
            @endif
        <form class="form-horizontal" method="post" action="{{URL::to('login')}}">
            {{Csrf_field()}}
            <div class="form-group">
                      <label class="control-label col-sm-2" for="email">Email:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" required name="email" placeholder=" Email">
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="password"> Password:</label>
                      <div class="col-sm-10">
                        <input type="password" class="form-control" required name="password" placeholder=" Password">
                      </div>
                    </div>
                   
                    <button type="submit" class="btn btn-danger col-md-offset-2" style="border-radius:5px;">Submit</button>
                    <a href="{{URL::to('forgotPassword')}}" class="col-md-offset-1 Forgt" style="">Forgot Password ?</a>
        </form>
        <div class="social-auth-links text-center">
            <p>- OR -</p>
            <a href="{{URL::to('auth/facebook')}}" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Login using
                Facebook</a>
            <a href="{{URL::to('auth/google')}}" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Login using
                Google+</a>
            <a href="{{URL::to('auth/twitter')}}" class="btn btn-block btn-social btn-twitter btn-flat"><i class="fa fa-twitter"></i> Login using
                Twitter</a>
            <a href="{{URL::to('auth/linkedin')}}" class="btn btn-block btn-social btn-linkedin btn-flat"><i class="fa fa-linkedin"></i> Login using
                Linkedin</a>
             
            </div>
    </div>
        </section>
</header>
@include('customer.layout.navigation')
@endsection
@section('style')
<style>
.registration-form{
    background-color:rgba(0, 0, 0, 0.9);
    border-radius: 5px;
    padding-bottom: 23px;
    margin-bottom: 20px;
}
.btn{
border-radius:5px;
color:white;

}
.btn-facebook{
    background-color:#2d4373;
}
.btn-facebook:hover{
    background-color:white;
    color:#2d4373;
}
.btn-google{
    background-color:#dd4b39;
}
.btn-google:hover{
    background-color:white;
    color:#dd4b39;
}
.btn-twitter{
    background-color:#1da1f2;
}
.btn-twitter:hover{
    background-color:white;
    color:#1da1f2;
}
.btn-linkedin{
    background-color:#01649b;
}
.btn-linkedin:hover{
    background-color:white;
    color:#01649b;
}
.btn-email{
    background-color:grey;
}
.btn-email:hover{
    background-color:white;
    color:#grey;
}
.Forgt{
border-radius:5px;
color:white;
font-size:16px;
font-weight:bold;
}
</style>
@endsection




