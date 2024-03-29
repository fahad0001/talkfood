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
              <!--<div class=" pull-right">
              
                  <div class="col-sm-2 dropdown">
        <button class="btn btn-primary dropdown-toggle" id="menu1" type="button" data-toggle="dropdown">Availability
        <span class="caret"></span></button>
        <ul id="menuavail" class="dropdown-menu" role="menu" aria-labelledby="menu1">
            <li role="presentation"><a data-value="Online" role="menuitem" tabindex="-1" href="{{URL::to('admin/updateavailibility/Online')}}">Online</a></li>
            <li role="presentation"><a data-value="Offline" role="menuitem" tabindex="-1" href="{{URL::to('admin/updateavailibility/Offline')}}">Offline</a></li>  
        </ul>
    </div>
              </div>-->
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                  <tbody>
                @if (isset($rests))
                
                <tr>
                  <th>ID</th>
                  <th>Restuarant Name</th>
                  <th>Address</th>
                  <th></th>
                  <th></th>
                   <th></th>
                </tr>
               
                        @foreach($rests as $index =>$rest)
                            <tr>
                            <td>{{$index+$start_num}}</td>
                            <td>{{$rest->rest_name}}</td>
                            <td>{{$rest->rest_street}} {{$rest->rest_city}} {{$rest->rest_country}}</td>
                           
                            <td><a href="{{URL::to('admin/viewcategory')}}/{{$rest->rest_id}}">Categories</a></td>
                             <td><a href="{{URL::to('admin/addmenuitem')}}/{{$rest->rest_id}}">Add Menu Items</a></td>
                            <td><a href="{{URL::to('admin/viewmenuitem')}}/{{$rest->rest_id}}">View Menu Items</a></td>
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
