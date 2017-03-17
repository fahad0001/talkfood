<nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand page-scroll" href="{{URL::to('/')}}">TalkFood</a>
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
                </li><li>
                    <a href="{{URL::to('logout')}}" class="page-scroll">Logout
                    </a>
                </li>
                @endif
                @endif

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle page-scroll" data-toggle="dropdown" style="background:none">Cart <span id="cartcount" class="badge">@if(isset($cart)) {{Session::get('cart')['totalquantity']}} @elseif(Session::has('cart')) {{Session::get('cart')['totalquantity']}}@else {{0}}@endif</span>
                    </a>
                    <ul class="dropdown-menu dropdown-cart" role="menu" style="padding: 10px 15px;width:250px">
                @if(isset($cart)) 
                <!--{{Session::get('cart')['totalquantity']}} -->
                @for ($i = 0; $i < (count(Session::get('cart'))-1); $i++)
                <li>
                  <span class="item">
                    <span class="item-left">
                        <span class="item-info">
                            <span>{{Session::get('cart')[$i]['food_name']}}</span>
                            <span class="pull-right"><b>{{Session::get('cart')[$i]['food_price']}}.$</b></span>
                        </span>
                    </span>
                </span>
              </li>
              <li class="divider"></li>
              @endfor
                @elseif(Session::has('cart')) 
                <!--{{Session::get('cart')['totalquantity']}}-->
               @for ($i = 0; $i < (count(Session::get('cart'))-1); $i++)
                <li>
                  <span class="item">
                    <span class="item-left">
                        <span class="item-info">
                            <span>{{Session::get('cart')[$i]['food_name']}}</span>
                            <span class="pull-right"><b>{{Session::get('cart')[$i]['food_price']}}.$</b></span>
                        </span>
                    </span>
                </span>
              </li>
              <li class="divider"></li>
              @endfor
                @else 
                <!--{{0}}  -->
                <li>
                  <span class="item">
                    <span class="item-left">
                        <span class="item-info">
                            <span><b>&nbsp No Items</b></span>
                        </span>
                    </span>
                </span>
              </li>
              <li class="divider"></li>
                @endif
              
              <li><a class="text-center" href="{{URL::to('/cart')}}">View Cart</a></li>
          </ul>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>