<?php
/*
 * @Description: multi controller test, url: http://localhost:8000/group.blog
 * @Version: 1,0
 * @Autor: fsh
 * @Date: 2023-02-17 11:09:35
 * @LastEditTime: 2023-02-19 15:03:10
 */
namespace app\controller\Group;
class Blog
{
    public function index()
    {
        return 'index';
    }
    public function read()
    {
        return 'read';
    }
}
