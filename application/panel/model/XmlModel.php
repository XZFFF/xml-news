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
        $filename = $_SERVER['DOCUMENT_ROOT'] . "/xml-news/public/xml/user.xml";

        // 读取文件方法1:适用于本地文件
        $handle = fopen($filename, 'r');
        $content = '';
        while (false != ($a = fread($handle, 8080))) {//返回false表示已经读取到文件末尾
            $content .= $a;
        }
        fclose($handle);

        // 读取文件方法2:适用于本地文件、远程文件
        /*
        $ctx = stream_context_create(array(
                'http' => array(
                    'timeout' => 1 //设置超时
                )
            )
        );
        $content = file_get_contents($filename, 0, $ctx);
        */

        return $content;
    }

    public function write_user_xml($content)
    {
        $filename = $_SERVER['DOCUMENT_ROOT'] . "/xml-news/public/xml/user.xml";
        $file = fopen($filename, "w"); // w代表替换写入
        fwrite($file, $content);
        fclose($file);
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

    public function has_user_xml($username)
    {
        $content = $this->read_user_xml();
        $dom = new \DOMDocument();
        $dom->loadXML($content);
        $root = $dom->documentElement;
        $users = $root->getElementsByTagName('user');
        foreach ($users as $key => $val) {
            $username_xml = $users->item($key)->getElementsByTagName('username')->item(0)->nodeValue;
            if ($username_xml == $username) {
                return data_return(CODE_SUCCESS, '存在用户');
            }
        }
        return data_return(CODE_ERROR, '不存在用户');
    }


    public function add_user_xml($username, $password, $realname, $status)
    {
        $content = $this->read_user_xml();
        $dom = new \DOMDocument();
        $dom->loadXML($content);
        $root = $dom->documentElement;

        // TODO 检查是否有重新username的用户

        $new_user_xml = $dom->createElement('user');
        $root->appendChild($new_user_xml);
        $username_xml = $dom->createElement('username', $username);
        $new_user_xml->appendChild($username_xml);
        $password_xml = $dom->createElement('password', $password);
        $new_user_xml->appendChild($password_xml);
        $realname_xml = $dom->createElement('realname', $realname);
        $new_user_xml->appendChild($realname_xml);
        $status_xml = $dom->createElement('status', $status);
        $new_user_xml->appendChild($status_xml);

        $content = $dom->saveXML();
        return $content;
    }

    public function echo_xml($content)
    {
        $xml_object = xml($content, 200, []); // 格式化xml字符串为对象
        return ($xml_object);
    }
}