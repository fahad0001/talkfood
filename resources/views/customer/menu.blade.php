@extends('customer.layout.master')
@section('style')
<style>

    .navbar-default .nav>li>a, .navbar-default .nav>li>a {
        color: #222 !important;
    }
    body {
        background-color: #f5f5f5 !important;
    }
    b, strong {
        font-weight: 500 !important;
    }
    .parsley-errors-list {
        color:red !important;
    }


</style>

@endsection
@section('content')
@include('customer.layout.navigation2')
@if($restinfo->rest_avail=="Online")

<section style="padding-top:70px;">

    <div class='container' >

        <div class='row'>

          


        </div>
        <div class='row' style=>
            <div class="col-sm-2">
                <p style="margin:0px;"> <i class="fa fa-glass"></i><b> Categories</b></p>
                <div class="col-sm-12" style='background-color: white;'>
                
                @foreach($cats as $c)
                <div>
                <a href="#{{$c->cate_name}}" style="color:#222;">{{ strtoupper($c->cate_name) }} </a>
                </div>
                
                @endforeach
                </div>
            </div>
            <div class='col-sm-10' style='background-color: white;min-height: 800px'>
                <h3><b> {{$restinfo->rest_name }}</b> </h3>
                @foreach($cats as $c)
                <div class="col-md-12 " id="{{$c->cate_name}}">
                    <h3 class="categories-name"> {{strtoupper($c->cate_name) }} </h3>
                </div>
                @foreach($data as $d)

                @if($d->cate_id == $c->cate_id)
                <div class="col-md-12" style="overflow:hidden;">
                    <div class="col-xs-9">
                        <h3 ><b> {{$d->food_name}}</b></h3>
                        <h4>{{$d->food_desc}}</h4>


                    </div>
                    <div class="col-xs-3">
                        <h4><b>@if($d->submenu_status==1) ${{$d->food_price}} CAD @else ${{$d->food_price}} CAD @endif </b><span style="text-decoration: none; color:#337ab7;" onclick="@if($d->submenu_status==1) addtocartop({{$d->food_id}}) @else addtocart({{$d->food_id}}) @endif"> <i class="fa fa-2x fa-plus-square"style="vertical-align: middle;font-size: 25px;"></i></span></h4>


                    </div>
                </div>
                @endif
              
                @endforeach

               
                @endforeach
            </div>

        </div>

    </div>


</div>


</section>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel" >{{$c->cate_name}}</h4>
      </div>
        <form id="subform">
      <div class="modal-body" style='overflow: auto;'>
        @foreach($data as $d)

                @if($d->cate_id == $c->cate_id)
                <div class="col-md-12" style="overflow:hidden;">
                    <div class="col-xs-9">
                        <h3 ><b> {{$d->food_name}}</b></h3>
                        <h4>{{$d->food_desc}}</h4>


                    </div>
                    <div class="col-xs-3">
                        <h4><b>@if($d->submenu_status==1) @else ${{$d->food_price}} CAD @endif </b><span style="text-decoration: none; color:#337ab7;" onclick="@if($d->submenu_status==1) addtocartop({{$d->food_id}}) @else addtocart({{$d->food_id}}) @endif"> <i class="fa fa-2x fa-plus-square"style="vertical-align: middle;font-size: 25px;"></i></span></h4>


                    </div>
                </div>
                @endif
        @endforeach
      </div>
      <div class="modal-footer">
       
        <button type="button" class="btn btn-danger" id="addop" >Add To Cart</button>
        
      </div>
    </form>
    </div>
  </div>
</div>
<div class="overlay" style="position: fixed;display:none;
    top: 0px;
    right: 0px;
    width: 100%;
    height: 100%;
    background-color: #666;
    background-image: url(http://test.talkfood.ca/img/loading.gif);
    background-repeat: no-repeat;
    background-position: center;
    z-index: 10000000;
    opacity: 0.4;">


</div>

@else
<section style="padding-top:70px;min-height:800px">

    <div class='container' >

<h1> Restaurant is Currently Offline !<h1>
</div>

</section>

@endif


@endsection

@section('scripts')


<script type="text/javascript">
$(document).ready(function(){
    $(".categories-name").click(function(){
      debugger;
      $("#myModal").modal('show');
    });
    
    $("#addop").click(function(){
        $(".overlay").show();
        console.log(ar);
       console.log($("#subform").parsley().validate());
       if($("#subform").parsley().validate()) {
           
           
               var dd=[];
       var formdata = {};
       $("#subform").find("input[name]").each(function(index,node) {
           if(node.name=="foodid") {
               
           }else {
           dd.push(node.value);
           }
       });
       var id= $("#subform").find("#foodid").val();
       formdata["checkbox"]=ar;
       formdata["dropdown"]=dd;
        $.ajax({
  method: "GET",
  url: "{{URL::to('/addtocartsub')}}/"+id,
  data:formdata,
})
  .done(function( msg ) {
         
          if(msg=="error") {
         alert("Can only order from one restaurent");
         }
         else {
         var cartcount=$('#cartcount').text();
          var count=parseInt(cartcount)+1;
             $('#cartcount').html(count);
             }
             $(".overlay").hide();
         
    $('#myModal').modal('toggle');
         
      console.log(msg);
  })
  .fail(function(error) {
    alert( error );
    console.log(error);
  });
           // alert("add to cart");
           
           
       }
       else {
            $(".overlay").hide();
         //  alert("error");
       }
   






       
    });
    
});
</script>



<script>
    function addtocart(id) {
    
    $(".overlay").show();
    
    $.ajax({
  method: "GET",
  url: "{{URL::to('/addtocart')}}/"+id,
  
})
  .done(function( msg ) {
         if(msg=="error") {
         alert("Can only order from one restaurent");
         }
         else {
         var cartcount=$('#cartcount').text();
          var count=parseInt(cartcount)+1;
             $('#cartcount').html(count);
             }
             $(".overlay").hide();
            
        
  })
  .fail(function(error) {
    alert( error );
    console.log(error);
  });
    
    }
    
     function addtocartop(id) {
  
   $.ajax({
  method: "GET",
  url: "{{URL::to('/submenu')}}/"+id,
  
})
  .done(function( msg ) {
             
       $('#myModal').modal('toggle');
       $('.modal-body').html(msg);
        $("#subform").parsley();

  })
  .fail(function(error) {
    alert( error );
    console.log(error);
  });
    
     }
     
      function addtocartsub(id) {
      $(".overlay").show();
   
   $.ajax({
  method: "GET",
  url: "{{URL::to('/addtocartsub')}}/"+id,
  
})
  .done(function( msg ) {
          if(msg=="error") {
         alert("Can only order from one restaurent");
         }
         else {
         var cartcount=$('#cartcount').text();
          var count=parseInt(cartcount)+1;
             $('#cartcount').html(count);
             }
             $(".overlay").hide();
         
    $('#myModal').modal('toggle');
    

  })
  .fail(function(error) {
    alert( error );
    console.log(error);
  });
    
     }
     
 
    
    
    
</script>


@endsection


