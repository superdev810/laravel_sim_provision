
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="{{route('Dashboard')}}">
                <img src="" /> </a>
            <div class="menu-toggler sidebar-toggler"> </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
               
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        @if(Auth::guard('admins')->user())
                            <span class="username username-hide-on-mobile"> {{Auth::guard('admins')->user()->username}} </span>
                            <i class="fa fa-angle-down"></i>
                        @else
                            <span class="username username-hide-on-mobile"> {{Auth::user()->fullname}} </span>
                            <img alt="" class="img-circle" src="{{Gravatar::get(Auth::user()->email)}}" />
                            <i class="fa fa-angle-down"></i>
                        @endif

                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        
                        <li class="divider"> </li>
                       
                        @if(Auth::guard('admins')->user())
                            <li>
                                <a href="{{url('/admin/logout')}}">
                                    <i class="icon-key"></i> Log Out </a>
                            </li>
                        @else
                            <li>
                                <a href="{{url('/logout')}}">
                                    <i class="icon-key"></i> Log Out </a>
                            </li>
                        @endif

                    </ul>
                </li>

            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>