<?php
/*
 * @Description: model for user
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-14 15:50:50
 * @LastEditTime: 2023-04-17 10:58:57
 */



namespace app\models\service\page;
use think\Model;
use think\facade\Db;
use app\models\service\data\RunInstances;
use think\facade\Session;
use app\models\service\page\UserService;
use app\models\service\page\AuthService;

class RunInstancesService {
    
    public static function getDataDetails($authId){
        // condition: "auth_id"=> 1
        $condition=array('auth_id'=>$authId); 
        $dbInfo=AuthService::getUserData($condition);
        // return $dbInfo;
        $runInstances = new RunInstances();
        $ret=$runInstances::getDataDetails($dbInfo);
        return $ret;
    }
    
}
