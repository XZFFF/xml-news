<?php
/**
 * Created by PhpStorm.
 * User: xiezefeng
 * Date: 2019/4/13
 * Time: 1:07 PM
 */
namespace app\panel\validate;

use think\Validate;

class PanelValidate extends Validate
{
    // 提交规则，|号之间不能加多余符号，包括空格
    protected $rule = [
        'username' => 'require',
        'password' => 'require'
    ];

    // 不符规则的错误提示
    protected $message = [
        'username.require' => '请输入用户名',
        'password.require' => '请输入用户名',
    ];

    // 场景验证
    protected $scene = [
        'do_login' =>  ['username', 'password'],
    ];
}