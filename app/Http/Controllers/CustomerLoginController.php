<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CustomerLoginRequest;
use App\Http\Controllers\Controller;
use Auth;
use App\Setting;
use App\Menu;
use App\Page;

class CustomerLoginController extends Controller
{
    //
    public function __contruct()
    {
        $this->middleware('guest:customer');
    }

    public function showLoginForm()
    {
        $settings = Setting::findOrFail(1);
        $footer_1st_menu = Menu::where('id',2)->first();
        $footer_2nd_menu = Menu::where('id',3)->first();
        $top_nav = Menu::where('id',1)->first();
        return view('mainsite.login',compact('settings','footer_1st_menu','footer_2nd_menu','top_nav'));
    }

    public function login(CustomerLoginRequest $request)
    {
    	if(Auth::guard('customer')->attempt(['email' => $request->login, 'password' => $request->password_login], $request->remember))
    	{
    		// If successful, then redirect to their intend location
    		return redirect()->route('customer.account');
    	}
        else
        {
            if(Auth::guard('customer')->attempt(['phonenumber' => $request->login, 'password' => $request->password_login], $request->remember))
            {
                // If successful, then redirect to their intend location
                return redirect()->route('customer.account');
            }
        }
    	
    	// If unsuceessful, then redirect to the login with form data
    	return redirect()->back()->withInput($request->only('login', 'remember'))->with('status','Thông tin đăng nhập không hợp lệ!');
    }

    public function logout()
    {
        Auth::guard('customer')->logout();

        //$request->session()->invalidate();

        return redirect()->route('customer.login')->with('status', 'Đăng xuất thành công!');
    }
}
