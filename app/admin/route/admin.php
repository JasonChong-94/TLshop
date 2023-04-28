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
Route::group(function(){
//登录
    Route::post('login', 'Index/login');
})->middleware('AllowCross');
Route::group(function(){
    //账户修改
    Route::post('sys_user/save', 'Index/save');
    //账户列表
    Route::get('sys_user', 'Index/list');
    //系统设置
    Route::get('sys_config', 'SysConfig/list');
    //系统设置修改
    Route::post('sys_config/save', 'SysConfig/save');
    //文件上传
    Route::post('file/upload', 'SysConfig/upload');
    //文件上传 批量
    Route::post('file/uploads', 'SysConfig/uploads');
    //文件上传 富文本
    Route::post('file/wangEditFile', 'SysConfig/wangEditFile');
    //产品列表
    Route::get('goods', 'Goods/index');
    //产品上传
    Route::post('goods/create', 'Goods/create');
    //产品修改
    Route::post('goods/update', 'Goods/update');
    //产品详细信息
    Route::get('goods/info', 'Goods/info');
    //产品上下架
    Route::post('goods/is_show', 'Goods/isShow');
    //产品分类
    Route::get('category', 'Category/index');
    //一级分类
    Route::get('category/pcate', 'Category/pcate');
    //新增分类
    Route::post('category/create', 'Category/create');
    //修改分类
    Route::post('category/update', 'Category/update');
    //订单列表
    Route::get('order', 'Order/index');
    //订单发货
    Route::post('order/delivery', 'Order/delivery');
    //用户列表
    Route::get('user', 'User/index');
    //内容管理
    Route::get('article', 'Article/list');
    //内容修改
    Route::post('article/save', 'Article/save');
    //积分产品列表
    Route::get('exchange', 'Exchange/index');
    //积分产品上传
    Route::post('exchange/create', 'Exchange/create');
    //积分产品修改
    Route::post('exchange/update', 'Exchange/update');
    //评论列表
    Route::get('reply', 'Reply/list');
})->middleware(['AllowCross','check']);