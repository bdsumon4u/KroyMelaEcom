<header class="main-nav">
  <div class="logo-wrapper">
    <a href="{{route('/')}}">
      <span class="h4 m-0">{{ $company->name }}</span>
    </a>
    <div class="back-btn"><i class="fa fa-angle-left"></i></div>
    <div class="toggle-sidebar"><i class="status_toggle middle" data-feather="grid" id="sidebar-toggle"> </i></div>
  </div>
  <div class="logo-icon-wrapper">
    <a href="{{route('/')}}">
      <img class="img-fluid" src="{{asset($logo->favicon ?? '')}}" width="36" height="36" alt="">
    </a>
  </div>
  <nav>
    <div class="main-navbar">
      <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
      <div id="mainnav">
        <ul class="nav-menu custom-scrollbar">
          <li class="back-btn">
            <a href="{{route('/')}}">
              <img class="img-fluid" src="{{asset($logo->favicon ?? '')}}" height="36" width="36" alt="">
            </a>
            <div class="mobile-back text-right"><span>Back</span><i class="fa fa-angle-right pl-2" aria-hidden="true"></i></div>
          </li>
          <li>
            <a class="nav-link menu-title link-nav {{ Route::currentRouteName()=='admin.home' ? 'active' : '' }}" href="{{route('admin.home')}}">
              <i data-feather="home"> </i>
              <span>Dashboard</span>
            </a>
          </li>

          <li>
            <a class="nav-link menu-title link-nav {{ Route::currentRouteName()=='admin.slides.index' ? 'active' : '' }}" href="{{route('admin.slides.index')}}">
              <i data-feather="image"> </i>
              <span>Slides</span>
            </a>
          </li>

          <li>
            <a class="nav-link menu-title link-nav {{ request()->is('admin/orders*') ? 'active' : '' }}" href="{{route('admin.orders.index')}}">
              <i data-feather="check"> </i>
              <span>Orders</span>
            </a>
          </li>

            <li class="dropdown">
                <a class="nav-link menu-title {{request()->is('admin/categories*') ? 'active' : '' }}" href="#">
                    <i data-feather="server"> </i><span>Categories</span>
                    <div class="according-menu"><i class="fa fa-angle-{{request()->is('admin/categories*') ? 'down' : 'right' }}"></i></div>
                </a>

                <ul class="nav-submenu menu-content" style="display: {{ request()->is('admin/categories*') ? 'block;' : 'none;' }}">
                    <li>
                        <a class="nav-link menu-title link-nav {{ Route::currentRouteName()=='admin.categories.index' ? 'active' : '' }}" href="{{route('admin.categories.index')}}">
                            <span>All Categories</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav {{ Route::currentRouteName()=='admin.category-menus.index' ? 'active' : '' }}" href="{{route('admin.category-menus.index')}}">
                            <span>Category Menu</span>
                        </a>
                    </li>
                </ul>
            </li>

          <li>
            <a class="nav-link menu-title link-nav {{ Route::currentRouteName()=='admin.brands.index' ? 'active' : '' }}" href="{{route('admin.brands.index')}}">
              <i data-feather="wind"> </i>
              <span>Brands</span>
            </a>
          </li>
          <li>
            <a class="nav-link menu-title link-nav {{ Route::currentRouteName()=='admin.images.index' ? 'active' : '' }}" href="{{route('admin.images.index')}}">
              <i data-feather="image"> </i>
              <span>Images</span>
            </a>
          </li>

          <li class="dropdown">
            <a class="nav-link menu-title {{request()->is('admin/products*') ? 'active' : '' }}" href="#">
              <i data-feather="shopping-cart"> </i><span>Products</span>
              <div class="according-menu"><i class="fa fa-angle-{{request()->is('admin/products*') ? 'down' : 'right' }}"></i></div>
            </a>

            <ul class="nav-submenu menu-content" style="display: {{ request()->is('admin/products*') ? 'block;' : 'none;' }}">
              <li>
                <a class="nav-link menu-title link-nav {{ Route::currentRouteName()=='admin.products.index' ? 'active' : '' }}" href="{{route('admin.products.index')}}">
                  <span>All Products</span>
                </a>
              </li>
              <li>
                <a class="nav-link menu-title link-nav {{ Route::currentRouteName()=='admin.products.create' ? 'active' : '' }}" href="{{route('admin.products.create')}}">
                  <span>Create Product</span>
                </a>
              </li>
            </ul>
          </li>

          <li class="dropdown">
            <a class="nav-link menu-title {{request()->is('admin/home-sections*') ? 'active' : '' }}" href="#">
              <i data-feather="layers"> </i><span>Home Sections</span>
              <div class="according-menu"><i class="fa fa-angle-{{request()->is('admin/home-sections*') ? 'down' : 'right' }}"></i></div>
            </a>

            <ul class="nav-submenu menu-content" style="display: {{ request()->is('admin/home-sections*') ? 'block;' : 'none;' }}">
              <li>
                <a class="nav-link menu-title link-nav {{ Route::currentRouteName()=='admin.home-sections.index' ? 'active' : '' }}" href="{{route('admin.home-sections.index')}}">
                  <span>All Sections</span>
                </a>
              </li>
              <li>
                <a class="nav-link menu-title link-nav {{ Route::currentRouteName()=='admin.home-sections.create' ? 'active' : '' }}" href="{{route('admin.home-sections.create')}}">
                  <span>Create Section</span>
                </a>
              </li>
            </ul>
          </li>

          <li class="dropdown">
            <a class="nav-link menu-title {{request()->is('admin/pages*') ? 'active' : '' }}" href="#">
              <i data-feather="layers"> </i><span>Pages</span>
              <div class="according-menu"><i class="fa fa-angle-{{request()->is('admin/pages*') ? 'down' : 'right' }}"></i></div>
            </a>

            <ul class="nav-submenu menu-content" style="display: {{ request()->is('admin/pages*') ? 'block;' : 'none;' }}">
              <li>
                <a class="nav-link menu-title link-nav {{ Route::currentRouteName()=='admin.pages.index' ? 'active' : '' }}" href="{{route('admin.pages.index')}}">
                  <span>All Pages</span>
                </a>
              </li>
              <li>
                <a class="nav-link menu-title link-nav {{ Route::currentRouteName()=='admin.pages.create' ? 'active' : '' }}" href="{{route('admin.pages.create')}}">
                  <span>Create Page</span>
                </a>
              </li>
            </ul>
          </li>

          <li>
            <a class="nav-link menu-title link-nav {{ Route::currentRouteName()=='admin.menus.index' ? 'active' : '' }}" href="{{route('admin.menus.index')}}">
              <i data-feather="menu"> </i>
              <span>Menus</span>
            </a>
          </li>

          <li>
            <a class="nav-link menu-title link-nav {{ Route::currentRouteName()=='admin.staffs.index' ? 'active' : '' }}" href="{{route('admin.staffs.index')}}">
              <i data-feather="users"> </i>
              <span>Staffs</span>
            </a>
          </li>
        </ul>
      </div>
      <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
    </div>
  </nav>
</header>
