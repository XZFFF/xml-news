<?php
/**
 * Created by PhpStorm.
 * User: xiezefeng
 * Date: 2019/4/13
 * Time: 11:37 PM
 */
namespace app\index\model;

use think\Model;

class ListsModel extends Model
{
    protected $table = 'lists';

    public function get_show_lists()
    {
        try {
            $lists = $this->where(['is_show' => 0])
                ->order('sort', 'desc')->select();
            if ($lists == false) {
                return data_return(CODE_ERROR, '获取失败', $this->getError());
            } else {
                return data_return(CODE_SUCCESS, '获取成功', $lists);
            }
        } catch (\Exception $e) {
            return data_return(CODE_ERROR, '数据库异常', $e->getMessage());
        }
    }
}
