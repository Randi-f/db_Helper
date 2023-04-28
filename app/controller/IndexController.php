<?php
/*
 * @Description: 
 * @Version: 
 * @Author: fsh
 * @Date: 2023-01-10 11:47:38
 * @LastEditTime: 2023-04-28 20:16:06
 */

namespace app\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\view;
use think\facade\Filesystem;
use think\facade\Request;
use think\facade\Session;

use app\models\service\page\UserService;
use app\models\service\page\AuthService;
use app\models\service\page\RunInstancesService;
use app\models\service\page\SecurityListService;
use app\models\service\page\OperationHistoryService;

class IndexController extends BaseController
{
    /**
     * @description: entrance of the system, home/homepage
     * @return {*}
     */    
    public function index()
    {
        return View::fetch("/home/homepage");
        //return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><p> ThinkPHP V' . \think\facade\App::version() . '<br/><span style="font-size:30px;">16载初心不改 - 你值得信赖的PHP框架</span></p><span style="font-size:25px;">[ V6.0 版本由 <a href="https://www.yisu.com/" target="yisu">亿速云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="ee9b1aa918103c4fc"></think>';
    }

     /**
     * @description: reset password
     * @return {*}
     */    
    public function resetPassword(){
        return View::fetch("/home/resetpassword");
    }

    public function deleteRowByRownum(){
        $rowNum=str_replace("num=","",Request::query());
        // return Request::query();
        // return $_POST["rowNum"];
        $dbInfo=AuthService::getDataByAuthId(Session::get('auth_id'));
        $ret=RunInstancesService::deleteByRownum($dbInfo,$rowNum);
        if($ret==1){
            return "<script language=javascript>alert('success');history.back();</script>";
        }
        else{
            return "<script language=javascript>alert('fail');history.back();</script>";
        }
        
    }
    
}
