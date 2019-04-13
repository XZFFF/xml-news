<?php
/**
 * Created by PhpStorm.
 * User: xiezefeng
 * Date: 2019/4/13
 * Time: 1:20 PM
 */

namespace app\panel\controller;

use think\App;
use think\Controller;
use think\facade\Session;

class Base extends Controller
{
    // 图标来源 https://www.thinkcmf.com/font_awesome.html
    public $menu = array(
        array(
            'c' => 'index',
            'a' => 'index',
            'title' => '控制台',
            'icon' => 'dashboard',
            'child' => array()
        ),
        array(
            'c' => 'lists',
            'a' => 'index',
            'title' => '栏目管理',
            'icon' => 'list',
            'child' => array()
        ),
        array(
            'c' => 'news',
            'a' => 'index',
            'title' => '新闻管理',
            'icon' => 'file-text',
            'child' => array()
        ),
        array(
            'c' => 'user',
            'a' => 'index',
            'title' => '用户管理',
            'icon' => 'user',
            'child' => array()
        ),
    );

    function __construct(App $app = null)
    {
        parent::__construct($app);
        if (!Session::has('panel_user')) {
            $this->redirect('login/index');
        }
        $realname = empty(Session::get('panel_user.realname')) ? '匿名' : Session::get('panel_user.realname');
        $this->assign('realname', $realname);
        $this->assign('menu', $this->menu);
    }

}