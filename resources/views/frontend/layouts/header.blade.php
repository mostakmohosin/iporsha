<header class="header shop">
    <!-- Middle Inner -->
    <div class="middle-inner">
        <div class="container">
            <div class="row">
                <!-- Logo and Search Form -->
                <div class="col-lg-2 col-md-2 col-12">
                    <div class="logo">
                        @php
                            $settings=DB::table('settings')->get();
                        @endphp
                        <a href="{{route('home')}}"><img src="@foreach($settings as $data) {{$data->logo}} @endforeach" alt="logo"></a>
                    </div>
                    <!-- Search Form -->
                    <div class="search-top">
                        <!-- Top Search -->
                        <div class="top-search"><a href="#0"><i class="ti-search"></i></a></div>
                        <!-- Search Form -->
                        <div class="search-top">
                            <form class="search-form">
                                <input type="text" placeholder="Search here..." name="search">
                                <button value="search" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                        <!--/ End Search Form -->
                    </div>
                    <!--/ End Search Form -->
                    <div class="mobile-nav"></div>
                </div>

                <!-- Search Bar -->
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="search-bar-top">
                        <div class="search-bar">
                            <!-- Search Form -->
                            <form method="POST" action="{{route('product.search')}}">
                                @csrf
                                <input name="search" placeholder="Search Products Here....." type="search">
                                <button class="btnn" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Wishlist and Cart -->
                <div class="col-lg-2 col-md-3 col-12">
                    <div class="right-bar">
                        <!-- Wishlist and Shopping Cart -->
                        <div class="sinlge-bar shopping">
                            <!-- Wishlist Icon -->
                            @php
                                $total_prod=0;
                                $total_amount=0;
                            @endphp
                            @if(session('wishlist'))
                                @foreach(session('wishlist') as $wishlist_items)
                                    @php
                                        $total_prod+=$wishlist_items['quantity'];
                                        $total_amount+=$wishlist_items['amount'];
                                    @endphp
                                @endforeach
                            @endif
                            <a href="{{route('wishlist')}}" class="single-icon"><i class="fa fa-heart-o"></i> <span class="total-count">{{Helper::wishlistCount()}}</span></a>

                            <!-- Shopping Item (Wishlist) -->
                            @auth
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span>{{count(Helper::getAllProductFromWishlist())}} Items</span>
                                        <a href="{{route('wishlist')}}">View Wishlist</a>
                                    </div>
                                    <ul class="shopping-list">
                                        @foreach(Helper::getAllProductFromWishlist() as $data)
                                            @php
                                                $photo=explode(',',$data->product['photo']);
                                            @endphp
                                            <li>
                                                <a href="{{route('wishlist-delete',$data->id)}}" class="remove" title="Remove this item"><i class="fa fa-remove"></i></a>
                                                <a class="cart-img" href="#"><img src="{{$photo[0]}}" alt="{{$photo[0]}}"></a>
                                                <h4><a href="{{route('product-detail',$data->product['slug'])}}" target="_blank">{{$data->product['title']}}</a></h4>
                                                <p class="quantity">{{$data->quantity}} x - <span class="amount">${{number_format($data->price,2)}}</span></p>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="bottom">
                                        <div class="total">
                                            <span>Total</span>
                                            <span class="total-amount">${{number_format(Helper::totalWishlistPrice(),2)}}</span>
                                        </div>
                                        <a href="{{route('cart')}}" class="btn animate">Cart</a>
                                    </div>
                                </div>
                            @endauth
                            <!--/ End Shopping Item (Wishlist) -->
                        </div>

                        <!-- Shopping Cart Icon -->
                        <div class="sinlge-bar shopping">
                            <a href="{{route('cart')}}" class="single-icon"><i class="ti-bag"></i> <span class="total-count">{{Helper::cartCount()}}</span></a>

                            <!-- Shopping Item (Cart) -->
                            @auth
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span>{{count(Helper::getAllProductFromCart())}} Items</span>
                                        <a href="{{route('cart')}}">View Cart</a>
                                    </div>
                                    <ul class="shopping-list">
                                        @foreach(Helper::getAllProductFromCart() as $data)
                                            @php
                                                $photo=explode(',',$data->product['photo']);
                                            @endphp
                                            <li>
                                                <a href="{{route('cart-delete',$data->id)}}" class="remove" title="Remove this item"><i class="fa fa-remove"></i></a>
                                                <a class="cart-img" href="#"><img src="{{$photo[0]}}" alt="{{$photo[0]}}"></a>
                                                <h4><a href="{{route('product-detail',$data->product['slug'])}}" target="_blank">{{$data->product['title']}}</a></h4>
                                                <p class="quantity">{{$data->quantity}} x - <span class="amount">${{number_format($data->price,2)}}</span></p>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="bottom">
                                        <div class="total">
                                            <span>Total</span>
                                            <span class="total-amount">${{number_format(Helper::totalCartPrice(),2)}}</span>
                                        </div>
                                        <a href="{{route('checkout')}}" class="btn animate">Checkout</a>
                                    </div>
                                </div>
                            @endauth
                            <!--/ End Shopping Item (Cart) -->
                        </div>

                        <!-- Dropdown for Login/Register -->
                        <div class="sinlge-bar shopping">
                            <a href="#" class="single-icon"><i class="ti-user"></i></a>

                            <!-- Login/Register Dropdown -->
                            <div class="shopping-item">
                                <ul class="list-main">
                                    @auth
                                        @if(Auth::user()->role=='admin')
                                            <li><i class="ti-user"></i> <a href="{{route('admin')}}"  target="_blank">Dashboard</a></li>
                                        @else
                                            <li><i class="ti-user"></i> <a href="{{route('user')}}"  target="_blank">Dashboard</a></li>
                                        @endif
                                        <li><i class="ti-power-off"></i> <a href="{{route('user.logout')}}">Logout</a></li>
                                    @else
                                        <li><i class="ti-power-off"></i><a href="{{route('login.form')}}">Login /</a> <a href="{{route('register.form')}}">Register</a></li>
                                    @endauth
                                </ul>
                            </div>
                            <!--/ End Login/Register Dropdown -->
                        </div>
                        <!--/ End Wishlist and Shopping Cart -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Middle Inner -->

    <!-- Navbar Start -->
    <div class="container-fluid mb-5">
        <div class="row border-top px-xl-5">
            <!-- Categories Dropdown (Left Sidebar) -->
            <div class="container-fluid mb-5">
                <div class="row border-top px-xl-5" >
                    <div class="col-lg-3 d-none d-lg-block" >
                        <a class="btn shadow-none d-flex align-items-center justify-content-between text-white w-100"
                            data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px; background: rgb(48, 47, 47);">
                            <h6 class="m-0">All Categories</h6>
                            <i class="fa fa-angle-down text-dark"></i>
                        </a>
                        <nav class="collapse {{ Request::path() == '/' ? 'show' : '' }} navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0"
                            id="navbar-vertical">
                            <div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
                                <div class="nav-item dropdown">
                                    <nav class="navbar navbar-expand-lg bg-dark navbar-light py-3 py-lg-0 px-0">

                                        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse" style="">
                                            <div class="navbar-nav mr-auto py-0" >
                                                <!-- Main Navigation Links -->
                                                <ul class="nav main-menu menu navbar-nav"  >
                                                    {{Helper::getHeaderCategory()}}
                                                </ul>
                                            </div>
                                        </div>
                                    </nav>
                                    <a href="" class="nav-item nav-link">Jumpsuits</a>
                                    <a href="" class="nav-item nav-link">Blazers</a>
                                    <a href="" class="nav-item nav-link">Jackets</a>
                                </div>
                            </div>
                        </nav>
                    </div>
                    <div class="col-lg-9">
                        <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse"style="background-color: rgb(48, 47, 47)">
                                <div class="navbar-nav mr-auto py-0" >
                                    <!-- Main Navigation Links -->
                                    <ul class="nav main-menu menu navbar-nav"  >
                                        <li class="{{Request::path()=='home' ? 'active' : ''}}"><a href="{{route('home')}}">Store List</a></li>
                                        <li class="{{Request::path()=='contact' ? 'active' : ''}}"><a href="{{route('contact')}}">Shop</a></li>
                                        <li class="{{Request::path()=='home' ? 'active' : ''}}"><a href="{{route('home')}}">Top Deals</a></li>
                                        <li class="{{Request::path()=='about-us' ? 'active' : ''}}"><a href="{{route('about-us')}}">Vendor Registration</a></li>
                                        <li class="@if(Request::path()=='product-grids'||Request::path()=='product-lists')  active  @endif"><a href="{{route('product-grids')}}">Career</a></li>
                                        <li class="{{Request::path()=='blog' ? 'active' : ''}}"><a href="{{route('blog')}}">Inquire</a></li>
                                        <li class="{{Request::path()=='product/track' ? 'active' : ''}}"><a href="{{route('order.track')}}">Track Order</a></li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                        <!-- Main Menu and Slider Area -->
                        <!--/ End Main Menu -->
                        <!-- Slider Area -->
                        @if(isset($banners) && count($banners) > 0)
                            <section id="header-carousel" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    @foreach($banners as $key=>$banner)
                                        <li data-target="#header-carousel" data-slide-to="{{$key}}" class="{{(($key==0)? 'active' : '')}}"></li>
                                    @endforeach
                                </ol>
                                <div class="carousel-inner" role="listbox">
                                    @foreach($banners as $key=>$banner)
                                        <div class="carousel-item {{(($key==0)? 'active' : '')}}" style="height: 410px;">
                                            <img class="img-fluid" src="{{$banner->photo}}" alt="Slide Image">
                                            <div class="carousel-caption d-flex flex-column align-items-center ">
                                                <h1 class="wow fadeInDown" style="color: yellow">{{$banner->title}}</h1>
                                        <span style="color: rgb(0, 0, 0)">{!! html_entity_decode($banner->description) !!}</span>
                                        <a class="btn btn-lg ws-btn wow fadeInUpBig" href="{{route('product-grids')}}" role="button">Shop Now<i class="far fa-arrow-alt-circle-right"></i></a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#header-carousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#Gslider" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
    </a>
</section>
@endif

<!--/ End Slider Area -->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Header Inner -->
</header>
