<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/reset', function(){
	$admin = App\Admin::findOrFail(1);
	$admin->password = bcrypt('90ecworkshop11');
	$admin->save();
	dd($admin);
});

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home/logout', 'Auth\LoginController@userLogout')->name('home.logout');


/*
|--------------------------------------------------------------------------|
|----------------------------  Admin routes  ------------------------------|
|--------------------------------------------------------------------------|
*/

/*
|--------------------------------------------------------------------------
| Admin users
|--------------------------------------------------------------------------
*/

Route::resource('/admin/users', 'AdminUsersController');

/*
|--------------------------------------------------------------------------
| Admin pages
|--------------------------------------------------------------------------
*/
Route::resource('/admin/pages', 'AdminPagesController');
Route::put('/admin/pages/{id}/media', 'AdminPagesController@uploadImage')->name('admin.pages.upload');
Route::put('/admin/pages/{id}/media/select', 'AdminPagesController@selectImage')->name('admin.pages.select');

/*
|--------------------------------------------------------------------------
| Admin articles
|--------------------------------------------------------------------------
*/

Route::resource('/admin/articles', 'AdminArticleController');
Route::put('/admin/articles/{id}/media', 'AdminArticleController@uploadImage')->name('admin.articles.upload');
Route::put('/admin/articles/{id}/media/select', 'AdminArticleController@selectImage')->name('admin.articles.select');
Route::resource('/admin/categories', 'AdminCategoriesController');
Route::resource('/admin/tags', 'AdminTagsController');


/*
| Menus Configuration -----------------------------------------------------
*/
Route::get('/admin/menus/', 'AdminMenusController@index')->name('admin.menus.index');
Route::get('/admin/menus/{id}/edit', 'AdminMenusController@edit')->name('admin.menus.edit');
Route::post('/admin/menus/', 'AdminMenusController@store')->name('admin.menus.store');
Route::put('/admin/menus/{id}/update', 'AdminMenusController@update')->name('adminmenus.update');
Route::delete('/admin/menus/{id}/destroy', 'AdminMenusController@destroy')->name('admin.menus.destroy');

Route::post('/admin/menus/{id}/addpage', 'AdminMenusController@addPage')->name('admin.menus.addpage');
Route::put('/admin/menus/{menu_id}/page/{page_id}/savepageorder', 'AdminMenusController@savePageOrder')->name('adminmenus.savepageorder');
Route::delete('/admin/menus/{menu_id}/page/{page_id}/destroypage', 'AdminMenusController@destroyPage')->name('admin.menus.destroypage');

/*
|--------------------------------------------------------------------------
| Admin items
|--------------------------------------------------------------------------
*/
Route::get('/admin/items/categories', 'AdminItemCategoriesController@index')->name('admin.items.cat.index');
Route::post('/admin/items/categories', 'AdminItemCategoriesController@store')->name('admin.items.cat.store');
Route::put('/admin/items/categories/{id}/update', 'AdminItemCategoriesController@update')->name('admin.items.cat.update');
Route::put('/admin/items/categories/{id}/updateparent', 'AdminItemCategoriesController@updateItemCatsParent')->name('admin.items.cat.updateparent');
Route::delete('/admin/items/categories/{id}/destroy', 'AdminItemCategoriesController@destroy')->name('admin.items.cat.destroy');


