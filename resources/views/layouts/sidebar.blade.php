<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <li class="sidebar-toggler-wrapper hide">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler"> </div>
                <!-- END SIDEBAR TOGGLER BUTTON -->
            </li>


            <li class="heading active"></li>
            <li class="nav-item open ">
                <a href="{{route('Dashboard')}}" class="nav-link nav-toggle">
                    <i class="icon-user"></i>
                    <span class="title">Home</span>
                    <span class="arrow"></span>
                </a>
            </li>
            @if(Auth::guard('admins')->user())


                <li class="nav-item open ">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-user"></i>
                        <span class="title">Users</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item">
                            <a href="{{route('add-user')}}" class="nav-link ">
                                <span class="title">Add User</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @else
                

                <li class="nav-item open ">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-cloud-upload"></i>
                        <span class="title">Contact Address</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item">
                            <a href="{{route('contact')}}" class="nav-link ">
                                <span class="title">Upload contact Address</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('contact-list-page')}}" class="nav-link ">
                                <span class="title">Address list</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item open ">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-cloud-upload"></i>
                        <span class="title">Sim Information</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item">
                            <a href="{{route('sim-contact')}}" class="nav-link ">
                                <span class="title">Upload Sim Information</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('sim-list-page')}}" class="nav-link ">
                                <span class="title">Sim Information List</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item open ">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-cloud-upload"></i>
                        <span class="title">Report</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu" style="{{(Request::is('user/report*')) ? 'display: block' : ''}}">
                        <li class="nav-item">
                            <a href="{{route('report')}}" class="nav-link ">
                                <span class="title">Success Report</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('report-failed')}}" class="nav-link ">
                                <span class="title">Failed Report</span>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="{{route('report-pending')}}" class="nav-link ">
                                <span class="title">Pending Report</span>
                            </a>
                        </li>

                        {{--<li class="nav-item">
                            <a href="{{route('report-retry')}}" class="nav-link ">
                                <span class="title">Retry Report</span>
                            </a>
                        </li>--}}


                    </ul>
                </li>

                <li class="nav-item open ">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-cloud-upload"></i>
                        <span class="title">Sim Registration</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu" style="{{(Request::is('user/report*')) ? 'display: block' : ''}}">
                        <li class="nav-item">
                            <a href="{{route('registration-page')}}" class="nav-link ">
                                <span class="title">Test Api</span>
                            </a>
                        </li>
                    </ul>
                </li>


            @endif



        </ul>
        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>