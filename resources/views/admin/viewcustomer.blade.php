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
              <h3 class="box-title">Customers</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                  <tbody>
                @if (isset($rests))
                
                <tr>
                  <th>ID</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                   <th></th>
                   <th></th>
                </tr>
                
                        @foreach($rests as $index =>$rest)
                            <tr>
                            <td>{{$index+$start_num}}</td>
                            <td>{{$rest->first_name}}</td>
                            <td>{{$rest->last_name}}</td>
                            <td>{{$rest->email}}</td>
                            <td><a href="{{URL::to('admin/viewCustomerAddress')}}/{{$rest->id}}">View Deatails</a></td>
                            <td><a href="{{URL::to('admin/deleteCustomer')}}/{{$rest->id}}">Delete</a></td>
                            </tr>                         
                        @endforeach
                    
                    @else
                        <h2>No Customer Exists!</h2>
                    
                    @endif
                             
              </tbody>
              </table>
                <div class="box-footer clearfix">
                    <ul class="pagination pagination-sm no-margin pull-right">
                        <?php echo $rests->render(); ?>
                    </ul>
                </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </div>
</div>
@stop

