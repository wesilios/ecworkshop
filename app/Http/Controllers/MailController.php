<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
class MailController extends Controller
{
    //
    public function sendmail()
    {
    	Mail::send(['text'=>'welcome'],['name','Sarthak'],function($message){
    		$message->to('nguyentque10190@gmail.com','To You')->subject('test Email');
    		$message->from('info@ecworkshop.vn','EC Distribution');
    	});
    }
}
