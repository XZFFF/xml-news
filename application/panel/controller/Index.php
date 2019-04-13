<?php

namespace app\panel\controller;

use app\panel\model\ListsModel;
use app\panel\model\NewsModel;
use app\panel\model\ViewsModel;
use app\panel\model\XmlModel;

class Index extends Base
{
    public function index()
    {
        $views_model = new ViewsModel();
        $lists_model = new ListsModel();
        $news_model = new NewsModel();
        $xml_model = new XmlModel();
        $day_view_count = $views_model->get_today_views(true)['data'];
        $total_view_count = $views_model->get_today_views(false)['data'];
        $user_count = count($xml_model->xmlToArray($xml_model->read_user_xml())['user']);
        $lists_count = count($lists_model->get_show_lists()['data']);
        $news_count = count($news_model->get_show_news()['data']);
        $count = array(
            'day_view' => $day_view_count,
            'total_view' => $total_view_count,
            'user' => $user_count,
            'lists' => $lists_count,
            'news' => $news_count,
        );
        $this->assign('count', $count);
        return $this->fetch();
    }
}
