<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use App\Customer;
use App\CustomerInformation;
use App\Setting;
use App\Menu;
use App\Page;
use App\Fee;
use App\FeeDistrict;
use App\Order;
use Validator;

class CustomerController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    public function getCustomerAcc()
    {
    	//dd(Auth::user());
    	$settings = Setting::findOrFail(1);
        $footer_1st_menu = Menu::where('id',2)->first();
        $footer_2nd_menu = Menu::where('id',3)->first();
        $top_nav = Menu::where('id',1)->first();
        $cities = Fee::all()->pluck('city','id');
        //dd($cities);
        if(isset(Auth::user()->customerInfo))
        {
            $districts = FeeDistrict::where('fee_id', Auth::user()->customerInfo->city_id)->get()->pluck('name','id');
        }
        else
        {
            $districts = null;
        }
        
        $customer = Customer::findOrFail(Auth::user()->id);
    	return view('mainsite.customer.index', compact(
    		'settings',
            'footer_1st_menu',
            'footer_2nd_menu',
            'top_nav',
            'cities',
            'customer',
            'districts'

    		));
    }

    public function update(Request $request)
    {
        //dd($request->all());
        $customer = Customer::findOrFail(Auth::user()->id);
        if(isset($request->change_password))
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('customers')->ignore(Auth::user()->id),
                ],
                'phonenumber' => [
                    'required',
                    'numeric',
                    Rule::unique('customers')->ignore(Auth::user()->id),
                ],
                'password' => 'required|string|min:6|confirmed'
            ]);  
        }
        else
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('customers')->ignore(Auth::user()->id),
                ],
                'phonenumber' => [
                    'required',
                    'numeric',
                    Rule::unique('customers')->ignore(Auth::user()->id),
                ]
            ]);
        }

        if ($validator->fails()) {
            return redirect()->route('customer.account')
                        ->withErrors($validator)
                        ->withInput();
        }
        if(isset($request->change_password))
        {
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phonenumber = $request->phonenumber;
            $customer->password = bcrypt($request->password);
        }
        else
        {
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phonenumber = $request->phonenumber;
        }
        
        $customer->save();
        return redirect()->route('customer.account')->with('status','Cập nhật tài khoản thành công');
    }

    public function customInfoUpdate(Request $request)
    {
    	//dd($request->all());
    	$customer = Customer::findOrFail(Auth::user()->id);
        $validator = Validator::make($request->all(), [
            'address' => 'required|string',
            'city_id' => 'required',
            'district_id' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('customer.account')
                        ->withErrors($validator)
                        ->withInput();
        }
    	if($customer->customerInfo == null)
    	{
    		$customerInfo = new CustomerInformation;
    		$customerInfo->customer_id = Auth::user()->id;
    		$customerInfo->address = $request->address;
    		$customerInfo->district_id = $request->district_id;
    		$customerInfo->city_id = $request->city_id;
    		$customerInfo->save();
    	}
    	else
    	{
    		$customerInfo = CustomerInformation::findOrFail($customer->customerInfo['id']);
    		$customerInfo->address = $request->address;
    		$customerInfo->district_id = $request->district_id;
    		$customerInfo->city_id = $request->city_id;
    		$customerInfo->save();
    	}
    	return redirect()->route('customer.account')->with('status','Cập nhật thông tin thành công');
    }
    
    public function getOrders()
    {
        $settings = Setting::findOrFail(1);
        $footer_1st_menu = Menu::where('id',2)->first();
        $footer_2nd_menu = Menu::where('id',3)->first();
        $top_nav = Menu::where('id',1)->first();
        $customer = Customer::findOrFail(Auth::user()->id);
        $orders = Order::where('customer_id', $customer->id)->get();
        return view('mainsite.customer.orders',compact('settings','footer_1st_menu','footer_2nd_menu','top_nav','orders'));
    }

    public function getOrder($orderCode)
    {
        $settings = Setting::findOrFail(1);
        $footer_1st_menu = Menu::where('id',2)->first();
        $footer_2nd_menu = Menu::where('id',3)->first();
        $top_nav = Menu::where('id',1)->first();
        $customer = Customer::findOrFail(Auth::user()->id);
        $order = Order::where('orderCode', $orderCode)->first();
        return view('mainsite.customer.order',compact('settings','footer_1st_menu','footer_2nd_menu','top_nav','order'));
    }

    public function search(Request $request)
    {
        if($request->ajax())
        {
            $orders = Order::where('orderCode','LIKE','%'.$request->search_query.'%')->where('customer_id',$request->customer_id)->get();
            if($orders)
            {
                $data = view('mainsite.ajax.searchorders',compact('orders'))->render();
            }
            return response()->json(['option'=>$data]);
        }
    }
}
