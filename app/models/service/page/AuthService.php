<?php
/*
 * @Description: service model for Authentication
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-14 15:50:50
 * @LastEditTime: 2023-04-28 16:24:09
 */



namespace app\models\service\page;

use think\Model;

use app\models\service\data\Auth;


class AuthService extends Model{
    
    /**
     * @description: get user data from authentication table
     * @param {*} $condition
     * @return {*}
     */ 
    public static function getUserData($condition){       
        $ret=Auth::getUserData($condition);
        return $ret;
    }

    public static function getAdminData(){
        return Auth::getAdminData();
    }

    public static function getDataByAuthId($authId){
        return Auth::getDataByAuthId($authId);
    }
    
}
