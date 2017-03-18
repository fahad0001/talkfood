@extends('customer.layout.master')
@section('content')
<header>
    <section>
        <div class="col-md-6 col-md-offset-3 registration-form" >  
            <h1 class="text-center" style="margin-bottom:30px;"> Registration</h1>
            @if ($errors->has())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>        
                @endforeach
            </div>
            @endif
            
             @if (Session::has('message'))
            <div class="alert alert-success">
              
                    {{ Session::get('message') }}<br>        
               </div>
            @endif
            <form class="form-horizontal" method="post" action="{{URL::to('signup/store')}}@if(isset($returnurl))?returnurl=checkout @endif" enctype="multipart/form-data">
                {{Csrf_field()}}
                <div class="form-group">
                    <label class="control-label col-sm-2"  for="firstname">First Name</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="firstname" placeholder=" First Name">
                        
                    </div>
                    <label class="control-label col-sm-2" for="lastname">Last Name</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="lastname"  placeholder=" Last Name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="radio-inline col-md-offset-2">
                        <input type="radio"  name="account" value="cus" id="customer-account" checked>Open Customer Account</label>
                    <label class="radio-inline"><input type="radio" value="sell" name="account" id="seller-account" >Open Seller Account</label>
                    <hr  style="max-width:100%" />
                </div>

                <div id="resturant-fields" style="display:none" >
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="rest_name">Restaurant Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="rest_name"   placeholder=" Restaurant Name">
                        </div>
                        <label class="control-label col-sm-2" for="kitchen_type">Kitchen Type</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="kitchen_type" placeholder=" Kitchen Type">
                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="rest_street">Street</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="rest_street"  placeholder=" Street">
                            
                        </div>
                        <label class="control-label col-sm-2" for="rest_city">City</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="rest_city" placeholder=" City">
                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="rest_state">State/Province</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="rest_state" placeholder=" State/Province">
                            
                        </div>
                        <label class="control-label col-sm-2" for="rest_country">Country</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="rest_country" placeholder=" Country">
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="rest_zip">Zip/Postal Code</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="rest_zip" placeholder=" Zip/Postal Code">
                            
                        </div>
                        <label class="control-label col-sm-2" for="rest_phone">Phone Number</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control " name="rest_phoneno" placeholder=" Phone Number">
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="rest_logo">Restaurant Logo:</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control-file" name="rest_logo" >
                        </div>
                    </div>

                </div>

                <div id="customer-fields"> 
                    <h4 class="text-center">Home Address</h4>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="cust_ship_street">Street</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="cust_ship_street" name="cust_ship_street" placeholder=" Street">
                        </div>
                        <label class="control-label col-sm-2" for="cust_ship_city">City</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="cust_ship_city" placeholder=" City">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="cust_ship_state">State/Province</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="cust_ship_state" placeholder=" State/Province">
                        </div>
                        <label class="control-label col-sm-2" for="cust_ship_country">Country</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="cust_ship_country" placeholder=" Country">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="cust_ship_zip">Zip/Postal Code</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="cust_ship_zip" placeholder=" Zip/Postal Code">
                        </div>
                        <label class="control-label col-sm-2" for="cust_ship_phone">Phone Number</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control " name="cust_ship_phone" placeholder=" Phone Number">
                        </div>
                    </div>



                    <hr  style="max-width:100%" />
                    <h4 class="text-center">Billing Address</h4>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="cust_bill_street">Street</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="cust_bill_street" placeholder=" Street">
                        </div>
                        <label class="control-label col-sm-2" for="cust_bill_city">City</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="cust_bill_city" placeholder=" City">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="cust_bill_state">State/Province</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="cust_bill_state" placeholder=" State/Province">
                        </div>
                        <label class="control-label col-sm-2" for="cust_bill_country">Country</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="cust_bill_country" placeholder=" Country">
                        </div>
                    </div>
                    <div class="form-group">

                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="cust_bill_zip">Zip/Postal Code</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="cust_bill_zip" placeholder=" Zip/Postal Code">
                        </div>
                        <label class="control-label col-sm-2" for="cust_bill_phone">Phone Number</label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control " name="cust_bill_phone" placeholder=" Phone Number">
                        </div>
                    </div>                   
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Email:</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" name="email" placeholder=" Email">
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="password"> Password:</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password" placeholder=" Password">
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="con_pass">Confirm Password:</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="con_pass" placeholder="Confirm Password">
                        
                    </div>
                </div>
                <button type="submit" class="btn btn-danger col-md-offset-2" style="border-radius:5px;">Submit</button>
            </form>

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
</style>
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        $("#seller-account").click(function () {
            $("#resturant-fields").show();
            $("#customer-fields").hide();
        });
        $("#customer-account").click(function () {
            $("#customer-fields").show();
            $("#resturant-fields").hide();
        });
    });
</script>
@endsection



