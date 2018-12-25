@extends('layouts.mainsite')

@section('header')
	<div id="app">
        <div class="sub-nav">
            <div class="container">
                <div class="col-xs-8 col-sm-6 col-md-6 col-lg-6 info"><i class="fa fa-clock-o"></i> {{ $settings->work_hour }} | <i class="fa fa-phone"></i> {{ $settings->phone }}</div>
                <div class="col-xs-4 col-sm-6 col-md-6 col-lg-6 account pull-right">
                    @if(Auth::guard('customer')->check())
                        <a href="/tai-khoan">
                            <i class="fa fa-user"></i>
                            <span>{{ Auth::guard('customer')->user()->name }}</span>
                        </a>
                    @else
                        <a href="{{ route('customer.login') }}">
                            <i class="fa fa-user"></i>
                            <span>Tài khoản</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="logo-nav">
            <div class="container">
                <!-- Branding Image -->
                <div class="col-xs-12 col-sm-3 col-lg-4 custom-no-padding">
                    <a class="navbar-brand" href="{{ route('index') }}">
                        <img class="img-responsive logo" src="{{ asset('images/black.png') }}"/>
                    </a>
                </div>

                <div class="col-xs-12 col-sm-7 col-md-6 col-md-offset-1 col-lg-6 col-lg-offset-1 custom-no-padding">
                    <div class="input-custom-group">
                        {!! Form::open(['method'=>'GET','action'=>'PagesController@search']) !!}
                            <input type="text" class="input-text" aria-label="..." placeholder="Bạn cần tìm gì?" name="search_query">
                            <select name="item_category_id">
                                <option value="0">Tất cả</option>
                                <option value="2">Full kits</option>
                                <option value="1">Thân máy</option>
                                <option value="3">Buồng đốt</option>
                                <option value="4">Tinh dầu</option>
                                <option value="5">Phụ kiện</option>
                            </select>
                            <button type="submit" name="search" id="search-btn" class="input-submit" value="tim_kiem"><i class="fa fa-search"></i></button>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2 col-md-1 col-lg-1">
                    <a href="{{route('cart.index')}}">
                        <div class="cart">
                            <img class="img-responsive logo" src="{{ asset('images/cart.png') }}"/>
                            <span class="badge">{{ Session::has('cart') ? Session::get('cart')->totalQty : '' }}</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-default">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <div class="navbar-cart">
                        <a href="{{route('cart.index')}}">
                            <div class="cart-header">
                                <img class="img-responsive" src="{{ asset('images/cart.png') }}"/>
                                <span class="badge">{{ Session::has('cart') ? Session::get('cart')->totalQty : '' }}</span>
                            </div>
                        </a>
                    </div>

                    <a href="">
                        <div class="brand-navigation">
                            <img class="img-responsive logo" src="{{ asset('images/black.png') }}"/>
                        </div>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <div class="div-navbar-center">
                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-center">
                            <!-- Authentication Links -->
                            @if($top_nav->pages->isNotEmpty())
                                @foreach($top_nav->pages as $pageslist)
                                    @if($pageslist->pageChildren->isNotEmpty())
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                                {{ $pageslist->name }}
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                @foreach($pageslist->pageChildren as $pagechild)
                                                    <li>
                                                        <a href="/{{ $pageslist->slug }}/{{ $pagechild->slug }}">{{ $pagechild->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @else
                                        <li><a href="/{{ $pageslist->slug }}">{{ $pageslist->name }}</a></li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </div>

                </div>
            </div>
        </nav>
    </div>

@endsection

@section('footer')
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                    <div class="footer-section-title">
                        Ec distribution
                    </div>
                    <ul>
                        <li>{{ $settings->address }}</li>
                        <li>Hotline: {{ $settings->phone }}</li>
                        <li>Thời gian làm việc: {{ $settings->work_hour }}</li>
                        <li>Email: <a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a></li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                    <div class="footer-section-title">
                        Danh mục sản phẩm
                    </div>
                    <ul>
                        @foreach($footer_1st_menu->pages as $pageslist)
                            <li><a href="/{{ $pageslist->slug }}">{{ $pageslist->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                    <div class="footer-section-title">
                        Điều khoản chung
                    </div>
                    <ul>
                        @foreach($footer_2nd_menu->pages as $pageslist)
                            <li><a href="/{{ $pageslist->slug }}">{{ $pageslist->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                    <div class="footer-section-title">
                        Facebook fanpage
                    </div>
                    <div id="facebook-page"></div>
                </div>
            </div>
        </div>
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>

        <!-- Your customer chat code -->
        <div class="fb-customerchat"
             attribution=setup_tool
             page_id="356955021359698">
        </div>
    </footer>

@endsection