<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fee;
use App\FeeDistrict;
use Auth;
use App\Box;
use App\Juice;
use App\Tank;
use App\Accessory;
use App\FullKit;
use App\Item;
use App\ItemCategory;
use App\Cart;
use App\Brand;
use App\Color;
use App\Size;
use Session;
use Validator;

class AjaxController extends Controller
{
    //
    public function getDistrictsList(Request $request)
    {
    	if($request->ajax())
    	{
    		$districts = FeeDistrict::where('fee_id',$request->city_id)->get()->pluck('name','id');
    		$data = view('mainsite.ajax.districts',compact('districts'))->render();
    		//return response()->json(['option'=>$data]);
            if($request->city_id == 0)
            {
                $fee = 0;
            }
            else
            {
                $fee = Fee::findOrFail($request->city_id)->fee;
            }
    		//return view('mainsite.ajax.districts',compact('districts'));
            return response()->json(['option'=>$data]);
    	}
    }

    public function orderPrice(Request $request)
    {
        if($request->ajax())
        {
            $districts = FeeDistrict::where('fee_id',$request->city_id)->get()->pluck('name','id');
            $data = view('mainsite.ajax.districts',compact('districts'))->render();
            if($request->city_id == 0) {
                $fee = 0;
                $pre_fee = 0;
            } else {
                $pre_fee = Fee::findOrFail($request->city_id)->fee;
                $fee =  number_format( $pre_fee , 0, ",",".");
            }
            //$pre_totalPrice = Session::get('cart')->totalPrice + $pre_fee;
            $pre_totalPrice = Session::get('cart')->totalPrice + 0;
            $totalPrice =  number_format( $pre_totalPrice , 0, ",",".");
            $data = view('mainsite.ajax.districts',compact('districts'))->render();
            return response()->json(['option'=>$data,'fee'=>0,'totalPrice'=>$totalPrice]);
        }
    }

    public function cartCheckItem(Request $request)
    {
        if($request->ajax())
        {
            $itemCategory = ItemCategory::where('id', $request->item_category_id)->first();
            $colors = null;
            $size = null;
            if($itemCategory->itemCategory == null)
            {
                $item_category_id = $request->item_category_id;
            }
            else
            {
                $item_category_id = $itemCategory->itemCategory->id;
            }
            switch ($item_category_id) {
                case '1':
                    $item = Box::where('item_id', $request->item_id)->first();
                    $colors = $item->colors;
                    break;

                case '2':
                    $item = FullKit::where('item_id', $request->item_id)->first();
                    $colors = $item->colors;
                    break;

                case '3':
                    $item = Tank::where('item_id', $request->item_id)->first();
                    $colors = $item->colors;
                    break;

                case '4':
                    $item = Juice::where('item_id', $request->item_id)->first();
                    $size = $item->size;
                    break;

                case '5':
                    $item = Accessory::where('item_id', $request->item_id)->first();
                    break;

                default:
                    # code...
                    break;
            }
            if($item->medias()->where('media_id', $item->item->index_img)->get()->isNotEmpty())
            {
                $url = asset($item->medias()->where('media_id', $item->item->index_img)->first()->url);
            }
            else
            {
                 $url = asset($item->medias()->first()->url);
            }
            $data = view('mainsite.ajax.cartcheck',compact('item','colors','size'))->render();
            return response()->json(['option'=>$data,'img'=>$url,'item_id'=>$item->id,'item_category_id'=>$item_category_id,'item_id_id'=>$item->item->id]);
            //return view('mainsite.ajax.cartcheck',compact('item'));
        }
    }

    public function cartAddItem(Request $request)
    {
        if($request->ajax())
        {
            $item_category_id = $request->item_category_id;
            switch ($item_category_id) {
                case '1':
                    $item = Box::where('id', $request->item_id)->first();
                    break;

                case '2':
                    $item = FullKit::where('id', $request->item_id)->first();
                    break;

                case '3':
                    $item = Tank::where('id', $request->item_id)->first();
                    break;

                case '4':
                    $item = Juice::where('id', $request->item_id)->first();
                    break;

                case '5':
                    $item = Accessory::where('id', $request->item_id)->first();
                    break;

                default:
                    # code...
                    break;
            }
            if($item->medias()->where('media_id', $item->item->index_img)->get()->isNotEmpty())
            {
                $url = $item->medias()->where('media_id', $item->item->index_img)->first()->url;
            }
            else
            {
                $url = $item->medias()->first()->url;
            }
            $quantity = $request->quantity;
            $total = $request->quantity * $item->item->price;
            $data = view('mainsite.ajax.cartsuccess',compact('item','url','quantity','total'))->render();
            $this->addToCart($request, $item->item->id, $item);
            $totalQty = Session::get('cart')->totalQty;
            return  response()->json(['item_name'=>$item->item->name,'option'=>$data,'totalQty'=>$totalQty,'route'=>route('cart.index')]);
        }
    }

