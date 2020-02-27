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

//Route::get('/', function () {
//    return view('welcome');
//});

// 在之前的路由里加上一个verify参数
Auth::routes(['verify' => true]);

// auth中间件登录才能访问,varified中间件必须验证邮箱才能访问
Route::group(['middleware' => [
    'auth',
    'verified'
]],function () {
    // 前台用户收货地址相关路由
   Route::get('user_addresses', 'UserAddressesController@index')->name('user_addresses.index');
   Route::get('user_addresses/create', 'UserAddressesController@create')->name('user_addresses.create');
   Route::post('user_addresses', 'UserAddressesController@store')->name('user_addresses.store');
   Route::get('user_addresses/{user_address}', 'UserAddressesController@edit')->name('user_addresses.edit');
   Route::put('user_addresses/{user_address}', 'UserAddressesController@update')->name('user_addresses.update');
   Route::delete('user_addresses/{user_address}', 'UserAddressesController@destroy')->name('user_addresses.destroy');

   // 商品收藏相关路由
   Route::post('products/{product}/favorite', 'ProductsController@favor')->name('products.favor');
   Route::delete('products/{product}/favorite', 'ProductsController@disfavor')->name('products.disfavor');
   Route::get('products/favorites', 'ProductsController@favorites')->name('products.favorites');
   // 购物车相关路由
   Route::post('cart', 'CartController@add')->name('cart.add');
   Route::get('cart', 'CartController@index')->name('cart.index');
   Route::delete('cart/{sku}', 'CartController@remove')->name('cart.remove');
   // 前台订单相关路由
   Route::post('orders', 'OrdersController@store')->name('orders.store');
   Route::get('orders', 'OrdersController@index')->name('orders.index');
   Route::get('orders/{order}', 'OrdersController@show')->name('orders.show');
   // 订单支付相关路由
   Route::get('payment/{order}/alipay', 'PaymentController@payByAlipay')->name('payment.alipay');
   Route::get('payment/alipay/return', 'PaymentController@alipayReturn')->name('payment.alipay.return');
   // 订单相关路由
   Route::post('orders/{order}/received', 'OrdersController@received')->name('orders.received');
   Route::get('orders/{order}/review', 'OrdersController@review')->name('orders.review.show');
   Route::post('orders/{order}/review', 'OrdersController@sendReview')->name('orders.review.store');
   Route::post('orders/{order}/apply_refund', 'OrdersController@applyRefund')->name('orders.apply_refund');
   // 前台优惠券相关路由
   Route::get('coupon_codes/{code}', 'CouponCodesController@show')->name('coupon_codes.show');
   // 众筹订单相关路由
   Route::post('crowdfunding_orders', 'OrdersController@crowdfunding')->name('crowdfunding_orders.store');
   // 分期付款订单
   Route::post('payment/{order}/installment', 'PaymentController@payByInstallment')->name('payment.installment');
   // 分期付款列表
   Route::get('installments', 'InstallmentsController@index')->name('installments.index');
   // 分期付款详情
   Route::get('installments/{installment}', 'InstallmentsController@show')->name('installments.show');
   // 分期付款支付宝支付
   Route::get('installments/{installment}/alipay', 'InstallmentsController@payByAlipay')->name('installments.alipay');
   // 分期付款网页回调
   Route::get('installments/alipay/return', 'InstallmentsController@alipayReturn')->name('installments.alipay.return');
});
Route::redirect('/','/products')->name('root');
Route::get('products', 'ProductsController@index')->name('products.index');
Route::get('products/{product}', 'ProductsController@show')->name('products.show');
Route::post('payment/alipay/notify', 'PaymentController@alipayNotify')->name('payment.alipay.notify');
// 分期付款服务器回调
Route::post('installments/alipay/notify', 'InstallmentsController@alipayNotify')->name('installments.alipay.notify');
