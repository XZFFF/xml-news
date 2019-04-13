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
        $news_model = new NewsModel();
        $views_model = new ViewsModel();
        try {
            $lists_info = $lists_model->get_show_lists();
            $resp['data'] = $lists_info['data'];
            foreach ($resp['data'] as $key => $value) {
                // 限制了只展示最新的10篇
                $news_info = $news_model->get_show_lists_news($value['id']);
                foreach ($news_info['data'] as $key2 => $value2) {
                    $news_id = $value2['id'];
                    $value2['view'] = $views_model->get_news_views($news_id)['data'];
                }
                $value['news'] = $news_info['data'];
            }
            return api_return(CODE_SUCCESS, '数据获取成功', $resp['data']);
        } catch (\Exception $e) {
            return data_return(CODE_ERROR, '数据获取失败', $e->getMessage());
        }
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
