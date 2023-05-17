<?php
/*
 * @Description: login page
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-19 14:19:52
 * @LastEditTime: 2023-05-16 13:34:37
 */
namespace app\controller;

use app\BaseController;
use think\facade\view;
use think\facade\Db;
use think\facade\Session;

use app\models\service\data\User as UserModel;
use app\models\service\page\SecurityListService;
use app\service\SendMail;


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
    public function createUser(){
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $ret =  UserModel::createUser($firstName,$lastName,$email,md5($password));
        SecurityListService::createAdmin($ret);
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
        if($username=="" || $password==""){
            return "<script language=javascript>alert('username or password is empty!');history.back();</script>";
        }
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
            echo "welcome! USER: ". Session::get('user_id');
            if($result[0]['role']=="super"){
                return View::fetch("/home/superadminpage");
            }
            else{
                return View::fetch("/home/personalpage");
            }
            
            
    	}

    }


}
