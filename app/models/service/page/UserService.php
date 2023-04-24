<?php
/*
 * @Description: model for user
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-14 15:50:50
 * @LastEditTime: 2023-04-17 15:53:30
 */



namespace app\models\service\page;
use think\Model;
use think\facade\Db;
use app\models\service\data\User;
use think\facade\Session;

class UserService extends Model{
    
    
    public static function getProfile($userId){
        $condition=array('user_id'=>$userId); 
        $result = User::where($condition)->field('user_id,first_name,last_name,email')->select();
        return $result;
    }

    public static function modifyProfileInfo($updateInfo){
        $condition=array('user_id'=>Session::get('user_id')); 
        $result = User::where($condition)->update($updateInfo);
        return $result;
    }

    public static function getUserData($user_id){
        if($user_id==-1){
            $condition=array('user_id'=>Session::get('user_id')); 
        }
        else{
            $condition=array('user_id'=>$user_id); 
        }
        
        $result = User::where($condition)->field('authIds')->select();
        return $result;
    }

    public static function modifyUserData($user_id,$updateInfo){
        if($user_id==-1){
            $condition=array('user_id'=>Session::get('user_id')); 
        }
        else{
            $condition=array('user_id'=>$user_id); 
        }
        
        $result = User::where($condition)->update($updateInfo);
        return $result;
    }
}
