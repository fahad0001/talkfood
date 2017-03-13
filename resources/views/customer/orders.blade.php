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
                <h2>Orders</h2>
               
                  @if (Session::has('message'))
            <div class="alert alert-success">
              
                    {{ Session::get('message') }}<br>        
               </div>
                  @endif
                <div class="table-responsive">
                  
                  @if(count($orders)>=1)
                    <table class="table table-bordered">
                        <thead>
                            <tr> <th>Order Id</th> <th>Quantity</th><th>Total</th><th>Status</th><th>Created at</th>  </tr>
                        </thead> 
                        <tbody>
                            
                               @foreach($orders as $order)
                               <tr>
                                   <td>
                                       {{$order->order_id}}
                                       <a style="color:red;" href="{{ URL::to('customer/orders')}}/{{$order->order_id}}">View</a>
                                   </td>
                                   
                                    <td>
                                       {{$order->order_qty}}
                                   </td>
                                   
                                     <td>
                                       {{$order->order_total_amount}} CAD
                                     </td>
                                     <td>
                                       {{$order->order_status}}
                                   </td>
                                   
                                   <td>
                                       {{$order->created_at}}
                                   </td>
                               </tr>
                              
                            
                              @endforeach
                              
                   
                        </tbody>
                    </table>
                  
                  @else
                  
                  <h3>No order History</h3>
                  @endif
                      
                    
                </div>
               

            

               



            </div>
         
        </div>

    </div>


</div>


</section>



@endsection


