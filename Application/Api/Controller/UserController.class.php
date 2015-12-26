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
        $userSession = array('uid'=>$rs['id'], 'username'=>$rs['username'], 'client_ip'=>get_client_ip());
                session('user', $userSession);
                $this->ajaxReturn(1);
            }
            $this->ajaxReturn(0);
        }
        else
        {
            $this->ajaxReturn($user->getError());
        }
    }

    public function login($username = '', $password = '', $type = 0)
    {
        if (!IS_POST)
            return true;

        // 用户名不能为空
        if (empty($username))
            $this->ajaxReturn(-101);

        // 密码不能为空
        if (empty($password))
            $this->ajaxReturn(-102);

        $db = M('User');
        $rs = $db->where(array('username'=>$username, 'email'=>$username, 'mobile'=>$username, 'qq'=>$username, 'weixin'=>$username, '_logic'=>'OR'))->find();
        // 用户不存在
        if (!$rs)
            $this->ajaxReturn(-103);

        // 密码不正确
        if ($rs['password'] != md5($password))
            $this->ajaxReturn(-104);

        // 用户为激活
        if ($rs['status'] != '1')
            $this->ajaxReturn(-105);

        // 保存用户信息到session
        session('user', array('uid'=>$rs['id'], 'username'=>$rs['username'], 'client_ip'=>get_client_ip()));
        // 写入信息到cookie
        if ($type == 1)
            cookie('user', array('uid'=>$rs['id'], 'username'=>$rs['username'], 'password'=>md5(md5(get_client_ip()) . $rs['password']), 'key'=>md5(get_client_ip())), 3600);

        // 验证通过
        $this->ajaxReturn(1);

        // 记录最后登录时间
        $rs['last_time'] = time();
        // 记录最后登录IP
        $rs['last_ip'] = get_client_ip();
        // 写入数据库
        $db->create($rs)->save();
    }

    public function logout()
    {
        session('user', null);
        cookie('user', null);
    }

    public function listUser()
    {
        if (!IS_POST)
            return false;

        $db = M('User');
        // 获取除password以外的所有字段
        $rs = $db->field('password', true)->select();
        if (!$rs)
            $this->ajaxReturn(-101);

        $this->ajaxReturn($rs);
    }

    public function profile()
    {
        if (!IS_POST)
            return false;

        $userSession = session('user');
        if (!$userSession)
            $this->ajaxReturn(-10001);    // 用户没有登录

        $user = M('User')->field('password', true)->find($userSession['uid']);
        $this->ajaxReturn($user);
    }
}
