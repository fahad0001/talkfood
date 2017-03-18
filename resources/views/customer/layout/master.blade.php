<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>TalkFood</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{URL::asset('bower_components/AdminLTE/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="{{URL::asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('bower_components/simple-line-icons/css/simple-line-icons.css')}}">
    <link rel="stylesheet" href="{{URL::asset('bower_components/device-mockups/device-mockups.min.css')}}">
     <link rel="stylesheet" href="{{URL::asset('css/mystyle.css?v=3')}}">

    <!-- Theme CSS -->
    <link href="{{URL::asset('css/new-age.min.css?v=1')}}" rel="stylesheet">
     <link rel="stylesheet" href="{{URL::asset('/css/jquery-ui.min.css')}}">

   @yield('style')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


 @if(isset($currentUser))
 
 
 <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-92155609-1', 'auto');
  ga('set', 'userId', "{{$currentUser->id}}");
  ga('send', 'pageview');

</script>
 
 
 @else
 
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-92155609-1', 'auto');
  ga('send', 'pageview');

</script>

@endif


</head>

<body id="page-top">




   @yield('content') 
  

   
@include('customer.layout.footer')
    <!-- jQuery -->
    <script src="{{URL::asset('bower_components/jquery/jquery.min.js')}}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{URL::asset('bower_components/AdminLTE/bootstrap/js/bootstrap.min.js')}}"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Theme JavaScript -->
    <script src="{{URL::asset('js/new-age.min.js')}}"></script>
    <script
  src="https://maps.googleapis.com/maps/api/js?v=3.6&sensor=false&key=AIzaSyDwg2kbpdgluP9bPWiXfsdqmuV71WXJ4I0&libraries=places">
</script>
 <script src="{{URL::asset('js/jquery.geocomplete.min.js')}}"></script>
<script src="{{URL::asset('js/parsley.min.js')}}"></script>
<script src="{{URL::asset('js/listgroup.min.js')}}"></script>

 @yield('scripts') 
  

</body>

</html>


