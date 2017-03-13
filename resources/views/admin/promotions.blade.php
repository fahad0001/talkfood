@extends('layout.master')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
              <h3 class="box-title">Promotions Settings</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                  <tbody>
                @if (isset($promotionSettings))
                
                <tr>
                  <th>Name</th>
                  <th>Expiry</th>
                  <th>Usage</th>
                  <th>Status</th>
                  <th></th>
                </tr>
                
                        @foreach($promotionSettings as $setting)
                            <tr>
                            <td>{{$setting->name}}</td>
                            <td>{{$setting->expiry}}</td>
                            <td>@if(isset($setting->usage) && $setting->usage) Once @else Many Times @endif</td>
                            <td>@if(isset($setting->status) && $setting->status) <span class="label label-success">Active</span> @else <span class="label label-danger">Disabled</span> @endif</span></td>
                            <td><a href="{{URL::to('admin/editPromotionSetting')}}/{{$setting->id}}">Edit</a></td>
                            </tr>                         
                        @endforeach
                    
                    @else
                        <h2>No Promotion Settings!</h2>
                    
                    @endif
                             
              </tbody>
              </table>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </div>
</div>
@stop

