<?php
/*
 * @Description: 
 * @Version: 
 * @Author: fsh
 * @Date: 2023-03-12 10:02:26
 * @LastEditTime: 2023-05-16 19:23:14
 */
use app\ExceptionHandle;
use app\Request;

// 容器Provider定义文件
return [
    'think\Request'          => Request::class,
    'think\exception\Handle' => ExceptionHandle::class,
    //     // 绑定自定义异常处理handle类
    // 'think\exception\Handle'       => '\\app\\exception\\Http',
];
