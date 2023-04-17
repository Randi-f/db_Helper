<?php
/*
 * @Description: 
 * @Version: 
 * @Author: fsh
 * @Date: 2023-01-10 11:47:38
 * @LastEditTime: 2023-04-16 22:01:53
 */

namespace app\controller;

use app\BaseController;
use think\facade\view;
use think\facade\Session;
use think\facade\Db;
use app\models\service\data\User;
use app\service\SendMail;

class TestController extends BaseController
{
    public function index()
    {
        return View::fetch("testGetTableValue");
        //return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><p> ThinkPHP V' . \think\facade\App::version() . '<br/><span style="font-size:30px;">16载初心不改 - 你值得信赖的PHP框架</span></p><span style="font-size:25px;">[ V6.0 版本由 <a href="https://www.yisu.com/" target="yisu">亿速云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="ee9b1aa918103c4fc"></think>';
    }

    public function testPersonalPage(){
        return View::fetch("/home/personalpage");
    }

    
    public function testSession(){
        Session::set('user_id','1');
        $userId=Session::get('user_id');
        echo $userId;
    }

    public function getUser(){
        Session::set('user_id','1');
        $userId=Session::get('user_id');
        $condition=array('user_id'=>$userId);  
        $allData = Db::table('user') -> field("first_name,last_name,email") ->where($condition)->select();
        return $allData;
    }
    public function testTable(){
        return View::fetch("/home/test1");
    }
    public function createUser(){
        // $this->ajaxReturn('跳转成功');
        // return '跳转成功';
        // $data = {'password':"password"};
        // echo json_encode($data);
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $ret =  User::createUser($firstName,$lastName,$email,md5($password));
        return $ret;
    }

    public function testMail(){
        SendMail::sendMail("test");
    }
    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }

    public function test()
    {
        // url: http://127.0.0.1:8000/index/test
        return View::fetch("test/form1");
    }

    public function login()
    {
        return View::fetch("login");
    }

    public function city(){
        $user = M("city")->select(); 
        $this->assign('list',$user);       
        $this->display();
    }

    // public function formprocess1controller(){
    //     echo $_POST['name'];
    // }

    public function useMD5(){
        $pwd = "12345";
        echo md5($pwd); // 827ccb0eea8a706c4c34a16891f84e7b
    }

    public function test1()
    {   
        session_start();    //运用session
        if (session('name')==null)    //查询session会话下的文件夹中的数据中name是否为空，即是否已经登录，拥有拦截作用，避免未经登录获取你的加密页面
        {
           return '你没有登录';  //为空。直接返回你没有登录，不再作任何执行
        }
        else     //不为空，即已经登录,可继续往下操作
        {
            echo "hi";
        	$htmls=$this->fetch();     //执行你想要的任何代码或者跳转到你已加密的页面或者显示你当前加密的页面
            return $htmls;              
        }
    }

}
