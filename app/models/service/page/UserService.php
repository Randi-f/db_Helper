<?php
/*
 * @Description: service model for user
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-14 15:50:50
 * @LastEditTime: 2023-05-16 18:46:58
 */

namespace app\models\service\page;

use think\Model;
use think\facade\Session;

use app\models\service\data\User;

class UserService extends Model{
    
    /**
     * @description: get user's profile info by userId
     * @param {*} $userId
     * @return {*}
     */    
    public static function getProfile($userId){
        $condition=array('user_id'=>$userId); 
        $result = User::where($condition)->field('user_id,first_name,last_name,email')->select();
        return $result;
    }

    /**
     * @description: modify profile info by userId
     * @param {*} $updateInfo
     * @return {*}
     */    
    public static function modifyProfileInfo($updateInfo){
        $condition=array('user_id'=>Session::get('user_id')); 
        $result = User::where($condition)->update($updateInfo);
        return $result;
    }

    /**
     * @description: get user's data by userId
     * @param {*} $user_id
     * @return {*}
     */    
    public static function getUserData($user_id){
        if($user_id==-1){
            $condition=array('user_id'=>Session::get('user_id')); 
        }
        else{
            $condition=array('user_id'=>$user_id); 
        }
        
        $result = User::where($condition)->field('authIds')->select();
        return $result;
    }

    /**
     * @description: modify user's data by userId
     * @param {*} $user_id
     * @param {*} $updateInfo
     * @return {*}
     */    
    public static function modifyUserData($user_id,$updateInfo){
        if($user_id==-1){
            $condition=array('user_id'=>Session::get('user_id')); 
        }
        else{
            $condition=array('user_id'=>$user_id); 
        }
        
        $result = User::where($condition)->update($updateInfo);
        return $result;
    }

    /**
     * @description: check whether the user exist
     * @param {*} $userId
     * @return {*}
     */    
    public static function checkUserExist($userId){
        $result=User::checkUserExist($userId);
        return $result;
    }

    /**
     * @description: reset password
     * @return {*}
     */
    public static function resetpassword($oldPassword,$newPassword){
        $condition=array('user_id'=>Session::get('user_id'),'user_pwd'=>$oldPassword);
        $updateInfo=array('user_pwd'=>$newPassword);
        $ret=User::where($condition)->find();
        if($ret){
            $result = User::where($condition)->update($updateInfo);
            return $result;
        }
        else{
            return "old password is wrong";
        }
        
    }

    public static function checkUserHasAuthToData($targetAuthId){
        // todo: check if the user has the authntication of the data
        $authIds = UserService::getUserData(Session::get('user_id'));
        // $authIds = UserService::getUserData(2);
        $authId = explode(",",$authIds[0]['authIds']);
        
        $rett=array();
        foreach($authId as $value){           
            if($value==$targetAuthId){
                return 1;
            }
        }
        return 0;
    }

    public static function deleteAuthorisedUser($trusteduserId){
        $condition=array('user_id'=>Session::get('user_id')); 
        // $condition=array('user_id'=>1); 
        $admin_authIds = User::where($condition)->field('authIds')->select();
        $condition=array('user_id'=>$trusteduserId); 
        $user_authIds = User::where($condition)->field('authIds')->select();
        $admin_authIds1=explode(",",$admin_authIds[0]['authIds']);
        $user_authIds1=explode(",",$user_authIds[0]['authIds']);
        foreach ($admin_authIds1 as $tobedeleted){
            if($tobedeleted!=1){
                foreach($user_authIds1 as $key => $value){
                    if($value == $tobedeleted){
                        unset($user_authIds1[$key]);
                    }
                }
            }
            
        }

        $user_authIds2=implode(",",$user_authIds1);
        $updateInfo=array("authIds"=>$user_authIds2);
        $result = User::where($condition)->update($updateInfo);
        if($result==0){
            // 抛出404异常
            abort(444, 'system error');
        }
        return $result;

        // $authIds=UserService::getUserData(-1);
        // $authId = explode(",",$authIds[0]['authIds']);
        
        // $rett=array();
        // foreach($authId as $value){           
        //     $condition=array("auth_id"=>$value);
        //     array_push($rett,AuthService::getUserData($condition));
        // }
        // $ret=json_encode($rett); // json array to string
        // $ret=str_replace('[','',$ret);
        // $ret=str_replace(']','',$ret);
        // return '['.$ret.']';              
    }
}
