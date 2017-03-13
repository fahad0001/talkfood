@extends('layout.master')

@section('content')
<div class="row">
    <div class="col-md-8">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Commission</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="{{URL::to('admin/commission/create')}}">
                {{Csrf_field()}}
              <div class="box-body">
                  <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Commission Type</label>
                  <div class="col-sm-10"> 
                      <input type="text"   class="form-control" name='commis_type' id="inputEmail3" >
                  </div>
                </div>
                  <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Commission Percent (%)</label>
                  <div class="col-sm-10"> 
                      <input type="text"   class="form-control" name='commis_percent' id="inputEmail3" >
                  </div>
                  </div>                 
                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-default">Cancel</button>
                <button type="submit" class="btn btn-info pull-right">Save</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
          <!-- general form elements disabled -->
          
          <!-- /.box -->
    </div>
</div>
@stop



