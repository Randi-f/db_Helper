<?php
/*
 * @Description: login  http://127.0.0.1:8000/login
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-19 14:19:52
 * @LastEditTime: 2023-04-15 18:08:06
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
    /**
     * @description: show the web page for users to login
     * @return {*}
     */    
    public function index()
    {
        return View::fetch("login");
    }

    /**
     * @description: show the web page for users to register
     * @return {*}
     */
    public function createPage(){
        return View::fetch("create");
    }

    /**
     * @description: get users' info of the tab "profile"
     * @return {*}
     */
    public function getUser(){
        // get user_id from Session
        $userId=Session::get('user_id');
        $condition=array('user_id'=>$userId);  
        $allData = Db::table('user') -> field("first_name,last_name,email") ->where($condition)->select();
        return $allData;
    }

    /**
     * @description: register process
     * @return {*}
     */    
    public function createUser(){ //todo: email send fail, warn user
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
        $condition=array('user_id'=>$username,'user_pwd'=>$MD5_password); 
        $result = UserModel::where($condition)->select();
    	if (sizeof($result)==0)
    	{
            echo '<script>alert("wrong username or password!")</script>';
            return View::fetch("login");
    	}
    	else               
    	{
            Session::set('user_id',$username);
            echo Session::get('user_id');
            return View::fetch("/home/personalpage");
    	}

    }


}
