<?php

namespace Api\Controller;

use Think\Controller;

class UserController extends Controller
{
    public function register()
    {
        if (!IS_POST)
            return true;

        $data = I('');
        $user = D('User');
        if ($user->create($data))
        {
            $uid = $user->add();
            if ($uid > 0)
            {
                session('uid', (string)$uid);
                die('1');
            }
            die('0');
        }
        else
        {
            die((string)($user->getError()));
        }
    }
}
