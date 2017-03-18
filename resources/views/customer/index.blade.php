@extends('customer.layout.master')

@section('content')

<header>
    <div class="container">
        <div class="row">
            <div class="header-content">
                <div class="header-content-inner text-center col-sm-12">
                    <h1><b>Feeling Hungry ?</b></h1>
                    <div class='col-sm-6 col-sm-offset-3'>
                        <form id="search">
                            <div class="input-group input-group-lg" >
                                <input type="text"  name="searcht" id="searcht" class="form-control" aria-label="..." placeholder="Enter Postal Code">
                                <div class="input-group-btn">
                                    <!-- Buttons -->
                                    <button type="button" id="sbutton" class="btn btn-danger btn-group-lg">I am Hungry!</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>

@include('customer.layout.navigation')

<section id="download" class="download bg-primary text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2 class="section-heading">Coming Soon On!</h2>
                <div class="badges">
                    <a class="badge-link" href="#"><img src="img/google-play-badge.svg" alt=""></a>
                    <a class="badge-link" href="#"><img src="img/app-store-badge.svg" alt=""></a>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="contact" class="contact" >
    <div class="container">
        <h2>We <i class="fa fa-heart"></i> new friends!</h2>
        <ul class="list-inline list-social">
           
            <li class="social-facebook">
                <a href="https://www.facebook.com/talkfood.ca"><i class="fa fa-facebook"></i></a>
            </li>
               <li class="social-twitter">
                <a href="https://twitter.com/TalkFoodCanada"><i class="fa fa-twitter"></i></a>
            </li>
           
        </ul>
    </div>
</section>


@endsection

@section('scripts')
<script>
    $(document).ready(function () {

        $("#sbutton").click(function () {

            search();

        });
        $("#searcht").keypress(function (event) {
            if (event.which == 13) {
                event.preventDefault();
                search();
            }

        });


        function search() {
            var lat = '';
            var lng = '';

                    window.location.href = '{{URL::TO('/search')}}/' + 45.9638923 + '/' + -66.6777752;
            var address = $("#searcht").val().toUpperCase();
            //alert(address);
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'address': address}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    lat = results[0].geometry.location.lat();
                    lng = results[0].geometry.location.lng();
                    //alert(results);
                    //.log(results);
                    window.location.href = '{{URL::TO('/search')}}/' + lat + '/' + lng;

                } else {
                    alert("Geocode was not successful for the following reason: " + status);
                }
            });
        }
        
      
    $( "#searcht" ).geocomplete();
        
        
    });

</script>
@endsection