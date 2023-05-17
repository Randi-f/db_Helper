<?php
/*
 * @Description: service model for operation_history table
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-14 15:50:50
 * @LastEditTime: 2023-05-17 15:00:08
 */

namespace app\models\service\page;

use app\models\service\data\OperationHistory;

class OperationHistoryService{
    
    /**
     * @description: update operation history table
     * @param {*} $userId
     * @param {*} $operation
     * @return {*}
     */    
    public static function updateOperationHistory($userId, $operation){
        return OperationHistory::updateOperationHistory($userId, $operation);
    }

    public static function viewOperationHistory(){
        return OperationHistory::viewOperationHistory();
    }
    
}
