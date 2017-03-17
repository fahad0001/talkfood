@extends('layout.master')
@section('title')
Restaurant Dashboard
@endsection
@section('header')
Food Category
@endsection

@section('content')
<div class="row">
 <!--<form class="navbar-form" action="{{URL::to('admin/viewcategory')}}" role="search">
    <div class=" col-md-2 pull-right">
      <input class="form-control" placeholder="Search" name="search" id="countries" type="text">
    </div>
  </form>-->
  @if(isset($catDetail))
<div class="col-md-8 col-md-offset-1">
   <!--<input type="hidden" id="page_name" value="adddishtype">-->
   
    <form class="form-horizontal" action="{{URL::to('admin/addcategory')}}/{{$catDetail[0]->rest_id}}" role="form" action="" method="POST">
        {{ Csrf_field() }}
        <div class="form-group">
            <label for="DishType" class="col-sm-2 control-label">Add Category:</label>
            <div class="col-md-4">
                <input type="text" class="form-control" id="typename" name="CategoryType" placeholder="">
                
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
        </div>

       
    </form>
    <div class="form-group">
    &nbsp;
</div>
    <div class="box">
            <div class="box-header">
                <h3>
                    Categories
                </h3>
            </div>
            <div class="box-body table-responsive no-padding">
     <table class="table table-bordered" id="tbtable" role="grid" aria-describedby="tbtable_info">
                <thead>
                    <tr role="row" >
                        <th class="sorting" tabindex="0" aria-controls="tbtable" rowspan="1" colspan="1" aria-label="Type Name: activate to sort column ascending" style="width: 238px;">Type Name</th>
                        <th class="sorting" tabindex="0" aria-controls="tbtable" rowspan="1" colspan="1" aria-label="Delete DishType: activate to sort column ascending" style="width: 66px;"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach($catDetail as $category)
                        <tr role="row" class="odd">                           
                                <td>{{$category->cate_name}}</td>
                                <td><a href="{{URL::to('admin/deletecategory/'.$category->cate_id)}}">Delete</a></td> 
                                
                        </tr>
                @endforeach
                </tbody>
            </table>
            <div class="box-footer clearfix">
            <ul class="pagination pagination-sm no-margin pull-right">
                <?php echo $catDetail->render(); ?>
            </ul>
        </div>
            </div>
    </div>
    <!--View Table-->
    <!--<h4 class="sub-header">View Category</h4>-->

    <!--End View Table-->

</div>
@endif
</div>
@endsection
@section('scripts')
 <script>

    $(function()
    {
    var options = {

  url: "/search/autocomplete",

  getValue: "name",

  list: {	
    match: {
      enabled: true
    }
  },

  theme: "Plate dark"
};

$("#countries").easyAutocomplete(options);
});
 </script>
@endsection