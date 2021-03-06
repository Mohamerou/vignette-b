
    <header>
        <!-- Header Start -->
        <div class="header-area ">
            <div class="main-header header-sticky">
                <div class="container-fluid">
                    <div class="menu-wrapper d-flex align-items-center justify-content-between">
                        <div class="header-left d-flex align-items-center">
                            <!-- Logo -->
                            <div class="logo">
                                <a href="index.html"><img src="../assets/img/logo/optique.png" alt=""></a>
                            </div>
                            <!-- Main-menu -->
                            <div class="main-menu  d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">
                                        <li><a href="{{route('index')}}">Accueil</a></li> 
                                        <li><a href="shop.html">Boutique</a></li>
                                        <li><a href="about.html">A-propos</a></li>
                                     {{--    <li><a href="blog.html"></a>
                                            <ul class="submenu">
                                                <li><a href="blog.html">Blog</a></li>
                                                <li><a href="blog_details.html">Blog Details</a></li>
                                                <li><a href="elements.html">Elements</a></li>
                                                <li><a href="product_details.html">Product Details</a></li>
                                            </ul>
                                        </li> --}}

                                        <li><a href="contact.html">Contact</a></li>
                                    </ul>
                                </nav>
                                 @include('partials.alert')
                             </div>
                        </div>
                        <div class="header-right1 d-flex align-items-center">
                            <!-- Social -->
                            <div class="header-social d-none d-md-block">
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="https://bit.ly/sai4ull"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-pinterest-p"></i></a>
                            </div>
                            <!-- Search Box -->
                            <div class="search d-none d-md-block">
                                <ul class="d-flex align-items-center">
                                    <li class="mr-15">
                                        <div class="nav-search search-switch">
                                            <i class="ti-search"></i>
                                        </div>
                                    </li>
                                {{-- carte affichage ordinateur --}}
                                    <li>
                                    <a href="{{route('cart.index')}}">
                                        <div class="card-stor">
                                            <img src="../assets/img/gallery/card.svg" alt="">
                                            <span>{{Cart::count()}}</span>
                                        </div>
                                    </a>
                                    </li>
                                      
                                </ul>
                            </div>
                        </div>
         <!-- Mobile Menu -->
                 <!--? Hero Area Start-->
        <div class="container-fluid">
            <div class="slider-area">
                <!-- Mobile Device Show Menu-->
                <div class="header-right2 d-flex align-items-center">
                    <!-- Social -->
                    <div class="header-social  d-block d-md-none">
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="https://bit.ly/sai4ull"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-pinterest-p"></i></a>
                    </div>
                    <!-- Search Box -->
                    <div class="search d-block d-md-none" >
                        <ul class="d-flex align-items-center">
                            <li class="mr-15">
                                <div class="nav-search search-switch">
                                    <i class="ti-search"></i>
                                </div>
                            </li>
                            {{-- cart affichage phone --}}
                            <li>
                              <a href="{{route('cart.index')}}">
                                <div class="card-stor">
                                    <i class="fab fa-cart "></i>
                                    <span>{{Cart::count()}}</span>
                                 
                                </div>
                              </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /End mobile  Menu-->
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>
    <!-- header end -->