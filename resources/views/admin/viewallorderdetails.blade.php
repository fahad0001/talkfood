@extends('layout.master')
@section('title')
Restaurant Dashboard
@endsection


@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header">
                <h3>
                    <b>{{$restName}}</b>'s Order
                </h3>
            </div>

            <div class="container">
                <label for="sel1" >Status :</label>
                <select id="status" name="status" class="selectContainer">
                     <option {{$orderstatus->order_status ==''? 'selected':''}} value=""></option>
                     <option {{$orderstatus->order_status =='complete'? 'selected':''}} value="complete">Complete</option>
                     <option {{$orderstatus->order_status =='pending'? 'selected':''}} value="pending">Pending</option>
                     <option {{$orderstatus->order_status =='canceled'? 'selected':''}} value="canceled">Canceled</option>
                     <option {{$orderstatus->order_status =='processing'? 'selected':''}} value="processing">Processing</option>
                </select>
            </div>

            <div class="box-body table-responsive no-padding">


                    <div class='row'>
            <div class='col-sm-12' style='background-color: white; padding-top:10px;padding-bottom:10px;min-height:500px;'>
                <div class="col-sm-6">
                     <h1>Orders Details</h1>
                     <h3 id="refOrder"><b>Order Status : {{$orderstatus->order_status}}</b></h3>
                    <h3><b>Order Id : {{$orderinfo->order_id}}</b></h3>
                    <h4>Order quantity : {{$orderinfo->order_qty}}</h4>
                     <h4>Order Subtotal : {{$orderinfo->order_total_without_tax}} CAD</h4>
                  <h4>Order Shipping : {{$orderinfo->order_ship_price}} CAD</h4>
                  <h4>Shipping Tax : {{$orderinfo->order_ship_tax}} CAD</h4>
                  <h4>Driver Tip : {{$orderinfo->drivertip}} CAD</h4>
                    <h4>Order Tax : {{$orderinfo->order_tax}} CAD</h4>
                     <h4>Order Total : {{$orderinfo->order_grand_total}} CAD</h4>
                    <h4>Created At: {{$orderinfo->created_at}} </h4>
                </div>
                <div class="col-sm-6">
                    <h3><b>Customer Details</b></h3>
                    <h3>Name : {{$orderinfo['customer']->first_name}} {{$orderinfo['customer']->last_name}}</h3>
                    <h5>Address : {{$orderinfo['customerAddress']->street}},{{$orderinfo['customerAddress']->city}},{{$orderinfo['customerAddress']->zip_code}},{{$orderinfo['customerAddress']->country}}</h5>

                </div>
 <div class="col-sm-12">
             <div class="table-responsive">

                    <h4><b>Items Details</b></h4>
                    <table class="table table-bordered">
                        <thead>
                                <tr> <th>Item Name</th> <th>Item Description</th> <th>Item Quantity</th> <th>Item Price</th> </tr>
                            </thead> 
                        <tbody>
                         
                                                     <?php $i = 1; ?>
                                @foreach($cart as $item) 
                                @if(!is_array($item))

                                @else
                                <tr> 
                                    <td>{{ $item['food_name'] }}
                                        @if($item['submenu_status']==1)
                                        @foreach($item['subitem'] as $s)
                                        <p style='font-size:12px;'>
                                            {{$s['option']}} : {{$s['name']}}
                                        </p>
                                        @endforeach
                                        @endif

                                    </td> 
                                    <td>{{ $item['food_desc'] }}</td> 
                                       <td>{{ $item['quantity'] }}</td> 

                                    <td>$ 
                                        @if($item['submenu_status']==1) 
                                            <?php $totali=$item['food_price'];?>
                                            <?php $sub=0; ?>
                                            @foreach($item['subitem'] as $is)
                                                <?php $sub=$sub+$is['price']?>
                                            
                                            @endforeach
                                             {{ $totali+$sub }}
                                       
                                        @else {{$item['food_price']}}

                                        @endif </td>

                                </tr> 
                                @endif
                                @endforeach




                        </tbody>
                    </table>






                </div>
     <a href="{{URL::to('admin/allorders')}}" class="btn btn-danger"> Back to Orders</a>
            </div>
            </div>
           

        </div>
                
            </div>
        </div>
        
    </div></div>
@endsection
@section('scripts')
    <script>
    $(document).ready(function(){
        $("#status").change(function(){
            var textLi=$(this).val();
            var URLA='';
             URLA="{{URL::to('newdashboard/updatestatus')}}";
             $.ajax({
                 headers: 
                 {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                 type:"POST",
                 data:{status:textLi,orderId:{{"$orderinfo->order_id"}}},
                 url:URLA,
                 success: function(datar)
                 {
                     $('#refOrder').html('<b>Order Status: '+datar+'</b>');
                 }
             });
        });
    });
    </script>
@endsection