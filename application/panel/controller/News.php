<?php
/**
 * Created by PhpStorm.
 * User: xiezefeng
 * Date: 2019/4/13
 * Time: 5:17 PM
 */

namespace app\panel\controller;

use app\panel\model\ListsModel;
use app\panel\model\NewsModel;
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

    public function get_news()
    {
        $input_data = input('post.aoData');
        $aoData = json_decode($input_data);
        $news_model = new NewsModel();
        $offset = 0;
        $limit = 10;
        foreach ($aoData as $key => $val) {
            if ($val->name == 'iDisplayStart')
                $offset = $val->value;
            if ($val->name == 'iDisplayLength')
                $limit = $val->value;
        }

        $news_info = $news_model->get_news($offset, $limit);
        // 计算总数
        $news_info_total = $news_model->get_news(0, 0);
        $resp['recordsTotal'] = count($news_info_total['data']);
        $resp['recordsFiltered'] = count($news_info_total['data']);
        $resp['data'] = $news_info['data'];
        echo json_encode($resp);
    }


    public function add_news()
    {
        $req = input('post.');
        $news_model = new NewsModel();
        $panel_validate = new PanelValidate();
        if ($panel_validate->scene('add_news')->check($req) != VALIDATE_PASS) {
            return api_return(CODE_PARAM_ERROR, $panel_validate->getError());
        }

        $add_data = array(
            'lists_id' => $req['lists_id'],
            'title' => $req['news_title'],
            'author' => $req['news_author'],
            'is_show' => $req['news_is_show'],
            'content' => $req['news_content'],
            'publish_time' => date('Y:m:d H:i:s', time()),
        );
        $news_info = $news_model->add_news($add_data);
        return api_return($news_info['code'], $news_info['msg'], $news_info['data']);
    }


}
