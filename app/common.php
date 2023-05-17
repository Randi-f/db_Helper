<?php
/*
 * @Description: 
 * @Version: 
 * @Author: fsh
 * @Date: 2023-03-12 10:02:26
 * @LastEditTime: 2023-05-16 19:11:17
 */
// 应用公共文件
function show($status, $message = 'error', $data = [], $httpStatus = 200){
    $result = [
        "status" => $status,
        "message" => $message,
        "result" => $data
    ];
    return json($result, $httpStatus);
}

