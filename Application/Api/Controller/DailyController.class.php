<?php

namespace Api\Controller;

use Think\Controller;

class DailyController extends Controller
{
    public function _initialize()
    {
        if (!$this->isLogined())
        {
            $this->ajaxReturn(-10001);
            return false;
        }
        else
        {
            return true;
        }
    }

    // 新建日报
    public function createDaily()
    {
        if (!IS_POST)
            return false;

        $db = D('Daily');
        $data = I();
        $user = session('user');
        $data['uid'] = $user['uid'];
        if ($db->create($data))
        {
            if ($db->add())
                $this->ajaxReturn(1);
            $this->ajaxReturn(0);
        }
        else
        {
            $this->ajaxReturn($db->getError());
        }
    }

    protected function isLogined()
    {
        if (!session('user'))
            return false;

        return true;
    }

    public function listDaily($uid = 0, $page = 1, $size = 18)
    {
        if (!IS_POST)
            return false;

        $user = M('User');
        $db = M('Daily');
        $rs = null;

        if ($uid == 0)
        {
            $data['total'] = (int)$db->field('id')->count();
            $rs = $db->select();
        }
        else
        {
            $rs = $user->find($uid);
            if (!$rs)
            {
                $this->ajaxReturn(-101);    // 用户不存在
            }
            $data['total'] = (int)$db->field('id')->where(array('uid'=>$uid))->count();
            $rs = $db->limit(array(($page - 1) * $size, $size))->select();
        }
        if (!$rs)
            return false;

        $data['curpage'] = (int)$page;
        $data['pagenum'] = (int)(($data['total'] + $size) / $size);
        $data['data'] = array();
        foreach ($rs as $item)
        {
            $uid = $item['uid'];
            $d = $user->field('username')->find($uid);
            unset($item['uid']);
            $item['author'] = $d['username'];
            $item['update_time'] = date('Y-m-d H:i:s', $item['update_time']);
            array_push($data['data'], $item);
        }
        $this->ajaxReturn($data);
    }

    // 删除日报
    public function deleteDaily($id = null)
    {
        if (!IS_POST)
            return false;

        $daily = M('Daily');
        $rs = $daily->find($id);
        if (!$rs)
            $this->ajaxReturn(-101);    // 没有找到日报

        $userSession = session('user');
        if ($rs['uid'] != $userSession['uid'])
            $this->ajaxReturn(-102);    // 用户只能删除自己编写的日报

        $daily->delete($id);
        $this->ajaxReturn(1);
    }

    // 日报详细内容
    public function detailDaily($id = null)
    {
        $daily = M('Daily');
        $rs = $daily->find($id);
        if (!$rs)
            $this->ajaxReturn(-101);    // 日报没有找到

        $data = array();
        $data['title'] = $rs['title'];
        $user = M('User')->find($rs['uid']);
        $data['author'] = $user['username'];
        $data['update_time'] = date('Y-m-d H:i:s', $rs['update_time']);
        $data['content'] = $rs['content'];
        $this->ajaxReturn($data);
    }

    // 编辑日报
    public function editDaily($id = 0, $title = '', $content = '')
    {
        if (!IS_POST)
            return false;

        $daily = D('Daily');
        $rs = $daily->field('uid')->find($id);
        if (!$rs)
            $this->ajaxReturn(-101);    // 日报不存在

        $userSession = session('user');
        $uid = $userSession['uid'];
        if ($rs['uid'] != $uid)
            $this->ajaxReturn(-102);    // 无权编辑他人日报

        $data = array();
        $data['id'] = $id;
        $data['title'] = $title;
        $data['content'] = $content;
        if ($daily->create($data))
        {
            $daily->save();
            $this->ajaxReturn(1);
        }
        else
        {
            $this->ajaxReturn($daily->getError());
        }
    }

    // 判断指定的日报是否归属自己
    public function owner($id = 0)
    {
        if (!IS_POST)
            return false;

        $daily = M('Daily');
        $rs = $daily->find($id);
        if (!$rs)
            $this->ajaxReturn(-101);    // 日报不存在

        $userSession = session('user');
        if ($rs['uid'] != $userSession['uid'])
            $this->ajaxReturn(-102);    // 日报所有者不是当前登录的用户

        $this->ajaxReturn(1);    // 日报是当前用户所有
    }
}
