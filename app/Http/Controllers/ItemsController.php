<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ItemCategory;
use App\Setting;
use App\Menu;
use App\Page;
use App\Box;
use App\Juice;
use App\Accessory;
use App\Tank;
use App\FullKit;
use App\Item;


class ItemsController extends Controller
{
    //
    public function getItemCat($item_cat)
    {
    	$settings = Setting::findOrFail(1);
        $footer_1st_menu = Menu::where('id',2)->first();
        $footer_2nd_menu = Menu::where('id',3)->first();
        $top_nav = Menu::where('id',1)->first();
        $page = Page::where('slug','=', $item_cat)->first();
    	$item_category = ItemCategory::where('slug',$item_cat)->first();
    	switch ($item_category->id) {
    		case '1':
    			$items = Box::orderBy('id','desc')->paginate(24);
    			break;

    		case '2':
    			$items = FullKit::orderBy('id','desc')->paginate(24);
    			break;

    		case '3':
    			$items = Tank::orderBy('id','desc')->paginate(24);
    			break;

    		case '4':
    			$items = Juice::orderBy('id','desc')->paginate(24);
    			break;

    		case '5':
    			$items = Accessory::orderBy('id','desc')->paginate(24);
    			break;
    		
    		default:
    			# code...
    			break;
    	}
    	//dd($item_cat);
    	return view('mainsite.items', compact(
    		'item_cat',
    		'settings',
            'footer_1st_menu',
            'footer_2nd_menu',
            'top_nav',
            'page',
            'items'
    	));
    }

    public function getItemSubCat($item_cat, $item_sub_cat)
    {
    	$settings = Setting::findOrFail(1);
        $footer_1st_menu = Menu::where('id',2)->first();
        $footer_2nd_menu = Menu::where('id',3)->first();
        $top_nav = Menu::where('id',1)->first();
        $page = Page::where('slug','=', $item_cat)->first();
        $pageSub = Page::where('slug','=', $item_sub_cat)->first();
    	$item_category = ItemCategory::where('slug',$item_cat)->first();
    	$item_sub_category = ItemCategory::where('slug', $item_sub_cat)->first();
    	//dd($item_sub_category);
    	switch ($item_category->id) {
    		case '3':
    			$items = Tank::orderBy('id','desc')->where('item_category_id', $item_sub_category['id'])->paginate(24);
    			break;

    		case '4':
    			$items = Juice::orderBy('id','desc')->where('item_category_id', $item_sub_category['id'])->paginate(24);
    			break;

    		case '5':
    			$items = Accessory::orderBy('id','desc')->where('item_category_id', $item_sub_category['id'])->paginate(24);
    			break;
    		
    		default:
    			# code...
    			break;
    	}
    	//dd($item_cat);
    	return view('mainsite.items', compact(
    		'pageSub',
    		'settings',
            'footer_1st_menu',
            'footer_2nd_menu',
            'top_nav',
            'page',
            'items',
            'item_cat',
            'item_sub_cat'
    	));
    }

    public function getSubItem($item_cat, $item_sub_cat, $item_id, $item_slug)
    {
        $settings = Setting::findOrFail(1);
        $footer_1st_menu = Menu::where('id',2)->first();
        $footer_2nd_menu = Menu::where('id',3)->first();
        $top_nav = Menu::where('id',1)->first();
        $page = Page::where('slug','=', $item_cat)->first();
        $pageSub = Page::where('slug','=', $item_sub_cat)->first();
        $item_category = ItemCategory::where('slug',$item_cat)->first();
        $not_item = Item::where('id',$item_id)->first();
        switch ($item_category->id) {
            case '1':
                $item = Box::where('item_id', $not_item->id)->first();
                $random_items = Box::where('id','!=',$item->id)->inRandomOrder()->paginate(5);
                break;

            case '2':
                $item = FullKit::where('item_id', $not_item->id)->first();
                $random_items = FullKit::where('id','!=',$item->id)->inRandomOrder()->paginate(5);
                break;

            case '3':
                $item = Tank::where('item_id', $not_item->id)->first();
                $random_items = Tank::where('id','!=',$item->id)->inRandomOrder()->paginate(5);
                break;

            case '4':
                $item = Juice::where('item_id', $not_item->id)->first();
                $random_items = Juice::where('id','!=',$item->id)->inRandomOrder()->paginate(5);
                break;

            case '5':
                $item = Accessory::where('item_id', $not_item->id)->first();
                $random_items = Accessory::where('id','!=',$item->id)->inRandomOrder()->paginate(5);
                break;
            
            default:
                # code...
                break;
        }

        return view('mainsite.item', compact(
            'pageSub',
            'settings',
            'footer_1st_menu',
            'footer_2nd_menu',
            'top_nav',
            'page',
            'item',
            'item_cat',
            'item_sub_cat',
            'random_items'
        ));
    }

    public function getItem($item_cat, $item_id, $item_slug)
    {
        $settings = Setting::findOrFail(1);
        $footer_1st_menu = Menu::where('id',2)->first();
        $footer_2nd_menu = Menu::where('id',3)->first();
        $top_nav = Menu::where('id',1)->first();
        $page = Page::where('slug','=', $item_cat)->first();
        $not_item = Item::where('id',$item_id)->first();
        $item_category = ItemCategory::where('slug',$item_cat)->first();
        switch ($item_category->id) {
            case '1':
                $item = Box::where('item_id', $not_item->id)->first();
                $random_items = Box::where('id','!=',$item->id)->inRandomOrder()->paginate(5);
                break;

            case '2':
                $item = FullKit::where('item_id', $not_item->id)->first();
                $random_items = FullKit::where('id','!=',$item->id)->inRandomOrder()->paginate(5);
                break;

            case '3':
                $item = Tank::where('item_id', $not_item->id)->first();
                $random_items = Tank::where('id','!=',$item->id)->inRandomOrder()->paginate(5);
                break;

            case '4':
                $item = Juice::where('item_id', $not_item->id)->first();
                $random_items = Juice::where('id','!=',$item->id)->inRandomOrder()->paginate(5);
                break;

            case '5':
                $item = Accessory::where('item_id', $not_item->id)->first();
                $random_items = Accessory::where('id','!=',$item->id)->inRandomOrder()->paginate(5);
                break;
            
            default:
                # code...
                break;
        }
        return view('mainsite.item', compact(
            'settings',
            'footer_1st_menu',
            'footer_2nd_menu',
            'top_nav',
            'page',
            'item',
            'item_cat',
            'random_items'
        ));
    }
}
