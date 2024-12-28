<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{url('public/admin/offer/logo_20160222155327.png')}}" class="img-circle" alt="User Image" />
      </div>
      <div class="pull-left info">
        <p> Local Tourism </p>
      </div>
    </div>

    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
        <li class="treeview">
            <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-tachometer"></i>Dasboard</a></li>
        </li>

        @canany(['View All Roles','Add Roles'])
        <li class="treeview">
            <a href="#">

            <i class="fa fa-user-secret"></i><span>Roles</span>

            <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                @can('Add Roles')
                <li><a href="{{route('admin.roles.create')}}"><i class="fa fa-circle-o"></i>Add Roles</a></li>
                @endcan
                @can('View All Roles')
                <li><a href="{{route('admin.roles.index')}}"><i class="fa fa-circle-o"></i>View Roles</a></li>
                @endcan
            </ul>
        </li>
        @endcanany

        @canany(['View Permissions','Add Permissions'])
        <li class="treeview">
            <a href="#">

            <i class="fa fa-wrench"></i><span>Permission</span>

            <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                @can('Add Permissions')
                <li><a href="{{route('admin.permissions.create')}}"><i class="fa fa-circle-o"></i>Add Permission</a></li>
                @endcan
                @can('View Permissions')
                <li><a href="{{route('admin.permissions.index')}}"><i class="fa fa-circle-o"></i>View Permission</a></li>
                @endcan
            </ul>
        </li>
        @endcanany

        @canany(['View Place','Add Place'])
        <li class="treeview">
            <a href="#">

            <i class="fa fa-home"></i><span>Places</span>

            <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                @can('Add Place')
                <li><a href="{{route('admin.places.create')}}"><i class="fa fa-circle-o"></i>Add Places</a></li>
                @endcan
                @can('View Place')
                <li><a href="{{route('admin.places.index')}}"><i class="fa fa-circle-o"></i>View Places</a></li>
                @endcan
            </ul>
        </li>
        @endcanany

        @canany(['View Hotel','Add Hotel'])
        <li class="treeview">
            <a href="#">

            <i class="fa fa-h-square"></i><span>Hotel</span>

            <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                @can('Add Hotel')
                <li><a href="{{route('admin.hotels.create')}}"><i class="fa fa-circle-o"></i>Add Hotel</a></li>
                @endcan
                @can('View Hotel')
                <li><a href="{{route('admin.hotels.index')}}"><i class="fa fa-circle-o"></i>View Hotel</a></li>
                @endcan
            </ul>
        </li>
        @endcanany

        @canany(['View Room','Add Room'])
        <li class="treeview">
            <a href="#">

            <i class="fa fa-home"></i><span>Rooms</span>

            <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                @can('Add Room')
                <li><a href="{{route('admin.rooms.create')}}"><i class="fa fa-circle-o"></i>Add Room</a></li>
                @endcan
                @can('View Room')
                <li><a href="{{route('admin.rooms.index')}}"><i class="fa fa-circle-o"></i>View Room</a></li>
                @endcan
            </ul>
        </li>
        @endcanany

        @canany(['View Taxi','Add Taxi'])
        <li class="treeview">
            <a href="#">

            <i class="fa fa-car"></i><span>Taxi Service</span>

            <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                @can('Add Taxi')
                <li><a href="{{route('admin.taxi.create')}}"><i class="fa fa-circle-o"></i>Add Taxi Service</a></li>
                @endcan
                @can('View Taxi')
                <li><a href="{{route('admin.taxi.index')}}"><i class="fa fa-circle-o"></i>View Taxi Service</a></li>
                @endcan
            </ul>
        </li>
        @endcanany

        @canany(['View Traking','Add Traking'])
        <li class="treeview">
            <a href="#">

            <i class="fa fa-home"></i><span>Traking Service</span>

            <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                @can('Add Traking')
                <li><a href="{{route('admin.traking.create')}}"><i class="fa fa-circle-o"></i>Add Traking Service</a></li>
                @endcan
                @can('View Traking')
                <li><a href="{{route('admin.traking.index')}}"><i class="fa fa-circle-o"></i>View Traking Service</a></li>
                @endcan
            </ul>
        </li>
        @endcanany

        @canany(['View Guide','Add Guide'])
        <li class="treeview">
            <a href="#">

            <i class="fa fa-home"></i><span>Guide</span>

            <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                @can('Add Guide')
                <li><a href="{{route('admin.guide.create')}}"><i class="fa fa-circle-o"></i>Add Guide</a></li>
                @endcan
                @can('View Guide')
                <li><a href="{{route('admin.guide.index')}}"><i class="fa fa-circle-o"></i>View Guide</a></li>
                @endcan
            </ul>
        </li>
        @endcanany

        @canany(['View Blog','Add Blog'])
        <li class="treeview">
            <a href="#">

            <i class="fa fa-home"></i><span>Content Management</span>

            <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                @can('View Guide')
                <li><a href="{{route('admin.blog.index')}}"><i class="fa fa-circle-o"></i>Blog</a></li>
                @endcan
                @can('View Service')
                <li><a href="{{route('admin.service.index')}}"><i class="fa fa-circle-o"></i>Service</a></li>
                @endcan
            </ul>
        </li>
        @endcanany

      </li>
    </ul>
  </section>
