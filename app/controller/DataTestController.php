<?php 
/*
 * @Description: database connection test
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-01 14:39:35
 * @LastEditTime: 2023-03-12 15:39:44
 */

namespace app\controller;

use think\facade\Db;
use app\model\User;

class DataTestController
{
    public function index()## 测试数据库连接
    {
        // 获取数据库(db_helper)表(user)中所有数据
        // 127.0.0.1:8000/index.php/database
        $allData = Db::table('user') -> select();

        // 输出查看结果
        return json($allData);
    }

    /**
     * @description: get connnection to the second database with the config.name = mydb
     * @return {*}
     */    
    public function demo()
    {
        $demo = Db::connect('mydb')->table('history')->select();
        return json($demo);
    }

    public function getUser()
    {
        $user = User::select();
        return json($user);
    }
}
