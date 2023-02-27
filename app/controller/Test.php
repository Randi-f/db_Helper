<?php
/*
 * @Description: 基础控制器测试
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-17 11:00:07
 * @LastEditTime: 2023-02-19 15:19:07
 */
namespace app\controller;
use app\BaseController;
use think\facade\view;

class Test extends BaseController
{
    public function index()
    {
        //返回实际路径
        //return $this->app->getBasePath();

        //返回当前方法名
        //return $this->request->action();

        return View::fetch("form1");
    }
}
