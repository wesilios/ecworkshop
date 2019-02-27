<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ItemsController as ItemsController;
use App\Http\Controllers\ArticleController as ArticleController;
use App\Http\Controllers\OrdersController as OrdersController;
use App\Setting;
use App\Menu;
use App\Page;
use App\Box;
use App\Juice;
use App\Accessory;
use App\Tank;
use App\FullKit;
use App\Slider;
use App\ItemCategory;
use App\Article;
use App\Fee;
use App\FeeDistrict;
use Auth;
use App\Item;
use App\Order;
use App\OrderDetail;
use App\ItemSearch;

class PagesController extends Controller
{
    //
    protected $itemsController;
    protected $articleController;
    protected $ordersController;

    public function __construct(ItemsController $itemsController, ArticleController $articleController, OrdersController $ordersController)
    {
        $this->itemsController = $itemsController;
        $this->articleController = $articleController;
        $this->ordersController = $ordersController;
    }

    public function getHome()
    {
    	try {
            $settings = Setting::find(1);
            $main_slider = Slider::find(1);
            $first_sub_slider = Slider::find(2);
            $second_sub_slider = Slider::find(3);


            $item_cats_all = ItemCategory::all();
            $item_cats_parent = [];
            $item_parents = [];
            foreach ($item_cats_all as $it_cat) {
                $items = Item::where('homepage_active','=',1);
                if($it_cat->id == $it_cat->item_category_id)
                {
                    $item_cats_parent[$it_cat->id]  = $it_cat;
                    $item_parents[$it_cat->id]      = $items->where('item_category_parent_id','=',$it_cat->id)->get();
                }
            }

            $boxes = Box::where('homepage_active', 1)->get();
            $tanks = Tank::where('homepage_active', 1)->get();
            $tankcategories = ItemCategory::where('item_category_id','3')->get();
            $juices = Juice::where('homepage_active', 1)->get();
            $juicecategories = ItemCategory::where('item_category_id','4')->get();
            $accessories = Accessory::where('homepage_active', 1)->get();
            $accessorycategories = ItemCategory::where('item_category_id','5')->get();

            $articles = Article::where('category_id','>','1')->paginate(5);
            $footer_1st_menu = Menu::where('id',2)->first();
            $footer_2nd_menu = Menu::where('id',3)->first();
            $top_nav = Menu::where('id',1)->first();
            return view('mainsite.home', compact(

                'settings',
                'main_slider',
                'first_sub_slider',
                'second_sub_slider',
                'boxes',
                'tanks',
                'tankcategories',
                'juices',
                'juicecategories',
                'accessories',
                'accessorycategories',
                'articles',
                'footer_1st_menu',
                'footer_2nd_menu',
                'top_nav',
                'item_cats_parent',
                'item_parents'

            ));
        } catch (\Exception $e) {
    	    return $e->getMessage();
        }
    }

    public function getPage($slug)
    {
        try {
            $pages = Page::all()->pluck('slug')->toArray();
            $itemCategory = ItemCategory::all()->pluck('slug')->toArray();
            $item_cats_all = ItemCategory::all();
            $item_cats_parent = [];
            foreach ($item_cats_all as $it_cat) {
                if($it_cat->id == $it_cat->item_category_id)
                {
                    $item_cats_parent[$it_cat->id]  = $it_cat;
                }
            }
            if(in_array($slug, $pages))
            {
                if(in_array($slug, $itemCategory))
                {
                    return $this->itemsController->getItemCat($slug);
                }
                else
                {
                    $settings = Setting::find(1);
                    $top_nav = Menu::where('id',1)->first();
                    $footer_1st_menu = Menu::where('id',2)->first();
                    $footer_2nd_menu = Menu::where('id',3)->first();
                    $page = Page::where('slug', $slug)->first();
                    return view('mainsite.page', compact('page','settings','top_nav','footer_1st_menu','footer_2nd_menu','item_cats_parent'));
                }
            } else {
                return redirect()->route('404.not.found');
            }
        } catch (\Exception $e) {
            return redirect()->route('404.not.found');
        }
    }

    public function getSubPage($slug, $slug_child)
    {
        $pages = Page::all()->pluck('slug')->toArray();
        //dd($pages);
        if(in_array($slug, $pages))
        {
            if($slug == 'review-blog')
            {

            }
            else
            {
                return $this->itemsController->getItemSubCat($slug, $slug_child);
            }
        } else {
            return redirect()->route('404.not.found');
        }
    }

    public function getSubItem($slug, $slug_child, $item_id, $item_slug)
    {
        return $this->itemsController->getSubItem($slug, $slug_child, $item_id, $item_slug);
    }

    public function getItem($slug, $item_id, $item_slug)
    {
        return $this->itemsController->getItem($slug, $item_id, $item_slug);
    }

    public function getCart(Request $request)
    {
        $settings = Setting::find(1);
        $top_nav = Menu::where('id',1)->first();
        $footer_1st_menu = Menu::where('id',2)->first();
        $footer_2nd_menu = Menu::where('id',3)->first();
        $item_cats_all = ItemCategory::all();
        $item_cats_parent = [];
        foreach ($item_cats_all as $it_cat) {
            if($it_cat->id == $it_cat->item_category_id)
            {
                $item_cats_parent[$it_cat->id]  = $it_cat;
            }
        }
        return view('mainsite.cart.index', compact('settings','top_nav','footer_1st_menu','footer_2nd_menu','item_cats_parent'));
    }

