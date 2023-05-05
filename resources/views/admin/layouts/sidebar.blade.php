<!-- ============================================================== -->
<!-- Topbar header - style you can find in pages.scss -->
<!-- ============================================================== -->
<header class="topbar" data-navbarbg="skin5">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header" data-logobg="skin5">
            <!-- This is for the sidebar toggle which is visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                <i class="ti-menu ti-close"></i>
            </a>
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <div class="navbar-brand">
                <a href="index.html" class="logo text-center">
                    <!-- Logo icon -->
                    <b class="logo-icon">
                        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                        <!-- Dark Logo icon -->
                        <!-- Light Logo icon -->
                        <img src="{{asset('assets/img/logos/logo-all-white.png')}}" alt="homepage" class="light-logo"  style="width: 50%" />
                    </b>
                    <!--End Logo icon -->
                    <!-- Logo text -->
                    <span class="logo-text">
                                <!-- dark Logo text -->
                        <!-- Light Logo text -->
                            </span>
                </a>
                <a class="sidebartoggler d-none d-md-block" href="javascript:void(0)" data-sidebartype="mini-sidebar">
                    <i class="mdi mdi-toggle-switch mdi-toggle-switch-off font-20"></i>
                </a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Toggle which is visible on mobile only -->
            <!-- ============================================================== -->
            <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent"
               aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="ti-more"></i>
            </a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse pr-0" id="navbarSupportedContent">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-left mr-auto">
            </ul>
            <!-- ============================================================== -->
            <!-- Right side toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-right">

                <!-- User profile and search -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark pro-pic text-white" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #FF0080;">
                        <img src="{{asset('assets/img/user-placeholder.png')}}" alt="user" class="rounded-circle" width="40">
                        <span class="m-l-5 font-medium d-none d-sm-inline-block">{{Session::get('admin.username')}} <i class="mdi mdi-chevron-down"></i></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <span class="with-arrow">
                                    <span class="bg-dark"></span>
                                </span>
                        <div class="d-flex no-block align-items-center p-15 text-white m-b-10" style="background-color: #231F20">
                            <div class="">
                                <img src="{{asset('assets/img/user-placeholder.png')}}" alt="user" class="rounded-circle" width="40">
                            </div>
                            <div class="m-l-10">
                                <h4 class="m-b-0">{{Session::get('admin.username')}}</h4>
                                <p class=" m-b-0">{{Session::get('admin.email')}}</p>
                            </div>
                        </div>
                        <div class="profile-dis scrollable">
                            <a class="dropdown-item" href="{{route('admin_panel_logout')}}">
                                <i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                        </div>
                    </div>
                </li>
                <!-- ============================================================== -->

            </ul>
        </div>
    </nav>
</header>
<!-- ============================================================== -->
<!-- End Topbar header -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">

                <?php
                $db_tables = DB::select('show tables');
                $not_to_show_table = array('tags','sub_tags');

                $show_tables = array('companies','admin_users','users');


                ?>

                <li class="sidebar-item">
                    <a class="sidebar-link "  href="{{url('/admin/tags')}}">
                        <i class="mdi mdi-home"></i>
                        <span>Tag Detayları</span>
                    </a>
                </li>
                @foreach($db_tables as $table)
                    @foreach($table as $key=>$value)

                        @if(in_array($value,$not_to_show_table))
                            @continue;

                        @endif
                        @if(in_array($value,$show_tables))


                                <li class="sidebar-item">
                                    <a class="sidebar-link "  href="{{url('/admin/'.$value)}}" {{ Request::is($value) ? 'active' : '' }}>
                                        <i class="mdi mdi-calendar-clock"></i>
                                        <span>{{ LanguageChange(FixName($value)) }}</span>
                                    </a>
                                </li>
                        @endif
                    @endforeach
                @endforeach
                <li class="nav-small-cap">
                    <i class="mdi mdi-dots-horizontal"></i>
                    <span class="hide-menu">Yönetim</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="ti-bolt-alt"></i>
                        <span class="hide-menu">Yönetim </span>
                    </a>
                    <ul aria-expanded="false" class="collapse  first-level">

                        <li class="sidebar-item">
                            <a class="sidebar-link"  href="{{route('admin_panel_admin_users')}}">
                                <i class="fas fa-users"></i>
                                <span>{{LanguageChange('Admin Users')}}</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link"  href="{{route('admin_panel_admin_user_types')}}">
                                <i class="fas fa-user-md"></i>
                                <span>{{LanguageChange('Admin User Types')}}</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link "  href="{{route('admin_panel_permission_types')}}">
                                <i class="fas fa-shield-alt"></i>
                                <span>{{LanguageChange('Permission Types')}}</span>
                            </a>
                        </li>

                    </ul>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>


