@extends('layout.master')
@section('title')
Restaurant Dashboard
@endsection

@section('content')
<div class="row">
    <div class="col-md-10">
        <form class="form-horizontal" role="form" method="POST">
            <div class="box">
                <div class="box-header">
                    <h3>
                        Foods
                    </h3>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-bordered" id="tbtable" role="grid" aria-describedby="tbtable_info">
                        <thead>
                            <tr role="row">
                                <th class="sorting" tabindex="0" aria-controls="tbtable" rowspan="1" colspan="1" aria-label="Type Name: activate to sort column ascending" style="width: 238px;">Name</th>
                                <th class="sorting" tabindex="0" aria-controls="tbtable" rowspan="1" colspan="1" aria-label="Type Name: activate to sort column ascending" style="width: 238px;">Category</th>
                                <th class="sorting" tabindex="0" aria-controls="tbtable" rowspan="1" colspan="1" aria-label="Type Name: activate to sort column ascending" style="width: 338px;">Description</th>
                                <th class="sorting" tabindex="0" aria-controls="tbtable" rowspan="1" colspan="1" aria-label="Delete DishType: activate to sort column ascending" style="width: 66px;">Price</th>                        
                                <th class="sorting" tabindex="0" aria-controls="tbtable" rowspan="1" colspan="1" aria-label="View Sub Item" style="width: 151px;"></th>
                                <th class="sorting" tabindex="0" aria-controls="tbtable" rowspan="1" colspan="1" aria-label="View / Update DishType: activate to sort column ascending" style="width: 101px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($foodDetail as $food)
                            <tr role="row" class="odd">

                                <td >{{$food['food_name']}}</td>                             
                                <td>{{$food['foodCategory']['cate_name']}}</td>
                                <td>{{$food['food_desc']}}</td>
                                <td>{{$food['food_price']}}</td>
                                <td><a href="{{URL::to('restaurant/editmenuitem/'.$food['food_id'])}}">View Sub Items</a></td> 
                                <td><a href="{{URL::to('restaurant/editmenuitem/'.$food['food_id'])}}">Edit</a></td> 
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
        <!--View Table-->
        <!--<h4 class="sub-header">View Category</h4>-->

        <!--End View Table-->

    </div>
    <div class="col-md-3">
        <form class="form-horizontal" role="form" method="POST">
            <div class="box">
                <div class="box-header">
                    <h3>
                        Sub Item
                    </h3>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-bordered" id="tbtable" role="grid" aria-describedby="tbtable_info">
                        <thead>
                            <tr role="row">
                                <th class="sorting" tabindex="0" aria-controls="tbtable" rowspan="1" colspan="1" aria-label="Type Name: activate to sort column ascending" style="width: 238px;">Name</th>
                                <th class="sorting" tabindex="0" aria-controls="tbtable" rowspan="1" colspan="1" aria-label="Type Name: activate to sort column ascending" style="width: 238px;">Category</th>
                                <th class="sorting" tabindex="0" aria-controls="tbtable" rowspan="1" colspan="1" aria-label="Type Name: activate to sort column ascending" style="width: 338px;">Description</th>

                            </tr>
                        </thead>
                        <tbody>                
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
        <!--View Table-->
        <!--<h4 class="sub-header">View Category</h4>-->

        <!--End View Table-->

    </div>
</div>
@endsection