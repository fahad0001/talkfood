<input type="hidden" id="foodid" name="foodid" value="{{$id}}" />

@foreach($opt as $o)



@if($o->type=="Dropdown")
{{$o->option}} (Choose One)
<input type="text" id="{{$o->option}}" name="{{$o->option}}"  value="" required style="display: none;"/>
@endif
@if($o->type=="Checkbox")
{{$o->option}} (Choose Multiple)
@endif



<ul class="list-group">
    
@foreach($submenu as $d)

@if($d->option==$o->option)

<li class="list-group-item" onclick="addtocartopt({{$d->id}})" id="{{$d->id}}" data-option="{{$o->option}}" data-type="{{$o->type}}" style="overflow: hidden;"><p class="pull-left ">{{$d->name}}</p> <p class="pull-right">@if($d->price==0) @else {{$d->price}} @endif</p> </li>
  
  

@endif

@endforeach
</ul>

@endforeach


<!--@foreach($submenu as $d)

       
                <div class="col-md-12" style="overflow:hidden;">
                    <div class="col-xs-9">
                        <b> {{$d->option}}</b>
                        <h3 ><b> {{$d->name}}</b></h3>
                        <h4>{{$d->desc}}</h4>


                    </div>
                    <div class="col-xs-3">
                        <h4><b>${{$d->price}} CAD</b><span style="text-decoration: none; color:#337ab7;" onclick="addtocartsub({{$d->id}})"> <i class="fa fa-2x fa-plus-square"style="vertical-align: middle;font-size: 25px;"></i></span></h4>


                    </div>
                </div>
               
              
                @endforeach-->



<script>
    $("#subform").parsley();
     var ar=[];
    function addtocartopt(id) {
        
        var type=$("#"+id).attr("data-type");
       
      if(type=="Dropdown") {
          $("[id='"+$("#"+id).attr("data-option")+"']").val(id);
           $("#"+id).addClass("active").siblings().removeClass("active");
           //alert($("#"+id).attr("data-option"));
      }
      
        if(type=="Checkbox") {
            
            if($("#"+id).hasClass("active")) {
                var i = ar.indexOf($("[id='"+$("#"+id).attr("data-option")+"']").val());
                 $("#"+id).removeClass("active");
                ar.splice(i,1);
                 console.log(ar);
            }
            else {
                
                 var old=$("#"+id).attr("id");
         //   var newd=old+"-"+id;
         // $("#"+$("#"+id).attr("data-option")).val(newd);
             $("#"+id).addClass("active");
             ar.push(old);
              console.log(ar);
            }
           
          // console.log(ar);
      }
       
        
    }
    
    
    </script>