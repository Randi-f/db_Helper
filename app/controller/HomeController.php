<?php
/*
 * @Description: 
 * @Version: 
 * @Author: fsh
 * @Date: 2023-01-10 11:47:38
 * @LastEditTime: 2023-04-17 10:50:58
 */

namespace app\controller;

use app\BaseController;
use think\facade\view;
use app\models\service\data\User;
use app\service\SendMail;
use app\models\service\page\UserService;
use app\models\service\page\AuthService;
use app\models\service\page\RunInstancesService;
use think\facade\Request;


class HomeController extends BaseController
{
    public function index()
    {
        return View::fetch("/home/personalpage");
        //return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><p> ThinkPHP V' . \think\facade\App::version() . '<br/><span style="font-size:30px;">16载初心不改 - 你值得信赖的PHP框架</span></p><span style="font-size:25px;">[ V6.0 版本由 <a href="https://www.yisu.com/" target="yisu">亿速云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="ee9b1aa918103c4fc"></think>';
    }

    public function getProfile(){
        $userId=1;
        $ret = UserService::getProfile($userId);
        return $ret;
    }

    public function modifyInfo(){
        $updateInfo=["none" =>"none"];
        if(Request::has('firstName','post')){
            $updateInfo['first_name']=$_POST['firstName'];
        }
        unset($updateInfo["none"]);
        
        $ret = UserService::modifyProfileInfo($updateInfo);
        return json($ret);
        // $re=Request::has('firstName','post');
        // // $ret={'status': $re };
        // return json($re);

        // return $_POST;
        // return "传输成功";
        // return "success";

    }

    public function chooseDataTable(){
        $runInstancesService= new RunInstancesService();
        $ret=$runInstancesService::getDataDetails($_POST['auth_id']);
        
        return $ret;
        // todo
    }

    public function getUserData(){
        $authIds=UserService::getUserData();
        // return $authIds;
        $authId = explode(",",$authIds[0]['authIds']);
        
        $rett=array();
        foreach($authId as $value){
            
            $condition=array("auth_id"=>$value);
            // return AuthService::getUserData($condition);
            array_push($rett,AuthService::getUserData($condition));
        }
        // $authIds=array("auth_id"=>1);
        // $ret = AuthService::getUserData($authIds);
        // return $rett;
        $ret=json_encode($rett); // json array to string
        $ret=str_replace('[','',$ret);
        $ret=str_replace(']','',$ret);

        // return json_encode($rett);
        return '['.$ret.']';
        

        
        
    }
}