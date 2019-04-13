<?php

namespace app\index\controller;

use app\index\model\ListsModel;
use app\index\model\NewsModel;
use app\index\model\ViewsModel;
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
        $views_model = new ViewsModel();
        $news_info = $news_model->get_show_lists_news($lists_id);
        foreach ($news_info['data'] as $key => $value) {
            $news_id = $value['id'];
            $value['view'] = $views_model->get_news_views($news_id)['data'];
        }
        return api_return($news_info['code'], $news_info['msg'], $news_info['data']);
    }

    public function get_news()
    {
        $news_id = input('post.news_id');
        $news_model = new NewsModel();
        $views_model = new ViewsModel();
        $news_info = $news_model->get_show_news($news_id);
        $news_info['data']['view'] = $views_model->get_news_views($news_id)['data'];
        return api_return($news_info['code'], $news_info['msg'], $news_info['data']);
    }

    public function set_view()
    {
        $news_id = input('post.news_id');
        $views_model = new ViewsModel();
        $views_info = $views_model->set_news_views($news_id);
        return api_return($views_info['code'], $views_info['msg'], $views_info['data']);
    }
}
