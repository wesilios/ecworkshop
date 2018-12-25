<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use App\Menu;
use Validator;
use Mail;
use App\Page;

class SendMailController extends Controller
{
    //
    public function getContact(Request $rq) {
        try {
            $settings = Setting::findOrFail(1);
            $top_nav = Menu::where('id',1)->first();
            $footer_1st_menu = Menu::where('id',2)->first();
            $footer_2nd_menu = Menu::where('id',3)->first();
            $page = Page::where('slug','=','contact')->first();
            return view('mainsite.contact.index',[
                'settings'  => $settings,
                'top_nav'   => $top_nav,
                'footer_1st_menu'   => $footer_1st_menu,
                'footer_2nd_menu'   => $footer_2nd_menu,
                'page' => $page
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function postContact(Request $rq)
    {
        try {
            $rules = [
                'name' => 'required',
                'phone' => 'required',
                'email' => 'required|email',
            ];

            $validators = Validator::make($rq->all(),$rules);
            if($validators->fails())
            {
                return response()->json(['status'=>'error','message'=>'Some of information is invalid']);
            }
            $input = $rq->all();
            Mail::send('mainsite.mail.whosales', array('name'=>$input["name"],'email'=>$input["email"], 'phone'=>$input['phone'],'message'=>$input['message']) , function($message){
                $message->from('no-reply@ecdistribution.com','No-reply')->to('quenguyen10190@mailinator.com', 'No-reply')->subject('Who sales!');
            });
            return response()->json(['status'=>'success','message'=>'Gửi liên lạc thành công. Chúng tôi sẽ liên lạc với bạn sau.']);
        } catch (\Exception $e) {
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    }
}
