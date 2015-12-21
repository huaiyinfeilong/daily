<?php

namespace Api\Model;

use Think\Model;

class DailyModel extends Model
{
    // 字段验证
    protected $_validate = array(
        // 标题验证
        array('title', 'require', -1, self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),    // 标题不能为空
        array('title', '', -2, self::EXISTS_VALIDATE, 'unique', self::MODEL_BOTH),    // 同名标题已经存在
        // 正文验证
        array('content', 'require', -3, self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),    // 正文内容不能为空
    );

    // 自动填充
    protected $_auto = array(
        array('create_time', 'time', self::MODEL_INSERT, 'function'),    // 发表时间
        array('update_time', 'time', self::MODEL_BOTH, 'function'),    // 最后更新时间
        array('create_ip', 'get_client_ip', self::MODEL_INSERT, 'function'),    // 创建时的IP地址
        array('update_ip', 'get_client_ip', self::MODEL_BOTH, 'function'),    // 最后更新时的IP地址
    );

}
