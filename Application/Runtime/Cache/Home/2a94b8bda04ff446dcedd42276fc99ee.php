<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title><?php echo C('WEBSITE_TITLE');?></title>
<script type="text/javascript" src="/daily/Public/js/jquery-2.1.3.min.js"></script>
</head>
<body>
<div class="wrap">
    <div class="header">
        <div class="logo"><a href="<?php echo U('/');?>"><img alt="<?php echo C('WEBSITE_TITLE');?> Logo" src="/daily/Public/img/logo.png" /></a></div>
        <!-- 导航菜单开始 -->
        <div class="nav-menu">
            <ul>
                <li><a href="<?php echo U('/');?>">首页</a></li>
                <?php if($user['uid']): ?><li><a id="link_user_photo" href="javascript:;"><?php echo ($user["username"]); ?></a></li>
                    <li><a id="link_user_logout" href="javascript:;">退出登录</a></li>
                    <li><a id="link_user_register" href="javascript:;" style="display:none;">注册</a></li>
                    <li><a id="link_user_login" href="javascript:;" style="display:none;">登录</a></li>
                <?php else: ?>
                    <li><a id="link_user_photo" href="javascript:;" style="display:none;"><?php echo ($user["username"]); ?></a></li>
                    <li><a id="link_user_logout" href="javascript:;" style="display:none;">退出登录</a></li>
                    <li><a id="link_user_register" href="javascript:;">注册</a></li>
                    <li><a id="link_user_login" href="javascript:;">登录</a></li><?php endif; ?>
            <li><a id="link_write_daily" href="javascript:;">撰写日报</a></li>
            </ul>
        </div>
        <!-- 导航菜单结束 -->
        <div class="user-selector">
            <select id="user_selector">
            </select>
        </div>
    </div>
    <div class="main">
        <div class="dynamic-view">
            <div id="user_register_form_view" style="display:none;">
                <label for="user_register_form_username">姓名：</label><input type="text" id="user_register_form_username" value="" size="100" maxsize="100" />
                <label for="user_register_form_password">密码：</label><input type="password" id="user_register_form_password" value="" size="100" maxsize="100" />
                <label for="user_register_form_password2">重复密码：</label><input type="password" id="user_register_form_password2" value="" size="100" maxsize="100" />
                <label for="user_register_form_email">电子邮箱：</label><input type="text" id="user_register_form_email" value="" size="100" maxsize="100" />
                <label for="user_register_form_mobile">手机号码：</label><input type="text" id="user_register_form_mobile" value="" size="100" maxsize="100" />
                <label for="user_register_form_qq">QQ号码：</label><input type="text" id="user_register_form_qq" value="" size="100" maxsize="100" />
                <label for="user_register_form_weixin">微信号：</label><input type="text" id="user_register_form_weixin" value="" size="100" maxsize="100" />
                <button id="btn_user_register_form_register" type="button">注册</button>
                <button id="btn_user_register_form_close" type="button">关闭</button>
            </div>
            <!-- 登录表单开始 -->
            <div id="user_login_form_view" style="display:none;">
                <label for="user_login_form_username">姓名/邮箱/手机/QQ/微信：</label><input type="text" id="user_login_form_username" value="" size="100" maxsize="100" />
                <label for="user_login_form_password">密码：</label><input type="password" id="user_login_form_password" value="" size="100" maxsize="100" />
                <input type="checkbox" id="user_login_form_remember_password" /><label for="user_login_form_remember_password">记住我的密码，下次自动登录</label>
                <button id="btn_user_login_form_login" type="button">登录</button>
                <button id="btn_user_login_form_close">关闭</button>
            </div>
            <!-- 登录表单结束 -->
            <!-- 日报撰写表单开始 -->
            <div id="write_daily_form_view" style="display:none;">
                <label for="write_daily_form_title">日报标题：</label><input type="text" id="write_daily_form_title" value="" size="100" maxsize="100" />
                <label for="write_daily_form_content">日报正文：</label>
                <textarea id="write_daily_form_content" rows="50" cols="50"></textarea>
                <button id="btn_write_daily_form_write" type="button">提交</button>
                <button id="btn_write_daily_form_close" type="button">关闭</button>
            </div>
            <!-- 日报撰写表单结束 -->
        </div>
        <!-- 日报列表开始 -->
        <div class="daily-list">
            <table id="daily_table">
                <caption>日报列表</caption>
                <tr>
                    <th class="th-daily-title">标题</th><th class="th-daily-author">作者</th><th class="th-daily-update-time">时间</th><th class="th-daily-edit"></th><th class="th-daily-delete"></th>
                </tr>
                <tbody id="daily_table_tbody">
                </tbody>
            </table>
        </div>
        <!-- 日报列表结束 -->
        <!-- 日报内容开始 -->
        <div tabindex="0" class="daily-detail-view" style="display:none;">
            <div class="daily-detail-title"></div>
            <div><span class="daily-detail-author"></span><span class="daily-detail-update-time"></span></div>
            <div class="daily-detail-content"></div>
            <div class="daily-detail-close"><button id="btn_daily_detail_close" type="button">关闭</button></div>
        </div>
        <!-- 日报内容结束 -->
    </div>
    <div class="footer">
        <div class="copyright">版权所有 &copy; <?php echo date('Y');?> <a href="http://www.siaa.org.cn" target="_blank">信息无障碍研究会</a></div>
    </div>
