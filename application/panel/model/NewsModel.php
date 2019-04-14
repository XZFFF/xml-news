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

    public function get_news($offset, $limit)
    {
        try {
            if ($offset == 0 && $limit == 0) {
                $lists = $this->where(true)
                    ->order('publish_time', 'desc')
                    ->select();
            } else {
                $lists = $this->where(true)
                    ->order('publish_time', 'desc')
                    ->limit($offset, $limit)->select();
            }

            if ($lists == false) {
                return data_return(CODE_ERROR, '获取失败', $this->getError());
            } else {
                return data_return(CODE_SUCCESS, '获取成功', $lists);
            }
        } catch (\Exception $e) {
            return data_return(CODE_ERROR, '数据库异常', $e->getMessage());
        }
    }

    public function get_the_news($id)
    {
        try {
            $lists = $this->where(['id' => $id])->find();
            if ($lists == false) {
                return data_return(CODE_ERROR, '获取失败', $this->getError());
            } else {
                return data_return(CODE_SUCCESS, '获取成功', $lists);
            }
        } catch (\Exception $e) {
            return data_return(CODE_ERROR, '数据库异常', $e->getMessage());
        }
    }

    public function get_show_news()
    {
        try {
            $news = $this->where(['is_show' => 1])->select();
            if ($news == false) {
                return data_return(CODE_ERROR, '获取失败', $this->getError());
            } else {
                return data_return(CODE_SUCCESS, '获取成功', $news);
            }
        } catch (\Exception $e) {
            return data_return(CODE_ERROR, '数据库异常', $e->getMessage());
        }
    }


    public function edit_news($id, $update_data)
    {
        try {
            $ok = $this->where(['id' => $id])->update($update_data);
            if ($ok == false) {
                return data_return(CODE_ERROR, '更新失败', $this->getError());
            } else {
                return data_return(CODE_SUCCESS, '更新成功', $ok);
            }
        } catch (\Exception $e) {
            return data_return(CODE_ERROR, '数据库异常', $e->getMessage());
        }
    }
}