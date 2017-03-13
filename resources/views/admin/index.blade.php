@extends('layout.master')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
              <h3 class="box-title">Restuarants</h3>
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
                
                        @foreach($rests as $rest)
                            <tr>
                            <td>{{$rest->rest_id}}</td>
                            <td>{{$rest->rest_name}}</td>
                            <td>{{$rest->kitchen_type}}</td>
                            <td>{{$rest->created_at->format('m/d/Y')}}</td>
                            <td>{{$rest->rest_street}} {{$rest->rest_city}} {{$rest->rest_country}}</td>
                            <td><span class="label label-success">{{$rest->rest_status}}</span></td>
                           
                            <td><a href="{{URL::to('admin/vieworders')}}/{{$rest->rest_id}}">View Orders</a></td>
                             <td><a href="{{URL::to('admin')}}/{{$rest->rest_id}}/salereport"> View sales</a></td>
                           
                            <td><a href="{{URL::to('admin/editrest')}}/{{$rest->rest_id}}"> Edit</a></td>
                             <td><a href="{{URL::to('admin/deleterest')}}/{{$rest->rest_id}}"> Delete</a></td>
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

