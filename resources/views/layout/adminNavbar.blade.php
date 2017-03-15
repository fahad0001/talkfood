<ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview ">
                <a href="{{URL::to('/admin/index')}}">
                    <i class="fa fa-dashboard"></i> <span>All Restaurants</span>
                    <span class="pull-right-container">
                      <!--<i class="fa fa-angle-left pull-right"></i>-->
                    </span>
                </a>

            </li>
            <li class="treeview ">
                <a href="{{URL::to('/admin/viewcustomer')}}">
                    <i class="fa fa-dashboard"></i> <span>All Customers</span>
                    <span class="pull-right-container">
                      <!--<i class="fa fa-angle-left pull-right"></i>-->
                    </span>
                </a>

            </li>
            <li class="treeview">
                <a href="{{URL::to('/admin/settings')}}">
                    <i class="fa fa-cog"></i> <span>Setting</span>
                    <span class="pull-right-container">
                      <!--<i class="fa fa-angle-left pull-right"></i>-->
                    </span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{URL::to('/admin/commission')}}">
                    <i class="fa fa-money"></i> <span>Commission</span>
                    <span class="pull-right-container">
                      <!--<i class="fa fa-angle-left pull-right"></i>-->
                    </span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{URL::to('/admin/promotions')}}">
                    <i class="fa fa-money"></i> <span>Promotion Settings</span>
                    <span class="pull-right-container">
                      <!--<i class="fa fa-angle-left pull-right"></i>-->
                    </span>
                </a>
            </li>

            
             <li class="treeview">
                <a href="{{URL::to('/admin/allorders')}}">
                    <i class="fa fa-money"></i> <span>All Orders</span>
                    <span class="pull-right-container">
                      <!--<i class="fa fa-angle-left pull-right"></i>-->
                    </span>
                </a>
            </li>
           
               <li class="treeview">
        <a href="#">
            <i class="fa fa-money"></i> <span>Menu</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class=""><a href="{{URL::to('admin/viewcategory')}}"><i class="fa fa-circle-o"></i> Add Categories</a></li>
            <li><a href="{{URL::to('admin/addmenuitem')}}"><i class="fa fa-circle-o"></i> Add Menu Item</a></li>
            <!-- <li><a href="{{URL::to('restaurant/viewmenuitem')}}"><i class="fa fa-circle-o"></i> View Menu Item</a></li>-->
          </ul>
    </li>
        </ul>