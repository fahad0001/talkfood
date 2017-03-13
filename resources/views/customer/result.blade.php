@extends('customer.layout.master')
@section('style')
<style>

    .navbar-default .nav>li>a, .navbar-default .nav>li>a {
        color: #222 !important;
    }
    body {
        background-color: #f5f5f5 !important;
    }
    b, strong {
        font-weight: 500 !important;
    }
    
    .rest {
        color:#222;
    }

</style>
@endsection
@section('content')
@include('customer.layout.navigation2')

<section style="padding-top:70px;">

    <div class='container' >

        <div class='row'>

            <h3><b>{{count($data)}} restaurants near you !</b></h3>


        </div>
        <div class='row'>
            <div class='col-sm-12' style='background-color: white;min-height: 800px;padding: 30px;'>
                
                @foreach($data as $d)
                <div class='col-sm-6' style='padding-top:20px;min-height:170px;'>
                    <a href="{{URL::to('/rest')}}/{{$d->rest_id}}" class='rest'>
                    <div class='col-sm-3'>  
                        <img src="{{URL::to('/')}}/uploads/{{$d->rest_logo_path}}" style="width:100%;" /> 
                    </div>
                    <div class='col-sm-9'>
                        <div >
                            <h3 style='margin-top:5px;'><b>{{$d->rest_name}}</b></h3>
                            <p style='margin-bottom: 2px;'>{{$d->kitchen_type}}</p>
                            <p style='margin-bottom: 2px;font-size:15px;'>{{$d->rest_street}},{{$d->rest_city}},{{$d->rest_state_province}} {{$d->rest_postal_code}},{{$d->rest_country}}</p>
                        </div>

                       
                    </div> 
                         </a>

                </div>

                @endforeach
            </div>

        </div>

    </div>


</div>


</section>



@endsection


