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

Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});
Route::get('user/login', 'user.Index/login');
//Route::get('user/api', 'user.Index/api')->middleware('check');
Route::group(function(){
//    Route::rule('hello/:name','hello');
    Route::get('user/api', 'user.Index/index');
})->middleware('check');