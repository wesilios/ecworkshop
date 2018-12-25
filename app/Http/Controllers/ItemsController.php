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
    	$items = Item::where('item_category_id','=',$item_category->id)->orderBy('id','desc')->paginate(24); //->paginate(24);
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
        $items = Item::where('item_category_parent_id','=',$item_category->id)
            ->where('item_category_id','=',$item_sub_category->id)->paginate(24);
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
        try {
            $settings = Setting::findOrFail(1);
            $footer_1st_menu = Menu::where('id',2)->first();
            $footer_2nd_menu = Menu::where('id',3)->first();
            $top_nav = Menu::where('id',1)->first();
            $page = Page::where('slug','=', $item_cat)->first();
            $pageSub = Page::where('slug','=', $item_sub_cat)->first();
            if(empty($page) || empty($pageSub))
            {
                return redirect()->route('404.not.found');
            }
            $item_category = ItemCategory::where('slug',$item_sub_cat)->first();
            $item = Item::where('slug',$item_slug)->first();
            $random_items = '';
            if(!$item_category && !$item)
            {
                return redirect()->route('404.not.found');
            }
            $random_items = Item::where('item_category_parent_id','=',$item_category->itemCategory->id)->inRandomOrder()->paginate(5);
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
        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->route('404.not.found') ;
        }
    }

    public function getItem($item_cat, $item_id, $item_slug)
    {
        $settings = Setting::findOrFail(1);
        $footer_1st_menu = Menu::where('id',2)->first();
        $footer_2nd_menu = Menu::where('id',3)->first();
        $top_nav = Menu::where('id',1)->first();
        $page = Page::where('slug','=', $item_cat)->first();
        $not_item = Item::where('id',$item_id)->first();
        if(empty($page))
        {
            return redirect()->route('404.not.found');
        }
        $item_category = ItemCategory::where('slug',$item_cat)->first();
        $item = Item::where('slug',$item_slug)->first();
        $random_items = '';
        if(!$item_category && !$item)
        {
            return redirect()->route('404.not.found');
        }
        $random_items = Item::where('item_category_parent_id','=',$item_category->id)->inRandomOrder()->paginate(5);

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
