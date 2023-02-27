<?php
/*
 * @Description: 
 * @Version: 
 * @Autor: fsh
 * @Date: 2023-02-15 16:33:28
 * @LastEditTime: 2023-02-15 16:34:42
 */
namespace app\Validate;
use think\Validate;
class User extends Validate{
    protected $rule=[
        'first_name' => 'require|min:2|max:10|chsDash',
        'last_name' => 'require|min:2|max:10|chsDash',
        'password' => 'require|min:6',
        'passwordnot' => 'require|confirm:password',
        'email' => 'require|email|unique:user'
//        'agree' => 'require|accept'

    ];
    protected $message=[
        'first_name.require' => '用户名不得为空,且只能长度为2-10位,只能是汉字、字母、数字、下划线和破折号',
        'last_name.require' => '用户名不得为空,且只能长度为2-10位,只能是汉字、字母、数字、下划线和破折号',,
        'password.require' => '用户密码至少为6位',
        'passwordnot.require' => '用户密码不一致',
        'email.require' =>'用户邮箱不能为空',
//        'agree.require' =>'只能同意'
    ];
}
