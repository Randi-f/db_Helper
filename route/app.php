<?php
/*
 * @Description: 
 * @Version: 
 * @Author: fsh
 * @Date: 2023-01-10 11:47:38
 * @LastEditTime: 2023-02-21 22:26:50
 */
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
    return 'hello,ThinkPHP6, 666!';
});

Route::get('hello/:name', 'index/hello');

// 表达含义是将前者的rule规则定义到User路由中。
// 接下来在View文件中创建User文件夹和index.html,
// 这样当你访问localhost/index.php/user的时候就能跳转到user文件夹下的index.html文件了。
// 也方便了文件的分开管理。
Route::resource('user', 'User');
Route::resource('home', 'Home');
