<?php
/*
 * @Description: service model for security list
 * @Version: 2.0
 * @Autor: fsh
 * @Date: 2023-02-14 15:50:50
 * @LastEditTime: 2023-05-16 20:25:11
 */

namespace app\models\service\page;

use think\facade\Session;

use app\models\service\data\SecurityList;
use app\models\service\data\User;
use app\models\service\page\UserService;

class SecurityListService {
    
    public static function createAdmin($adminId){
        $ret = SecurityList::createAdmin($adminId);
        return $ret;
    }
    /**
     * @description: get the user's trusted users
     * @param {*} $userId
     * @return {*}
     */    
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
    
    /**
     * @description: modify the user's trusted users
     * @param {*} $updateInfo
     * @return {*}
     */    
    public static function modifyTrustedUser($updateInfo){
        
        
        $ret = SecurityList::modifyTrustedUser($updateInfo);// update security list table


        $authIds = UserService::getUserData(-1);//admin's authIds
        // $str_authIds=$authIds[0]['authIds'];
        if(array_key_exists("user1",$updateInfo)){
            if($updateInfo["user1"]!="" && $updateInfo["user1"]!=null){
                $user1_authIds = UserService::getUserData($updateInfo['user1']);
                // $str_user1_authIds=$user1_authIds[0]["authIds"];
                // $str1_authIds=$str_authIds.','.$str_user1_authIds;
                // $str1_authIds=chop($str_authIds,",");
                // $updateInfo_detail=array("authIds"=>$str1_authIds);
                // // $authIds[0]["authIds"]=$str_authIds;
                // // $authIds.array_push($user1_authIds);
                // $ret = UserService::modifyUserData($updateInfo['user1'],$updateInfo_detail);
                if(str_contains($authIds[0]['authIds'], ",")){
                    $admin_authIds1=explode(",",$authIds[0]['authIds']);
                    $user_authIds1=explode(",",$user1_authIds[0]['authIds']);
                    foreach ($admin_authIds1 as $tobeadded){
                        if(in_array($tobeadded,$user_authIds1)){

                        }
                        else{
                            array_push($user_authIds1,$tobeadded);
                        }
                        
                    }
                    $user_authIds2=implode(",",$user_authIds1);
                    $updateInfo1=array("authIds"=>$user_authIds2);
                    $condition=array("user_id"=>$updateInfo["user1"]);
                    $result = User::where($condition)->update($updateInfo1);
                }
                
                // return $result;
            }
            
        }

        if(array_key_exists("user2",$updateInfo)){
            if($updateInfo["user2"]!=""&&$updateInfo["user2"]!=null){
                $user2_authIds = UserService::getUserData($updateInfo['user2']);
                if(str_contains($authIds[0]['authIds'], ",")){
                    $admin_authIds1=explode(",",$authIds[0]['authIds']);
                    $user2_authIds1=explode(",",$user2_authIds[0]['authIds']);
                    foreach ($admin_authIds1 as $tobeadded){
                        if(in_array($tobeadded,$user2_authIds1)){

                        }
                        else{
                            array_push($user2_authIds1,$tobeadded);
                        }
                        
                    }
                    $user2_authIds2=implode(",",$user2_authIds1);
                    $updateInfo2=array("authIds"=>$user2_authIds2);
                    $condition=array("user_id"=>$updateInfo["user2"]);
                    $result = User::where($condition)->update($updateInfo2);
                }
                

                // $str_user2_authIds=$user2_authIds[0]["authIds"];
                // $str2_authIds=$str_authIds.','.$str_user2_authIds;
                // $str2_authIds=chop($str_authIds,",");
                // $updateInfo_detail=array("authIds"=>$str2_authIds);
                // // $authIds[0]["authIds"]=$str_authIds;
                // // $authIds.array_push($user1_authIds);
                // $ret = UserService::modifyUserData($updateInfo['user2'],$updateInfo_detail);
            }
        }
        

        return $result;
    }
}
