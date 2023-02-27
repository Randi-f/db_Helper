<?php
/*
 * @Description: hello world test
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-17 10:50:28
 * @LastEditTime: 2023-02-17 10:58:18
 */

namespace app\controller;

class HelloWorld
{
    public function index()
    {
        // return 'hello world';
        $data = array ( 'a'=>1, 'b'=>2, 'c'=>3);
        halt('中断输出');
        return json($data);
    }
}