/*
| Item brands -------------------------------------------------------------
*/
Route::get('/admin/brands', 'AdminBrandsController@index')->name('admin.brands.index');
Route::post('/admin/brands', 'AdminBrandsController@store')->name('admin.brands.store');
Route::put('/admin/brands/{id}/update', 'AdminBrandsController@update')->name('admin.brands.update');
Route::delete('/admin/brands/{id}/destroy', 'AdminBrandsController@destroy')->name('admin.brands.destroy');
/*
| Item colors -------------------------------------------------------------
*/
Route::get('/admin/colors', 'AdminColorsController@index')->name('admin.colors.index');
Route::post('/admin/colors', 'AdminColorsController@store')->name('admin.colors.store');
Route::put('/admin/colors/{id}/update', 'AdminColorsController@update')->name('admin.colors.update');
Route::delete('/admin/colors/{id}/destroy', 'AdminColorsController@destroy')->name('admin.colors.destroy');
/*
| Item boxes --------------------------------------------------------------
*/
Route::resource('/admin/boxes', 'AdminBoxesController');
Route::put('/admin/boxes/{id}/media', 'AdminBoxesController@uploadImage')->name('admin.boxes.upload');
Route::put('/admin/boxes/{id}/media/select', 'AdminBoxesController@selectImage')->name('admin.boxes.select');
Route::put('/admin/boxes/{id}/indeximage', 'AdminBoxesController@set_image_index')->name('admin.boxes.indeximage');
Route::delete('/admin/boxes/{id}/deleteimage','AdminBoxesController@delete_image')->name('admin.boxes.deleteimage');
/*
| Item full kits ----------------------------------------------------------
*/
Route::resource('/admin/fullkits', 'AdminFullKitsController');
Route::put('/admin/fullkits/{id}/media', 'AdminFullKitsController@uploadImage')->name('admin.fullkits.upload');
Route::put('/admin/fullkits/{id}/media/select', 'AdminFullKitsController@selectImage')->name('admin.fullkits.select');
Route::put('/admin/fullkits/{id}/indeximage', 'AdminFullKitsController@set_image_index')->name('admin.fullkits.indeximage');
Route::delete('/admin/fullkits/{id}/deleteimage','AdminFullKitsController@delete_image')->name('admin.fullkits.deleteimage');
/*
| Item tanks --------------------------------------------------------------
*/
Route::resource('/admin/tanks', 'AdminTanksController');
Route::put('/admin/tanks/{id}/media', 'AdminTanksController@uploadImage')->name('admin.tanks.upload');
Route::put('/admin/tanks/{id}/media/select', 'AdminTanksController@selectImage')->name('admin.tanks.select');
Route::put('/admin/tanks/{id}/indeximage', 'AdminTanksController@set_image_index')->name('admin.tanks.indeximage');
Route::delete('/admin/tanks/{id}/deleteimage','AdminTanksController@delete_image')->name('admin.tanks.deleteimage');
/*
| Item juices --------------------------------------------------------------
*/
Route::get('/admin/juices/sizes', 'AdminSizesController@index')->name('admin.juices.sizes.index');
Route::post('/admin/juices/sizes', 'AdminSizesController@store')->name('admin.juices.sizes.store');
Route::put('/admin/juices/sizes/{id}/update', 'AdminSizesController@update')->name('admin.juices.sizes.update');
Route::delete('/admin/juices/sizes/{id}/destroy', 'AdminSizesController@destroy')->name('admin.juices.sizes.destroy');
Route::resource('/admin/juices', 'AdminJuicesController');
Route::put('/admin/juices/{id}/media', 'AdminJuicesController@uploadImage')->name('admin.juices.upload');
Route::put('/admin/juices/{id}/media/select', 'AdminJuicesController@selectImage')->name('admin.juices.select');
Route::put('/admin/juices/{id}/indeximage', 'AdminJuicesController@set_image_index')->name('admin.juices.indeximage');
Route::delete('/admin/juices/{id}/deleteimage','AdminJuicesController@delete_image')->name('admin.juices.deleteimage');
/*
| Item accessories -----------------------------------------------------------
*/
Route::resource('/admin/accessories', 'AdminAccessoriesController');
Route::put('/admin/accessories/{id}/media', 'AdminAccessoriesController@uploadImage')->name('admin.accessories.upload');
Route::put('/admin/accessories/{id}/media/select', 'AdminAccessoriesController@selectImage')->name('admin.accessories.select');
Route::put('/admin/accessories/{id}/indeximage', 'AdminAccessoriesController@set_image_index')->name('admin.accessories.indeximage');
Route::delete('/admin/accessories/{id}/deleteimage','AdminAccessoriesController@delete_image')->name('admin.accessories.deleteimage');
/*
|--------------------------------------------------------------------------
| Admin slider
|--------------------------------------------------------------------------
*/
Route::get('/admin/sliders', 'AdminSlidersController@index')->name('admin.sliders.index');
Route::get('/admin/sliders/{id}/edit', 'AdminSlidersController@edit')->name('admin.sliders.edit');
Route::post('/admin/sliders/{id}/upload', 'AdminSlidersController@upload')->name('admin.sliders.upload');
Route::post('/admin/sliders/{id}/selectImage', 'AdminSlidersController@selectImage')->name('admin.sliders.selectImage');
Route::put('/admin/sliders/{slider_id}/{id}/updateLink', 'AdminSlidersController@updateLink')->name('admin.sliders.updateLink');
Route::delete('/admin/sliders/{slider_id}/{id}/destroyImage', 'AdminSlidersController@destroyImage')->name('admin.sliders.destroyImage');
/*
|--------------------------------------------------------------------------
| Admin media
|--------------------------------------------------------------------------
*/
Route::get('/admin/media', 'AdminMediaController@index')->name('admin.media.index');
Route::post('/admin/media/create', 'AdminMediaController@create')->name('admin.media.create');
Route::put('/admin/media/{id}/update', 'AdminMediaController@update')->name('admin.media.update');
Route::delete('/admin/media/{id}/destroy', 'AdminMediaController@destroy')->name('admin.media.destroy');
/*
|--------------------------------------------------------------------------
| Admin folders
|--------------------------------------------------------------------------
*/
Route::post('/admin/folder/create','AdminFolderController@create')->name('admin.folder.create');
Route::get('/admin/media/folders/{slug}','AdminFolderController@show')->name('admin.folder.show');
/*
|--------------------------------------------------------------------------
| Admin orders
|--------------------------------------------------------------------------
*/
Route::get('/admin/orders', 'AdminOrdersController@index')->name('admin.orders.index');
Route::post('/admin/orders/search', 'AdminOrdersController@searchOrder')->name('admin.orders.search');
Route::get('/admin/orders/search_query={search_query}&&method={search_type}', 'AdminOrdersController@result')->name('admin.order.result');
Route::get('/admin/order/{orderCode}', 'AdminOrdersController@getOrder')->name('admin.order');
Route::get('admin/orders/status={order_status_id}', 'AdminOrdersController@getOrdersByStatus')->name('admin.orders.status');
Route::put('/admin/order/{id}/update', 'AdminOrdersController@updateOrder')->name('admin.order.update');
Route::get('/admin/orders/ajax/search','AdminOrdersController@ajaxSearch')->name('admin.orders.ajaxSearch');
Route::delete('/admin/orders/delete/{id}','AdminOrdersController@delete')->name('admin.orders.delete');

