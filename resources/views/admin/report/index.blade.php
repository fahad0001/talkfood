@extends('layout.master')
@section('title') 
Restaurant Dashboard 
@endsection 
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header">
                <h3>
                    Restaurant Order Report
                </h3>
            </div>
            <form action="{{URL::to('admin')}}/{{$id}}/viewsalereport" role="form" method="GET">
            {{Csrf_field()}}
                <div class="container">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="input-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">From:</label>
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" value="{{isset($dateFrom)?$dateFrom:''}}" name="dateFrom" class="form-control" id="datepicker">
                            </div>
                        </div>

                        <div class="col-sm-3">
                           <div class="input-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">To:</label>
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" value="{{isset($dateTo)?$dateTo:''}}" name="dateTo" class="form-control" id="datepicker2">
                            </div>
                        </div>
                        <input class="btn btn-primary" type="submit" value="Search">
                    </div>
                </div>
            </form>
            <div style="margin-top:1%" class="box-body table-responsive">
            @if(isset($orderdetail))
                <table class="table table-bordered " id="tbtable " role="grid " aria-describedby="tbtable_info ">
                    <thead>
                        <tr role="row ">

                            <th class="sorting " tabindex="0 " aria-controls="tbtable " rowspan="1 " colspan="1 " aria-label="Tablename: activate to sort column ascending " style="width: 120px; ">
                                Customer name
                            </th>
                            <th class="sorting " tabindex="0 " aria-controls="tbtable " rowspan="1 " colspan="1 " aria-label="Orderid: activate to sort column ascending " style="width: 80px; ">
                                OrderId
                            </th>
                            <th class="sorting " tabindex="0 " aria-controls="tbtable " rowspan="1 " colspan="1 " aria-label="Date/Time: activate to sort column ascending " style="width: 100px; ">
                                Date/Time
                            </th>
                            <th class="sorting " tabindex="0 " aria-controls="tbtable " rowspan="1 " colspan="1 " aria-label="Amount (RS): activate to sort column ascending " style="width: 120px; ">
                                Amount (RS)
                            </th>
                        </tr>      
                        @foreach($orderdetail as $order)
                            <tr role="row">
                            <td>{{$order['customer']['first_name']}}</td>
                            <td>{{$order['order_id']}}</td>  
                            <td>{{$order['created_at']}}</td>
                            <td>{{$order['order_total_amount']}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <th colspan="2">Grand Total: </th>
                            <td><input type="hidden" id="amount" name="amount">{{$totalAmount}}</td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="box-footer clearfix ">
                <ul class="pagination pagination-sm no-margin pull-right ">
                    <?php echo $orderdetail->render(); ?>
                </ul>
            </div>
            </div>
        @endif
        </div>
    </div>
</div>
@endsection
@section('scripts')

<script>
  $( function() {
    $( "#datepicker" ).datepicker();
     $( "#datepicker2" ).datepicker();
  } );
  </script>
@endsection