@extends('layout.master')

@section('content')
<div class="row">
    <div class="col-md-8">
          @if (Session::get('status'))
            <div class="alert alert-danger">{{Session::get('status')}}</div>
          @endif
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Reset Password for {{$user->first_name}} {{$user->last_name}}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="{{URL::to('admin/resetPassword')}}/{{$id}}">
                {{Csrf_field()}}
              <div class="box-body">
                <div class="form-group">
                  <label for="name" class="col-sm-2 control-label">Password</label>
                  <div class="col-sm-10">                   
                    <input type="password" class="form-control" required name="password" >
                  </div>
                </div>
                <div class="form-group">
                  
                  <label for="status" class="col-sm-2 control-label">Confirm Password</label>
                  
                  <div class="col-sm-10"> 
                      <input type="password" class="form-control" required name="confirm_password" >
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
