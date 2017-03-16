@extends('layout.master')
@section('title')
Restaurant Dashboard
@endsection


@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Add Menu Item</h3>
            </div>
            <form class="form-horizontal" role="form" action="{{URL::to('restaurant/viewsubitem')}}/{{$subfood->id}}" method="POST">
                {{Csrf_field()}}
                <div class="box-body">
                    <div class="form-group">
                        <label for="DishType" class="col-md-3 control-label">Food Name:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="typename" placeholder="" value='{{$food->food_name}}' readonly>
                        </div>


                    </div>
                    <div class="form-group">
                        <label for="DishType" class="col-md-3 control-label">Item Name:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="typename" value='{{$subfood->name}}' name="name" placeholder="" required="">

                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-md-3 control-label">Description:</label>
                        <div class="col-md-6">
                            <textarea type="textarea" class="form-control" id="typename" name="desc">{{$subfood->desc}}</textarea>

                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-md-3 control-label">Price:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="typename" value="{{$subfood->price}}" name="price" placeholder="" required="">

                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">            
                            <button type="submit" class="btn btn-google">Update</button>            
                        </div>
                    </div>
                    <div class="box-body">
                        </form>

                    </div>
                </div>

        </div>
    </div>

    @endsection


