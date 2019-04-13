<?php

namespace app\index\controller;

use app\index\model\ListsModel;
use app\index\model\NewsModel;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    public function detail()
    {
        return $this->fetch();
    }

    public function get_lists()
    {
        $lists_model = new ListsModel();
        $lists_info = $lists_model->get_show_lists();
        return api_return($lists_info['code'], $lists_info['msg'], $lists_info['data']);
    }

    public function get_lists_news()
    {
        $lists_id = input('post.lists_id');
        $news_model = new NewsModel();
        $news_info = $news_model->get_show_lists_news($lists_id);
        return api_return($news_info['code'], $news_info['msg'], $news_info['data']);
    }

    public function get_news()
    {
        $news_id = input('post.news_id');
        $news_model = new NewsModel();
        $news_info = $news_model->get_show_news($news_id);
        // TODO 获取浏览量
        return api_return($news_info['code'], $news_info['msg'], $news_info['data']);
    }

    public function
}
