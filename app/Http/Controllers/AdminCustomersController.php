<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Order;
use App\OrderStatus;
use App\ExtraCustomer;

class AdminCustomersController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
    	$customers = Customer::orderBy('id','desc')->paginate(15);
    	$extraCustomers = ExtraCustomer::orderBy('id','desc')->paginate(15);
    	return view('admin.customers.index', compact('customers','extraCustomers'));
    }

    public function showCustomer($id)
    {
        $customer = Customer::findOrFail($id);
        $orders = Order::where('customer_id',$id)->orderBy('id','desc')->get();
        $order_statuses = OrderStatus::all();
        return view('admin.customers.customershow', compact('customer','order_statuses','orders'));
    }

    public function getCustomerOrdersByStatus(Request $request)
    {
        if($request->ajax())
        {
            //return response()->json(['option'=>$data]);
            $orders = Order::where('customer_id',$request->customer_id)
                            ->where('order_status_id',$request->status)->get();
            $data = view('admin.ajax.orders',compact('orders'))->render();
            return response()->json(['option'=>$data]);
        }
    }

    public function searchCustomer(Request $request)
    {
        if($request->ajax())
        {
            $orders = Order::where('orderCode','LIKE','%'.$request->search_query.'%')->where('customer_id',$request->customer_id)->get();
            if($orders)
            {
                $data = view('admin.ajax.orders',compact('orders'))->render();
            }
            return response()->json(['option'=>$data]);
        }
    }

    public function showExtraCustomer($id)
    {
        $extracustomer = ExtraCustomer::findOrFail($id);
        $orders = Order::where('extra_customer_id',$id)->orderBy('id','desc')->get();
        $order_statuses = OrderStatus::all();
        return view('admin.customers.extracustomershow', compact('extracustomer','order_statuses','orders'));
    }

    public function getExtraCustomerOrdersByStatus(Request $request)
    {
        if($request->ajax())
        {
            //return response()->json(['option'=>$data]);
            $orders = Order::where('extra_customer_id',$request->extra_customer_id)
                            ->where('order_status_id',$request->status)->get();
            $data = view('admin.ajax.orders',compact('orders'))->render();
            return response()->json(['option'=>$data]);
        }
    }

    public function searchExtraCustomer(Request $request)
    {
        if($request->ajax())
        {
            $orders = Order::where('orderCode','LIKE','%'.$request->search_query.'%')->where('extra_customer_id',$request->extra_customer_id)->get();
            if($orders)
            {
                $data = view('admin.ajax.orders',compact('orders'))->render();
            }
            return response()->json(['option'=>$data]);
        }
    }
}
