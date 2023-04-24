<?php
/*
 * @Description: model for user
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-14 15:50:50
 * @LastEditTime: 2023-04-19 11:03:49
 */



namespace app\models\service\page;
use think\Model;
use think\facade\Db;
use app\models\service\data\Auth;
use think\facade\Session;
use app\models\service\page\UserService;

class FileService{
    
    public static function getDataFromFile($file){
        // condition: "auth_id"=> 1
        // $file = fopen($fileName,'r');
        // while ($data = fgetcsv($file)) { //每次读取CSV里面的一行内容

        // //print_r($data); //此为一个数组，要获得每一个数据，访问数组下标即可

        // $goods_list[] = $data;

        // }
        // fclose($file);
        // return $goods_list[2][0];
        return $file;
    }
    
}
