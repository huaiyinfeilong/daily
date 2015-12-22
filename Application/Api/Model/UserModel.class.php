<?php

namespace Api\Model;

use Think\Model;

class UserModel extends Model
{
    // 字段验证
    protected $_validate = array(
        // 用户名验证
        array('username', 'require', -1, self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),    // 用户名不能为空
        array('username', '/^[\x{4e00}-\x{9fa5}]{2,10}$/u', -2, self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),    // 用户名只能由2~10个汉字组成
        array('username', '', -3, self::EXISTS_VALIDATE, 'unique', self::MODEL_INSERT),    // 用户名已经存在！
        // 密码验证
        array('password', 'require', -4, self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),    // 密码不能为空
        array('password', '/^[a-zA-Z0-9\-]{6,20}$/', -5, self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),    // 密码长度必须在6~20之间，且只能由于字母、数字和“-”组成
        // 重复密码验证
        array('password2', 'password', -6, self::EXISTS_VALIDATE, 'confirm', self::MODEL_BOTH),    // 两次密码输入不一致
    // 电子邮箱验证
        array('email', 'require', -7, self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),    // 电子邮箱不能为空
    array('email', 'email', -8, self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),    // 电子邮箱格式不正确
        array('email', '5,30', -9, self::EXISTS_VALIDATE, 'length', self::MODEL_BOTH),    // 电子邮箱地址的长度只能在5~30之间
        array('email', '', -10, self::EXISTS_VALIDATE, 'unique', self::MODEL_INSERT),    // 电子邮箱已被注册
        // 验证手机号码
        array('mobile', 'require', -11, self::EXISTS_VALIDATE, 'regex', self::MODEL_INSERT),    // 手机号码不能为空
        array('mobile', '/^1[3-9][0-9]{9}$/', -12, self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),    // 手机号码不正确
        array('mobile', '', -13, self::EXISTS_VALIDATE, 'unique', self::MODEL_BOTH),    // 手机号码已被注册
        // 验证QQ号码
        array('qq', 'require', -14, self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),     // QQ号码不能为空
        array('qq', '/^[1-9][0-9]{5,10}$/', -15, self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),    // QQ号码格式错误
        array('qq', '', -16, self::EXISTS_VALIDATE, 'unique', self::MODEL_BOTH),    // QQ号码已被注册
        // 验证微信号码
        array('weixin', 'require', -17, self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),     // 微信号码不能为空
        array('weixin', '/^[a-zA-Z1-9][a-zA-Z_0-9]{5,20}$/', -18, self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),    // 微信号码格式错误
        array('weixin', '', -19, self::EXISTS_VALIDATE, 'unique', self::MODEL_BOTH),    // 微信号码已被注册


    );

    // 自动填充
    protected $_auto = array(
        // 密码md5加密
        array('password', 'md5', self::MODEL_BOTH, 'function'),
        // 注册时间
        array('register_time', 'time', self::MODEL_INSERT, 'function'),
        // 注册IP
        array('register_ip', 'get_client_ip', self::MODEL_INSERT, 'function'),
    );

}
