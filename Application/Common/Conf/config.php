<?php
return array(
    //'配置项'=>'配置值'
    // 网站名称
    'WEBSITE_TITLE'=>'项目部日报管理系统',
    // 数据库配置
    'DB_TYPE'=>'mysql',
    'DB_HOST'=>'localhost',
    'DB_PORT'=>'3306',
    'DB_NAME'=>'daily',
    'DB_USER'=>'root',
    'DB_PWD'=>'hyfl1989hyfl',
    'DB_PREFIX'=>'daily_',
    // 路由配置
    'URL_ROUTER_ON'=>true,
    'URL_MODEL'=>2,
    'URL_ROUTE_RULES'=>array(
        // API模块路由
        'api/user/register$'=>'Api/User/register',
    ),

);