<?php
/*
 * @Description: service model for operation_history table
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-14 15:50:50
 * @LastEditTime: 2023-04-24 22:34:03
 */



namespace app\models\service\page;
use app\models\service\data\OperationHistory;



class OperationHistoryService{
    
    public static function updateOperationHistory($userId, $operation){
        return OperationHistory::updateOperationHistory($userId, $operation);
    }
    
}
