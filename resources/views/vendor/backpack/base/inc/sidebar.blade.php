@if (Auth::check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="https://placehold.it/160x160/00a65a/ffffff/&text={{ mb_substr(Auth::user()->name, 0, 1) }}" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>{{ Auth::user()->name }}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <li class="header">{{ trans('backpack::base.administration') }}</li>
          <!-- ================================================ -->
          <!-- ==== Recommended place for admin menu items ==== -->
          <!-- ================================================ -->
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
          <li><a href="{{ url('admin/timetable') }}"><i class="fa fa-calendar-times-o"></i> <span> TimeTables</span></a></li>

          <li class="treeview">
            <a href="#">
              <i class="fa fa-id-card"></i> <span>Shifts</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu menu-open" style="display: block;">
              <li><a href="{{ url('admin/shift') }}"><i class="fa fa-id-card-o"></i> <span> All Shifts</span></a></li>
              <li><a href="{{ url('admin/shift/create') }}"><i class="fa fa-plus-square"></i> Add Shift</a></li>
            </ul>
          </li>
          <li><a href="{{ url('admin/user/assignShift') }}"><i class="fa fa-user-circle"></i> <span> Assign Shifts</span></a></li>
          <li><a href="{{ url('admin/advance') }}"><i class="fa fa-money"></i> <span> Advances</span></a></li>

          <li><a href="{{ url('admin/holiday') }}"><i class="fa fa-calendar-o"></i> <span> Holidays</span></a></li>
          <li><a href="{{ url('admin/leave') }}"><i class="fa fa-user-o"></i> <span> Leaves</span></a></li>

          <li class="treeview">
            <a href="#">
              <i class="fa fa-newspaper-o"></i> <span>Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu" >
              <li><a href="{{ url('admin/report/general') }}"><i class="fa fa-circle-o"></i> General Report</a></li>
              <li><a href="{{ url('admin/report/detail') }}"><i class="fa fa-circle-o"></i> Detail Report</a></li>
            </ul>
          </li>
          <li><a href="{{ url('admin/report/schedule') }}"><i class="fa fa-users"></i> <span> Print Schedule</span></a></li>
          <li><a href="{{ url('admin/email') }}"><i class="fa fa-at"></i> <span> Emails</span></a></li>
          <li><a href="{{ url('admin/report/workingHours') }}"><i class="fa fa-sort-numeric-asc"></i> <span> Working Hours</span></a></li>



          <!-- ======================================= -->
          <li class="header">{{ trans('backpack::base.user') }}</li>
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/logout') }}"><i class="fa fa-sign-out"></i> <span>{{ trans('backpack::base.logout') }}</span></a></li>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
@endif