/*
|--------------------------------------------------------------------------
| Admin customers
|--------------------------------------------------------------------------
*/
Route::get('/admin/customers', 'AdminCustomersController@index')->name('admin.customers.index');
Route::get('/admin/customer/{id}', 'AdminCustomersController@showCustomer')->name('admin.customer.show');
Route::get('/admin/extracustomer/{id}', 'AdminCustomersController@showExtraCustomer')->name('admin.extracustomer.show');
Route::post('admin/customer/orders/', 'AdminCustomersController@getCustomerOrdersByStatus')->name('admin.customer.orders.status');
Route::post('admin/extracustomer/orders/', 'AdminCustomersController@getExtraCustomerOrdersByStatus')->name('admin.extracustomer.orders.status');
Route::get('/admin/extracustomer/order/search', 'AdminCustomersController@searchExtraCustomer')->name('admin.extracustomer.order.search');
Route::get('/admin/customer/order/search', 'AdminCustomersController@searchCustomer')->name('admin.customer.order.search');
Route::prefix('/admin')->group(function() {
	Route::post('/ajax-post', 'AjaxController@ajaxPost')->name('admin.ajax.post');
/*
|--------------------------------------------------------------------------
| Admin website settings
|--------------------------------------------------------------------------
*/

	Route::get('/settings/{id}/edit', 'AdminSettingsController@edit')->name('admin.settings.edit');
	Route::put('/settings/{id}', 'AdminSettingsController@update')->name('admin.settings.update');

/*
|--------------------------------------------------------------------------
| Admin shipping fee
|--------------------------------------------------------------------------
*/
	Route::get('/fee/', 'AdminFeesController@index')->name('admin.fee.index');
	Route::post('/fee/{id}/districts', 'AdminFeesController@store')->name('admin.fee.districts.store');
	Route::put('/fee/{fee_id}/districts/{id}', 'AdminFeesController@updateDistrict')->name('admin.fee.districts.update');
	Route::get('/fee/{id}/edit', 'AdminFeesController@edit')->name('admin.fee.edit');
	Route::put('/fee/{id}/update', 'AdminFeesController@update')->name('admin.fee.update');
	Route::delete('/fee/districts/{id}/destroy', 'AdminFeesController@destroy')->name('admin.fee.destroy');

/*
|--------------------------------------------------------------------------
| Admin login and profile
|--------------------------------------------------------------------------
*/

	Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login')->middleware('guest:admin');
	Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
	Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
	Route::get('/{id}', 'AdminController@adminShow')->name('admin.me');
	Route::get('/{id}/edit', 'AdminController@adminEdit')->name('admin.me.edit');
	Route::put('/{id}', 'AdminController@adminUpdate')->name('admin.me.update');
	Route::get('', 'AdminController@index')->name('admin.dashboard');
});

Route::group(['prefix'=>'api','middleware' => 'auth:admin'], function(){
    Route::get('/find', function(Illuminate\Http\Request $request){
        $keyword = $request->input('keyword');
        Log::info($keyword);
        $skills = DB::table('seos')->where('seo_keyword','like','%'.$keyword.'%')
                  ->select('seos.id','seos.seo_keyword','seos.display')
                  ->get();
        return json_encode($skills);
    })->name('api.skills');
});


/*
|--------------------------------------------------------------------------
| Mainsite
|--------------------------------------------------------------------------
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
