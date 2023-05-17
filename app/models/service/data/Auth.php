<?php
/*
 * @Description: model for Authentication
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-14 15:50:50
 * @LastEditTime: 2023-04-28 17:40:35
 */



namespace app\models\service\data;
use think\Model;
use think\facade\Db;

class Auth extends Model{
    protected $connection = 'mysql';

    /**
     * @description: get user data from authentication table
     * @param {*} $condition
     * @return {*}
     */    
    public static function getUserData($condition){
        $result = Db::name('authentication')->where($condition)->select();
        return $result;
    }

    /**
     * @description: admin can get every data from the auth table
     * @return {*}
     */
    public static function getAdminData(){
        return Db::name('authentication')->select();
    }

    public static function getDataByAuthId($authId){
        $condition=array('auth_id'=>$authId);
        return Db::name('authentication')->where($condition)->select();
    }
    
}