    public function addToCart(Request $request, $id, $item)
    {
        //$item = Item::findOrFail($id);
        if($request->color == null){
            $color = null;
            $color_id = 0;
        }
        else
        {
            $color = Color::findOrFail($request->color);
            $color_id = $request->color;
        }
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($item, $id, $request->quantity, $color, $color_id);
        $request->session()->put('cart', $cart);
        //dd($request->session()->get('cart'));
        //return redirect()->route('test.cart');
    }

    public function getCart(Request $request)
    {
        echo bcrypt('Ecworkshop1207');
        //dd($request->session()->get('cart'));
        //$request->session()->flush('cart');
    }

    public function cartUpdate(Request $request)
    {
        //dd($request->all());
        $cart = $request->session()->get('cart');
        if($cart == null)
        {
            return redirect()->route('cart.index')->with('status','Giỏ hàng bạn đang trống');
        }
        $cart->totalQty = 0;
        $cart->totalPrice = 0;
        foreach($cart->items as $item)
        {
            //echo $item['item']->item['id'].': '. $request['quantity'.$item['item']->item['id']] . '<br>';
            $totalColorQty = 0;
            if(isset($item['colors'][0]))
            {
                $cart->items[$item['item']->item['id']]['quantity'] = $request['quantity'.$item['item']->item['id']];
                $cart->items[$item['item']->item['id']]['price'] = $request['quantity'.$item['item']->item['id']] * $item['item']->item['price'];
            }
            else
            {
                foreach($item['colors'] as $color)
                {
                    //echo $color['color']['id'].': '. $request['quantity'.$item['item']->item['id'].'_'.$color['color']['id']] . '<br>';
                    $cart->items[$item['item']->item['id']]['colors'][$color['color']['id']]['quantity'] = $request['quantity'.$item['item']->item['id'].'_'.$color['color']['id']];
                    $totalColorQty += $cart->items[$item['item']->item['id']]['colors'][$color['color']['id']]['quantity'];
                }
                $cart->items[$item['item']->item['id']]['quantity'] = $totalColorQty;
                $cart->items[$item['item']->item['id']]['price'] = $totalColorQty * $item['item']->item['price'];
            }
            $cart->totalQty += $cart->items[$item['item']->item['id']]['quantity'];
            $cart->totalPrice += $cart->items[$item['item']->item['id']]['price'];
        }
        $request->session()->forget('cart');
        $request->session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('status','Cập nhật giỏ hàng thành công!');
    }

    public function cartDelete(Request $request, $id)
    {
        $cart = $request->session()->get('cart');
        foreach($cart->items as $item)
        {
            if($item['item']->item['id'] == $id)
            {
                $quantity = $item['quantity'];
                $price = $item['price'];
            }
            unset($cart->items[$id]);
        }
        $cart->totalQty = $cart->totalQty - $quantity;
        $cart->totalPrice = $cart->totalPrice - $price;
        //dd($cart);
        $request->session()->forget('cart');
        if($cart->totalQty > 0)
        {
            $request->session()->put('cart', $cart);
        }
        return redirect()->route('cart.index')->with('error','Xóa khỏi giỏ hàng thành công!');
    }

    public function ajaxPost(Request $request)
    {
        if($request->ajax())
        {
            switch ($request->type) {
                case __('ajax.library.brand'):
                    $brand = new Brand;
                    $brand->name = $request->post_value;
                    $brand->save();
                    $brands = Brand::all()->pluck('name','id');
                    if($brands)
                    {
                        $brands_v = view('admin.ajax.select_brand',compact('brands'))->render();
                    }
                    break;

                case __('ajax.library.color'):
                    $color = new Color;
                    $color->name = $request->post_value;
                    $color->save();
                    $colors = Color::all()->pluck('name','id');
                    if($colors)
                    {
                        $colors_v = view('admin.ajax.select_color',compact('colors'))->render();
                    }
                    break;

                case __('ajax.library.size'):
                    $juice_size = new Size;
                    $juice_size->name = $request->post_value;
                    $juice_size->save();
                    $juice_sizes = Size::all()->pluck('name','id');
                    if($juice_sizes)
                    {
                        $juice_sizes_v = view('admin.ajax.select_juice_size',compact('juice_sizes'))->render();
                    }
                    break;
            }
            if(isset($brands_v))
            {
                return response()->json(['brands'=>$brands_v, 'colors'=>'0', 'juice_sizes'=>'0']);
            }
            if(isset($colors_v))
            {
                return response()->json(['colors'=>$colors_v, 'brands'=>'0', 'juice_sizes'=>'0']);
            }
            if(isset($juice_sizes_v))
            {
                return response()->json(['juice_sizes'=>$juice_sizes_v, 'brands'=>'0', 'colors'=>'0']);
            }
        }
    }
}
