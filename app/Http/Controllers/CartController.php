<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fee;
use App\FeeDistrict;
use App\Order;
use App\OrderDetail;
use App\ExtraCustomer;
use App\Menu;
use App\Setting;
use Session;
use Validator;
use Auth;
use Mail;
use Carbon\Carbon;
use App\Jobs\SendEmailCustomerOrdersJob;


class CartController extends Controller
{
    //
    public function pushCart(Request $request)
    {  
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phonenumber' => 'required|string|max:255',
            'address' => 'required|string',
            'city_id' => 'required|numeric',
            'district_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()->route('cart.check')
                        ->withErrors($validator)
                        ->withInput();
        }
        $cart = $request->session()->get('cart');
        if($cart == null)
        {
            return redirect()->route('cart.index')->with('status','Giỏ hàng bạn đang trống');
        }
        //dd($request->all());
        //return $request->district_id;
        $feedistrict = FeeDistrict::findOrFail($request->district_id);
        $setting = Setting::findOrFail(1);
        $city = Fee::findOrFail($request->city_id);
        $footer_2nd_menu = Menu::where('id',3)->first();

        //return $cart->totalQty;
        //dd($cart);
        //return redirect()->route('cart.index')->with('error','Xóa khỏi giỏ hàng thành công!');
        $order = new Order;
        $order->address = $request->address;
        $order->district = $feedistrict->name;
        $order->city = $city->city;
        $order->note = $request->note;
        $order->totalQty = $cart->totalQty;
        $order->totalPrice = $cart->totalPrice + $city->fee;
        Carbon::setLocale('vi');
        $order->orderCode = date("jmYHis", strtotime(Carbon::now('Asia/Bangkok')));
        if(Auth::guard('customer')->check())
        {
            $order->customer_id = Auth::guard('customer')->user()->id;
            $user = Auth::guard('customer')->user();
        }

        else
        {
            $extra_customer = new ExtraCustomer;
            $extra_customer->name = $request->name;
            $extra_customer->email = $request->email;
            $extra_customer->phonenumber = $request->phonenumber;
            $extra_customer->password = bcrypt('GoDslayeR101');
            $extra_customer->save();
            $order->extra_customer_id = $extra_customer->id;
            $user = $extra_customer;
        }

        $order->save();
        $this->createOrderDetails($request, $order->id);
        //dd($footer_2nd_menu->pages->toArray());
        $data = array (
        	'email' => $request->email,
            'name' => $request->name,
            'address' => $request->address,
            'city' => $city->city,
            'district' => $feedistrict->name,
            'note' => $request->note,
            'orderCode' => $order->orderCode,
        	'orders' => collect($cart)->toArray(),
            'shippingfee' => $city->fee,
            'menu' => $footer_2nd_menu->pages->toArray()
        	);
        if(Auth::guard('customer')->check())
        {
            $job = (new SendEmailCustomerOrdersJob($order, $user, $footer_2nd_menu))->delay(Carbon::now()->addSeconds(10));
            dispatch($job);
        }
        //dd(collect($data));

        /*Mail::send('emails.notify',$data, function($message) use ($data){
            $message->from('info@ecworkshop.vn','EC Distribution');
            $message->to($data['email'],$data['name']);
            $message->subject('Xác nhận đơn hàng');
        });



        $data2 = array (
            'email' => $setting->email,
            'name' => $request->name,
            'address' => $request->address,
            'city' => $city->city,
            'district' => $feedistrict->name,
            'note' => $request->note,
            'orderCode' => $order->orderCode,
            'orders' => collect($cart)->toArray(),
            'shippingfee' => $city->fee,
            'menu' => $footer_2nd_menu->pages->toArray()
            );

        Mail::send('emails.notify',$data2, function($message) use ($data2){
            $message->from('info@ecworkshop.vn','EC Distribution');
            $message->to($data2['email'],'Admin EC');
            $message->subject('Đơn hàng mới');
        });*/
        //$request->session()->flush('cart');
        return redirect()->route('cart.done', [$order->orderCode, $city->fee]);
        //dd($order->extraCustomer);
    }

    public function createOrderDetails(Request $request, $order_id)
    {
    	$cart = $request->session()->get('cart');
    	foreach($cart->items as $item)
    	{
    		$orderDetail = new OrderDetail;
    		$orderDetail->item_name = $item['item']->brand['name'] .' '. $item['item']->item['name'];
			$orderDetail->quantity = $item['quantity'];
			$orderDetail->price = $item['price'];
			$orderDetail->order_id = $order_id;
    		if(isset($item['colors'][0]))
    		{
    			if(isset($item['item']->size))
    			{
    				$orderDetail->feature = $item['item']->size['name'];
    			}
    		}
    		else
    		{
    			foreach ($item['colors'] as $color) 
    			{
    				$orderDetail->feature .= $color['quantity'] .'-'. $color['color']->name . ' ';
    			}
    		}
    		$orderDetail->save();
    	}
    }
}
