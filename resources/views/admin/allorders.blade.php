<?php
 $page_num   =   (int) (!isset($_GET['page']) ? 1 : $_GET['page']);
 $start_num =((($page_num*15)-15)+1);
 ?>
@extends('layout.master')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
              <h3 class="box-title">Orders</h3>
              <form action="{{URL::to('admin/search/orderinfo')}}" role="form" method="GET" style="margin-top: -16px;">
                <div class="box-tools pull-right" style="position:relative">
                        <div class="input-group input-group-sm" style="width: 200px;">                            
                            <input type="text" name="search" class="form-control pull-right" placeholder="Search">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>                            
                            </div>                            
                        </div>
                </div>
            </form>
              <div class="col-md-2 pull-right"> 
              
              <div class="btn-group" role="group">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Order Filter
      <span class="caret"></span>
    </button>
    <ul class="dropdown-menu orderfilter">
      <li class="active"><a href="{{URL::to('admin/allorders')}}?search=all">All</a></li>
       <li><a href="{{URL::to('admin/allorders')}}?search=pending">Pending</a></li>
      <li><a href="{{URL::to('admin/allorders')}}?search=processing">Processing</a></li>
         <li><a href="{{URL::to('admin/allorders')}}?search=complete">Complete</a></li>
      <li><a href="{{URL::to('admin/allorders')}}?search=canceled">Cancel</a></li>
    </ul>
  </div>
              
              
               </div>
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
                @foreach($orderdetail as $index=>$order)
                <tr role="row" class="odd">

                    <td class="sorting_1">{{$index+$start_num}}</td>
                    <td>{{$order['customer']['first_name']}}</td>
                    <td>{{$order['order_id']}}</td>  
                    <td>{{$order['order_date']}}</td>
                    <td>{{$order['order_total_amount']}}</td>
                    <td><span class="label label-success">{{$order['order_status']}}</span>@if($order['order_status']=="pending")<span class="label label-danger">NEW</span>@endif</td>
                    <td><a href={{URL::to('/admin/viewallorderdetails/'.$order['order_id'])}}>View Details</a> <button class='btn btn-danger' id="deleteorder" data-order='{{$order['order_id']}}' >Delete</button></td>


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


<!-- Modal -->
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Delete Order</h4>
      </div>
      <div class="modal-body">
          Do you want to delete this order <span id='orderi'> </span>  ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        <button type="button" id='ondelete'  class="btn btn-primary">Delete</button>
      </div>
    </div>
  </div>
</div>
@stop
@section('scripts')
<script>

$(document).ready(function() {


@if(Request::has('search'))

@if(Request::input('search')=="all")
 
  $(".orderfilter li a").parents('.btn-group').find('.dropdown-toggle').html('All'+' <span class="caret"></span>');
  
  
@elseif(Request::input('search')=="processing")
 $(".orderfilter li a").parents('.btn-group').find('.dropdown-toggle').html('Processing'+' <span class="caret"></span>');

@elseif(Request::input('search')=="complete")
 $(".orderfilter li a").parents('.btn-group').find('.dropdown-toggle').html('Complete'+' <span class="caret"></span>');

@elseif(Request::input('search')=="canceled")
 $(".orderfilter li a").parents('.btn-group').find('.dropdown-toggle').html('Canceled'+' <span class="caret"></span>');

@elseif(Request::input('search')=="pending")
 $(".orderfilter li a").parents('.btn-group').find('.dropdown-toggle').html('Pending'+' <span class="caret"></span>');
 

@endif
 
 
@endif


$(".orderfilter li a").click(function(){
  var selText = $(this).text();
  $(this).parents('.btn-group').find('.dropdown-toggle').html(selText+' <span class="caret"></span>');
});




    $('#deleteorder').on('click', function (e) {
        e.preventDefault();
         
                //alert($(e.target).attr("data-order"));
        
        
       $("#orderi").text($(e.target).attr('data-order'));
           $("#ondelete").attr("data-order",$(e.target).attr('data-order'));
        $("#delete").modal('show');
//      $.ajax({
//            type: "POST",
//            url: host + '/articles/create',
//            data: {title: title, body: body, published_at: published_at},
//            success: function( msg ) {
//                $("#ajaxResponse").append("<div>"+msg+"</div>");
//            }
//        });
    });
    
    $('#ondelete').on('click', function (e) {
     var url="{{URL::to('admin/viewallorderdetails/delete')}}"+"/"+$("#ondelete").attr('data-order');
          $.ajax({
            type: "GET",
            url: url,
            data:{ "_token": "{{ csrf_token() }}"},
            success: function( msg ) {
              
                 location.reload();
            }
        });
    
    });
});
</script>

@endsection

