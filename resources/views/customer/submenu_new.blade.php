 

@foreach($opt as $o)

{{$o->option}}

@if($o->type=="Dropdown")
<input type="hidden" id="{{$o->option}}" name="{{$o->option}}"  value=""/>
@endif
@if($o->type=="Checkbox")

@endif



<ul class="list-group">
    <input type="hidden" name="{{$o->option}}"  value=""/>
@foreach($submenu as $d)

@if($d->option==$o->option)

<li class="list-group-item" onclick="addtocartopt({{$d->id}})" id="{{$d->id}}" data-option="{{$o->option}}" data-type="{{$o->type}}" style="overflow: hidden;"><p class="pull-left ">{{$d->name}}</p> <p class="pull-right">{{$d->price}}</p> </li>
  
  

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
    function addtocartopt(id) {
        
        var type=$("#"+id).attr("data-type");
      if(type=="Dropdown") {
          $("#"+$("#"+id).attr("data-option")).val(id);
           alert($("#"+id).attr("data-option"));
      }
      
        if(type=="Checkbox") {
            var old=$("#"+$("#"+id).attr("data-option")).val();
            var newd=old+"-"+id;
          $("#"+$("#"+id).attr("data-option")).val(newd);
           alert($("#"+id).attr("data-option"));
      }
       
        
    }
    
    
    </script>