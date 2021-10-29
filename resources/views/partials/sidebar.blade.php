   <!-- Sidebar -->
   <ul class="navbar-nav bg-gradient-warning sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-shipping-fast"></i>
            {{-- <img src="{{URL::to('img/logo2c.jpg')}}" alt="Logo" height="60" width="60" style="border-radius: 10%;"> --}}
        </div>
        <div class="sidebar-brand-text mx-3">Max Post</div>
        {{-- <div class="sidebar-brand-text mx-3" style="color: #CF3733">MaxPost</div> --}}
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    

    @if ( auth()->user()->user_type == 'admin')
    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ (request()->is('/*')) ? 'active' : '' }}">
        <a class="nav-link" href="/">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
@endif

@if ( auth()->user()->user_type == 'admin')
    <li class="nav-item {{ (request()->is('driver*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{URL::to('/driver')}}">
            <i class="fas fa-fw fa-car"></i>
            <span>Drivers</span></a>
    </li>

    @endif
   
    @if ( auth()->user()->user_type == 'admin')

    <li class="nav-item {{ (request()->is('store*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{URL::to('/store')}}">
            <i class="fas fa-fw fa-store"></i>
            <span>Stores</span></a>
    </li>
@endif

    {{-- <li class="nav-item {{ (request()->is('post*')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo"> 
            <i class="fas fa fa-paper-plane"></i>
            <span>Posts</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Posts per:</h6>
                <a class="collapse-item" href="{{URL::to('/post/new')}}">New Posts</a>
                <a class="collapse-item" href="{{URL::to('/post/on-the-way')}}">On the way posts</a>
                <a class="collapse-item" href="{{URL::to('/post/delivered')}}">Delivered posts</a>
                <a class="collapse-item" href="{{URL::to('/post/refused')}}">Refused posts</a>
            </div>
        </div>
    </li> --}}
    
     <!-- Nav Item - Posts -->
     @if ( auth()->user()->user_type == 'admin'||auth()->user()->user_type=='employee')
     <li class="nav-item {{ (request()->is('post*')) ? 'active' : '' }}">
        <a href="{{URL::to('/post')}}" class="nav-link">
            <i class="fas fa fa-paper-plane"></i>
            <span>Posts</span></a>
     </li>
    @endif

     @if ( auth()->user()->user_type == 'admin')

    <!-- Nav Item - Cities -->
    <li class="nav-item {{ (request()->is('location*')) ? 'active' : '' }}">
        <a href="{{URL::to('/location')}}" class="nav-link">
            <i class="fas fa-city"></i>
            <span>Cities</span></a>
     </li>

      <!-- Nav Item - System Users -->
      <li class="nav-item {{ (request()->is('user*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{URL::to('user')}}">
            <i class="fas fa-user"></i>
            <span>System Users</span></a>
    </li>
    @endif
    <!-- Nav Item - Tables -->
    {{-- <li class="nav-item">
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a>
    </li> --}}

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->