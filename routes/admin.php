<?php
/**
 * Created by PhpStorm.
 * User: Wesley Nguyen <wesley@ifreight.net>
 * Date: 12/11/18
 * Time: 6:31 AM
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
Route::get('/admin/items/','AdminItemsController@index')->name('admin.items.index');
Route::get('/admin/items/{slug}', 'AdminItemsController@edit')->name('admin.items.edit');
Route::get('/admin/items/{slug}/create', 'AdminItemsController@create')->name('admin.items.create');
Route::post('/admin/items/{slug}/store', 'AdminItemsController@store')->name('admin.items.store');
Route::put('/admin/items/{slug}/update', 'AdminItemsController@update')->name('admin.items.update');
Route::delete('/admin/items/{slug}/delete', 'AdminItemsController@destroy')->name('admin.items.delete');
Route::put('/admin/items/{slug}/media', 'AdminItemsController@uploadImage')->name('admin.items.upload');
Route::post('/admin/items/{slug}/media/select', 'AdminItemsController@selectImage')->name('admin.items.select');
Route::put('/admin/items/{slug}/indeximage', 'AdminItemsController@set_image_index')->name('admin.items.indeximage');
Route::delete('/admin/items/{slug}/deleteimage','AdminItemsController@delete_image')->name('admin.items.deleteimage');

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
| Admin folders
|--------------------------------------------------------------------------
*/
    Route::post('/admin/folder/create','AdminFolderController@create')->name('admin.folder.create');
    Route::get('/admin/media/folder/{slug}','AdminFolderController@show')->name('admin.folder.show');
    Route::post('/admin/media/folder/ajax/','AdminFolderController@ajaxModalMedia')->name('admin.folder.ajax.show');
    Route::post('/admin/media/folder/ajax/juice','AdminFolderController@ajaxJuiceModalShow')->name('admin.folder.juice.ajax.show');
    Route::post('/admin/media/folder/ajax/accessory','AdminFolderController@ajaxAccessoryModalShow')->name('admin.folder.accessory.ajax.show');
    Route::post('/admin/media/folder/ajax/box','AdminFolderController@ajaxBoxModalShow')->name('admin.folder.box.ajax.show');
    Route::post('/admin/media/folder/ajax/tank','AdminFolderController@ajaxTankModalShow')->name('admin.folder.tank.ajax.show');
    Route::post('/admin/media/folder/ajax/fullkit','AdminFolderController@ajaxFullKitModalShow')->name('admin.folder.fullkit.ajax.show');
    Route::post('/admin/media/folder/ajax/item','AdminFolderController@ajaxItemModalShow')->name('admin.folder.item.ajax.show');

    Route::post('/admin/folder/juice/create_ajax','AdminFolderController@createJuiceAjax')->name('admin.folder.createJuiceAjax');
    Route::post('/admin/folder/accessory/create_ajax','AdminFolderController@createAccessoryAjax')->name('admin.folder.createAccessoryAjax');
    Route::post('/admin/folder/box/create_ajax','AdminFolderController@createBoxAjax')->name('admin.folder.createBoxAjax');
    Route::post('/admin/folder/tank/create_ajax','AdminFolderController@createTankBoxAjax')->name('admin.folder.createTankAjax');
    Route::post('/admin/folder/fullkit/create_ajax','AdminFolderController@createFullKitAjax')->name('admin.folder.createFullKitAjax');
    Route::post('/admin/folder/item/create_ajax','AdminFolderController@createItemAjax')->name('admin.folder.createItemAjax');
    /*
    |--------------------------------------------------------------------------
    | Admin ajax
    |--------------------------------------------------------------------------
    */
    Route::post('/admin/article/ajaxUpload', 'AdminArticleController@ajaxUpload')->name('admin.article.ajaxUpload');
    Route::post('/admin/juice/ajaxUpload', 'AdminJuicesController@ajaxUpload')->name('admin.juice.ajaxUpload');
    Route::post('/admin/accessory/ajaxUpload', 'AdminAccessoriesController@ajaxUpload')->name('admin.accessory.ajaxUpload');
    Route::post('/admin/box/ajaxUpload', 'AdminBoxesController@ajaxUpload')->name('admin.box.ajaxUpload');
    Route::post('/admin/tank/ajaxUpload', 'AdminTanksController@ajaxUpload')->name('admin.tank.ajaxUpload');
    Route::post('/admin/fullkit/ajaxUpload', 'AdminFullKitsController@ajaxUpload')->name('admin.fullkit.ajaxUpload');
    Route::post('/admin/item/ajaxUpload', 'AdminItemsController@ajaxUpload')->name('admin.item.ajaxUpload');

    Route::post('/admin/juice/remove_selected_img', 'AdminJuicesController@ajaxRemoveImg')->name('admin.juice.remove_selected_img');
    Route::post('/admin/accessory/remove_selected_img', 'AdminAccessoriesController@ajaxRemoveImg')->name('admin.accessory.remove_selected_img');
    Route::post('/admin/box/remove_selected_img', 'AdminBoxesController@ajaxRemoveImg')->name('admin.box.remove_selected_img');
    Route::post('/admin/tank/remove_selected_img', 'AdminTanksController@ajaxRemoveImg')->name('admin.tank.remove_selected_img');
    Route::post('/admin/fullkit/remove_selected_img', 'AdminFullKitsController@ajaxRemoveImg')->name('admin.fullkit.remove_selected_img');
    Route::post('/admin/items/remove_selected_img', 'AdminItemsController@ajaxRemoveImg')->name('admin.item.remove_selected_img');
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