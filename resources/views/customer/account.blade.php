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
            <div class='col-sm-12' style='background-color: white; padding-top:10px;padding-bottom:10px;min-height:500px;'>
               
                <div class="col-sm-12">  <h2 class="pull-left">Account Information</h2> <a href="{{URL::to('customer/orders')}}" class="btn btn-danger pull-right">View Orders</a>
                 </div>
                    @if ($errors->has())
            <div class="alert alert-danger" style="    overflow: hidden;">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>        
                @endforeach
            </div>
            @endif
            
             @if (Session::has('message'))
            <div class="alert alert-success" style="    overflow: hidden;">
              
                    {{ Session::get('message') }}<br>        
               </div>
            @endif
                
                    <form class="form-horizontal" method="post" action="{{URL::to('customer/account')}}" enctype="multipart/form-data">
                {{Csrf_field()}}
                <div class="form-group">
                    <label class="control-label col-sm-2"  for="firstname">First Name</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="firstname" placeholder=" First Name" value="{{ Auth::user()->first_name }}">
                        
                    </div>
                    <label class="control-label col-sm-2" for="lastname">Last Name</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="lastname"  placeholder=" Last Name" value="{{ Auth::user()->last_name }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Email:</label>
                    <div class="col-sm-4">
                        <input type="email" class="form-control" name="email" placeholder=" Email" value="{{ Auth::user()->email }}">
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">
                        Canadian Government ID:
                        <span data-toggle="tooltip" title="Upload your ID so you can purchase alcohol. Must be over 18 years of age." class="glyphicon glyphicon-info-sign"></span>
                    </label>
                    <div class="col-sm-4">
                        <input type="file" class="form-control" name="photo" placeholder=" Photo" >
                        @if (isset($photo))
                        <img src="{{URL::to($photo)}}" width="100"/>
                        @endif
                    </div>
                </div>

                <div id="customer-fields"> 
                    <h4 class="text-center">Home Address</h4>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="cust_ship_street">Street</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" value="{{ $cus[0]->street }}" id="cust_ship_street" name="cust_ship_street" placeholder=" Street">
                        </div>
                        <label class="control-label col-sm-2" for="cust_ship_city">City</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="cust_ship_city" placeholder=" City" value="{{ $cus[0]->city }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="cust_ship_state">State/Province</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="cust_ship_state" placeholder=" State/Province" value="{{ $cus[0]->state_province }}">
                        </div>
                        <label class="control-label col-sm-2" for="cust_ship_country">Country</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="cust_ship_country" placeholder=" Country" value="{{ $cus[0]->country }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="cust_ship_zip">Zip/Postal Code</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="cust_ship_zip" placeholder=" Zip/Postal Code" value="{{ $cus[0]->zip_code }}">
                        </div>
                        <label class="control-label col-sm-2" for="cust_ship_phone">Phone Number</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control " name="cust_ship_phone" placeholder=" Phone Number" value="{{ $cus[0]->phone_no }}">
                        </div>
                    </div>



                    <hr  style="max-width:100%" />
                    <h4 class="text-center">Billing Address</h4>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="cust_bill_street">Street</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="cust_bill_street" placeholder=" Street" value="{{ $cus[1]->street }}">
                        </div>
                        <label class="control-label col-sm-2" for="cust_bill_city">City</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="cust_bill_city" placeholder=" City" value="{{ $cus[1]->city }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="cust_bill_state">State/Province</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="cust_bill_state" placeholder=" State/Province" value="{{ $cus[1]->state_province }}">
                        </div>
                        <label class="control-label col-sm-2" for="cust_bill_country">Country</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="cust_bill_country" placeholder=" Country" value="{{ $cus[1]->country }}">
                        </div>
                    </div>
                    <div class="form-group">

                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="cust_bill_zip">Zip/Postal Code</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="cust_bill_zip" placeholder=" Zip/Postal Code" value="{{ $cus[1]->zip_code }}">
                        </div>
                        <label class="control-label col-sm-2" for="cust_bill_phone">Phone Number</label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control " name="cust_bill_phone" placeholder=" Phone Number" value="{{ $cus[1]->phone_no }}">
                        </div>
                    </div>                   
                </div>

                
                
               
                <button type="submit" class="btn btn-danger col-md-offset-2" style="border-radius:5px;">Update</button>
            </form>
            
               

            

               



            </div>
         
        </div>

    </div>


</div>


</section>



@endsection

@section('scripts')
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip({placement: "bottom", trigger: "click"});   
});
</script>
@endsection