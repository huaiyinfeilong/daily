<?php

namespace Api\Controller;

use Think\Controller;

class DailyController extends Controller
{
    public function create()
    {
        if (!IS_POST)
            return false;

        // 用户登录态检查
        if (!$this->isLogined())
            die('-11');

        $db = D('Daily');
        $data = I();
        $user = session('user');
        $data['uid'] = $user['uid'];
        if ($db->create($data))
        {
            if ($db->add())
                die('1');
            die('0');
        }
        else
        {
            die((string)($db->getError()));
        }
    }

    protected function isLogined()
    {
        if (!session('user'))
            return false;

        return true;
    }

    public function listDaily()
    {
        if (!IS_POST)
            return false;

        $db = M('Daily');
        $rs = $db->select();
        if (!$rs)
            return false;

        $data = array();
        $user = M('User');
        foreach ($rs as $item)
        {
            $uid = $item['uid'];
            $d = $user->field('username')->find($uid);
            unset($item['uid']);
            $item['author'] = $d['username'];
            $item['update_time'] = date('Y-m-d H:i:s', $item['update_time']);
            array_push($data, $item);
        }
        die(json_encode($data));
    }

    public function deleteDaily($id = null)
    {
        if (!IS_POST)
            return false;

        $userSession = session('user');
        if (!$userSession)
            die('-1');    // 没有登录

        $daily = M('Daily');
        $rs = $daily->find($id);
        if (!$rs)
            die('-2');    // 没有找到日报

        if ($rs['uid'] != $userSession['uid'])
            die('-3');    // 用户只能删除自己编写的日报

        $daily->delete($id);
        die('1');
    }

    // 日报详细内容
    public function detailDaily($id = null)
    {
        $daily = M('Daily');
        $rs = $daily->find($id);
        if (!$rs)
            die('-1');    // 日报没有找到

        $data['title'] = $rs['title'];
        $user = M('User')->find($rs['uid']);
        $data['author'] = $user['username'];
        $data['update_time'] = date('Y-m-d H:i:s', $rs['update_time']);
        $data['content'] = $rs['content'];
        die(json_encode($data));
    }
}
