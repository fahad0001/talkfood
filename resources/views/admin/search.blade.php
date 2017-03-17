
@extends('layout.master')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header">
                <h3>
                    Search
                </h3>
            </div>
            <form action="{{URL::to('admin/search')}}" role="form" method="POST">
            {{Csrf_field()}}
                <div class="container">
                    <div class="col-md-3">
                        <div class="input-group input-group-sm">
                          <input type="text" name="name" class="form-control">
                          <span class="input-group-btn">
                            <button type="submit" class="btn btn-info btn-flat">Search!</button>
                          </span>
                        </div>
                    </div>
                    <div class="col-md-6" >
                          <label class="radio-inline">
                            <input type="radio" name="search" checked value="fname">First Name
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="search"  value="lname">Last Name
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="search"  value="email">Email
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="search"  value="orders">Orders
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="search"  value="orderno">Order No
                          </label>
                          <label class="radio-inline">
                            <input type="radio" name="search"  value="restname">Restuarant Name
                          </label>
                    </div>
                </div>
            </form>
            <div style="margin-top:1%" class="box-body table-responsive">
              <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                  <tbody>
                @if (isset($rests))
                
                <tr>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                   <th></th>
                </tr>
                
                        @foreach($rests as $index =>$rest)
                            <tr>
                            <td>{{$rest->first_name}}</td>
                            <td>{{$rest->last_name}}</td>
                            <td>{{$rest->email}}</td>
                            <td><a href="{{URL::to('admin/viewCustomerAddress')}}/{{$rest->id}}">View Details</a></td>
                            </tr>                         
                        @endforeach
                    
                    @else
                        <h2>No Customer Exists!</h2>
                    
                    @endif
                             
              </tbody>
              </table>
                
            </div>
        </div>
    </div>
</div>



@stop

 @section('scripts')


<script>


</script>
@stop