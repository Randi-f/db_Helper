<?php
/*
 * @Description: login  http://127.0.0.1:8000/login
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-19 14:19:52
 * @LastEditTime: 2023-02-19 14:29:53
 */
namespace app\controller;

use app\BaseController;
use think\facade\view;
class Login extends BaseController
{
    public function index()
    {
        return View::fetch("login");
    }


}
