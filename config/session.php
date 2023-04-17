<?php
/*
 * @Description: 
 * @Version: 
 * @Author: fsh
 * @Date: 2023-03-12 10:02:26
 * @LastEditTime: 2023-04-15 17:49:13
 */
// +----------------------------------------------------------------------
// | 会话设置
// +----------------------------------------------------------------------

return [
    // session name
    'name'           => 'PHPSESSID',
    // SESSION_ID的提交变量,解决flash上传跨域
    'var_session_id' => '',
    // 驱动方式 支持file cache
    'type'           => 'file',
    // 存储连接标识 当type使用cache的时候有效
    'store'          => null,
    // 过期时间
    'expire'         => 1440,
    // 前缀
    'prefix'         => '',
    'auto_start'     => true,

    // 'session'                => [
    //     'prefix'         => 'think',
    //     'type'           => '',
    //     'auto_start'     => true,
    // ],
];
