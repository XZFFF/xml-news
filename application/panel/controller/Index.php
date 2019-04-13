<?php
namespace app\panel\controller;

use app\panel\model\ListsModel;
use app\panel\model\NewsModel;

class Index extends Base
{
    public function index()
    {
        $lists_model = new ListsModel();
        $news_model = new NewsModel();
        $list_count = count($lists_model->get_show_lists()['data']);
        $news_count = count($news_model->get_show_news()['data']);
        return $this->fetch();
    }
}
