<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 模板设置
// +----------------------------------------------------------------------

return [
    // 模板引擎类型 支持 php think 支持扩展
    'type' => 'Think',
    // 默认模板渲染规则 1 解析为小写+下划线 2 全部转换小写 3 保持操作方法
    'auto_rule' => 1,
    // 模板路径
    'view_path' => '',
    // 模板后缀
    'view_suffix' => 'html',
    // 模板文件名分隔符
    'view_depr' => DIRECTORY_SEPARATOR,
    // 模板引擎普通标签开始标记
    'tpl_begin' => '{',
    // 模板引擎普通标签结束标记
    'tpl_end' => '}',
    // 标签库标签开始标记
    'taglib_begin' => '{',
    // 标签库标签结束标记
    'taglib_end' => '}',
    // 模板参数替换
    'tpl_replace_string' => [
        '__INDEX__' => '/xml-news/public/index.php/index',
        '__INDEX_CSS__' => '/xml-news/public/static/index/css',
        '__INDEX_FONT__' => '/xml-news/public/static/index/fonts',
        '__INDEX_JS__' => '/xml-news/public/static/index/js',
        '__INDEX_IMG__' => '/xml-news/public/static/index/images',

        '__PANEL__' => '/xml-news/public/index.php/panel',
        '__PANEL_CSS__' => '/xml-news/public/static/panel/css',
        '__PANEL_FONT__' => '/xml-news/public/static/panel/fonts',
        '__PANEL_JS__' => '/xml-news/public/static/panel/js',
        '__PANEL_IMG__' => '/xml-news/public/static/panel/images',

        '__UM__' => '/xml-news/public/umeditor',
        '__UE__' => '/xml-news/public/ueditor',
    ]
];
