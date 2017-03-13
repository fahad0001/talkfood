<div class="user-panel">
        <div class="pull-left image">
        <img src="{{URL::to('/uploads/'.$rest->rest_logo_path)}}">
        </div>
        <div class="pull-left info">
          <p>{{$rest->rest_name}}</p>
        </div>
</div>
<ul class="sidebar-menu">
    <div class="dropdown col-md-offset-4">
        <button class="btn btn-primary dropdown-toggle" id="menu1" type="button" data-toggle="dropdown">{{$rest->rest_avail==NULL?'Select Availibility':$rest->rest_avail}}
        <span class="caret"></span></button>
        <ul id="menuavail" class="dropdown-menu" role="menu" aria-labelledby="menu1">
            <li role="presentation"><a data-value="Online" role="menuitem" tabindex="-1">Online</a></li>
            <li role="presentation"><a data-value="Offline" role="menuitem" tabindex="-1">Offline</a></li>  
        </ul>
    </div>
     <li class="header">MAIN NAVIGATION</li>
    <li class="treeview">
        <a href="{{URL::to('restaurant/index')}}">
            <i class="fa fa-dashboard"></i> <span>Order</span>
            <span class="pull-right-container">
              <!--<i class="fa fa-angle-left pull-right"></i>-->
            </span>
        </a>

    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-dashboard"></i> <span>Menu</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="{{URL::to('restaurant/viewcategory')}}"><i class="fa fa-circle-o"></i> Add Categories</a></li>
            <li><a href="{{URL::to('restaurant/addmenuitem')}}"><i class="fa fa-circle-o"></i> Add Menu Item</a></li>
            <li><a href="{{URL::to('restaurant/viewmenuitem')}}"><i class="fa fa-circle-o"></i> View Menu Item</a></li>
          </ul>
    </li>
    <li class="treeview">
        <a href="{{URL::to('restaurant/salereport')}}">
            <i class="fa fa-dashboard"></i> <span>Sales</span>
            <span class="pull-right-container">
              <!--<i class="fa fa-angle-left pull-right"></i>-->
            </span>
        </a>

    </li>
    <li class="treeview">
        <a href="{{URL::to('restaurant/viewprofile')}}">
            <i class="fa fa-user"></i> <span>Profile Info</span>
            <span class="pull-right-container">
              <!--<i class="fa fa-angle-left pull-right"></i>-->
            </span>
        </a>
    </li>
</ul>
 