</div>

<script type="text/javascript">
// 清空用户注册表单
function clearUserRegisterForm()
{
document.getElementById('user_register_form_username').value = '';
document.getElementById('user_register_form_password').value = '';
document.getElementById('user_register_form_password2').value = '';
document.getElementById('user_register_form_email').value = '';
document.getElementById('user_register_form_mobile').value = '';
document.getElementById('user_register_form_qq').value = '';
document.getElementById('user_register_form_weixin').value = '';
}

// 清空用户登录表单
function clearUserLoginForm()
{
    document.getElementById('user_login_form_username').value = '';
    document.getElementById('user_login_form_password').value = '';
    document.getElementById('user_login_form_remember_password').checked = '';
}

// 清空日报撰写表单
function clearWriteDailyForm()
{
    document.getElementById('write_daily_form_title').value = '';
    document.getElementById('write_daily_form_content').value = '';
}

// 更新用户组合框
function updateUserSelector()
{
    $.post('<?php echo U('/api/user/list');?>', {}, function(data){
            var userList = JSON.parse(data);
            $("#user_selector").html('');
            for (var i = 0; i < userList.length; i++)
                $("#user_selector").append('<option value="' + userList[i].id + '">' + userList[i].username + '</option>');
    });
}

// 显示用户登录表单
function showUserLoginForm()
{
    $("#user_login_form_view").show();
        $("#user_login_form_username").focus();
}

// 关闭用户登录表单
function closeUserLoginForm()
{
    clearUserLoginForm();
    $("#user_login_form_view").hide();
}

// 显示撰写日报表单
function showWriteDailyForm()
{
    var date = new Date();
    $("#write_daily_form_title").val(date.getFullYear().toString() + date.getMonth().toString() + date.getDate().toString() + '日报-' + $("#link_user_photo").html());
    $("#write_daily_form_content").html('【工作列表】\r\n');
    $("#write_daily_form_view").show();
    $("#write_daily_form_content").focus();
}

// 关闭日报撰写表单
function closeWriteDailyForm()
{
$("#write_daily_form_view").hide();
clearWriteDailyForm();
}

// 显示日报内容详情视图
function showDailyDetailView()
{
    $(".daily-detail-view").show();
        $(".daily-detail-view").focus();
}

// 清空日报内容视图中的数据
function clearDailyDetailView()
{
    $(".daily-detail-title").html('');
    $(".daily-detail-author").html('');
    $(".daily-detail-update-time").html('');
    $(".daily-detail-content").html('');
}

// 关闭日报详情视图
function closeDailyDetailView()
{
    clearDailyDetailView();
    $(".daily-detail-view").hide();
}

// 点击日报标题链接
function detailDaily(id)
{
    $.post('<?php echo U('/api/daily/detail');?>', {id: id}, function(data){
        switch (data)
        {
        case '-1':
            alert('日报没有找到！');
        break;
        default:
            var dailyDetail = JSON.parse(data);
            $(".daily-detail-title").html(dailyDetail.title);
            $(".daily-detail-author").html(dailyDetail.author);
            $(".daily-detail-update-time").html(dailyDetail.update_time);
            $(".daily-detail-content").html(dailyDetail.content);
            showDailyDetailView();
        break;
        }
    });
}

