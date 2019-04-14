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
        $lists_model = new ListsModel();
        $news_model = new NewsModel();
        $views_model = new ViewsModel();
        try {
            // 栏目列表
            $lists_data = $lists_model->where(['is_show' => 0])->order('sort', 'desc')->select();
            // 查询栏目下的新闻数
            foreach ($lists_data as $key => $value) {
                $lists_id = $value['id'];
                $lists_data[$key]['news_num'] = count($news_model->where(['lists_id' => $lists_id, 'is_show' => 1])->select());
            }
            $this->assign('lists_data', $lists_data);

            // 新闻列表
            $news_data = $news_model->where(['is_show' => 1])->paginate(2);
            foreach ($news_data->items() as $key => $value) {
                $lists_id = $value['lists_id'];
                $news_data->items()[$key]['lists_name'] = $lists_model->field('name')->where(['id' => $lists_id])->find()['name'];
                $news_id = $value['id'];
                $news_data->items()[$key]['views'] = $views_model->get_news_views($news_id)['data'];
            }
            $news_page = $news_data->render();
            $this->assign('news_data', $news_data);
            $this->assign('news_page', $news_page);

        } catch (\Exception $e) {
            return data_return(CODE_ERROR, '数据获取失败', $e->getMessage());
        }
        return $this->fetch();
    }

    public function lists()
    {
        $now_lists_id = input('get.lists_id');
        $lists_model = new ListsModel();
        $news_model = new NewsModel();
        $views_model = new ViewsModel();
        try {
            // 栏目名称
            $lists_name = $lists_model->field('name')->where(['id' => $now_lists_id])->find()['name'];
            $this->assign('lists_name', $lists_name);

            // 栏目列表
            $lists_data = $lists_model->where(['is_show' => 0])->order('sort', 'desc')->select();
            // 查询栏目下的新闻数
            foreach ($lists_data as $key => $value) {
                $lists_id = $value['id'];
                $lists_data[$key]['news_num'] = count($news_model->where(['lists_id' => $lists_id, 'is_show' => 1])->select());
            }
            $this->assign('lists_data', $lists_data);

            // 新闻列表
            $news_data = $news_model->where(['is_show' => 1, 'lists_id' => $now_lists_id])
                ->paginate(2, false, [
                    'query' => request()->param()
                ]);
            foreach ($news_data->items() as $key => $value) {
                $lists_id = $value['lists_id'];
                $news_data->items()[$key]['lists_name'] = $lists_model->field('name')->where(['id' => $lists_id])->find()['name'];
                $news_id = $value['id'];
                $news_data->items()[$key]['views'] = $views_model->get_news_views($news_id)['data'];
            }
            $news_page = $news_data->render();
            $this->assign('news_data', $news_data);
            $this->assign('news_page', $news_page);

        } catch (\Exception $e) {
            return data_return(CODE_ERROR, '数据获取失败', $e->getMessage());
        }
        return $this->fetch();
    }

    public function news()
    {
        $now_news_id = input('get.news_id');
        $lists_model = new ListsModel();
        $news_model = new NewsModel();
        $views_model = new ViewsModel();
        try {
            // 栏目列表
            $lists_data = $lists_model->where(['is_show' => 0])->order('sort', 'desc')->select();
            // 查询栏目下的新闻数
            foreach ($lists_data as $key => $value) {
                $lists_id = $value['id'];
                $lists_data[$key]['news_num'] = count($news_model->where(['lists_id' => $lists_id, 'is_show' => 1])->select());
            }
            $this->assign('lists_data', $lists_data);

            // 新闻详细信息
            $news_data = $news_model->where(['id' => $now_news_id])->find();
            $lists_id = $news_data['lists_id'];
            $news_data['lists_name'] = $lists_model->field('name')->where(['id' => $lists_id])->find()['name'];
            $news_data['views'] = $views_model->get_news_views($now_news_id)['data'];
            $this->assign('news_data', $news_data);
        } catch (\Exception $e) {
            return data_return(CODE_ERROR, '数据获取失败', $e->getMessage());
        }
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
