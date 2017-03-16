
@extends('layout.master')

@section('content')

    <input type="text" placeholder="Search..." name="term" id="countries">



@stop

@section('scripts')
<script>
//     $(function()
// {
// 	 $( "#q" ).autocomplete({
// 	  source: "search/autocomplete",
// 	  minLength: 3,
// 	  select: function(event, ui) {
// 	  	$('#q').val(ui.item.value);
// 	  }
// 	});
// });
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

  theme: "square"
};

$("#countries").easyAutocomplete(options);
});
</script>
@stop