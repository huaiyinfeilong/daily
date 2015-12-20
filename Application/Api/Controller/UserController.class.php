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
                die('1');
            }
            die('0');
        }
        else
        {
            die((string)($user->getError()));
        }
    }

    public function login($username = '', $password = '', $type = 0)
    {
        if (!IS_POST)
            return true;

        // 用户名不能为空
        if (empty($username))
            die('-1');

        // 密码不能为空
        if (empty($password))
            die('-2');

        $db = M('User');
        $rs = $db->where(array('username'=>$username, 'email'=>$username, 'mobile'=>$username, 'qq'=>$username, 'weixin'=>$username, '_logic'=>'OR'))->find();
        // 用户不存在
        if (!$rs)
            die('-3');

        // 密码不正确
        if ($rs['password'] != md5($password))
            die('-4');

        // 保存用户信息到session
        session('user', array('uid'=>$rs['id'], 'username'=>$rs['username'], 'client_ip'=>get_client_ip()));
        // 写入信息到cookie
        if ($type == 1)
            cookie('user', array('uid'=>$rs['id'], 'password'=>md5(md5(get_client_ip()) . $rs['password']), 'key'=>md5(get_client_ip())), 3600);

        // 验证通过
        die('1');

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
            die();

        die(json_encode($rs));
    }
}
