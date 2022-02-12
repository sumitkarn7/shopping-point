<div class="sidebar-menu">
        <ul class="menu">
            
            
                <li class='sidebar-title'>Main Menu</li>
            
            
            
                <li class="sidebar-item {{ request()->routeIs('admin') ?'active':'inactive'}}">
                    <a href="{{ route('admin')}}" class='sidebar-link '>
                        <i data-feather="home" width="20"></i> 
                        <span>Dashboard</span>
                    </a>
                    
                </li>

                <li class="sidebar-item {{ request()->routeIs('banner.*') ?'active':''}}">
                    <a href="{{ route('banner.index') }}" class='sidebar-link '>
                        <i data-feather="bold" width="20"></i> 
                        <span>Banner</span>
                    </a>
                    
                </li>


                <li class="sidebar-item {{ request()->routeIs('brand.*') ?'active':''}}">
                    <a href="{{ route('brand.index') }}" class='sidebar-link '>
                        <i data-feather="briefcase" width="20"></i> 
                        <span>Brand</span>
                    </a>
                    
                </li>

                <li class="sidebar-item {{ request()->routeIs('category.*') ?'active':''}}">
                    <a href="{{ route('category.index') }}" class='sidebar-link '>
                        <i data-feather="list" width="20"></i> 
                        <span>Category</span>
                    </a>
                    
                </li>


                <li class="sidebar-item {{ request()->routeIs('product.*') ?'active':''}}">
                    <a href="{{ route('product.index') }}" class='sidebar-link '>
                        <i data-feather="shopping-cart" width="20"></i> 
                        <span>Product</span>
                    </a>
                    
                </li>

                <li class="sidebar-item {{ request()->routeIs('user.*') ?'active':''}}">
                    <a href="{{ route('user.index') }}" class='sidebar-link '>
                        <i data-feather="users" width="20"></i> 
                        <span>Users</span>
                    </a>
                    
                </li>


                <li class="sidebar-item {{ request()->is('admin/page/page') ?'active':''}}">
                    <a href="{{ route('page.show','page') }}" class='sidebar-link '>
                        <i data-feather="book-open" width="20"></i> 
                        <span>Pages Module</span>
                    </a>
                    
                </li>


                <li class="sidebar-item {{ request()->is('admin/page/blog') ?'active':''}}">
                    <a href="{{ route('page.show','blog') }}" class='sidebar-link '>
                        <i data-feather="book" width="20"></i> 
                        <span>Review/Blog Module</span>
                    </a>
                    
                </li>


                <li class="sidebar-item {{ request()->routeIs('promotion.*') ?'active':''}}">
                    <a href="{{ route('promotion.index') }}" class='sidebar-link '>
                        <i data-feather="dollar-sign" width="20"></i> 
                        <span>Promotion Module</span>
                    </a>
                    
                </li>

            
            

            
            
         
        </ul>
    </div>