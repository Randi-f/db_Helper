<?php
/*
 * @Description: model for operation_history table
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-14 15:50:50
 * @LastEditTime: 2023-04-24 22:35:19
 */



namespace app\models\service\data;
use think\Model;
use think\facade\Db;
use think\facade\Session;

class OperationHistory extends Model{
    protected $connection = 'mysql';

    public static function updateOperationHistory($userId, $operation){
        if($userId=-1){
            $userId=Session::get('user_id');
        }
        $data = [
            'operator' => $userId,
            'operation' => $operation,
            'op_time' => date('Y-m-d H:i:s'),

            ];
        $ret = Db::name('operation_history')->insertGetId($data);
        return $ret;
    }

    public static function getTrustedUser($condition){
        $result = Db::name('operation_history')->where($condition)->field('user1,user2')->select();
        return $result;
    }

    public static function modifyTrustedUser($updateInfo){
        $condition=array('admin_id'=>Session::get('user_id')); 
        $result = Db::name('operation_history')->where($condition)->update($updateInfo);
        return $result;

    }

    
}
