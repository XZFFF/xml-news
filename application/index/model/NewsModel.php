<?php
/**
 * Created by PhpStorm.
 * User: xiezefeng
 * Date: 2019/4/13
 * Time: 11:37 PM
 */

namespace app\index\model;

use think\Model;

class NewsModel extends Model
{
    protected $table = 'news';

    public function get_show_lists_news($lists_id)
    {
        try {
            $news = $this->where(['lists_id' => $lists_id, 'is_show' => 1])
                ->limit(0, 10)
                ->order('publish_time', 'desc')
                ->select();
            if ($news == false) {
                return data_return(CODE_ERROR, '获取失败', $this->getError());
            } else {
                return data_return(CODE_SUCCESS, '获取成功', $news);
            }
        } catch (\Exception $e) {
            return data_return(CODE_ERROR, '数据库异常', $e->getMessage());
        }
    }

    public function get_show_news($news_id)
    {
        try {
            $news = $this->where(['id' => $news_id, 'is_show' => 1])->find();
            if ($news == false) {
                return data_return(CODE_ERROR, '获取失败', $this->getError());
            } else {
                return data_return(CODE_SUCCESS, '获取成功', $news);
            }
        } catch (\Exception $e) {
            return data_return(CODE_ERROR, '数据库异常', $e->getMessage());
        }
    }
}