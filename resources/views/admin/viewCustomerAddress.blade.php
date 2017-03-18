@extends('layout.master')
@section('title')
Restaurant Dashboard
@endsection


@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header">
                
            </div>
            <div class="box-body table-responsive no-padding">


                    <div class='row'>
            <div class='col-sm-12' style='background-color: white; padding-top:10px;padding-bottom:10px;min-height:500px;'>
                <div class="col-sm-6">
                     <h1>Customer Details</h1>
                    <h3><b>Customer Id : {{$custdetail->id}}</b></h3>
                    <h4>First Name  : {{$custdetail->first_name}}</h4>
                     <h4>Last Name : {{$custdetail->last_name}}</h4>
                  <h4>Email : {{$custdetail->email}}</h4>
                    @if(!empty($files = glob('uploads/' .$custdetail->id . '.*')))
                        <img src="{{URL::to($files[0])}}" style="max-width:500px;"  />
                    @endif
                  
                </div>
                @foreach($custAddress as $i)
 <div class="col-sm-6">
 		@if($i->address_type==='ship')
                     <h3>Shipping Address</h3>
                    <h3>Street : {{$i->street}}</h3>
                    <h4>City : {{$i->city}}</h4>
                     <h4>State\Province : {{$i->state_province}}</h4>
                     <h4>Country : {{$i->country}}</h4>
                     <h4>Zip Code : {{$i->zip_code}}</h4>
                     <h4>Phone No : {{$i->phone_no}}</h4>
                </div>
                @elseif($i->address_type==='del')
                 <h3>Delivery Address</h3>
                    <h3>Street : {{$i->street}}</h3>
                    <h4>City : {{$i->city}}</h4>
                     <h4>State\Province : {{$i->state_province}}</h4>
                     <h4>Country : {{$i->country}}</h4>
                     <h4>Zip Code : {{$i->zip_code}}</h4>
                     <h4>Phone No : {{$i->phone_no}}</h4>
                </div>
                @elseif($i->address_type==='bill')
                 <h3>Billing Address</h3>
                    <h3>Street : {{$i->street}}</h3>
                    <h4>City : {{$i->city}}</h4>
                     <h4>State\Province : {{$i->state_province}}</h4>
                     <h4>Country : {{$i->country}}</h4>
                     <h4>Zip Code : {{$i->zip_code}}</h4>
                     <h4>Phone No : {{$i->phone_no}}</h4>
                </div>
                @endif
         @endforeach
     <a href="{{URL::to('admin/viewcustomer')}}" class="btn btn-danger"> Back to Customer</a>
     <a href="{{URL::to('admin/resetPassword')}}/{{$custdetail->id}}" class="btn btn-danger"> Reset Password</a>
     
            <h2>Promotions Given</h2>
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                  <tbody>
                @if (isset($promotions))
                
                <tr>
                  <th>Promotion</th>
                  <th>Code</th>
                  <th>Created</th>
                  <th>Expired</th>
                  <th>Used</th>
                  <th></th>
                </tr>
                
                        @foreach($promotions as $promo)
                            <tr>
                            <td>{{$promotionSettings[$promo->promotion_setting_id]}}</td>
                            <td>{{$promo->code}}</td>
                            <td>{{$promo->created_at->format('m/d/Y')}}</td>
                            <td>{{date('m/d/Y', strtotime($promo->created_at . '+' . $promotionSettingsExpiry[$promo->promotion_setting_id] . 'days'))}}</td>
                            <td>{{$promo->used}}</td>
                            <td><a href="{{URL::to('admin/deletePromotion')}}/{{$promo->id}}"> Delete</a></td>
                            </tr>                         
                        @endforeach
                    
                    @else
                        <h2>No Promotions Exists!</h2>
                    
                    @endif
                             
              </tbody>
              </table>

            </div>
            @if($oncePromotionElligible)
            <form class="form-horizontal" method="post" action="{{URL::to('admin/addPromotion')}}">
                {{Csrf_field()}}
                <input type="hidden" class="form-control" value="{{$custdetail->id}}" name="user_id" >
                <input type="hidden" class="form-control" value="1" name="promotion_setting_id" >
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-info">Give Free Delivery Once Promotion</button>
              </div>
              <!-- /.box-footer -->
            </form>
            @endif
            @if($manyTimesPromotionElligible)
            <form class="form-horizontal" method="post" action="{{URL::to('admin/addPromotion')}}">
                {{Csrf_field()}}
                <input type="hidden" class="form-control" value="{{$custdetail->id}}" name="user_id" >
                <input type="hidden" class="form-control" value="2" name="promotion_setting_id" >
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-info">Give Free Delivery Many Times Promotion</button>
              </div>
              <!-- /.box-footer -->
            </form>
            @endif
            </div>
            </div>
           







                
            </div>
        </div>
        
    </div></div>
@endsection
