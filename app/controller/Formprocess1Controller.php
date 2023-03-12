<?php
/*
 * @Description: 
 * @Version: 
 * @Author: fsh
 * @Date: 2023-02-19 15:24:14
 * @LastEditTime: 2023-03-12 15:13:04
 */
namespace app\controller;
class Formprocess1Controller{
    public function index(){
        echo $_POST['username'];
    }
}

