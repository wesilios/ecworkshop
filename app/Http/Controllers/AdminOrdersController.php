<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Customer;
use App\OrderStatus;
use App\OrderDetail;
use App\ExtraCustomer;
use Illuminate\Support\Facades\DB;

class AdminOrdersController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
    	$orders = Order::orderBy('order_status_id')->paginate(10);
        $order_statuses = OrderStatus::all();
    	return view('admin.orders.index', compact('orders','order_statuses'));
    }

    public function searchOrder(Request $request)
    {
    	//dd($request->all());
    	return redirect()->route('admin.order.result',[$request->search_query,$request->search_type]);
    }

    public function result($search_query, $search_type)
    {
    	$customer_orders = null;
    	$extraCustomer_orders = null;
    	$orders = null;
        $order_statuses = OrderStatus::all();

    	switch ($search_type) {
    		case 'so_dien_thoai':
    			$customer = Customer::where('phonenumber', $search_query)->first();
    			$extraCustomer = ExtraCustomer::where('phonenumber', $search_query)->first();

    			$customer_id = -1;
    			$extra_customer_id = -1;
    			if($customer != null)
    			{
    				$customer_id = $customer->id;
    			}
    			if($extraCustomer != null)
    			{
    				$extra_customer_id = $extraCustomer->id;
    			}

    			$customer_orders = Order::where('customer_id', $customer_id)->get();
    			$extraCustomer_orders = Order::where('extra_customer_id', $extra_customer_id)->get();
    			$orders = Order::where('orderCode', $search_query)->paginate(20);
    			break;
    		
    		case 'ma_don_hang':
    			$orders = Order::where('orderCode', $search_query)->paginate(20);
    			$customer_orders = Order::where('customer_id', $search_query)->get();
    			$extraCustomer_orders = Order::where('extra_customer_id', $search_query)->get();
    			break;

    		default:
    			//code
    			break;
    	}
    	//dd($customer_orders);
    	if($orders->isEmpty() && $customer_orders->isEmpty() && $extraCustomer_orders->isEmpty())
    	{
    		return view('admin.orders.index', compact('orders','customer_orders','extraCustomer_orders','order_statuses'))->with('error','Không có kết quả tìm kiếm');
    	}
    	else
    	{
    		return view('admin.orders.index', compact('orders','customer_orders','extraCustomer_orders','order_statuses'));
    	}
    }

    public function getOrder($orderCode)
    {
    	$order = Order::where('orderCode', $orderCode)->first();
        $order_statuses = OrderStatus::all()->pluck('name','id');
    	return view('admin.orders.order', compact('order','order_statuses'));
    }

    public function updateOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->order_status_id = $request->order_status_id;
        $order->save();
        return redirect()->route('admin.order',[$order->orderCode])->with('status','Cập nhật thành công!');
    }

    public function getOrdersByStatus($order_status_id)
    {
        $orders = Order::where('order_status_id', $order_status_id)->paginate(20);
        $order_statuses = OrderStatus::all();
        return view('admin.orders.index', compact('orders','order_statuses'));
    }

    public function ajaxSearch(Request $request)
    {
        if($request->ajax())
        {
            switch ($request->search_type) {
                case 'ma_don_hang':
                    $orders = Order::where('orderCode','LIKE','%'.$request->search_query.'%')->get();
                    if($orders)
                    {
                        $data = view('admin.ajax.orders',compact('orders'))->render();
                    }
                    break;
                
                case 'so_dien_thoai':
                    $orderTest = Order::join('customers','orders.customer_id','customers.id')
                        ->join('extra_customers','orders.extra_customer_id','extra_customers.id')
                        ->where('customers.phonenumber' ,'LIKE', '%'. $request->search_query.'%')
                        ->where('extra_customers.phonenumber' ,'LIKE', '%'. $request->search_query.'%')
                        ->select(['orders.orderCode','orders.totalQty','orders.totalPrice','orders.order_status_id','orders.created_at'])
                        ->get();
                    $customer = Customer::where('phonenumber','LIKE','%'. $request->search_query.'%')->first();
                    $extraCustomer = ExtraCustomer::where('phonenumber', 'LIKE','%'. $request->search_query.'%')->first();

                    if($customer)
                    {
                        $customer_orders = Order::where('customer_id', $customer->id)->get();
                        if($customer_orders)
                        {
                            $orders = $customer_orders;  
                        }
                    } else {
                        $orders = NULL;
                    }

                    if($extraCustomer)
                    {
                        $extraCustomer_orders = Order::where('extra_customer_id', $extraCustomer->id)->get();
                        if($extraCustomer_orders)
                        {
                            //$orders = $extraCustomer_orders;
                        }
                    }
                    $data = view('admin.ajax.orders',compact('orders'))->render();
                    break;
            }

            
            return response()->json(['option'=>$data]);
        }
    }

    public function delete($id) 
    {
        $order = Order::findOrFail($id);
        $order_details = OrderDetail::where('order_id', $id)->get();
        if($order) 
        {    
            foreach($order_details as $order_detail)
            {
                $order_detail->delete();
            }
            $order->delete();
        }

        return redirect()->route('admin.orders.index')->with('delete','Xóa đơn hàng thành công!');
    }
}
