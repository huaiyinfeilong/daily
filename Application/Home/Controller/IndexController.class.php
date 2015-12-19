<?php

namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $user = M('User');
        $this->userList = $user->select();
        $this->display();
    }
}
