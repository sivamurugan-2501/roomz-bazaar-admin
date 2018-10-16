 <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <div class="portal-logo">
                <img src="images/pro-icon.png" />
                <span>Property Portal</span>
            </div>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="production/images/default-user.png" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2>{{ ucfirst(strtolower(Auth::user()->name )) }}</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br/>

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-home"></i> Property <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{route('add-edit-property')}}">Add</a></li>
                      <li><a href="{{route('list-property')}}">View All</a></li>
                      <li><a href="{{route('add-edit-property')}}">Dashboard</a></li>
                    </ul>

                  <!--li><a href="{{route('property.index')}}"><i class="fa fa-home"></i> Property</a></li-->

                  <li><a href="{{route('propertytypemaster.index')}}"><i class="fa fa-globe"></i> Property Type Master</a></li>
                    <li><a href="{{route('countries.index')}}"><i class="fa fa-globe"></i> Countries</a></li>
                    <li><a href="{{route('roles.index')}}"><i class="fa fa-users"></i> Roles Management</a></li>
                    <li><a href="{{route('backendusers.index')}}"><i class="fa fa-user"></i> User Management</a></li>
                  </li>

                   <li><a><i class="fa fa-spinner"></i> Master <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li>
                        <a>Property Type</a>
                          <ul class="nav child_menu">
                            <li><a href="{{route('add-edit-property')}}">View</a></li>
                            <li><a href="{{route('add-edit-property')}}">Add</a></li>
                          </ul>
                      </li>
                    </ul>
                  </li>
                  
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>