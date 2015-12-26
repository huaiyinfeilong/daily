<?php

namespace Api\Controller;

use Think\Controller;

class AuthController extends Controller
{
    public function _initialize()
    {
        if (MODULE_NAME == 'Api' && CONTROLLER_NAME == 'User' && (ACTION_NAME == 'register' || ACTION_NAME == 'login'))
            return true;

        if (!$this->isLogined())
        {
            $this->ajaxReturn(-10001);
            return false;
        }
        else
        {
            $userSession = session('user');
            if (!$this->getUserStatus($userSession['uid']))
            {
                $this->ajaxReturn(-10002);
                return false;
            }
            return true;
        }
    }

    protected function isLogined()
    {
        if (!session('user'))
            return false;

        return true;
    }

    protected function getUserStatus($id = 0)
    {
        $db = M('User');
        $rs = $db->field('status')->find($id);
        if (!$rs)
            return false;

        return $rs['status'];
    }
}
