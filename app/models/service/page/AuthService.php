<?php
/*
 * @Description: model for user
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-14 15:50:50
 * @LastEditTime: 2023-04-16 21:34:56
 */



namespace app\models\service\page;
use think\Model;
use think\facade\Db;
use app\models\service\data\Auth;
use think\facade\Session;
use app\models\service\page\UserService;

class AuthService extends Model{
    
    public static function getUserData($condition){
        // condition: "auth_id"=> 1
        
        $ret=Auth::getUserData($condition);
        return $ret;
    }
    
}
