<?php

namespace Home\Controller;

use Think\Controller;

class AdminController extends Controller
{
    public function _initialize()
    {
        if (ACTION_NAME == 'login' || ACTION_NAME == 'ajaxLogin')
            return true;

        if (session('admin'))
        {
            return true;
        }
        else
        {
            $this->redirect('/admin/login');
            return false;
        }
    }

    public function login()
    {
        $this->display();
    }

    public function ajaxLogin($username = '', $password = '')
    {
        if (!IS_POST)
            return true;

        if ($username == '')
            $this->ajaxReturn(-101);    // 用户名不能为空
        if ($password == '')
            $this->ajaxReturn(-102);    // 密码不能为空

        if ($username != C('ADMIN_USERNAME') || $password != C('ADMIN_PASSWORD'))
            $this->ajaxReturn(-103);    // 用户名或密码不正确

        session('admin', 1);

        $this->ajaxReturn(1);
    }

    // 获取用户列表
    public function ajaxUserList()
    {
        if (!IS_POST)
            return true;

        $db = M('User');
        $rs = $db->order('`register_time` DESC')->field('password', true)->select();
        $this->ajaxReturn($rs);
    }

    // 删除用户
    public function ajaxUserDelete($id = 0)
    {
        if (!IS_POST)
            return true;

        $db = M('User');
        $rs = $db->find($id);
        if (!$rs)
            $this->ajaxReturn(-1);    // 用户不存在

        $db->delete($id);
        $db = M('Daily');
        $db->where(array('uid'=>$id))->delete();

        $this->ajaxReturn(1);
    }

    // 设置用户状态
    public function ajaxUserSetStatus($id = 0, $status = 0)
    {
        if (!IS_POST)
            return true;

        $db = M('User');
        $rs = $db->find($id);
        if (!$rs)
            $this->ajaxReturn(-101);    // 用户不存在

        if ($status != 1 && $status != 0)
            $this->ajaxReturn(-102);    // 参数错误

        $rs['status'] = $status;
        $db->data($rs)->save();
        $this->ajaxReturn(1);
    }
}
