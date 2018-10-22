@extends('layouts.headerfooter')

@section('meta')
    <title>EC Distribution</title>
    

    <!-- seo thong thuong-->
    <meta name="keywords" content="{{ $settings->keywords }}" />
    <meta name="description" content="{{ $settings->description }}" />
    <meta name="author" content="EC Distribution" />
    <meta name="revisit-after" content="1 days" />
    <meta name="robots" content="index,follow" />
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <!-- meta google -->
    <meta itemprop="name" content="Home | EC Distribution">
    <meta itemprop="description" content="{{ $settings->description }}">
    <meta itemprop="image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    <!-- meta facebook -->
    <meta property="fb:app_id" content="" />
    <meta property="og:url" content="{{ route('index') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="EC Distribution">
    <meta property="og:title" content="Home | EC Distribution" />
    <meta property="og:description" content="{{ $settings->description }}" />
    <meta property="og:image" content="{{ asset('images/1531112245_media_Rouge-100-Back.jpg') }}" />

    {{ $settings->google_id }}
    {{ $settings->webmaster }}

@endsection

@section('slider')
	<div class="container container-carousel no-padding">
        <header id="main_slider" class="carousel slide">
            <!-- Indicators -->
            <ol class="carousel-indicators">
            	@php 
					$i = 0
	            @endphp
	            @foreach($main_slider->sliderDetails as $slider)
                	<li data-target="#main_slider" data-slide-to="{{ $i }}" class="{{ $i ==0 ? 'active' : '' }}"></li>
                @php 
					$i++
	            @endphp
                @endforeach
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
            	@php 
					$i = 0
	            @endphp
	            @foreach($main_slider->sliderDetails as $slider)
                <div class="item {{ $i ==0 ? 'active' : '' }}">
                    <a href="{{ $slider->link }}"><img class="img-responsive" src="{{ asset($slider->media->url) }}" alt="{{ $slider->media->alt_text }}"></a>
                </div>
                @php 
					$i++
	            @endphp
                @endforeach
            </div>
            <a class="left carousel-control" href="#main_slider" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#main_slider" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
        </header>
    </div>

@endsection

