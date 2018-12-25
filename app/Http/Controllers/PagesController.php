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
            $settings = Setting::findOrFail(1);
            $main_slider = Slider::findOrFail(1);
            $first_sub_slider = Slider::findOrFail(2);
            $second_sub_slider = Slider::findOrFail(3);

            $items = Item::where('homepage_active','=',1);
            $item_cats_all = ItemCategory::all();
            $item_cats_parent = [];
            $item_parents = [];
            foreach ($item_cats_all as $it_cat) {
                if($it_cat->id == $it_cat->item_category_id)
                {
                    $item_cats_parent[$it_cat->id]  = $it_cat;
                    $item_parents[$it_cat->id]      = $items->where('item_category_id','=',$it_cat->id)->get();
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
        $pages = Page::all()->pluck('slug')->toArray();
        $itemCategory = ItemCategory::all()->pluck('slug')->toArray();
        if(in_array($slug, $pages))
        {
            if(in_array($slug, $itemCategory))
            {
                return $this->itemsController->getItemCat($slug);
            }
            else
            {
                $settings = Setting::findOrFail(1);
                $top_nav = Menu::where('id',1)->first();
                $footer_1st_menu = Menu::where('id',2)->first();
                $footer_2nd_menu = Menu::where('id',3)->first();
                $page = Page::where('slug', $slug)->first();
                return view('mainsite.page', compact('page','settings','top_nav','footer_1st_menu','footer_2nd_menu'));
            }
        } else {
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
        $settings = Setting::findOrFail(1);
        $top_nav = Menu::where('id',1)->first();
        $footer_1st_menu = Menu::where('id',2)->first();
        $footer_2nd_menu = Menu::where('id',3)->first();
        return view('mainsite.cart.index', compact('settings','top_nav','footer_1st_menu','footer_2nd_menu'));
    }

    public function getCheck(Request $request)
    {
        $settings = Setting::findOrFail(1);
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
        return view('mainsite.cart.checkout', compact('cart','settings','top_nav','footer_1st_menu','footer_2nd_menu','cities','districts'));
    }

    public function getDone(Request $request, $orderCode, $fee)
    {
        $settings = Setting::findOrFail(1);
        $top_nav = Menu::where('id',1)->first();
        $footer_1st_menu = Menu::where('id',2)->first();
        $footer_2nd_menu = Menu::where('id',3)->first();
        $cart = $request->session()->get('cart');
        $order = Order::where('orderCode',$orderCode)->first();
        $request->session()->forget('cart');
        return view('mainsite.cart.done', compact('cart','settings','top_nav','footer_1st_menu','footer_2nd_menu','orderCode','order','fee'));
    }

    public function getCheckOrders()
    {
        /*dd(Auth::guard('customer')->user());
        if(Auth::guard('customer')->check())
        {
            return redirect()->route('customer.orders');
        }*/
        $settings = Setting::findOrFail(1);
        $top_nav = Menu::where('id',1)->first();
        $footer_1st_menu = Menu::where('id',2)->first();
        $footer_2nd_menu = Menu::where('id',3)->first();
        return view('mainsite.extracustomer.index', compact('settings','top_nav','footer_1st_menu','footer_2nd_menu'));
    }

    public function searchOrder(Request $request)
    {
        return redirect()->route('orders.result', [$request->orderCode]);
    }

    public function resultOrder($orderCode)
    {
        $settings = Setting::findOrFail(1);
        $top_nav = Menu::where('id',1)->first();
        $footer_1st_menu = Menu::where('id',2)->first();
        $footer_2nd_menu = Menu::where('id',3)->first();
        $order = Order::where('orderCode',$orderCode)->first();

        return view('mainsite.extracustomer.index', compact('settings','top_nav','footer_1st_menu','footer_2nd_menu','order','orderCode'));
    }

    public function search(Request $request)
    {
        $settings = Setting::findOrFail(1);
        $top_nav = Menu::where('id',1)->first();
        $footer_1st_menu = Menu::where('id',2)->first();
        $footer_2nd_menu = Menu::where('id',3)->first();

        $itemSearch = new ItemSearch(null);

        if(!empty($request->search_query))
        {
            switch ($request->item_category_id) {
                case '1':
                    $items = Item::where('name','LIKE','%'.$request->search_query.'%')
                        ->where('item_category_id',$request->item_category_id)->get();
                    foreach($items as $item)
                    {
                        $box = Box::where('item_id',$item->id)->first();
                        $itemSearch->add($item, $item->id, $box, $box->item_category_id);
                    }
                    break;

                case '2':
                    $items = Item::where('name','LIKE','%'.$request->search_query.'%')
                        ->where('item_category_id',$request->item_category_id)->get();
                    foreach($items as $item)
                    {
                        $fullkit = FullKit::where('item_id',$item->id)->first();
                        $itemSearch->add($item, $item->id, $fullkit, $fullkit->item_category_id);
                    }
                    break;

                case '3':
                    $items = Item::where('name','LIKE','%'.$request->search_query.'%')
                        ->where('item_category_id',$request->item_category_id)->get();
                    foreach($items as $item)
                    {
                        $tank = Tank::where('item_id',$item->id)->first();
                        $itemSearch->add($item, $item->id, $tank, $tank->item_category_id);
                    }
                    break;

                case '4':
                    $items = Item::where('name','LIKE','%'.$request->search_query.'%')
                        ->where('item_category_id',$request->item_category_id)->get();
                    foreach($items as $item)
                    {
                        $juice = Juice::where('item_id',$item->id)->first();
                        $itemSearch->add($item, $item->id, $juice, $juice->item_category_id);
                    }
                    break;

                case '5':
                    $items = Item::where('name','LIKE','%'.$request->search_query.'%')
                        ->where('item_category_id',$request->item_category_id)->get();
                    foreach($items as $item)
                    {
                        $accessory = Accessory::where('item_id',$item->id)->first();
                        $itemSearch->add($item, $item->id, $accessory, $accessory->item_category_id);
                    }
                    break;

                default:
                    # code...
                    break;
            }

            $items = Item::where('name','LIKE','%'.$request->search_query.'%')->get();
            foreach($items as $item)
            {
                if($item->item_category_id > 5)
                {
                    $item_category_id = $item->itemCategory->itemCategory->id;
                }
                else
                {
                    $item_category_id = $item->item_category_id;
                }
                switch ($item_category_id) {
                    case '1':
                        $box = Box::where('item_id',$item->id)->first();
                        $itemSearch->add($item, $item->id, $box, $box->item_category_id);
                        break;

                    case '2':
                        $fullkit = FullKit::where('item_id',$item->id)->first();
                        $itemSearch->add($item, $item->id, $fullkit, $fullkit->item_category_id);
                        break;

                    case '3':
                        $tank = Tank::where('item_id',$item->id)->first();
                        $itemSearch->add($item, $item->id, $tank, $tank->item_category_id);
                        break;

                    case '4':
                        $juice = Juice::where('item_id',$item->id)->first();
                        $itemSearch->add($item, $item->id, $juice, $juice->item_category_id);
                        break;

                    case '5':
                        $accessory = Accessory::where('item_id',$item->id)->first();
                        $itemSearch->add($item, $item->id, $accessory, $accessory->item_category_id);
                        break;

                    default:
                        # code...
                        break;
                }
            }
        } else {
            $items = [];
        }



        return view('mainsite.search', compact(
            'item_cat',
            'settings',
            'footer_1st_menu',
            'footer_2nd_menu',
            'top_nav',
            'page',
            'itemSearch'
        ));
    }

    public function get404()
    {
        $settings = Setting::findOrFail(1);
        $top_nav = Menu::where('id',1)->first();
        $footer_1st_menu = Menu::where('id',2)->first();
        $footer_2nd_menu = Menu::where('id',3)->first();
        return view('mainsite.404', compact('settings','top_nav','footer_1st_menu','footer_2nd_menu'));
    }
}
