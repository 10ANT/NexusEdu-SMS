<style>
/* Sidebar styles */
.sidebar {
  background-color: #222;
  border-right: 1px solid #222;
}

.sidebar .nav-link {
  color: #f5f5f5;
  padding: 12px 20px;
  font-size: 14px;
  font-weight: 500;
  transition: background-color 0.3s, color 0.3s;
}

.sidebar .nav-link:hover,
.sidebar .nav-link.active {
  background-color: #444;
  color: #fff;
}

.sidebar .nav-link i {
  margin-right: 10px;
  font-size: 16px;
}

.sidebar .nav-item-submenu .nav-link {
  padding-left: 40px;
}

.sidebar .nav-item-submenu .nav-group-sub .nav-link {
  padding-left: 50px;
}

.sidebar .sidebar-user {
  background-color: #333;
  padding: 20px;
  border-bottom: 1px solid #222;
}

.sidebar .sidebar-user .media-title {
  color: #f5f5f5;
}

.sidebar .sidebar-user .font-size-xs {
  color: #ccc;
}

.sidebar .sidebar-user .rounded-circle {
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
}

.sidebar .sidebar-mobile-toggler {
  background-color: #2b2b2b;
  padding: 10px 20px;
  color: #f5f5f5;
  border-bottom: 1px solid #222;
}

.sidebar .sidebar-mobile-toggler i {
  font-size: 18px;
}

/* Hover and active states */
.sidebar .nav-link:hover {
  background-color: #3b3b3b;
}

.sidebar .nav-link.active {
  background-color: #444;
  color: #fff;
}

/* Responsive styles */
@media (max-width: 767px) {
  .sidebar {
    position: fixed;
    top: 0;
    left: -240px;
    width: 240px;
    height: 100%;
    transition: left 0.3s;
    z-index: 1000;
  }

  .sidebar.sidebar-mobile-open {
    left: 0;
  }

  .sidebar-mobile-toggler {
    display: block;
    text-align: right;
    padding: 10px 20px;
    color: #f5f5f5;
  }
}
</style>

<div class="sidebar sidebar sidebar-main sidebar-expand-md">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        Navigation
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user">
            <div class="card-body">
                <div class="media">
                    <div class="mr-3">
                        <a href="{{ route('my_account') }}"><img src="{{ Auth::user()->photo }}" width="38" height="38" class="rounded-circle" alt="photo"></a>
                    </div>

                    <div class="media-body">
                        <div class="media-title font-weight-semibold">{{ Auth::user()->name }}</div>
                        <div class="font-size-xs opacity-50">
                            <i class="icon-user font-size-sm"></i> &nbsp;{{ ucwords(str_replace('_', ' ', Auth::user()->user_type)) }}
                        </div>
                    </div>

                    <div class="ml-3 align-self-center">
                        <a href="{{ route('my_account') }}" class="text-white"><i class="icon-cog3"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /user menu -->

        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Main -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ (Route::is('dashboard')) ? 'active' : '' }}">
                        <i class="icon-home4"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                {{--Academics--}}
                @if(Qs::userIsAcademic())
                    <li class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['tt.index', 'ttr.edit', 'ttr.show', 'ttr.manage']) ? 'nav-item-expanded nav-item-open' : '' }} ">
                        <a href="#" class="nav-link"><i class="icon-graduation2"></i> <span> Academics</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Manage Academics">

                        {{--Timetables--}}
                            <li class="nav-item"><a href="{{ route('tt.index') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['tt.index']) ? 'active' : '' }}">Timetables</a></li>
                        </ul>
                    </li>
                    @endif

                {{--Administrative--}}
                @if(Qs::userIsAdministrative())
                    <li class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['payments.index', 'payments.create', 'payments.invoice', 'payments.receipts', 'payments.edit', 'payments.manage', 'payments.show',]) ? 'nav-item-expanded nav-item-open' : '' }} ">
                        <a href="#" class="nav-link"><i class="icon-office"></i> <span> Administrative</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Administrative">

                            {{--Payments--}}
                            @if(Qs::userIsTeamAccount())
                            <li class="nav-item nav-item-submenu {{ in_array(Route::currentRouteName(), ['payments.index', 'payments.create', 'payments.edit', 'payments.manage', 'payments.show', 'payments.invoice']) ? 'nav-item-expanded' : '' }}">

                                <a href="#" class="nav-link {{ in_array(Route::currentRouteName(), ['payments.index', 'payments.edit', 'payments.create', 'payments.manage', 'payments.show', 'payments.invoice']) ? 'active' : '' }}">Payments</a>

                                <ul class="nav nav-group-sub">
                                    <li class="nav-item"><a href="{{ route('payments.create') }}" class="nav-link {{ Route::is('payments.create') ? 'active' : '' }}">Create Payment</a></li>
                                    <li class="nav-item"><a href="{{ route('payments.index') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['payments.index', 'payments.edit', 'payments.show']) ? 'active' : '' }}">Manage Payments</a></li>
                                    <li class="nav-item"><a href="{{ route('payments.manage') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['payments.manage', 'payments.invoice', 'payments.receipts']) ? 'active' : '' }}">Student Payments</a></li>

                                </ul>

                            </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @include('pages.'.Qs::getUserType().'.menu')

              
                </ul>
            </div>
        </div>
</div>
