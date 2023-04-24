<?php
/*
 * @Description: 
 * @Version: 
 * @Author: fsh
 * @Date: 2023-01-10 11:47:38
 * @LastEditTime: 2023-04-24 23:04:28
 */

namespace app\controller;

use app\BaseController;
use think\facade\view;
use think\facade\Session;
use think\facade\Db;
use app\models\service\data\User;
use app\service\SendMail;
use app\models\service\page\FileService;
use app\models\service\page\UserService;
use app\models\service\data\OperationHistory;
use app\models\service\page\SecurityListService;
use app\service\Result;
class TestController extends BaseController
{
    public function index()
    {
        $str1=[1,2,3];
        $str2=[2,3];
        foreach ($str1 as $value){
            if(in_array($value, $str2)){
                echo $value;
            }
        }
        return $str2[0];
        $str2=array_push($str2,$str1);
        return json_encode($str2);
        return View::fetch("testUploadFile");
        //return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><p> ThinkPHP V' . \think\facade\App::version() . '<br/><span style="font-size:30px;">16载初心不改 - 你值得信赖的PHP框架</span></p><span style="font-size:25px;">[ V6.0 版本由 <a href="https://www.yisu.com/" target="yisu">亿速云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="ee9b1aa918103c4fc"></think>';
    }

    public function readUploadFile(){
        $file = request()->file('fileName');// C:\Users\lenovo\AppData\Local\Temp\php377.tmp
        // 上传到本地服务器
        $savename = \think\facade\Filesystem::putFile( 'topic', $file); // e.g. topic/20230419\53c3a65fb2b4ab597c03d9d732ce0478.csv
        
        $savename=str_replace("\\","/",$savename);
        // echo $savename;
        $FILE_PATH="./runtime/storage/";
        // $savename="topic/20230419/bbcbb8c4f512c2d6747c6f961f0e55a7.csv";
        $fp = fopen($FILE_PATH.$savename, 'r');
        

        // 逐行输出文件内容
        while($line = fgetcsv($fp)){
            // $data.array_push($line);
            $goods_list[] = $line;
        }

        $filename=$file->getOriginalName();
        $filename=str_replace(".csv","",$filename);
        // $filename="test6";
        $cmd_create="CREATE TABLE IF NOT EXISTS `".$filename."`(`";
        $i=0;
        foreach ($goods_list[0] as $value){
            if($i==0){
                $cmd_create=$cmd_create.$value."` int(8) unsigned NOT NULL AUTO_INCREMENT,";
            }
            else{
                $cmd_create=$cmd_create."`".$value."` varchar(45),";
            }
            $i ++;
            echo $value;
        }
        $cmd_create=$cmd_create."PRIMARY KEY (`".$goods_list[0][0]."`)); ";

        Db::connect('mydb')->execute($cmd_create);
        $filePath = $FILE_PATH.$savename;
        Db::connect('mydb')->execute("LOAD DATA LOCAL INFILE '{$filePath}' INTO TABLE ".$filename. " CHARACTER SET gbk fields terminated by ',' IGNORE 1 LINES");


        // 文件关闭
        fclose($fp);
        //$file->getOriginalName()

        $data = [
            'db_name' => 'mydb',
            'table_name' => $filename,
            ];
        // $ret = Db::name('user')->insert($data);
        $authId = Db::name('authentication')->insertGetId($data);
        $authIds=UserService::getUserData(1);
        $str_authIds=$authIds[0]['authIds'];
        
        $str_authIds=$str_authIds.",".$authId;
        $updateInfo=array("authIds"=>$str_authIds);
        // $updateInfo_detail=array("authIds"=>$str2_authIds);
        UserService::modifyUserData("1",$updateInfo);

        return $file->getOriginalName().json_encode($goods_list); // e.g. topic/20230419\53c3a65fb2b4ab597c03d9d732ce0478.csv
        

	
    }

    public function updateAuth(){
        $filename="test1";
        $data = [
            'db_name' => 'mydb',
            'table_name' => $filename,
            ];
        // $ret = Db::name('user')->insert($data);
        $ret = Db::name('authentication')->insertGetId($data);


        return $ret;
    }

    public function updateUserAuthIds(){
        $authId=3;
        $authIds=UserService::getUserData(1);
        $str_authIds=$authIds[0]['authIds'];
        
        $str_authIds=$str_authIds.",".$authId;
        $updateInfo=array("authIds"=>$str_authIds);
        // $updateInfo_detail=array("authIds"=>$str2_authIds);
        return UserService::modifyUserData("1",$updateInfo);
        

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

    public function test2(){
        // update trusted user's data
        $trustedUser=SecurityListService::getTrustedUser(1);
        $updateInfo=array("user1"=>$trustedUser[0]['user1'],"user2"=>$trustedUser[0]['user2'],);
        $ret=SecurityListService::modifyTrustedUser($updateInfo);
        return $trustedUser;
    }

    public function testOp(){
        return OperationHistory::updateOperationHistory(1, "test");
    }
    public function testTime(){
        return date('Y-m-d H:i:s');
        // return new DateTime();
    }
    public function testEmptyFile(){
        if( '' != filesize('data.txt')){
 
            echo "The file is empty";
        }
    }

}
