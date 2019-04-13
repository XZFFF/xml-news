<?php
/**
 * Created by PhpStorm.
 * User: xiezefeng
 * Date: 2019/4/13
 * Time: 1:43 PM
 */

namespace app\panel\controller;

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
}
