<?php
/**
 * Created by PhpStorm.
 * User: xiezefeng
 * Date: 2019/4/13
 * Time: 11:37 PM
 */

namespace app\index\model;

use think\Model;

class ViewsModel extends Model
{
    protected $table = 'views';

    public function get_news_views($news_id)
    {
        try {
            $views = $this->where(['news_id' => $news_id])->select();
            return data_return(CODE_SUCCESS, '获取成功', count($views));
        } catch (\Exception $e) {
            return data_return(CODE_ERROR, '数据库异常', $e->getMessage());
        }
    }

    public function set_news_views($news_id)
    {
        try {
            $add_data = array(
                'news_id' => $news_id,
                'view_time' => date('Y:m:d H:i:s', time()),
            );
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