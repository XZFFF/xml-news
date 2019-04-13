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
        // 用户
        'username' => 'require',
        'password' => 'require',
        'realname' => 'require',

        // 新闻栏目
        'lists_id' => 'require',
        'lists_name' => 'require',
        'lists_sort' => 'require',
        'lists_is_show' => 'require',

        // 新闻内容
        'news_id' => 'require',
        'news_title' => 'require',
        'news_author' => 'require',
        'news_content' => 'require',
        'news_is_show' => 'require',
    ];

    // 不符规则的错误提示
    protected $message = [
        // 用户
        'username.require' => '请输入用户名',
        'password.require' => '请输入用户名',
        'realname.require' => '请输入真实姓名',

        // 新闻栏目
        'lists_id.require' => '需要lists_id',
        'lists_name.require' => '需要lists_name',
        'lists_sort.require' => '需要lists_sort',
        'lists_is_show.require' => '需要lists_is_show',

        // 新闻内容
        'news_id.require' => '需要news_id',
        'news_title.require' => '需要news_title',
        'news_author.require' => '需要news_author',
        'news_content.require' => '需要news_content',
        'news_is_show.require' => '需要news_is_show',
    ];

    // 场景验证
    protected $scene = [
        // 用户
        'do_login' => ['username', 'password'],
        'add_user' => ['username', 'password', 'realname'],

        // 新闻栏目
        'add_lists' => ['lists_name', 'lists_sort', 'lists_is_show'],
        'edit_lists' => ['lists_id', 'lists_name', 'lists_sort', 'lists_is_show'],

        // 新闻内容
        'add_news' => ['news_title', 'news_author', 'news_content', 'news_is_show'],
        'edit_news' => ['news_id', 'news_title', 'news_author', 'news_content', 'news_is_show'],
        'view_news' => ['news_id'],
    ];
}