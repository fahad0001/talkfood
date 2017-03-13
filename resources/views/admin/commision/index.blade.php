@extends('layout.master')

@section('content')
<div class="row">
    
   <div class="col-md-6">
       <div class="col-md-12">
        <div class="box">
            
            <div class="box-header">
                
            <a class="btn btn-primary pull-right" href="{{URL::to('/admin/commission/create')}}"> Add</a>
              <h3 class="box-title">Commission Group</h3>
              
            </div>
       
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                
              <table class="table table-hover">
                  <tbody>
                @if (isset($comms))
                
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Percent</th>
                  <th></th>
                </tr>
                
                        @foreach($comms as $comm)
                            <tr>
                            <td>{{$comm->commis_id}}</td>
                            <td>{{$comm->commis_type}}</td>
                            <td>{{$comm->commis_percent}}</td>
                            <td><a href="{{URL::to('/admin/commission/delete')}}/{{$comm->commis_id}}"> Delete</a></td>
                            </tr>                         
                        @endforeach
                    
                    @else
                        <h2>No Record Exists!</h2>
                    
                    @endif
                             
              </tbody>
              </table>
               
            </div>
            <!-- /.box-body -->
          </div>
       </div>
          <!-- /.box -->
    </div>
</div>
@stop

