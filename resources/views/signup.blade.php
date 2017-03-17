
@extends('customer.layout.master')
@section('content')
<header>
    <section>
        <div class="col-md-4 col-md-offset-4 registration-form" >  
            <h1 class="text-center" style="margin-bottom:30px;"> Sign Up</h1>
                   
        <div class="social-auth-links text-center">
            
            <a href="{{URL::to('auth/facebook')}}" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Login using
                Facebook</a>
            <a href="{{URL::to('auth/google')}}" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Login using
                Google+</a>
            <a href="{{URL::to('auth/twitter')}}" class="btn btn-block btn-social btn-twitter btn-flat"><i class="fa fa-twitter"></i> Login using
                Twitter</a>
            <a href="{{URL::to('auth/linkedin')}}" class="btn btn-block btn-social btn-linkedin btn-flat"><i class="fa fa-linkedin"></i> Login using
                Linkedin</a>
                <p>- OR -</p>
             <a href="{{URL::to('signup/email')}}" class="btn btn-block btn-social btn-email btn-flat"><i class="fa fa-navigation"></i> Login using
                Email</a>
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
</style>
@endsection

