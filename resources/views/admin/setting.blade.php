@extends('layout.master')

@section('content')
<div class="row">
    <div class="col-md-8">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Shipping Detail</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="{{URL::to('admin/settings')}}">
                {{Csrf_field()}}
              <div class="box-body">
                  <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Shipping Price</label>
                  <div class="col-sm-10"> 
                      <input type="text"   class="form-control" name='ship_price' id="inputEmail3" value='@if(isset($ship->ship_price)){{$ship->ship_price}}@endif' >
                  </div>
                </div>
                  <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Shipping Tax (%)</label>
                  <div class="col-sm-10"> 
                      <input type="text"   class="form-control" name='ship_tax' id="inputEmail3" value='@if(isset($ship->ship_price)){{$ship->ship_tax}}@endif'>
                  </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Tax (%)</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name='tax'  value='@if(isset($ship->ship_price)){{$ship->tax}}@endif' >
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Driver Tip</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" name='driver_tip'  value='@if(isset($ship->ship_price)){{$ship->driver_tip}}@endif' >
                    </div>
                </div>  
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
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



