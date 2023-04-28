<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::get('/', function () {
    return 'hello,ThinkPHP6!';
});
//Route::get('user/api', 'user.Index/api')->middleware('check');
Route::group(function(){
//    Route::rule('hello/:name','hello');
    Route::get('user/index', 'user.Index/index');
    Route::get('user/info', 'user.Index/info');
    Route::post('user/add', 'user.Index/add');
    Route::post('address', 'user.Address/add');
    Route::get('address', 'user.Address/index');
    Route::get('test', 'user.Address/test');
    Route::get('cart', 'product.Cart/index');
    Route::post('cart', 'product.Cart/add');
    Route::put('cart', 'product.Cart/update');
    Route::delete('cart', 'product.Cart/del');
    Route::post('cart/confirm', 'product.Cart/confirm');
    Route::get('recommend', 'product.Cart/recommend');
    Route::post('order/create', 'product.Order/create');
    Route::get('order', 'product.Order/list');
    Route::get('exchange', 'product.Exchange/index');
    Route::get('integral', 'user.Integral/index');
    Route::get('inIntegral', 'user.Integral/inIntegral');

})->middleware(['AllowCross','check']);
Route::group(function(){
    Route::get('login', 'user.Index/login');
    Route::get('register', 'user.Index/register');
    Route::get('index', 'homepage.Index/index');
    Route::get('search', 'homepage.Index/search');
    Route::get('product', 'homepage.Index/goods');
    Route::get('product/goods', 'product.Index/index');
    Route::get('product/detail', 'product.Index/detail');
    Route::get('reply', 'product.reply/index');
    Route::post('reply', 'product.reply/create');
    Route::get('category', 'category.Index/index');
    Route::get('category/goods', 'category.Index/getGoodsByCate');
})->middleware('AllowCross');