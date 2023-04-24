<?php
/*
 * @Description: MD5 encryption
 * @Version: 1.2
 * @Author: fsh
 * @Date: 2023-03-12 15:27:08
 * @LastEditTime: 2023-04-19 11:18:51
 */

 namespace app\service;

 class Result
 {
    //success
    static public function Success($data) {
        $rs = [
            'code'=>200,
            'message'=>"success",
            'data'=>$data,
        ];
        return json($rs);
    }
    
    /**
     * error
     * 402  图片上传格式错误
     * 500  错误
     * */
    static public function Error($code,$msg) {
        $rs = [
            'code'=>$code,
            'message'=>$msg,
            'data'=>"",
        ];
        return json($rs);
    }
 }