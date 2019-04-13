<?php
/**
 * Created by PhpStorm.
 * User: xiezefeng
 * Date: 2019/4/13
 * Time: 1:01 PM
 */

namespace app\panel\controller;

use app\panel\validate\PanelValidate;
use think\Controller;
use think\facade\Session;

class Login extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    public function do_login()
    {
        $req = input('post.');
        $panel_validate = new PanelValidate();
        if ($panel_validate->scene('do_login')->check($req) != VALIDATE_PASS) {
            return api_return(CODE_PARAM_ERROR, $panel_validate->getError());
        }
        $username = $req['username'];
        $password = $req['password'];
        if ($username == 'xzfff' && $password == '123') {
            $panel_user['username'] = $username;
            $panel_user['password'] = $password;
            Session::set('panel_user', $panel_user);
            return api_return(CODE_SUCCESS, '登录成功', $username);
        } else {
            return api_return(CODE_ERROR, '登录失败');
        }
    }
}


