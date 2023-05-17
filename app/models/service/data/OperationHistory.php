<?php
/*
 * @Description: model for operation_history table
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-14 15:50:50
 * @LastEditTime: 2023-05-17 14:59:40
 */

namespace app\models\service\data;

use think\Model;
use think\facade\Db;
use think\facade\Session;

class OperationHistory extends Model{
    protected $connection = 'mysql';

    /**
     * @description: update user's operation history
     * @param {*} $userId
     * @param {*} $operation
     * @return {*}
     */    
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

    public static function viewOperationHistory(){
        $ret = Db::name('operation_history')->select();
        return $ret;
    }

    
}
