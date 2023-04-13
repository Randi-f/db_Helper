<?php
/*
 * @Description: model for user
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-14 15:50:50
 * @LastEditTime: 2023-04-09 15:58:37
 */



namespace app\models\service\data;
use think\Model;
use think\facade\Db;

class User extends Model{
    protected $connection = 'mysql';

    /**
     * @description: insert data in table USER
     * @return {*}
     */    
    public static function createUser($firstName, $lastName, $email, $password){
        $data = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'user_pwd' => $password,
            'email' => $email,
            ];
        // $ret = Db::name('user')->insert($data);
        $ret = Db::name('user')->insertGetId($data);
        return $ret;
        // TODO: insertAll(),save()
        //save()方法是一个通用方法，可以自行判断是新增还是修改(更新)数据；
        //save()方法判断是否为新增或修改的依据为，是否存在主键，不存在即新增；
        Db::name('user')->save($data);
    }

    
}
