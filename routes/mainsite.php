<?php
/**
 * Created by PhpStorm.
 * User: Wesley Nguyen <wesley@ifreight.net>
 * Date: 12/11/18
 * Time: 6:31 AM
 */

/*
|--------------------------------------------------------------------------
| Customer login
|--------------------------------------------------------------------------
*/

Route::get('/dang-nhap','CustomerLoginController@showLoginForm')->name('customer.login')->middleware('guest:customer');
Route::post('/dang-nhap', 'CustomerLoginController@login')->name('customer.login.submit');
Route::post('/dang-ky', 'CustomerRegisterController@register')->name('customer.register');
Route::post('/dang-xuat', 'CustomerLoginController@logout')->name('customer.logout');
Route::get('/tai-khoan', 'CustomerController@getCustomerAcc')->name('customer.account');
Route::put('/tai-khoan/', 'CustomerController@update')->name('customer.account.update');
Route::put('/tai-khoan/thong-tin', 'CustomerController@customInfoUpdate')->name('customer.account.info.update');
Route::get('/tim-kiem', 'PagesController@search')->name('mainsite.search');
Route::get('/lich-su-mua-hang', 'CustomerController@getOrders')->name('customer.orders');
Route::get('/lich-su-mua-hang/{orderCode}', 'CustomerController@getOrder')->name('customer.order');
Route::get('/lich-su-mua-hang/don-hang/tim-kiem', 'CustomerController@search')->name('customer.orders.search');


Route::post('/fee/districts','AjaxController@getDistrictsList')->name('districts.list');
Route::post('/order/fee','AjaxController@orderPrice')->name('order.price');
Route::post('/cart/check/item', 'AjaxController@cartCheckItem')->name('cart.check.item');
Route::post('/cart/add/item', 'AjaxController@cartAddItem')->name('cart.add.item');
Route::get('/cart/add/{id}',[
    'uses'=>'AjaxController@addToCart',
    'as'=>'product.addToCart'
]);
Route::post('/cart/update', 'AjaxController@cartUpdate')->name('cart.update');
Route::get('/cart/delete/{id}', 'AjaxController@cartDelete')->name('cart.delete');
Route::put('/them-don-hang', 'CartController@pushCart')->name('cart.push');

Route::get('/cart/test/cartttt', 'AjaxController@getCart')->name('test.cart');
Route::get('/gio-hang', 'PagesController@getCart')->name('cart.index');
Route::get('/back', function(){
    return redirect()->intended(route('index'));
})->name('back');
Route::get('/thanh-toan', 'PagesController@getCheck')->name('cart.check');
Route::get('/hoan-tat/{orderCode}/{fee}', 'PagesController@getDone')->name('cart.done');
Route::group(['middleware'=>['web']], function() {
    // Articles routes
    Route::get('/review-blog','ArticleController@getArticles')->name('article.index');
    Route::get('/kiem-tra-don-hang', 'PagesController@getCheckOrders')->name('orders.check');
    Route::post('/kiem-tra-don-hang', 'PagesController@searchOrder')->name('orders.sear');
    Route::get('/kiem-tra-don-hang/{orderCode}', 'PagesController@resultOrder')->name('orders.result');
    Route::get('/review-blog/{slug}', [
        'as'=>'article.single',
        'uses'=>'ArticleController@getSingle'
    ])->where('slug','[\w\d\-\_]+');

    Route::get('/khong-tim-thay',['as'=>'404.not.found','uses'=>'PagesController@get404']);

    // Items routes
    Route::get('/{item_cat}', [
        'as'=>'items.cat.index',
        'uses'=>'PagesController@getPage'
    ])->where('item_cat','[\w\d\-\_]+');

    Route::get('/{item_cat}/{item_sub_cat}', [
        'as'=>'items.cat.sub.index',
        'uses'=>'PagesController@getSubPage'
    ])->where(['item_cat'=>'[\w\d\-\_]+' , 'item_sub_cat'=>'[\w\d\-\_]+']);

    Route::get('/{item_cat}/{item_id}/{item_name}', [
        'as'=>'item.index',
        'uses'=>'PagesController@getItem'
    ])->where(['item_cat'=>'[\w\d\-\_]+', 'item_name'=>'[\w\d\-\_]+']);

    Route::get('/{item_cat}/{item_sub_cat}/{item_id}/{item_name}', [
        'as'=>'item.sub.index',
        'uses'=>'PagesController@getSubItem'
    ])->where(['item_cat'=>'[\w\d\-\_]+' , 'item_sub_cat'=>'[\w\d\-\_]+', 'item_name'=>'[\w\d\-\_]+']);

    Route::get('/', 'PagesController@getHome')->name('index');
});