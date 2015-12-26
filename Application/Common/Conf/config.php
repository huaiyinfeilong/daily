<?php
return array(
    //'配置项'=>'配置值'
    // 网站名称
    'WEBSITE_TITLE'=>'项目部日报管理系统',
    // 管理后台的用户名密码
    'ADMIN_USERNAME'=>'admin',
    'ADMIN_PASSWORD'=>'123456',
    // 数据库配置
    'DB_TYPE'=>'mysql',
    'DB_HOST'=>'127.0.0.1',
    'DB_PORT'=>'3306',
    'DB_NAME'=>'daily',
    'DB_USER'=>'root',
    'DB_PWD'=>'hyfl1989hyfl',
    'DB_PREFIX'=>'daily_',
    // 路由配置
    'URL_ROUTER_ON'=>true,
    'URL_MODEL'=>2,
    'URL_ROUTE_RULES'=>array(
        // 外网访问登录路由
        'login$'=>'Home/Index/login',
        // API模块路由
        'api/user/register$'=>'Api/User/register',    // 用户注册
        'api/user/login'=>'Api/user/login',    // 用户登录
        'api/user/logout$'=>'Api/User/logout',    // 用户退出登录
        'api/user/list$'=>'Api/User/listUser',
        'api/user/profile$'=>'Api/User/profile',
        'api/daily/create$'=>'Api/Daily/createDaily',
        'api/daily/list$'=>'Api/Daily/listDaily',
        'api/daily/delete$'=>'Api/Daily/deleteDaily',
        'api/daily/detail$'=>'Api/Daily/detailDaily',    // 日报内容详情
        'api/daily/edit$'=>'Api/Daily/editDaily',
        'api/daily/owner$'=>'Api/Daily/owner',

        // 后台路由
        'admin/login$'=>'Home/Admin/login',
        'admin/api/login'=>'Home/Admin/ajaxLogin',
        'admin/index$'=>'Home/Admin/index',
        'admin/api/user/list$'=>'Home/Admin/ajaxUserList',
        'admin/api/user/delete$'=>'Home/Admin/ajaxUserDelete',
        'admin/api/user/setstatus$'=>'Home/Admin/ajaxUserSetStatus',
    ),

);