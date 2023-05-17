<?php
/*
 * @Description: service model for run instance
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-14 15:50:50
 * @LastEditTime: 2023-05-17 11:53:25
 */

namespace app\models\service\page;

use app\models\service\data\RunInstances;
use app\models\service\page\AuthService;

class RunInstancesService {
    
    /**
     * @description: get data from run instances
     * @param {*} $authId
     * @return {*}
     */    
    public static function getDataDetails($authId){
        // condition: "auth_id"=> 1
        $condition=array('auth_id'=>$authId); 
        $dbInfo=AuthService::getUserData($condition);
        // return $dbInfo;
        $runInstances = new RunInstances();
        $ret=$runInstances::getDataDetails($dbInfo);
        return $ret;
    }

    public static function deleteByRownum($dbInfo, $rowNum){
        return RunInstances::deleteByRownum($dbInfo, $rowNum);
    }

    public static function modifyData($dbInfo,$condition,$updateData){
        return RunInstances::modifyData($dbInfo,$condition,$updateData);
    }
    
}
