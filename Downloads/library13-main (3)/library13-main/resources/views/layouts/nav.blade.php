   <nav class="navbar navbar-expand navbar-light navbar-bg">
       <a class="sidebar-toggle js-sidebar-toggle">
           <i class="hamburger align-self-center"></i>
       </a>

       <div class="navbar-collapse collapse">
           <ul class="navbar-nav navbar-align">
                <li>
                    <form action="lang"  method="get">
                        <select name="lang"  class="form-select" onchange="submit()">
                            <option value="ar" @selected(app()->getLocale() == 'ar' )>عربي</option>
                            <option value="en" @selected(app()->getLocale() == 'en' )>English</option>
                        </select>
                    </form>
                </li>
               <li class="nav-item dropdown">
                   <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#"
                       data-bs-toggle="dropdown">
                       <i class="align-middle" data-feather="settings"></i>
                   </a>

                   <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#"
                       data-bs-toggle="dropdown">                       
                       <span class="text-dark">Charles Hall</span>
                   </a>
                   <div class="dropdown-menu dropdown-menu-end">
                       <a class="dropdown-item" href="pages-profile.html"><i class="align-middle me-1"
                               data-feather="user"></i> Profile</a>
                       <a class="dropdown-item" href="#"><i class="align-middle me-1"
                               data-feather="pie-chart"></i> Analytics</a>
                       <div class="dropdown-divider"></div>
                       <a class="dropdown-item" href="index.html"><i class="align-middle me-1"
                               data-feather="settings"></i> Settings & Privacy</a>
                       <a class="dropdown-item" href="#"><i class="align-middle me-1"
                               data-feather="help-circle"></i> Help Center</a>
                       <div class="dropdown-divider"></div>
                       <a class="dropdown-item" href="#">Log out</a>
                   </div>
               </li>
           </ul>
       </div>
   </nav>
