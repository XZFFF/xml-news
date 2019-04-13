<?php
/**
 * Created by PhpStorm.
 * User: xiezefeng
 * Date: 2019/4/13
 * Time: 3:07 PM
 */

namespace app\panel\model;

use think\Model;

class XmlModel extends Model
{
    public function read_user_xml()
    {
        $filename = "http://localhost/xml-news/public/xml/user.xml";

        // 读取文件方法1:适用于本地文件
        /*
        $handle = fopen($filename, 'r');
        $content = '';
        while (false != ($a = fread($handle, 8080))) {//返回false表示已经读取到文件末尾
            $content .= $a;
        }
        fclose($handle);
        */

        // 读取文件方法2:适用于本地文件、远程文件
        $ctx = stream_context_create(array(
                'http' => array(
                    'timeout' => 1 //设置超时
                )
            )
        );

        $content = file_get_contents($filename, 0, $ctx);
        return $content;
    }


    public function find_user_xml($username, $password)
    {
        $content = $this->read_user_xml();
        $dom = new \DOMDocument();
        $dom->loadXML($content);
        $root = $dom->documentElement;
        $users = $root->getElementsByTagName('user');
        foreach ($users as $key => $val) {
            $username_xml = $users->item($key)->getElementsByTagName('username')->item(0)->nodeValue;
            $password_xml = $users->item($key)->getElementsByTagName('password')->item(0)->nodeValue;
            if ($username_xml == $username && $password_xml == $password) {
                $panel_user['username'] = $username;
                $panel_user['password'] = $password;
                $panel_user['realname'] = $users->item($key)->getElementsByTagName('realname')->item(0)->nodeValue;
                $panel_user['status'] = $users->item($key)->getElementsByTagName('status')->item(0)->nodeValue;
                return data_return(CODE_SUCCESS, '登录成功', $panel_user);
            }
        }
        return data_return(CODE_ERROR, '登录失败');
    }


    public function add_user_xml()
    {
        $articleList = array(
            array(
                'id' => '1234',
                'create_date' => '333'
            ),
        );
        $html = '';
        $html .= '<urlset>';
        foreach ($articleList as $key => $value) {
            $html .= '<url>';
            $html .= '<loc>https://www.codelovers.cn/article/' . $value['id'] . '.html</loc>';
            $html .= '<lastmod>' . $value['create_date'] . '</lastmod>';
            $html .= '<changefreq>Always</changefreq>';
            $html .= '<priority>0.8</priority>';
            $html .= '</url>';
        }
        $html .= '</urlset>';
        //最后一个参数是去掉tp字典的根节点，只输出自己的内容
        $result = xml($html, 200, [], ['root_node' => 'xml']);
        return ($result);
    }

    public function echo_xml($content)
    {
        $xml_object = xml($content, 200, []); // 格式化xml字符串为对象
        return ($xml_object);
    }
}