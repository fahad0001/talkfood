<aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      

      <!-- search form (Optional) -->
      
      <!-- /.search form -->
       <!-- Sidebar Menu -->
  
       
       
       
       @if($currentUser->role=='rest')
       @include('layout.restNavbar')
       @endif
       
       @if($currentUser->role=='admin')
       @include('layout.adminNavbar')
       @endif
      <!--<ul class="sidebar-menu">
        <li class="header">HEADER</li>
      </ul>-->
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>