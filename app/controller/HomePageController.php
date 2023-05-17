<?php
/*
 * @Description: login page
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-19 14:19:52
 * @LastEditTime: 2023-05-16 13:01:42
 */
namespace app\controller;

use app\BaseController;
use think\facade\view;
use think\facade\Db;
use think\facade\Session;

use app\models\service\data\User as UserModel;

use app\service\SendMail;


class HomePageController extends BaseController
{
      
    public function index()
    {
        return View::fetch("index/view");
    }

    public function showContactUs(){
        return View::fetch("index/contactus");
    }




}
