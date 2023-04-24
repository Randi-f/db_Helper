<?php
/*
 * @Description: model for user
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-14 15:50:50
 * @LastEditTime: 2023-04-24 21:55:19
 */

namespace app\models\service\page;
use think\facade\Session;
use app\models\service\data\SecurityList;
use app\models\service\page\UserService;

class SecurityListService {
    
    public static function getTrustedUser($userId){
        if($userId==-1){
            $condition=array('admin_id'=>Session::get('user_id')); 
        }
        else{
            $condition=array('admin_id'=>$userId); 
        }
        
        $ret = SecurityList::getTrustedUser($condition);
        return $ret;
    }
    
    public static function modifyTrustedUser($updateInfo){
        //todo check whether the new user exists
        $ret = SecurityList::modifyTrustedUser($updateInfo);// update security list table
        $authIds = UserService::getUserData(-1);//admin's authIds
        $str_authIds=$authIds[0]['authIds'];
        if($updateInfo["user1"]!="" && $updateInfo["user1"]!=null){
            $user1_authIds = UserService::getUserData($updateInfo['user1']);
            $str_user1_authIds=$user1_authIds[0]["authIds"];
            $str1_authIds=$str_authIds.','.$str_user1_authIds;
            $str1_authIds=chop($str_authIds,",");
            $updateInfo_detail=array("authIds"=>$str1_authIds);
            // $authIds[0]["authIds"]=$str_authIds;
            // $authIds.array_push($user1_authIds);
            $ret = UserService::modifyUserData($updateInfo['user1'],$updateInfo_detail);
        }
        if($updateInfo["user2"]!=""&&$updateInfo["user2"]!=null){
            $user2_authIds = UserService::getUserData($updateInfo['user2']);
            $str_user2_authIds=$user2_authIds[0]["authIds"];
            $str2_authIds=$str_authIds.','.$str_user2_authIds;
            $str2_authIds=chop($str_authIds,",");
            $updateInfo_detail=array("authIds"=>$str2_authIds);
            // $authIds[0]["authIds"]=$str_authIds;
            // $authIds.array_push($user1_authIds);
            $ret = UserService::modifyUserData($updateInfo['user2'],$updateInfo_detail);
        }

        return $ret;
    }
}
