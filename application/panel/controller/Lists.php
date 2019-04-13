<?php
/**
 * Created by PhpStorm.
 * User: xiezefeng
 * Date: 2019/4/13
 * Time: 5:17 PM
 */

namespace app\panel\controller;

use app\panel\model\ListsModel;
use app\panel\validate\PanelValidate;

class Lists extends Base
{
    public function index()
    {
        return $this->fetch();
    }

    public function add()
    {
        return $this->fetch();
    }

    public function edit()
    {
        $id = input('get.lists_id');
        $lists_model = new ListsModel();
        $lists_info = $lists_model->get_the_lists($id);
        $rel['lists_id'] = $lists_info['data']['id'];
        $rel['lists_name'] = $lists_info['data']['name'];
        $rel['lists_sort'] = $lists_info['data']['sort'];
        $rel['lists_is_show'] = $lists_info['data']['is_show'];
        $this->assign('rel', $rel);
        return $this->fetch();
    }

    public function get_lists()
    {
        $input_data = input('post.aoData');
        $aoData = json_decode($input_data);
        $lists_model = new ListsModel();
        $offset = 0;
        $limit = 10;
        foreach ($aoData as $key => $val) {
            if ($val->name == 'iDisplayStart')
                $offset = $val->value;
            if ($val->name == 'iDisplayLength')
                $limit = $val->value;
        }

        $lists_info = $lists_model->get_lists($offset, $limit);
        // 计算总数
        $lists_info_total = $lists_model->get_lists(0, 0);
        $resp['recordsTotal'] = count($lists_info_total['data']);
        $resp['recordsFiltered'] = count($lists_info_total['data']);
        $resp['data'] = $lists_info['data'];
        echo json_encode($resp);
    }

    public function add_lists()
    {
        $req = input('post.');
        $lists_model = new ListsModel();
        $panel_validate = new PanelValidate();
        if ($panel_validate->scene('add_lists')->check($req) != VALIDATE_PASS) {
            return api_return(CODE_PARAM_ERROR, $panel_validate->getError());
        }

        $add_data = array(
            'name' => $req['lists_name'],
            'sort' => $req['lists_sort'],
            'is_show' => $req['lists_is_show']
        );
        $lists_info = $lists_model->add_lists($add_data);
        return api_return($lists_info['code'], $lists_info['msg'], $lists_info['data']);
    }

    public function edit_lists()
    {
        $req = input('post.');
        $lists_model = new ListsModel();
        $panel_validate = new PanelValidate();
        if ($panel_validate->scene('edit_lists')->check($req) != VALIDATE_PASS) {
            return api_return(CODE_PARAM_ERROR, $panel_validate->getError());
        }
        $id = $req['lists_id'];

        $update_data = array(
            'name' => $req['lists_name'],
            'sort' => $req['lists_sort'],
            'is_show' => $req['lists_is_show']
        );
        $lists_info = $lists_model->edit_lists($id, $update_data);
        return api_return($lists_info['code'], $lists_info['msg'], $lists_info['data']);
    }
}
