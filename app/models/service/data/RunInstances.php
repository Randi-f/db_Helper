<?php
/*
 * @Description: model for user
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-14 15:50:50
 * @LastEditTime: 2023-04-17 11:02:03
 */



namespace app\models\service\data;
use think\Model;
use think\facade\Db;

class RunInstances {
    // protected $connection = 'mysql';

    public static function getDataDetails($dbInfo){
        
        // RunInstances::setConnection($dbInfo['db_name']);
        // $result = Db::name($dbInfo['table_name'])->select();
        $result = Db::connect('mydb')->table('history')->select();
        return $result;
    }
    
    public static function getUserData($condition){
        $result = Db::name('authentication')->where($condition)->select();
        return $result;
    }

    
}
