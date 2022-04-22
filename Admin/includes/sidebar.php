<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            
            <a class="nav-link active" href="index.php">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>

            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProducts" aria-expanded="false" aria-controls="collapseProducts">
                <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                Products
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseProducts" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link sub_nav_link" href="products.php">All Products</a>
                    <a class="nav-link sub_nav_link" href="trending_products.php">Trending Products</a>
                    <a class="nav-link sub_nav_link" href="product_color.php">Colors</a>
                    <a class="nav-link sub_nav_link" href="product_size.php">Sizes</a>
                </nav>
            </div>

            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategories" aria-expanded="false" aria-controls="collapseCategories">
                <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                Categories
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseCategories" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link sub_nav_link" href="category.php">Categories</a>
                    <a class="nav-link sub_nav_link" href="sub_category.php">Sub Category</a>
                </nav>
            </div>

            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOrders" aria-expanded="false" aria-controls="collapseOrders">
                <div class="sb-nav-link-icon"><i class="fas fa-cart-arrow-down	"></i></div>
                Orders
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseOrders" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link sub_nav_link" href="orders.php">All Orders</a>
                    <a class="nav-link sub_nav_link" href="pending_orders.php">Pending Orders</a>
                    <a class="nav-link sub_nav_link" href="completed_orders.php">Order History</a>
                </nav>
            </div>
            
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseServiser" aria-expanded="false" aria-controls="collapseServiser">
                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                Users
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseServiser" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link sub_nav_link" href="customers.php">Customers</a>
                </nav>
            </div>

            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAddress" aria-expanded="false" aria-controls="collapseAddress">
                <div class="sb-nav-link-icon"><i class="fas fa-address-book"></i></div>
                Address
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseAddress" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link sub_nav_link" href="cities.php">Cities</a>
                </nav>
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link sub_nav_link" href="states.php">States</a>
                </nav>
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link sub_nav_link" href="countries.php">Countries</a>
                </nav>
            </div>
        </div>
    </div>
</nav>