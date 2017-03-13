@extends('layout.master')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
              <h3 class="box-title">Customers</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-bordered" id="tbtable" role="grid" aria-describedby="tbtable_info">
            <thead>
                <tr role="row">
                    <th class="sorting_asc" tabindex="0" aria-controls="tbtable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="SrNo: activate to sort column descending" style="width: 33px;">
                        Customer Id
                    </th>
                    <th class="sorting" tabindex="0" aria-controls="tbtable" rowspan="1" colspan="1" aria-label="Tablename: activate to sort column ascending" style="width: 120px;">
                        Customer name
                    </th>
                    <th class="sorting" tabindex="0" aria-controls="tbtable" rowspan="1" colspan="1" aria-label="Orderid: activate to sort column ascending" style="width: 80px;">
                        OrderId
                    </th>
                    <th class="sorting" tabindex="0" aria-controls="tbtable" rowspan="1" colspan="1" aria-label="Date/Time: activate to sort column ascending" style="width: 100px;">
                        Date/Time
                    </th>
                    <th class="sorting" tabindex="0" aria-controls="tbtable" rowspan="1" colspan="1" aria-label="Amount (RS): activate to sort column ascending" style="width: 120px;">
                        Amount (CAD$)
                    </th>
                    <th class="sorting" tabindex="0" aria-controls="tbtable" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 44px;">
                        Status
                    </th>
                    <th class="sorting" tabindex="0" aria-controls="tbtable" rowspan="1" colspan="1" aria-label="View: activate to sort column ascending" style="width: 32px;">
                        View
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($orderdetail as $order)
                <tr role="row" class="odd">

                    <td class="sorting_1">{{$order['customer']['id']}}</td>
                    <td>{{$order['customer']['first_name']}}</td>
                    <td>{{$order['order_id']}}</td>  
                    <td>{{$order['order_date']}}</td>
                    <td>{{$order['order_total_amount']}}</td>
                    <td><span class="label label-success">{{$order['order_status']}}</span></td>
                    <td><a href={{URL::to('/admin/vieworderdetails/'.$order['order_id'])}}>View Details</a></td>


                </tr>
                @endforeach
                
            </tbody>
           
        </table>
                <div style="margin:10px;">
                      {{$orderdetail->render()}}
                
                </div>
               
            
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </div>
</div>
@stop

