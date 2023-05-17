<?php
/*
 * @Description: model for auto_increment ID (dumped)
 * @Version: 1.0
 * @Autor: fsh
 * @Date: 2023-02-14 15:50:50
 * @LastEditTime: 2023-02-20 21:17:19
 */

namespace app\model;
use think\Model;
use think\facade\Db;
class Auto_index extends Model{
    protected $connection = 'mysql';
    //protected static $auto_index_db = Db::table('auto_index');
    /**
     * @description: find data in table USER
     * @return {*}
     */    
    public function findUserData(){
        $allData = Db::table('user')->where('user_id', 'USER001')->find();
        return json($allData);

    }

    /**
     * @description: insert data in table USER
     * @return {*}
     */    
    public function addUserData(){
        $data = [
            'user_id' => 'USER1',
            'first_name' => 'Meimei',
            'last_name' => 'Fu',
            'user_pwd' => 'huiye@163.com',
            'email' => 'huiye@163.com',
            ];
        Db::name('user')->insert($data);
        
        //save()方法是一个通用方法，可以自行判断是新增还是修改(更新)数据；
        //save()方法判断是否为新增或修改的依据为，是否存在主键，不存在即新增；
        Db::name('user')->save($data);
    }

    public function modifyUserData(){
        $data = [
            'last_name' => '李白2'
            ];
        Db::name('user')->where('user_id', 'USER1')->update($data);
    }

    public function deleteUserData(){
        Db::name('user')->where('id', 47)->delete();
    }

    /**
     * @description: get the next index for user account (data too large, cost high)
     * @return {*}
     */    
    public function getNextIndex(){
        $index = Db::name('auto_index')->select();
        $new_index =  (int)$index[0]['index_id'];
        Db::table('auto_index')->where('index_id',$new_index)->update(['index_id'=> $new_index + 1]);
        echo 'USER' . $new_index;
        $allData = Db::table('auto_index') -> select();
        // 输出查看结果
        return json($allData);
    }
}

