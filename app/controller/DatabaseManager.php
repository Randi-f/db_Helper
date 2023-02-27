<?php
/*
 * @Description: controller to manage the database
 * @Version: 1.0
 * @Author: fsh
 * @Date: 2023-02-19 14:40:58
 * @LastEditTime: 2023-02-20 21:07:58
 */

 namespace app\controller;

 use app\model\Auto_index as DbModel;
 use think\facade\Db;
 // use app\model\User;

 class DatabaseManager{
    public function index()
    {
        $db_model = new DbModel();
        $db_model->getNextIndex();
        return 'hi';
        /*
        $data = [
            'last_name' => '李白2'
            ];
        Db::name('user')->where('user_id', 'USER1')->update($data);
        $allData = Db::table('user') -> select();
        // 输出查看结果
        return json($allData);
        //return Db::getLastSql();*/
    }

    
 }