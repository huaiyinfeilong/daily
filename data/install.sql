DROP TABLE IF EXISTS `daily_user`;
CREATE TABLE `daily_user` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
    `username` varchar(32) NOT NULL DEFAULT '' COMMENT '用户名',
    `password` varchar(32) NOT NULL DEFAULT '' COMMENT '用户密码',
    `email` varchar(50) NOT NULL DEFAULT '' COMMENT '电子邮箱',
    `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号码',
    `qq` varchar(12) NOT NULL DEFAULT '' COMMENT 'QQ号码',
    `weixin` varchar(50) NOT NULL DEFAULT '' COMMENT '微信号码',
    `register_time` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '注册时间',
    `last_time` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '最后登录时间',
    `register_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '用户注册时的IP地址',
    `last_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '用户最后登录时的IP地址',
    UNIQUE KEY `username` (`username`),
    UNIQUE KEY `email` (`email`),
    UNIQUE KEY `mobile` (`mobile`),
    UNIQUE KEY `qq` (`qq`),
    UNIQUE `weixin` (`weixin`),
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `daily_daily`;
CREATE TABLE `daily_daily` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `uid` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '用户ID',
    `title` varchar(50) NOT NULL DEFAULT '' COMMENT '日报标题',
    `content` varchar(5000) NOT NULL DEFAULT '' COMMENT '日报正文',
    `create_time` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '创建时间',
    `update_time` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '更新时间',
    `create_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '创建时的IP地址',
    `update_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '更新时的IP地址',
    PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

