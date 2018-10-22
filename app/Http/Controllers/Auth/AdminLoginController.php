<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Controllers\Controller;
use Auth;

class AdminLoginController extends Controller
{
     /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    //
    public function __contruct()
    {
    	$this->middleware('guest:admin');
    }

    public function showLoginForm()
    {
        return view('admin.login'); 
    }

    public function login(AdminLoginRequest $request)
    {
    	// Validate the form data using request

    	// Attempt to log the user in
    	//return $request->all();
    	if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember))
    	{
    		// If successful, then redirect to their intend location
    		return redirect()->intended(route('admin.dashboard'));
    	}
    	
    	// If unsuceessful, then redirect to the login with form data
    	return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        //$request->session()->invalidate();

        return redirect()->route('admin.login')->with('logout', 'Đăng xuất thành công!');
    }
}