    public function getCheck(Request $request)
    {
        $settings = Setting::find(1);
        $top_nav = Menu::where('id',1)->first();
        $footer_1st_menu = Menu::where('id',2)->first();
        $footer_2nd_menu = Menu::where('id',3)->first();
        $cart = $request->session()->get('cart');
        if($cart == null)
        {
            return redirect()->route('cart.index')->with('status','Giỏ hàng bạn đang trống');
        }
        $cities = Fee::all()->pluck('city','id');
        if(Auth::guard('customer')->check())
        {
            if(isset(Auth::guard('customer')->user()->customerInfo))
            {
                $districts = FeeDistrict::where('fee_id',Auth::guard('customer')->user()->customerInfo->city_id)->get()->pluck('name','id');
            }
            else
            {
                $districts = null;
            }
        }
        else
        {
            $districts = null;
        }
        $item_cats_all = ItemCategory::all();
        $item_cats_parent = [];
        foreach ($item_cats_all as $it_cat) {
            if($it_cat->id == $it_cat->item_category_id)
            {
                $item_cats_parent[$it_cat->id]  = $it_cat;
            }
        }
        return view('mainsite.cart.checkout', compact('cart','settings','top_nav','footer_1st_menu','footer_2nd_menu','cities','districts','item_cats_parent'));
    }

    public function getDone(Request $request, $orderCode, $fee)
    {
        $settings = Setting::find(1);
        $top_nav = Menu::where('id',1)->first();
        $footer_1st_menu = Menu::where('id',2)->first();
        $footer_2nd_menu = Menu::where('id',3)->first();
        $cart = $request->session()->get('cart');
        $order = Order::where('orderCode',$orderCode)->first();
        $request->session()->forget('cart');
        $item_cats_all = ItemCategory::all();
        $item_cats_parent = [];
        foreach ($item_cats_all as $it_cat) {
            if($it_cat->id == $it_cat->item_category_id)
            {
                $item_cats_parent[$it_cat->id]  = $it_cat;
            }
        }
        return view('mainsite.cart.done', compact('cart','settings','top_nav','footer_1st_menu','footer_2nd_menu','orderCode','order','fee','item_cats_parent'));
    }

    public function getCheckOrders()
    {
        /*dd(Auth::guard('customer')->user());
        if(Auth::guard('customer')->check())
        {
            return redirect()->route('customer.orders');
        }*/
        $settings = Setting::find(1);
        $top_nav = Menu::where('id',1)->first();
        $footer_1st_menu = Menu::where('id',2)->first();
        $footer_2nd_menu = Menu::where('id',3)->first();
        $item_cats_all = ItemCategory::all();
        $item_cats_parent = [];
        foreach ($item_cats_all as $it_cat) {
            if($it_cat->id == $it_cat->item_category_id)
            {
                $item_cats_parent[$it_cat->id]  = $it_cat;
            }
        }
        return view('mainsite.extracustomer.index', compact('settings','top_nav','footer_1st_menu','footer_2nd_menu','item_cats_parent'));
    }

    public function searchOrder(Request $request)
    {
        return redirect()->route('orders.result', [$request->orderCode]);
    }

    public function resultOrder($orderCode)
    {
        $settings = Setting::find(1);
        $top_nav = Menu::where('id',1)->first();
        $footer_1st_menu = Menu::where('id',2)->first();
        $footer_2nd_menu = Menu::where('id',3)->first();
        $order = Order::where('orderCode',$orderCode)->first();
        $item_cats_all = ItemCategory::all();
        $item_cats_parent = [];
        foreach ($item_cats_all as $it_cat) {
            if($it_cat->id == $it_cat->item_category_id)
            {
                $item_cats_parent[$it_cat->id]  = $it_cat;
            }
        }
        return view('mainsite.extracustomer.index', compact('settings','top_nav','footer_1st_menu','footer_2nd_menu','order','orderCode','item_cats_parent'));
    }

    public function search(Request $request)
    {
        $settings = Setting::find(1);
        $top_nav = Menu::where('id',1)->first();
        $footer_1st_menu = Menu::where('id',2)->first();
        $footer_2nd_menu = Menu::where('id',3)->first();

        $itemSearch = new ItemSearch(null);
        $item_cats_all = ItemCategory::all();
        $item_cats_parent = [];
        foreach ($item_cats_all as $it_cat) {
            if($it_cat->id == $it_cat->item_category_id)
            {
                $item_cats_parent[$it_cat->id]  = $it_cat;
            }
        }
        $it_cat_rq = $request->get('item_category_id','');
        if(!empty($request->search_query))
        {
            if($it_cat_rq == 0 || empty($it_cat_rq))
            {
                $items = Item::where('name','LIKE','%'.$request->search_query.'%')->get();
            } else {
                $items = Item::where([
                    ['name','LIKE','%'.$request->search_query.'%'],
                    ['item_category_id','=',$it_cat_rq]
                ])->get();
            }

        } else {
            $items = [];
        }
        $itemSearch = $items;
        return view('mainsite.search', compact(
            'item_cat',
            'settings',
            'footer_1st_menu',
            'footer_2nd_menu',
            'top_nav',
            'page',
            'itemSearch',
            'item_cats_parent'
        ));
    }

    public function get404()
    {
        $settings = Setting::find(1);
        $top_nav = Menu::where('id',1)->first();
        $footer_1st_menu = Menu::where('id',2)->first();
        $footer_2nd_menu = Menu::where('id',3)->first();
        $item_cats_all = ItemCategory::all();
        $item_cats_parent = [];
        foreach ($item_cats_all as $it_cat) {
            if($it_cat->id == $it_cat->item_category_id)
            {
                $item_cats_parent[$it_cat->id]  = $it_cat;
            }
        }
        return view('mainsite.404', compact('settings','top_nav','footer_1st_menu','footer_2nd_menu','item_cats_parent'));
    }
}