@section('content')
	<section class="item-div">
        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
        <div class="container">
            <div class="col-lg-12 custom-no-padding">
                <div class="items-title">
                    <div class="active">Thân máy</div>
                    <div><a href="">Mech</a></div>
                    <div><a href="">Box</a></div>
                    <select name="" id="">
                        <option value="">Mech</option>
                        <option value="">Box</option>
                    </select>
                    <div class="item-hr"></div>
                </div>
            </div>
            <div class="col-lg-12 custom-no-padding">
                <div class="items-carousel">
                	@foreach($boxes as $box)
                		@if($box->medias()->where('media_id', $box->item->index_img)->get()->isNotEmpty())
	                    <div>
                            <div class="item">
                                <a href="{{ $box->item->itemCategory->slug }}/{{ $box->item->id }}/{{ $box->item->slug }}">
                                    <img class="img-responsive" 
                                    src="
                                    @foreach($box->medias()->where('media_id', $box->item->index_img)->get() as $img)
                                    {{ asset($img->url) }}
                                    @endforeach
                                    " alt="">
                                    <div class="item-name">{{ $box->brand->name . ' ' . $box->item->name }}</div>
                                    <div class="item-price">
                                        @if($box->item->price_off > 0 || $box->item->price_off != null)
                                            {{ number_format($box->item->price_off,0, ",",".") }} VNĐ
                                            <span>{{ number_format($box->item->price,0, ",",".") }} VNĐ</span>
                                            
                                        @else
                                            {{ number_format($box->item->price,0, ",",".") }} VNĐ
                                        @endif
                                    </div>
                                    
                                </a>
                                <input type="hidden" name="hid_item_id" id="hid_item_id_{{ $box->item->id }}" value="{{ $box->id }}">
                                <input type="hidden" name="hid_category_id" id="hid_category_id_{{ $box->item->id }}" value="{{ $box->item_category_id }}">
                                <div class="btn-cart" id="{{ $box->item->id }}">Thêm vào giỏ hàng <i class="fa fa-cart-plus"></i></div>
                            </div> 
	                    </div>
	                    @else
						<div>
	                        <div class="item">
                                <a href="{{ $box->item->itemCategory->slug }}/{{ $box->item->id }}/{{ $box->item->slug }}">
                                    @if($box->medias()->first() == null)
                                    <img class="img-responsive" src="https://via.placeholder.com/650x650?text=No+image" alt="">
                                    @else
                                    <img class="img-responsive" 
                                    src="
                                    {{ asset($box->medias()->first()->url) }}
                                    " alt="">
                                    @endif
                                    <div class="item-name">{{ $box->brand->name . ' ' . $box->item->name }}</div>
                                    <div class="item-price">
                                        @if($box->item->price_off > 0 || $box->item->price_off != null)
                                            {{ number_format($box->item->price_off,0, ",",".") }} VNĐ
                                            <span>{{ number_format($box->item->price,0, ",",".") }} VNĐ</span>
                                            
                                        @else
                                            {{ number_format($box->item->price,0, ",",".") }} VNĐ
                                        @endif
                                    </div>
                                    
                                </a>
                                <input type="hidden" name="hid_item_id" id="hid_item_id_{{ $box->item->id }}" value="{{ $box->id }}">
                                <input type="hidden" name="hid_category_id" id="hid_category_id_{{ $box->item->id }}" value="{{ $box->item_category_id }}">
                                <div class="btn-cart" id="{{ $box->item->id }}">Thêm vào giỏ hàng <i class="fa fa-cart-plus"></i></div>
                            </div>
	                    </div>		
	                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    
    <section class="item-div">
        <div class="container">
            <div class="col-lg-12 custom-no-padding">
                <div class="items-title">
                    <div class="active">Buồng Đốt</div>
                    @foreach($tankcategories as $category)
                    <div><a href="/buong-dot/{{ $category['slug'] }}">{{ $category['name'] }}</a></div>
                    @endforeach
                    <select name="" id="">
                        @foreach($tankcategories as $category)
                        <option value="">{{ $category['name'] }}</option>
                        @endforeach
                    </select>
                    <div class="item-hr"></div>
                </div>
            </div>
            <div class="col-lg-12 custom-no-padding">
                <div class="container-carousel no-padding" style="margin-bottom:20px">
                    <div id="1st_sub_slider" class="carousel slide">
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                            @php 
                                $i = 0
                            @endphp
                            @foreach($first_sub_slider->sliderDetails as $slider)
                            <div class="item {{ $i ==0 ? 'active' : '' }}">
                                <img class="img-responsive" src="{{ asset($slider->media->url) }}" alt="{{ $slider->media->alt_text }}">
                            </div>
                            @php 
                                $i++
                            @endphp
                            @endforeach
                        </div>
                       
                    </div>
                </div>

                <div class="items-carousel">
                    @foreach($tanks as $tank)
                        @if($tank->medias()->where('media_id', $tank->item->index_img)->get()->isNotEmpty())
                        <div>
                            <div class="item">
                                <a href="/buong-dot/{{ $tank->item->itemCategory->slug }}/{{ $tank->item->id }}/{{ $tank->item->slug }}">
                                    <img class="img-responsive" 
                                    src="
                                    @foreach($tank->medias()->where('media_id', $tank->item->index_img)->get() as $img)
                                    {{ asset($img->url) }}
                                    @endforeach
                                    " alt="">
                                    <div class="item-name">{{ $tank->brand->name . ' ' . $tank->item->name }}</div>
                                    <div class="item-price">
                                        @if($tank->item->price_off > 0 || $tank->item->price_off != null)
                                            {{ number_format($tank->item->price_off,0, ",",".") }} VNĐ
                                            <span>{{ number_format($tank->item->price,0, ",",".") }} VNĐ</span>
                                            
                                        @else
                                            {{ number_format($tank->item->price,0, ",",".") }} VNĐ
                                        @endif
                                    </div>
                                    
                                </a>
                                <input type="hidden" name="hid_item_id" id="hid_item_id_{{ $tank->item->id }}" value="{{ $tank->id }}">
                                <input type="hidden" name="hid_category_id" id="hid_category_id_{{ $tank->item->id }}" value="{{ $tank->item_category_id }}">
                                <div class="btn-cart" id="{{ $tank->item->id }}">Thêm vào giỏ hàng <i class="fa fa-cart-plus"></i></div>
                            </div> 
                        </div>
                        @else
                        <div>
                            <div class="item">
                                <a href="/buong-dot/{{ $tank->item->itemCategory->slug }}/{{ $tank->item->id }}/{{ $tank->item->slug }}">
                                    @if($tank->medias()->first() == null)
                                    <img class="img-responsive" src="https://via.placeholder.com/650x650?text=No+image" alt="">
                                    @else
                                    <img class="img-responsive" 
                                    src="
                                    {{ asset($tank->medias()->first()->url) }}
                                    " alt="">
                                    @endif
                                    <div class="item-name">{{ $tank->brand->name . ' ' . $tank->item->name }}</div>
                                    <div class="item-price">
                                        @if($tank->item->price_off > 0 || $tank->item->price_off != null)
                                            {{ number_format($tank->item->price_off,0, ",",".") }} VNĐ
                                            <span>{{ number_format($tank->item->price,0, ",",".") }} VNĐ</span>
                                            
                                        @else
                                            {{ number_format($tank->item->price,0, ",",".") }} VNĐ
                                        @endif
                                    </div>
                                    
                                </a>
                                <input type="hidden" name="hid_item_id" id="hid_item_id_{{ $tank->item->id }}" value="{{ $tank->id }}">
                                <input type="hidden" name="hid_category_id" id="hid_category_id_{{ $tank->item->id }}" value="{{ $tank->item_category_id }}">
                                <div class="btn-cart" id="{{ $tank->item->id }}">Thêm vào giỏ hàng <i class="fa fa-cart-plus"></i></div> 
                            </div>
                        </div>      
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="item-div">
        <div class="container">
            <div class="col-lg-12 custom-no-padding">
                <div class="items-title">
                    <div class="active">Tinh dầu</div>
                    @foreach($juicecategories as $category)
                    <div><a href="/tinh-dau-vape/{{ $category['slug'] }}">{{ $category['name'] }}</a></div>
                    @endforeach
                    <select name="" id="">
                        @foreach($juicecategories as $category)
                        <option value="">{{ $category['name'] }}</option>
                        @endforeach
                    </select>
                    <div class="item-hr-2"></div>
                </div>
            </div>
            <div class="col-lg-12 custom-no-padding">
                <div class="container-carousel no-padding" style="margin-bottom:20px">
                    <div id="2nd_sub_slider" class="carousel slide">
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                            @php 
                                $i = 0
                            @endphp
                            @foreach($second_sub_slider->sliderDetails as $slider)
                            <div class="item {{ $i ==0 ? 'active' : '' }}">
                                <img class="img-responsive" src="{{ asset($slider->media->url) }}" alt="{{ $slider->media->alt_text }}">
                            </div>
                            @php 
                                $i++
                            @endphp
                            @endforeach
                        </div>
                       
                    </div>
                </div>

                <div class="items-carousel">
                    @foreach($juices as $juice)
                        @if($juice->medias()->where('media_id', $juice->item->index_img)->get()->isNotEmpty())
                        <div>
                            <div class="item">
                                <a href="/tinh-dau-vape/{{ $juice->item->itemCategory->slug }}/{{ $juice->item->id }}/{{ $juice->item->slug }}">
                                    <img class="img-responsive" 
                                    src="
                                    @foreach($juice->medias()->where('media_id', $juice->item->index_img)->get() as $img)
                                    {{ asset($img->url) }}
                                    @endforeach
                                    " alt="">
                                    <div class="item-name">{{ $juice->brand->name . ' ' . $juice->item->name }}</div>
                                    <div class="item-price">
                                        @if($juice->item->price_off > 0 || $juice->item->price_off != null)
                                            {{ number_format($juice->item->price_off,0, ",",".") }} VNĐ
                                            <span>{{ number_format($juice->item->price,0, ",",".") }} VNĐ</span>
                                            
                                        @else
                                            {{ number_format($juice->item->price,0, ",",".") }} VNĐ
                                        @endif
                                    </div>
                                    
                                </a>
                                <input type="hidden" name="hid_item_id" id="hid_item_id_{{ $juice->item->id }}" value="{{ $juice->id }}">
                                <input type="hidden" name="hid_category_id" id="hid_category_id_{{ $juice->item->id }}" value="{{ $juice->item_category_id }}">
                                <div class="btn-cart" id="{{ $juice->item->id }}">Thêm vào giỏ hàng <i class="fa fa-cart-plus"></i></div>
                            </div> 
                        </div>
                        @else
                        <div>
                            <div class="item">
                                <a href="/tinh-dau-vape/{{ $juice->item->itemCategory->slug }}/{{ $juice->item->id }}/{{ $juice->item->slug }}">
                                    @if($juice->medias()->first() == null)
                                    <img class="img-responsive" src="https://via.placeholder.com/650x650?text=No+image" alt="">
                                    @else
                                    <img class="img-responsive" 
                                    src="
                                    {{ asset($juice->medias()->first()->url) }}
                                    " alt="">
                                    @endif
                                    <div class="item-name">{{ $juice->brand->name . ' ' . $juice->item->name }}</div>
                                    <div class="item-price">
                                        @if($juice->item->price_off > 0 || $juice->item->price_off != null)
                                            {{ number_format($juice->item->price_off,0, ",",".") }} VNĐ
                                            <span>{{ number_format($juice->item->price,0, ",",".") }} VNĐ</span>
                                            
                                        @else
                                            {{ number_format($juice->item->price,0, ",",".") }} VNĐ
                                        @endif
                                    </div>
                                    
                                </a>
                                <input type="hidden" name="hid_item_id" id="hid_item_id_{{ $juice->item->id }}" value="{{ $juice->id }}">
                                <input type="hidden" name="hid_category_id" id="hid_category_id_{{ $juice->item->id }}" value="{{ $juice->item_category_id }}">
                                <div class="btn-cart" id="{{ $juice->item->id }}">Thêm vào giỏ hàng <i class="fa fa-cart-plus"></i></div>
                            </div>
                        </div>      
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="item-div">
        <div class="container">
            <div class="col-lg-12 custom-no-padding">
                <div class="items-title">
                    <div class="active">Phụ kiện</div>
                    @foreach($accessorycategories as $category)
                    <div><a href="/phu-kien/{{ $category['slug'] }}">{{ $category['name'] }}</a></div>
                    @endforeach
                    <select name="" id="">
                        @foreach($accessorycategories as $category)
                        <option value="">{{ $category['name'] }}</option>
                        @endforeach
                    </select>
                    <div class="item-hr"></div>
                </div>
            </div>
            <div class="col-lg-12 custom-no-padding">
                <div class="items-carousel">
                    @foreach($accessories as $accessory)
                        @if($accessory->medias()->where('media_id', $accessory->item->index_img)->get()->isNotEmpty())
                        <div>
                            <div class="item">
                                <a href="/phu-kien/{{ $accessory->item->itemCategory->slug }}/{{ $accessory->item->id }}/{{ $accessory->item->slug }}">
                                    <img class="img-responsive" 
                                    src="
                                    @foreach($accessory->medias()->where('media_id', $accessory->item->index_img)->get() as $img)
                                    {{ asset($img->url) }}
                                    @endforeach
                                    " alt="">
                                    <div class="item-name">{{ $accessory->brand->name . ' ' . $accessory->item->name }}</div>
                                    <div class="item-price">
                                        @if($accessory->item->price_off > 0 || $accessory->item->price_off != null)
                                            {{ number_format($accessory->item->price_off,0, ",",".") }} VNĐ
                                            <span>{{ number_format($accessory->item->price,0, ",",".") }} VNĐ</span>
                                            
                                        @else
                                            {{ number_format($accessory->item->price,0, ",",".") }} VNĐ
                                        @endif
                                    </div>
                                    
                                </a>
                                <input type="hidden" name="hid_item_id" id="hid_item_id_{{ $accessory->item->id }}" value="{{ $accessory->id }}">
                                <input type="hidden" name="hid_category_id" id="hid_category_id_{{ $accessory->item->id }}" value="{{ $accessory->item_category_id }}">
                                <div class="btn-cart" id="{{ $accessory->item->id }}">Thêm vào giỏ hàng <i class="fa fa-cart-plus"></i></div>
                            </div> 
                        </div>
                        @else
                        <div>
                            <div class="item">
                                <a href="/phu-kien/{{ $accessory->item->itemCategory->slug }}/{{ $accessory->item->id }}/{{ $accessory->item->slug }}">
                                    @if($accessory->medias()->first() == null )
                                    <img class="img-responsive" src="https://via.placeholder.com/650x650?text=No+image" alt="">
                                    @else
                                    <img class="img-responsive" 
                                    src="
                                    {{ asset($accessory->medias()->first()->url) }}
                                    " alt="">
                                    @endif
                                    <div class="item-name">{{ $accessory->brand->name . ' ' . $accessory->item->name }}</div>
                                    <div class="item-price">
                                        @if($accessory->item->price_off > 0 || $accessory->item->price_off != null)
                                            {{ number_format($accessory->item->price_off,0, ",",".") }} VNĐ
                                            <span>{{ number_format($accessory->item->price,0, ",",".") }} VNĐ</span>
                                            
                                        @else
                                            {{ number_format($accessory->item->price,0, ",",".") }} VNĐ
                                        @endif
                                    </div>
                                    
                                </a>
                                <input type="hidden" name="hid_item_id" id="hid_item_id_{{ $accessory->item->id }}" value="{{ $accessory->id }}">
                                <input type="hidden" name="hid_category_id" id="hid_category_id_{{ $accessory->item->id }}" value="{{ $accessory->item_category_id }}">
                                <div class="btn-cart" id="{{ $accessory->item->id }}">Thêm vào giỏ hàng <i class="fa fa-cart-plus"></i></div>
                            </div>
                        </div>      
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" role="dialog" id="item_check">
        <div class="modal-dialog modal_item_check">
            <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-5">
                                <img class="img-responsive img-item img-hover" src="" alt="" id="img-model">
                            </div>
                            <div class="col-lg-7">
                                <div class="col-lg-12 no-padding" id="ajax-location">
                                    
                                </div>
                                <div class="col-lg-8 no-padding">
                                    <div class="newform">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <input type='button' value='-' class='qtyminus btn btn-secondary' field='quantity' />
                                            </span>
                                                <input type='text' name='quantity' value='1' class='qty form-control' id="quantity"/>
                                            <span class="input-group-btn">
                                                <input type='button' value='+' class='qtyplus btn btn-secondary' field='quantity' />
                                            </span>
                                        </div>
                                    </div>
                                    <div class="newform">
                                        <div class="input-group">
                                            <input type="hidden" id="item_id" value=""/>
                                            <input type="hidden" id="item_category_id" value=""/>
                                            <input type="button" name="add_cart_btn" value="+ Thêm vào giỏ hàng" class="btn-add-cart">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /modal-body -->
                </div><!-- /modal-content -->
        </div><!-- /modal-dialog -->
    </div><!-- /modal -->

    
@endsection

@section('section-blog')
	<section class="section-blog">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="blog-sec-title">Review & Blog</div>
                    <hr class="blog-hr">
                </div>
            </div>
            <div class="row">
                @foreach($articles as $article)
                <div class="col-md-5ths col-xs-12 col-sm-12 co-md-6">
                    <a href="/review-blog/{{ $article->slug }}"><img class="img-responsive" src="{{ asset($article->media()->first()->url) }}" alt=""></a>
                    <h5 class="blog-title">{{ $article->title }}</h5>
                    <p>{{ str_limit($article->summary, 110) }}</p>
                </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="blog-seemore">
                        <a href="/review-blog">Xem Thêm</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