// 更新日报列表
function updateDailyTable()
{
    $.post('<?php echo U('/api/daily/list');?>', {}, function(data){
        $("#daily_table_tbody").html('');
            if (data)
        {
            var dailyList = JSON.parse(data);
        for (var i = 0; i < dailyList.length; i++)
                $("#daily_table_tbody").append('<tr><td><a class="daily-item-title" onclick="detailDaily(' + dailyList[i].id + ')" href="javascript:;">' + dailyList[i].title + '</a></td><td>' + dailyList[i].author + '</td><td>' + dailyList[i].update_time + '</td><td><a class="daily-item-edit" onclick="editDaily(' + dailyList[i].id + ')" href="javascript:;">编辑</a></td><td><a class="daily-item-delete" onclick="deleteDaily(' + dailyList[i].id + ')" href="javascript:;">删除</a></td></tr>');
        }
    });
}

// 编辑日报
function editDaily(id)
{
}

// 删除日报
function deleteDaily(id)
{
    $.post('<?php echo U('/api/daily/delete');?>', {id: id}, function(data){
        switch (data)
        {
        case '-1':
            alert('您尚未登录，无法进行此操作！');
        break;
        case '-2':
            alert('您要删除的日报不存在！');
        break;
        case '-3':
            alert('您无权删除他人日报！');
        break;
        case '1':
            alert('删除成功！');
            updateDailyTable();
        break;
        default:
            alert('未知错误，');
        break;
        }
    });
}

