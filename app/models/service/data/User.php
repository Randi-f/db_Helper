<?php
/*
 * @Description: model for user
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-14 15:50:50
 * @LastEditTime: 2023-04-27 23:08:08
 */

namespace app\models\service\data;

use think\Model;
use think\facade\Db;

class User extends Model{
    protected $connection = 'mysql';

    /**
     * @description: create user and insert data into user table
     * @param {*} $firstName
     * @param {*} $lastName
     * @param {*} $email
     * @param {*} $password
     * @return {*}
     */       
    public static function createUser($firstName, $lastName, $email, $password){
        $data = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'user_pwd' => $password,
            'email' => $email,
            ];
        $ret = Db::name('user')->insertGetId($data);
        return $ret;

    }

    public static function checkUserExist($userId){
        $condition=array("user_id"=>$userId);
        $ret = Db::name('user')->where($condition)->find();
        if($ret){
            return 1;
        }
        else{
            return 0;
        }
       

    }

    public static function deleteAuthIds($adminId,$userId){
        
    }
    
}
