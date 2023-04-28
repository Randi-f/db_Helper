<?php
/*
 * @Description: function for personal home page
 * @Version: 3.0
 * @Author: fsh
 * @Date: 2023-01-10 11:47:38
 * @LastEditTime: 2023-04-28 20:09:59
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



class HomeController extends BaseController
{
    /**
     * @description: direct to home/personalpage
     * @return {*}
     */    
    public function index()
    {
        return View::fetch("/home/personalpage");
        //return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><p> ThinkPHP V' . \think\facade\App::version() . '<br/><span style="font-size:30px;">16载初心不改 - 你值得信赖的PHP框架</span></p><span style="font-size:25px;">[ V6.0 版本由 <a href="https://www.yisu.com/" target="yisu">亿速云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="ee9b1aa918103c4fc"></think>';
    }

     /**
     * @description: reset password
     * @return {*}
     */    
    public function resetPassword(){
        // return View::fetch("resetpassword");
        return UserService::resetpassword(md5($_POST["oldpassword"]),md5($_POST["password"]));
    }

    
    /**
     * @description: user uploads file, analyse and restructure and store in db
     * @return {*}
     */    
    public function readUploadFile(){
        
        // check file type. only csv is allowed
        if($_FILES['fileName']['type']!="text/csv"){
            return "<script language=javascript>alert('please upload csv file');history.back();</script>";
        }

        // get the uploaded file
        $file = request()->file('fileName');// C:\Users\lenovo\AppData\Local\Temp\php377.tmp
        // check whether the file content is null
        if(filesize($file) <= 2){ // when file is modified but the content becomes null, its filesize is 2 instead of 0
            return "<script language=javascript>alert('file is empty');history.back();</script>";
        }
        // upload to local server
        $savename = Filesystem::putFile( 'topic', $file); // e.g. topic/20230419\53c3a65fb2b4ab597c03d9d732ce0478.csv
        $savename=str_replace("\\","/",$savename); // standardize the file name, e.g.$savename="topic/20230419/bbcbb8c4f512c2d6747c6f961f0e55a7.csv";

        $FILE_PATH="./runtime/storage/";       
        $fp = fopen($FILE_PATH.$savename, 'r');
        // get file name
        $filename=$file->getOriginalName();
        $filename=str_replace(".csv","",$filename);
        // check if name is colliding
        $cmd_duplicated="select*from information_schema.TABLES where TABLE_NAME = '".$filename."'";
        $dupname = Db::connect('mydb')->execute($cmd_duplicated);
        if($dupname==1){
            // if the name is collided, generate a new name
            $filename=$filename."_".rand(0,100); 
        }
               
        // read the content of the file line by line
        while($line = fgetcsv($fp)){
            $goods_list[] = $line;
        }

        $cmd_create="CREATE TABLE IF NOT EXISTS `".$filename."`(";
        $i=0;
        foreach ($goods_list[0] as $value){
            $cmd_create=$cmd_create."`".$value."` varchar(45),";
            echo $value;
        }
        $cmd_create=rtrim($cmd_create,',');
        $cmd_create=$cmd_create."); ";
        Db::connect('mydb')->execute($cmd_create);
        $filePath = $FILE_PATH.$savename;
        Db::connect('mydb')->execute("LOAD DATA LOCAL INFILE '{$filePath}' INTO TABLE ".$filename. " CHARACTER SET gbk fields terminated by ',' IGNORE 1 LINES");
        $cmd_createPk="alter table ".$filename." add unique_id int unsigned not Null auto_increment primary key";
        Db::connect('mydb')->execute($cmd_createPk);

        // close the file
        fclose($fp);

        // update auth table and user table
        $data = [
            'db_name' => 'mydb',
            'table_name' => $filename,
            ];
        $authId = Db::name('authentication')->insertGetId($data);
        $authIds=UserService::getUserData(-1);
        $str_authIds=$authIds[0]['authIds'];
        $str_authIds=$str_authIds.",".$authId;
        $updateInfo=array("authIds"=>$str_authIds);
        $ret = UserService::modifyUserData(-1,$updateInfo);
        if($ret==0){
            return "<script language=javascript>alert('status:fail, please try again!');history.back();</script>";
        }

        // update trusted user's data
        $trustedUser=SecurityListService::getTrustedUser(-1);
        $updateInfo=array("user1"=>$trustedUser[0]['user1'],"user2"=>$trustedUser[0]['user2']);
        $ret=SecurityListService::modifyTrustedUser($updateInfo);

        if($ret==1){
            OperationHistoryService::updateOperationHistory(-1, "upload data ".$filename);
            return "<script language=javascript>alert('status:success, data name:".$filename."');history.back();</script>";
        }
        else{
            return "<script language=javascript>alert('status:fail, please try again!');history.back();</script>";
        }
	
    }
    
    /**
     * @description: get the user's profile  (test)
     * @return {*}
     */    
    public function getProfile(){
        $userId=1;
        $ret = UserService::getProfile($userId);
        return $ret;
    }

    /**
     * @description: user modify profile info
     * @return {*}
     */    
    public function modifyInfo(){
        $updateInfo=["none" =>"none"];
        if(Request::has('firstName','post')){
            $updateInfo['first_name']=$_POST['firstName'];
        }
        if(Request::has('lastName','post')){
            $updateInfo['last_name']=$_POST['lastName'];
        }
        if(Request::has('email','post')){
            $updateInfo['email']=$_POST['email'];
        }
        unset($updateInfo["none"]);
        
        $ret = UserService::modifyProfileInfo($updateInfo);
        return json($ret);
    }

    /**
     * @description: user view certain data
     * @return {*}
     */    
    public function chooseDataTable(){
        Session::set('auth_id',$_POST['auth_id']);
        // todo: check if the user has the authntication of the data
        return View::fetch("/test/test1");
        
        //  arrange the html filename and its parent-file
        // return View::fetch("/home/datapage");
    }

    /**
     * @description: user choose certain data to view
     * @return {*}
     */    
    public function viewDataTable(){
        // echo Session::get('auth_id');
        $ret=RunInstancesService::getDataDetails(Session::get('auth_id'));      
        return $ret;
    }

    /**
     * @description: get user's trusted users
     * @return {*}
     */    
    public function getTrustedUser(){
        $ret=SecurityListService::getTrustedUser(-1);
        return $ret;
    }

    /**
     * @description: modify trusted users
     * @return {*}
     */    
    public function modifyTrustedUser(){
        //check whether the new user exists
        if($_POST['user1']!=""){
            if(UserService::checkUserExist($_POST['user1'])==0){
                return "user1 does not exist!";
            }
        }
        if($_POST['user2']!=""){
            if(UserService::checkUserExist($_POST['user2'])==0){
                return "user2 does not exist!";
            }
        }
        $updateInfo=array("user1"=>$_POST['user1'],"user2"=>$_POST['user2']);
        $ret=SecurityListService::modifyTrustedUser($updateInfo);
        if($ret==1){
            return "success";
        }
        else{
            return "fail";
        }
    }

    /**
     * @description: get user's authorised data
     * @return {*}
     */    
    public function getUserData(){
        $authIds=UserService::getUserData(-1);
        $authId = explode(",",$authIds[0]['authIds']);
        
        $rett=array();
        foreach($authId as $value){           
            $condition=array("auth_id"=>$value);
            array_push($rett,AuthService::getUserData($condition));
        }
        $ret=json_encode($rett); // json array to string
        $ret=str_replace('[','',$ret);
        $ret=str_replace(']','',$ret);
        return '['.$ret.']';              
    }

    /**
     * @description: admin can get every data from the database
     * @return {*}
     */    
    public function getAdminData(){
        return AuthService::getAdminData();
    }

    public function deleteRowByRownum(){
        return Request::query();
        return $_POST["rowNum"];
        $dbInfo=AuthService::getDataByAuthId(Session::get('auth_id'));
        $ret=RunInstancesService::deleteByRownum($dbInfo,$_GET['rowNum']);
        if($ret==1){
            return "success";
        }
        else{
            return "fail";
        }
        
    }

   
}