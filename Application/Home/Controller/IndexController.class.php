<?php

namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
        // 自动登录
        $this->autoLogin();
        if (!session('user'))
            $this->redirect('/login');

        // 传递session中的user到前端
        $this->user = session('user');

        $this->display();
    }

    protected function autoLogin()
    {
        $cookie = cookie('user');
        if (empty($cookie))
            return false;

        $uid = $cookie['uid'];
        if ($uid <= 0)
            return false;

        $db = M('User');
        $rs = $db->find($uid);
        if (!$rs)
            return false;
        if ($rs['status'] != 1)
            return false;
        if ($cookie['key'] != md5(get_client_ip()))
            return false;

        if ($cookie['password'] != md5(md5(get_client_ip()) . $rs['password']))
            return false;

        $userSession = array('uid'=>$uid, 'username'=>$rs['username'], 'client_ip'=>get_client_ip());
        session('user', $userSession);

        return true;
    }

    public function login()
    {
        $this->display();
    }
}
