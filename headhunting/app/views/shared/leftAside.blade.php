      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="../dist/img/avatar5.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>{{Auth::user()->first_name." ".Auth::user()->last_name}}</p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            @if(Auth::user()->getRole() == 1)
              <li class="treeview">
              <a href="#">
                <i class="fa fa-users"></i> <span>Employees</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{ URL::route('employee-list') }}"><i class="fa fa-user"></i>Employee List</a></li>
                <li><a href="{{ URL::route('add-employee') }}"><i class="fa fa-user-plus"></i>Add Employee</a></li>
              </ul>
            </li>
            @endif
            @if(Auth::user()->getRole() <= 3)
              <li class="treeview">
              <a href="#">
                <i class="fa fa-users"></i> <span>Clients</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{ URL::route('client-list') }}"><i class="fa fa-user"></i>Client List</a></li>
                <li><a href="{{ URL::route('add-client') }}"><i class="fa fa-user-plus"></i>Add Client</a></li>
              </ul>
            </li>
            @endif
            @if(Auth::user()->getRole() <= 3)
              <li class="treeview">
              <a href="#">
                <i class="fa fa-users"></i> <span>Vendors</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{ URL::route('vendor-list') }}"><i class="fa fa-user"></i>Vendor List</a></li>
                <li><a href="{{ URL::route('add-vendor') }}"><i class="fa fa-user-plus"></i>Add Vendor</a></li>
              </ul>
            </li>
            @endif
            @if(Auth::user()->getRole() <= 3)
            <li class="treeview">
              <a href="#">
                <i class="fa fa-bookmark-o"></i> <span>Requirements</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{ URL::route('list-requirement') }}"><i class="fa fa-level-down"></i>Posted Requirements</a></li>
                <li><a href="{{ URL::route('post-requirement') }}"><i class="fa fa-plus"></i>Post Requirement</a></li>
                <li><a href="{{ URL::route('assigned-requirement', array(Auth::user()->id)) }}"><i class="fa fa-upload"></i>Assigned Requirement</a></li>
              </ul>
            </li>
            @else
	            <li class="treeview">
	              <a href="#">
	                <i class="fa fa-bookmark-o"></i> <span>Requirements</span> <i class="fa fa-angle-left pull-right"></i>
	              </a>
	              <ul class="treeview-menu">
	                <li><a href="{{ URL::route('list-requirement') }}"><i class="fa fa-level-down"></i>Posted Requirements</a></li>
	                <li><a href="{{ URL::route('assigned-requirement', array(Auth::user()->id)) }}"><i class="fa fa-upload"></i>Assigned Requirement</a></li>
	              </ul>
	            </li>
            @endif
            @if(Auth::user()->getRole() <= 3)
              <li class="treeview">
              <a href="#">
                <i class="fa fa-users"></i> <span>Candidates</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{ URL::route('candidate-list') }}"><i class="fa fa-user"></i>Candidate List</a></li>
                <li><a href="{{ URL::route('add-candidate') }}"><i class="fa fa-user-plus"></i>Add Candidate</a></li>
              </ul>
            </li>
            @endif
            <li>
              <a href="{{ URL::route('advance-search') }}">
                <i class="fa fa-search"></i> <span>Search</span>
              </a>
            </li>
			<li>
              <a href="{{ URL::route('peers') }}">
                <i class="fa fa-users"></i> <span>My Team</span>
              </a>
            </li>

          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
