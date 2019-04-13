<?php
/**
 * Created by PhpStorm.
 * User: xiezefeng
 * Date: 2019/4/13
 * Time: 5:17 PM
 */

namespace app\panel\controller;

use app\panel\model\ListsModel;
use app\panel\validate\PanelValidate;
use think\facade\Session;

class News extends Base
{
    public function index()
    {
        return $this->fetch();
    }

    public function add()
    {
        $lists_model = new ListsModel();
        $lists_info = $lists_model->get_show_lists();
        $this->assign('lists_info', $lists_info['data']);
        $panel_user = Session::get('panel_user');
        $this->assign('panel_user', $panel_user);
        return $this->fetch();
    }
}
