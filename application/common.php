<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
define("VALIDATE_PASS", true);
define("VALIDATE_ERROR", false);

define("CODE_SUCCESS", 0);
define("CODE_ERROR", -1);
define("CODE_PARAM_ERROR", -2); // 缺少必要参数

define("NO_LOGIN", -3); // 后台用户未登录


define("USERNAME_NOT_EXIST", 10001); // 登录用户名不存在
define("LOGIN_PASSWORD_WRONG", 10002); // 登录密码错误
define("LOGIN_STATUS_WRONG", 10003); // 登录状态异常
define("USERNAME_IS_EXIST", 10004); // 注册用户名已存在

/**
 * 通用化API接口数据输出
 * @param $code -接口错误码
 * @param $msg -接口错误信息
 * @param array $data -接口数据
 * @param int $http_code -接口http状态码
 * @return \think\response\Json
 */
function api_return($code, $msg, $data = [], $http_code = 200)
{
    return json([
        'code' => $code,
        'msg' => $msg,
        'data' => $data,
    ], $http_code);
}

/**
 * 通用化Model层数据传输
 * @param int $code -错误码
 * @param string $msg -错误信息
 * @param array $data -数据
 * @return array
 */
function data_return($code = CODE_SUCCESS, $msg = '', $data = [])
{
    return array(
        'code' => $code,
        'msg' => $msg,
        'data' => $data,
    );
}