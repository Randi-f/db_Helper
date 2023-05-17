<?php
/*
 * @Description: Result model
 * @Version: 1.2
 * @Author: fsh
 * @Date: 2023-03-12 15:27:08
 * @LastEditTime: 2023-04-26 20:32:39
 */

 namespace app\service;

 class Result
 {

    /**
     * @description: success 
     * @param {*} $data
     * @return {*}
     */    
    static public function Success($data) {
        $rs = [
            'code'=>200,
            'message'=>"success",
            'data'=>$data,
        ];
        return json($rs);
    }
    
    /**
     * @description: error,402  picture upload error (图片上传格式错误),500  error (错误)
     * @param {*} $code
     * @param {*} $msg
     * @return {*}
     */    
    static public function Error($code,$msg) {
        $rs = [
            'code'=>$code,
            'message'=>$msg,
            'data'=>"",
        ];
        return json($rs);
    }
 }