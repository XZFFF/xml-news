<?php
namespace app\panel\controller;

class Index extends Base
{
    public function index()
    {
        return $this->fetch();
    }
}
