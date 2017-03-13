@extends('layout.master')

@section('content')
<div class="row">
        <div class="col-md-8">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Restaurant</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action='{{URL::to('admin/editrest/edit')}}'>
                {{Csrf_field()}}
              <div class="box-body">
                  <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Restaurant Id</label>
                  <div class="col-sm-10"> 
                      <input type="text" readonly  class="form-control" name='rest_id' id="inputEmail3" value="{{$resto->rest_id}}">
                  </div>
                </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Restaurant Name</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" name='restname' id="inputEmail3" value="{{$resto->rest_name}}" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">First Name</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" name='firstname' id="inputEmail3" value="{{$usero->first_name}}" >
                    </div>
                </div>
                  <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Last Name</label>

                  <div class="col-sm-10">
                      <input type="text" class="form-control" name='lastname' id="inputEmail3" value="{{$usero->last_name}}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-10">
                      <input type="email" class="form-control" name="email" id="inputEmail3" value="{{$usero->email}}">
                  </div>
                </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Commission Group</label>

                    <div class="col-sm-10">
                        <select name="commis_group" class="form-control">
                            @foreach($commiso as $comm)
                            <option value="{{ $comm->commis_id }}"  {{ $resto->commis_id == $comm->commis_id ? 'selected' : '' }}> {{ $comm->commis_type }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Phone No</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="phone_no" id="inputEmail3" value="{{$resto->rest_phone_no}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-10">
                        <select name="status" class="form-control">
                           
                               
                                 </option>
                                 <option value="active" {{$resto->rest_status == 'active' ? 'selected' : '' }}>
                               
                                 Active</option>
                                 <option value="pending"  {{ $resto->rest_status == 'pending' ? 'selected' : '' }} >Pending</option>
                                 <option value="block" {{ $resto->rest_status == 'block' ? 'selected' : '' }}>Block</option>
                          </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Kitchen Type</label>
                    <div class="col-sm-10">
                        <input type="text" name="kitchen_type" class="form-control" id="inputEmail3" value="{{$resto->kitchen_type}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Street</label>
                    <div class="col-sm-10">
                        <input type="text" name="street" class="form-control" id="inputEmail3" value="{{$resto->rest_street}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">City</label>
                    <div class="col-sm-10">
                        <input type="text" name="city" class="form-control" id="inputEmail3" value="{{$resto->rest_city}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">State/Province</label>
                    <div class="col-sm-10">
                        <input type="text" name="province" class="form-control" id="inputEmail3" value="{{$resto->rest_state_province}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Country</label>
                    <div class="col-sm-10">
                        <input type="text" name="country"
                             class="form-control" id="inputEmail3" value="{{$resto->rest_country}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Zip/Postal Code</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="zip_code" id="inputEmail3" value="{{$resto->rest_postal_code}}">
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