// 事件处理
$(function(){
    updateUserSelector();    // 更新用户列表
    updateDailyTable();    // 更新日报列表
    // 点击注册链接
    $("#link_user_register").click(function(){
            $("#user_register_form_view").show();
        $("#user_register_form_username").focus();
    });
    // 点击注册表单中的注册按钮
    $("#btn_user_register_form_register").click(function(){
        $.post('<?php echo U('/api/user/register');?>', {username: document.getElementById('user_register_form_username').value, password: document.getElementById('user_register_form_password').value, password2: document.getElementById('user_register_form_password2').value, email: document.getElementById('user_register_form_email').value, mobile: document.getElementById('user_register_form_mobile').value, qq: document.getElementById('user_register_form_qq').value, weixin: document.getElementById('user_register_form_weixin').value}, function(data){
            switch (data)
            {
            case '-1':
                alert('姓名不能为空！');
                $("#user_register_form_username").focus();
            break;
            case '-2':
                alert('姓名只能由2~10个汉字组成！');
                $("#user_register_form_username").focus();
                break;
            case '-3':
                alert('用户已经存在！');
                $("#user_register_form_username").focus();
            break;
            case '-4':
                alert('密码不能为空！');
                $("#user_register_form_password").focus();
            break;
            case '-5':
                alert('密码长度必须在6~20之间，且只能由于字母、数字和“-”组成！');
                $("#user_register_form_password").focus();
            break;
            case '-6':
                alert('两次密码输入不一致！');
                $("#user_register_form_password").focus();
            break;
            case '-7':
                alert('电子邮箱不能为空！');
                $("#user_register_form_email").focus();
            break;
            case '-8':
                alert('电子邮箱格式不正确！');
                $("#user_register_form_email").focus();
            break;
            case '-9':
                alert('电子邮箱地址的长度只能在5~30之间！');
                $("#user_register_form_email").focus();
            break;
            case '-10':
                alert('电子邮箱已被注册！');
                $("#user_register_form_email").focus();
            break;
            case '-11':
                alert('手机号码不能为空！');
                $("#user_register_form_mobile").focus();
            break;
            case '-12':
                alert('手机号码不正确！');
                $("#user_register_form_mobile").focus();
            break;
            case '-13':
                alert('手机号码已被注册！');
                $("#user_register_form_mobile").focus();
            break;
            case '-14':
                alert('QQ号码不能为空！');
                $("#user_register_form_qq").focus();
            break;
            case '-15':
                alert('QQ号码格式不正确！');
                $("#user_register_form_qq").focus();
            break;
            case '-16':
                alert('QQ号码已被注册！');
                $("#user_register_form_qq").focus();
            break;
            case '-17':
                alert('微信号码不能为空！');
                $("#user_register_form_weixin").focus();
            break;
            case '-18':
                alert('微信号码格式不正确！');
                $("#user_register_form_weixin").focus();
            break;
            case '-19':
                alert('微信号码已被注册！');
                $("#user_register_form_weixin").focus();
            break;
            case '0':
                alert('未知错误，请联系管理员！');
            break;
            case '1':
                alert('注册成功，请登录！');
                updateUserSelector();
                $("#user_register_form_view").hide();
                clearUserRegisterForm();
                showUserLoginForm();
            break;
            }
        });
    });
    // 点击注册表单中的关闭按钮
    $("#btn_user_register_form_close").click(function(){
        $("#user_register_form_view").hide();
        clearUserRegisterForm();
    });

    // 点击导航中的登录链接
    $("#link_user_login").click(function(){
        showUserLoginForm();
    });

    // 点击了登录表单中的登录按钮
    $("#btn_user_login_form_login").click(function(){
        var username = document.getElementById('user_login_form_username').value;
        var password = document.getElementById('user_login_form_password').value;
        var rememberPassword = document.getElementById('user_login_form_remember_password').checked;
        $.post('<?php echo U('api/user/login');?>', {username: username, password: password, type: (rememberPassword? 1 : 0)}, function(data){
            switch (data)
            {
            case '-1':
                alert('用户名不能为空！');
                $("#user_login_form_username").focus();
            break;
            case '-2':
                alert('密码不能为空！');
                $("#user_login_form_password").focus();
            break;
            case '-3':
                alert('用户不存在！');
                $("#user_login_form_username").focus();
            break;
            case '-4':
                alert('密码不正确！');
                $("#user_login_form_password").focus();
            break;
            case '1':
                alert('登录成功！');
                $("#link_user_photo").html($("#user_login_form_username").val());
                closeUserLoginForm();
                $("#link_user_register").hide();
                $("#link_user_login").hide();
                $("#link_user_photo").show();
                $("#link_user_logout").show();
            break;
            default:
                alert('未知错误，请联系管理员！');
            break;
            }
        });

    });

    // 点击登录表单中的关闭按钮
    $("#btn_user_login_form_close").click(function(){
        closeUserLoginForm();
    });

    // 点击退出登录链接
    $("#link_user_logout").click(function(){
        $.post('<?php echo U('/api/user/logout');?>', {}, function(data){
            $("#link_user_photo").hide();
            $("#link_user_logout").hide();
            $("#link_user_register").show();
            $("#link_user_login").show();
        });
    });

    // 点击撰写日报链接
    $("#link_write_daily").click(function(){
        if ($("#link_user_photo").is(":hidden"))
        {
            alert('您还没有登录，请先登录！');
            showUserLoginForm();
        }
        else
        {
            showWriteDailyForm();
        }
    });

    // 点击日报撰写表单中的关闭按钮
    $("#btn_write_daily_form_close").click(function(){
        closeWriteDailyForm();
    });

    // 点击撰写日报表单中的提交按钮
    $("#btn_write_daily_form_write").click(function(){
        var title = document.getElementById('write_daily_form_title').value;
        var content = document.getElementById('write_daily_form_content').value;
        $.post('<?php echo U('/api/daily/create');?>', {title: title, content: content}, function(data){
            switch (data)
            {
            case '-11':
                alert('您还没有登录，无法提交日报,请先登录！');
                showUserLoginForm();
            break;
            case '-1':
                alert('日报标题不能为空！');
                $("#write_daily_form_title").focus();
            break;
            case '-2':
                alert('同名日报已经存在！');
                $("#write_daily_form_title").focus();
            break;
            case '-3':
                alert('日报内容不能为空！');
                $("#write_daily_form_content").focus();
            break;
            case '1':
                alert('日报提交成功！');
                closeWriteDailyForm();
                updateDailyTable();
            break;
            default:
                alert('未知错误，请联系管理员！');
            break;
            }
        });
    });

    // 点击日报详情内容视图中的关闭按钮
    $("#btn_daily_detail_close").click(function(){
            closeDailyDetailView();
        });

});
</script>
</body>
</html>