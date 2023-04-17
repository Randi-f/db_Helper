<?php
/*
 * @Description: model for user
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-14 15:50:50
 * @LastEditTime: 2023-04-16 13:05:15
 */



namespace app\models\service\data;
use think\Model;
use think\facade\Db;

class Auth extends Model{
    protected $connection = 'mysql';

    
    public static function getUserData($condition){
        $result = Db::name('authentication')->where($condition)->select();
        return $result;
    }

    
}
