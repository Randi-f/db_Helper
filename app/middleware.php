<?php
/*
 * @Description: 
 * @Version: 
 * @Author: fsh
 * @Date: 2023-03-12 10:02:26
 * @LastEditTime: 2023-04-15 18:07:33
 */
// 全局中间件定义文件
return [
    // 全局请求缓存
    // \think\middleware\CheckRequestCache::class,
    // 多语言加载
    // \think\middleware\LoadLangPack::class,
    // Session初始化
    \think\middleware\SessionInit::class
];
