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
              <h3 class="box-title">Restuarants</h3>
              <div class=" pull-right">              
                  <div class="col-sm-2 dropdown">
                    <button class="btn btn-primary dropdown-toggle" id="menu1" type="button" data-toggle="dropdown">Availability
                    <span class="caret"></span></button>
                    <ul id="menuavail" class="dropdown-menu" role="menu" aria-labelledby="menu1">
                        <li role="presentation"><a data-value="Online" role="menuitem" tabindex="-1" href="{{URL::to('admin/updateavailibility/Online')}}">Online</a></li>
                        <li role="presentation"><a data-value="Offline" role="menuitem" tabindex="-1" href="{{URL::to('admin/updateavailibility/Offline')}}">Offline</a></li>  
                    </ul>
                </div>
              </div>
              <form action="{{URL::to('admin/search/restaurant')}}" role="form" method="GET" style="margin-top: -16px;">
                <div class="box-tools pull-right" style="position:relative">
                        <div class="input-group input-group-sm" style="width: 200px;">                            
                            <input type="text" name="search" class="form-control pull-right" placeholder="Search">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>                            
                            </div>
                            
                        </div>
                </div>
              </form>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                  <tbody>
                @if (isset($rests))
                
                <tr>
                  <th>ID</th>
                  <th>Restuarant Name</th>
                  <th>Kitchen Type</th>
                  <th>Date</th>
                  <th>Address</th>
                  <th>Status</th>
                  <th></th>
                  <th></th>
                   <th></th>
                </tr>
                
                        @foreach($rests as $index =>$rest)
                            <tr>
                            <td>{{$index+$start_num}}</td>
                            <td>{{$rest->rest_name}}</td>
                            <td>{{$rest->kitchen_type}}</td>
                            <td>{{$rest->created_at->format('m/d/Y')}}</td>
                            <td>{{$rest->rest_street}} {{$rest->rest_city}} {{$rest->rest_country}}</td>
                            <td><span class="label label-success">{{$rest->rest_status}}</span></td>
                           
                            <td><a href="{{URL::to('admin/vieworders')}}/{{$rest->rest_id}}">View Orders</a></td>
                             <td><a href="{{URL::to('admin')}}/{{$rest->rest_id}}/salereport"> View sales</a></td>
                           
                            <td><a href="{{URL::to('admin/editrest')}}/{{$rest->rest_id}}"> Edit</a></td>
                             <td><a href="{{URL::to('admin/deleterest')}}/{{$rest->rest_id}}" onclick="return confirm('Are you sure you want to delete {{$rest->rest_name}}?');"> Delete</a></td>
                            </tr>                         
                        @endforeach
                    
                    @else
                        <h2>No Restaurant Exists!</h2>
                    
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

