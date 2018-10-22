<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;
use App\Admin;
use App\Order;
use App\Customer;
use App\ExtraCustomer;
use Carbon\Carbon;
use App\Item;
use App\Article;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ordersInAMonth = $this->getOrdersInAMonth()->count();
        $allOrdersCount = $this->getAllOrders()->count();
        $ordersNoDelivery = $this->getOrdersNoDelivery();
        $allCustomersCount = $this->getAllCustomers()->count();
        $allExtraCustomerCount = $this->getAllExtraCustomer()->count();
        $allItemsCount = $this->getAllItems()->count();
        $sevenOrders = $this->getSevenOrders();
        $sevenArticle = $this->getSevenArticle();
        $sevenCustomer = $this->getSevenCustomer();
        $sevenExtraCustomer = $this->getSevenExtraCustomer();
        return view('admin.dashboard',compact(
            'ordersInAMonth',
            'allOrdersCount',
            'ordersNoDelivery',
            'allCustomersCount',
            'allExtraCustomerCount',
            'allItemsCount',
            'sevenOrders',
            'sevenArticle',
            'sevenCustomer',
            'sevenExtraCustomer'
        ));
    }

    public function getOrdersInAMonth()
    {
        return Order::where('order_status_id', 1)->where('created_at','>',Carbon::now()->subMonth())->get();
    }

    public function getAllOrders()
    {
        return Order::all();
    }

    public function getSevenOrders()
    {
        return Order::orderBy('id','desc')->paginate(7);
    }

    public function getSevenArticle()
    {
        return Article::orderBy('id','desc')->paginate(7);
    }

    public function getSevenCustomer()
    {
        return Customer::orderBy('id','desc')->paginate(7);
    }

    public function getSevenExtraCustomer()
    {
        return ExtraCustomer::orderBy('id','desc')->paginate(7);
    }

    public function getOrdersNoDelivery()
    {
        return Order::where('order_status_id', 1)->get();
    }

    public function getAllCustomers()
    {
        return Customer::all();
    }

    public function getAllExtraCustomer()
    {
        return ExtraCustomer::all();
    }

    public function getAllItems()
    {
        return Item::all();
    }

    public function adminShow($id)
    {
        $admin = Admin::findOrFail($id);
        $items = $admin->items()->orderBy('id', 'desc')->take(10)->get();
        $articles = $admin->articles()->orderBy('id', 'desc')->take(10)->get();
        return view('admin.users.adminShow', compact('admin','items','articles'));
    }

    public function adminEdit($id)
    {
        $admin = Admin::findOrFail($id);
        return view('admin.users.adminEdit', compact('admin'));
    }

    public function adminUpdate(Request $request, $id)
    {
        //
        $validator = Validator::make($request->all(), [
            'name'=> 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('admins')->ignore($id),
            ],
            'password' => 'required|string|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.me.edit', [$id])
                        ->withErrors($validator)
                        ->withInput();
        }

        if($file = $request->file('photo_id')) {
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['path'=>$name]);
            $admin->photo_id = $photo->id;
        }

        $admin = Admin::findOrFail($id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->save();
        return redirect()->route('admin.me', [$id])->with('edit', 'Lưu chỉnh sửa thành công!');
    }
}
