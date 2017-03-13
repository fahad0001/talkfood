@extends('layout.master')

@section('content')
<div class="row">
    <div class="col-md-8">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Promotion Settings</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="{{URL::to('admin/editPromotionSetting')}}/{{$promotionSetting->id}}">
                {{Csrf_field()}}
              <div class="box-body">
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-10">                   
                    <input type="text" disabled class="form-control" value="@if(isset($promotionSetting->name) && isset($promotionSetting->usage)){{$promotionSetting->name}}@endif" name="name" >
                  </div>
                </div>
                <div class="form-group">
                  
                  <label for="status" class="col-sm-2 control-label">Expiry Days</label>
                  
                  <div class="col-sm-10"> 
                      <input type="number" name='expiry' id="expiry" value="@if(isset($promotionSetting->expiry)){{$promotionSetting->expiry}}@endif" >
                  </div>
                </div>
                <div class="form-group">
                  
                  <label for="status" class="col-sm-2 control-label">Activate</label>
                  
                  <div class="col-sm-10"> 
                      <input type="checkbox" name='status' id="status" value="1" @if(isset($promotionSetting->status) && $promotionSetting->status) checked @endif >
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
