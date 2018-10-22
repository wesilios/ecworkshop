<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CustomerRegisterRequest;
use App\Customer;
use App\CustomerInformation;
use Auth;

class CustomerRegisterController extends Controller
{
    //
    public function register(CustomerRegisterRequest $request)
    {
    	//dd($request->all());

    	$customer = new Customer;
    	$customer->name = $request->name;
    	$customer->email = $request->email;
    	$customer->phonenumber = $request->phonenumber;
    	$customer->password = bcrypt($request->password);
    	$customer->save();
        $customerInfo = new CustomerInformation;
        $customerInfo->customer_id = $customer->id;
        $customerInfo->save();
    	if($this->guard()->attempt(['email' => $request->email, 'password' => $request->password]))
    	{
    		return redirect()->intended(route('index'));
    	}
    	return redirect()->back()->withInput(); 
    }

    protected function guard()
    {
        return Auth::guard('customer');
    }
}
