<?php
/**
 * Created by PhpStorm.
 * User: xiezefeng
 * Date: 2019/4/13
 * Time: 1:43 PM
 */

namespace app\panel\controller;

use app\panel\model\XmlModel;
use app\panel\validate\PanelValidate;
use think\Controller;
use think\facade\Session;

class User extends Base
{
    public function index()
    {
        return $this->fetch();
    }

    public function add()
    {
        return $this->fetch();
    }

    public function edit()
    {
        $panel_user = Session::get('panel_user');
        $this->assign('rel', $panel_user);
        return $this->fetch();
    }

    public function add_user()
    {
        $req = input('post.');
        $xml_model = new XmlModel();
        $panel_validate = new PanelValidate();
        if ($panel_validate->scene('add_user')->check($req) != VALIDATE_PASS) {
            return api_return(CODE_PARAM_ERROR, $panel_validate->getError());
        }
        $username = $req['username'];
        $password = $req['password'];
        $realname = $req['realname'];
        $status = empty($req['status']) ? '0' : $req['status'];

        $has_user = $xml_model->has_user_xml($username);
        if ($has_user['code'] == CODE_SUCCESS) {
            return api_return(CODE_ERROR, '该用户名已存在，请重新设置用户名');
        }
        $content = $xml_model->add_user_xml($username, $password, $realname, $status);
        $xml_model->write_user_xml($content);
        return api_return(CODE_SUCCESS, '用户数据添加成功', $username);
    }
}
