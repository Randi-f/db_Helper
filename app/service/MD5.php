<?php
/*
 * @Description: MD5 encryption
 * @Version: 
 * @Author: fsh
 * @Date: 2023-03-12 15:27:08
 * @LastEditTime: 2023-03-12 15:29:06
 */

 namespace app\service;

 class MD5
 {
    public function index(){
        $pwd = "12345";
        echo md5($pwd);
    }
 }