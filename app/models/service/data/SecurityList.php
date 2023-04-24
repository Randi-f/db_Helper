<?php
/*
 * @Description: model for user
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-14 15:50:50
 * @LastEditTime: 2023-04-17 15:36:52
 */



namespace app\models\service\data;
use think\Model;
use think\facade\Db;
use think\facade\Session;

class SecurityList extends Model{
    protected $connection = 'mysql';

    
    public static function getTrustedUser($condition){
        $result = Db::name('security_list')->where($condition)->field('user1,user2')->select();
        return $result;
    }

    public static function modifyTrustedUser($updateInfo){
        $condition=array('admin_id'=>Session::get('user_id')); 
        $result = Db::name('security_list')->where($condition)->update($updateInfo);
        return $result;

    }

    
}
