<nav id="mainNav" class="navbar navbar-default navbar-fixed-top" style="background-color:white;color:black;">
    <div class="container" style="color:black;">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand page-scroll" href="{{URL::to("/")}}" style="color:black;">TalkFood</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                 <li>
                        <a class="page-scroll" href="{{URL::to('/login')}}">Login</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="{{URL::to('/signup')}}">Sign Up</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="https://www.talkfood.org/faq">Faq</a>
                    </li>
                       @if(isset($currentUser))
                @if($currentUser->role=="cus")
                <li>
                    <a href="{{URL::to('/customer/account')}}" class="page-scroll">Account
                    </a>
                </li>
                <li>
                    <a href="{{URL::to('logout')}}" class="page-scroll">Logout
                    </a>
                </li>
                @endif
                @endif
                     <li>
                         
                         <a href="{{URL::to('/cart')}}" class="page-scroll">Cart <span id="cartcount" class="badge">@if(isset($cart)) {{Session::get('cart')['totalquantity']}} @elseif(Session::has('cart')) {{Session::get('cart')['totalquantity']}}@else {{0}}  @endif</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>