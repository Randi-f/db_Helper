<?php
/*
 * @Description: model for security list
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-14 15:50:50
 * @LastEditTime: 2023-05-16 13:24:13
 */



namespace app\models\service\data;

use think\Model;
use think\facade\Db;
use think\facade\Session;

class SecurityList extends Model{
    protected $connection = 'mysql';

    public static function createAdmin($adminId){
        $data = [
            'admin_id' => $adminId,
            ];
        $ret = Db::name('security_list')->insertGetId($data);
        return $ret;
    }
    /**
     * @description: get trusted user according to userId
     * @param {*} $condition
     * @return {*}
     */ 
    public static function getTrustedUser($condition){
        $result = Db::name('security_list')->where($condition)->field('user1,user2')->select();
        return $result;
    }

    /**
     * @description: modify trusted user
     * @param {*} $updateInfo
     * @return {*}
     */ 
    public static function modifyTrustedUser($updateInfo){
        $condition=array('admin_id'=>Session::get('user_id')); 
        $result = Db::name('security_list')->where($condition)->update($updateInfo);
        return $result;

    }

    
}
