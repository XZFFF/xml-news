<?php
/**
 * Created by PhpStorm.
 * User: xiezefeng
 * Date: 2019/4/13
 * Time: 10:41 PM
 */

namespace app\panel\model;

use think\Model;

class ViewsModel extends Model
{
    protected $table = 'views';

    public function get_news_views($id)
    {
        try {
            $views = $this->where(['news_id' => $id])->select();
            return data_return(CODE_SUCCESS, '获取成功', count($views));
        } catch (\Exception $e) {
            return data_return(CODE_ERROR, '数据库异常', $e->getMessage());
        }
    }


    public function get_today_views($is_today = false)
    {
        try {
            if ($is_today) {
                $views = $this->whereTime('view_time', 'today')->select();
            } else {
                $views = $this->where(true)->select();
            }
            return data_return(CODE_SUCCESS, '获取成功', count($views));
        } catch (\Exception $e) {
            return data_return(CODE_ERROR, '数据库异常', $e->getMessage());
        }
    }
}