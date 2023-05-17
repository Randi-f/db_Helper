<?php
/*
 * @Description: model for RunInstances
 * @Version: 2.0
 * @Autor: fsh
 * @Date: 2023-02-14 15:50:50
 * @LastEditTime: 2023-05-17 11:52:44
 */



namespace app\models\service\data;

use think\facade\Db;

class RunInstances {


    /**
     * @description: get data of db:mydb, table:history
     * @param {*} $dbInfo
     * @return {*}
     */    
    public static function getDataDetails($dbInfo){      
        $result = Db::connect($dbInfo[0]['db_name'])->table($dbInfo[0]['table_name'])->select();
        return $result;
    }
    
    /**
     * @description: get user's data
     * @param {*} $condition
     * @return {*}
     */ 
    public static function getUserData($condition){
        $result = Db::name('authentication')->where($condition)->select();
        return $result;
    }

    public static function getPrimaryKey($dbInfo){
        //获取主键
        // $dbInfo=Auth::getDataByAuthId(2);
        $cmd_sql="SELECT cu.Column_Name FROM INFORMATION_SCHEMA.`KEY_COLUMN_USAGE` cu WHERE
         CONSTRAINT_NAME = 'PRIMARY'
         AND CONSTRAINT_SCHEMA = '".$dbInfo[0]['db_name']."' AND cu.Table_Name = '".$dbInfo[0]['table_name']."' limit 1";
         
        $ret=Db::connect('mysql')->query($cmd_sql);

        return $ret[0]["COLUMN_NAME"];
    }

    public static function deleteByRownum($dbInfo, $rowNum){

        $cmd_sql="SELECT cu.Column_Name FROM INFORMATION_SCHEMA.`KEY_COLUMN_USAGE` cu WHERE
         CONSTRAINT_NAME = 'PRIMARY'
         AND CONSTRAINT_SCHEMA = '".$dbInfo[0]['db_name']."' AND cu.Table_Name = '".$dbInfo[0]['table_name']."' limit 1";
         
        $ret=Db::connect('mysql')->query($cmd_sql);

        $uniqueId=$ret[0]["COLUMN_NAME"];

        $sql_cmd="DELETE from ".$dbInfo[0]['table_name']." where `".$uniqueId."` in (SELECT `".$uniqueId."` from 
        (select @rownum:=@rownum+1 AS rownum,`".$uniqueId."` from ".$dbInfo[0]['table_name']." ,(SELECT @rownum:=0) r) t
         where t.rownum = ".$rowNum." );";

        $ret=Db::connect('mydb')->execute($sql_cmd);     
        return $ret;  
    }

    public static function addData($dbInfo,$insertData){
        $ret = Db::connect($dbInfo[0]['db_name'])->table($dbInfo[0]['table_name'])->insert($insertData);
        return $ret;
    }

    public static function modifyData($dbInfo,$condition,$updateData){
        $ret = Db::connect($dbInfo[0]['db_name'])->table($dbInfo[0]['table_name'])->where($condition)->update($updateData);
        return $ret;
    }
}
