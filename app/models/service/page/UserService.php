<?php
/*
 * @Description: model for user
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-14 15:50:50
 * @LastEditTime: 2023-04-11 19:05:00
 */



namespace app\models\service\page;
use think\Model;
use think\facade\Db;
use app\models\service\data\User;

class UserService extends Model{
    public static function getProfile($userId){
        $condition=array('user_id'=>$userId); 
        $result = User::where($condition)->field('user_id,first_name,last_name,email')->select();
        return $result;
    }
}
