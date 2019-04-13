<?php
/**
 * Created by PhpStorm.
 * User: xiezefeng
 * Date: 2019/4/13
 * Time: 1:01 PM
 */

namespace app\panel\controller;

use app\panel\model\XmlModel;
use app\panel\validate\PanelValidate;
use think\Controller;
use think\facade\Session;
use think\File;

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
        $xml_model = new XmlModel();
        if ($panel_validate->scene('do_login')->check($req) != VALIDATE_PASS) {
            return api_return(CODE_PARAM_ERROR, $panel_validate->getError());
        }
        $username = $req['username'];
        $password = $req['password'];

        $login_user = $xml_model->find_user_xml($username, $password);
        if ($login_user['code'] != CODE_SUCCESS) {
            return api_return(CODE_ERROR, '登录失败');
        }
        $panel_user['username'] = $username;
        $panel_user['password'] = $password;
        $panel_user['realname'] = $login_user['data']['realname'];
        $panel_user['status'] = $login_user['data']['status'];;
        Session::set('panel_user', $panel_user);
        return api_return(CODE_SUCCESS, '登录成功', $username);
    }

    public function logout()
    {
        if (Session::has('panel_user')) {
            Session::destroy();
            $this->redirect('login/index');
        }
    }

    public function add_user_xml()
    {
        $xml_model = new XmlModel();
        return $xml_model->add_user_xml('hfx', '123', '韩飞翔', 0);
    }

}


