<?php
/**
 * Created by PhpStorm.
 * User: xiezefeng
 * Date: 2019/4/13
 * Time: 5:21 PM
 */

namespace app\panel\model;

use think\Model;

class NewsModel extends Model
{
    protected $table = 'news';

    public function add_news($add_data)
    {
        try {
            $ok = $this->strict(false)->insert($add_data);
            if ($ok == false) {
                return data_return(CODE_ERROR, '添加失败', $this->getError());
            } else {
                return data_return(CODE_SUCCESS, '添加成功', $ok);
            }
        } catch (\Exception $e) {
            return data_return(CODE_ERROR, '数据库异常', $e->getMessage());
        }
    }
}