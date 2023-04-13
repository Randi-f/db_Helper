<?php
/*
 * @Description: login  http://127.0.0.1:8000/login
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-19 14:19:52
 * @LastEditTime: 2023-04-10 17:00:41
 */
namespace app\controller;

use app\BaseController;
use think\facade\view;
use app\models\service\data\User as UserModel;
use app\service\SendMail;
use think\facade\Db;
use think\facade\Session;

class LoginController extends BaseController
{
    public function index()
    {
        return View::fetch("login");
    }

    public function createPage(){
        return View::fetch("create");
    }

    /**
     * @description: register process
     * @return {*}
     */    
    public function createUser(){
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $ret =  UserModel::createUser($firstName,$lastName,$email,md5($password));
        SendMail::sendMail($email,$ret);
        return $ret;
    }


    /**
     * @description: validate user
     * @return {*}
     */    
    public function validateUser(){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $MD5_password = md5($password);
        // echo "user name:".$username;
        // echo "password: ".$MD5_password;

        $condition=array('user_id'=>$username,'user_pwd'=>$MD5_password);    //把上面获取的值放入到un数组中

    	//$result=UserModel::get($un);    //查找数据库模型User，进行查询un数组的值在数据库中User表里面存在与否
        // $result = UserModel::where($un)::select(); 
        // $result = UserModel::where($un)->select();
        $result = UserModel::where($condition)->select();
    	if (sizeof($result)==0)  //如果un数组为空的时候,即查询失败，没有这个值，即账号密码错误
    	{
    		// return '登录失败';  
            echo '<script>alert("wrong username or password!")</script>';
            return View::fetch("login");
    	}
    	else                  //反之，即查询成功，账号密码正确
    	{
            session_start();     //运用session
            $x=session('name',$username);   //把上面得到用户名，改名为name=***($username)放入session会话下的文件夹里面
		    // return View::fetch("index/test1");;  //又或者可以输入跳转代码，跳转去你加密的后台页
            return Session::get('name'); 
    	}

    }


}
