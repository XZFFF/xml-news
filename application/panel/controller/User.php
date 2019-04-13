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

    public function get_user_list()
    {
        $xml_model = new XmlModel();
        $content = $xml_model->read_user_xml();
        $user_info = $xml_model->xmlToArray($content);
        // TODO 分页问题待完善
        $count = count($user_info['user']);
        $resp['recordsTotal'] = $count;
        $resp['recordsFiltered'] = $count;
        $resp['data'] = $user_info['user'];
        echo json_encode($resp);
    }

    public function edit_user_status()
    {
        $username = input('get.username');
        $status = input('get.status');
        $xml_model = new XmlModel();
        $content = $xml_model->edit_user_xml($username, $status);
        $xml_model->write_user_xml($content);
        MessageBox($username . '用户状态更新成功', -1);
    }
}
