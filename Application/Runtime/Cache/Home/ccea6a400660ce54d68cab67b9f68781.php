<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>登录_<?php echo C('WEBSITE_TITLE');?></title>
<script type="text/javascript" src="/daily/Public/js/jquery-2.1.3.min.js"></script>
</head>
<body>
<div class="wrap">
    <div class="header">
        <div class="logo"><a href="<?php echo U('/');?>"><img src="/daily/Public/img/logo.png" alt="<?php echo C('WEBSITE_TITLE');?> Logo" /></a></div>
        <div class="nav-menu">
            <ul>
                <li><a id="link_user_login" href="javascript:;">登录</a></li>
            <li><a id="link_user_register" href="javascript:;">注册</a></li>
            </ul>
        </div>
    </div>
    <div class="main">
        <!-- 用户注册表单开始 -->
        <div id="user_register_form_view" style="display:none;">
            <label for="user_register_form_username">姓名：</label><input type="text" id="user_register_form_username" value="" size="100" maxsize="100" />
            <label for="user_register_form_password">密码：</label><input type="password" id="user_register_form_password" value="" size="100" maxsize="100" />
            <label for="user_register_form_password2">重复密码：</label><input type="password" id="user_register_form_password2" value="" size="100" maxsize="100" />
            <label for="user_register_form_email">电子邮箱：</label><input type="text" id="user_register_form_email" value="" size="100" maxsize="100" />
            <label for="user_register_form_mobile">手机号码：</label><input type="text" id="user_register_form_mobile" value="" size="100" maxsize="100" />
            <label for="user_register_form_qq">QQ号码：</label><input type="text" id="user_register_form_qq" value="" size="100" maxsize="100" />
            <label for="user_register_form_weixin">微信号：</label><input type="text" id="user_register_form_weixin" value="" size="100" maxsize="100" />
            <button id="btn_user_register_form_register" type="button">注册</button>
        </div>
        <!-- 用户注册表单结束 -->
        <!-- 登录表单开始 -->
        <div id="user_login_form_view" style="display:none;">
            <label for="user_login_form_username">姓名/邮箱/手机/QQ/微信：</label><input type="text" id="user_login_form_username" value="" size="100" maxsize="100" />
            <label for="user_login_form_password">密码：</label><input type="password" id="user_login_form_password" value="" size="100" maxsize="100" />
            <input type="checkbox" id="user_login_form_remember_password" /><label for="user_login_form_remember_password">记住我的密码，下次自动登录</label>
            <button id="btn_user_login_form_login" type="button">登录</button>
        </div>
        <!-- 登录表单结束 -->
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

// 显示用户登录表单
function showUserRegisterForm()
{
            $("#user_register_form_view").show();
        $("#user_register_form_username").focus();
}

// 关闭用户注册表单
function closeUserRegisterForm()
{
    clearUserRegisterForm();
            $("#user_register_form_view").hide();
}

// 清空用户登录表单
function clearUserLoginForm()
{
    document.getElementById('user_login_form_username').value = '';
    document.getElementById('user_login_form_password').value = '';
    document.getElementById('user_login_form_remember_password').checked = '';
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

// 事件处理
$(function(){
    // 显示用户注册表单
    showUserLoginForm();
    // 点击注册链接
    $("#link_user_register").click(function(){
        if ($("#user_register_form_view").is(":hidden"))
        {
            closeUserLoginForm();
            showUserRegisterForm();
        }
    });
    // 点击注册表单中的注册按钮
    $("#btn_user_register_form_register").click(function(){
        $.post('<?php echo U('/api/user/register');?>', {username: document.getElementById('user_register_form_username').value, password: document.getElementById('user_register_form_password').value, password2: document.getElementById('user_register_form_password2').value, email: document.getElementById('user_register_form_email').value, mobile: document.getElementById('user_register_form_mobile').value, qq: document.getElementById('user_register_form_qq').value, weixin: document.getElementById('user_register_form_weixin').value}, function(data){
            switch (data)
            {
            case -1:
                alert('姓名不能为空！');
                $("#user_register_form_username").focus();
            break;
            case -2:
                alert('姓名只能由2~10个汉字组成！');
                $("#user_register_form_username").focus();
                break;
            case -3:
                alert('用户已经存在！');
                $("#user_register_form_username").focus();
            break;
            case -4:
                alert('密码不能为空！');
                $("#user_register_form_password").focus();
            break;
            case -5:
                alert('密码长度必须在6~20之间，且只能由于字母、数字和“-”组成！');
                $("#user_register_form_password").focus();
            break;
            case -6:
                alert('两次密码输入不一致！');
                $("#user_register_form_password").focus();
            break;
            case -7:
                alert('电子邮箱不能为空！');
                $("#user_register_form_email").focus();
            break;
            case -8:
                alert('电子邮箱格式不正确！');
                $("#user_register_form_email").focus();
            break;
            case -9:
                alert('电子邮箱地址的长度只能在5~30之间！');
                $("#user_register_form_email").focus();
            break;
            case -10:
                alert('电子邮箱已被注册！');
                $("#user_register_form_email").focus();
            break;
            case -11:
                alert('手机号码不能为空！');
                $("#user_register_form_mobile").focus();
            break;
            case -12:
                alert('手机号码不正确！');
                $("#user_register_form_mobile").focus();
            break;
            case -13:
                alert('手机号码已被注册！');
                $("#user_register_form_mobile").focus();
            break;
            case -14:
                alert('QQ号码不能为空！');
                $("#user_register_form_qq").focus();
            break;
            case -15:
                alert('QQ号码格式不正确！');
                $("#user_register_form_qq").focus();
            break;
            case -16:
                alert('QQ号码已被注册！');
                $("#user_register_form_qq").focus();
            break;
            case -17:
                alert('微信号码不能为空！');
                $("#user_register_form_weixin").focus();
            break;
            case -18:
                alert('微信号码格式不正确！');
                $("#user_register_form_weixin").focus();
            break;
            case -19:
                alert('微信号码已被注册！');
                $("#user_register_form_weixin").focus();
            break;
            case 0:
                alert('未知错误，请联系管理员！');
            break;
            case 1:
                alert('注册成功，请等待管理员审核通过！');
                closeUserRegisterForm();
                showUserLoginForm();
            break;
            }
        });
    });

    // 点击导航中的登录链接
    $("#link_user_login").click(function(){
        if ($("#user_login_form_view").is(":hidden"))
        {
            closeUserRegisterForm();
            showUserLoginForm();
        }
    });

    // 点击了登录表单中的登录按钮
    $("#btn_user_login_form_login").click(function(){
        var username = document.getElementById('user_login_form_username').value;
        var password = document.getElementById('user_login_form_password').value;
        var rememberPassword = document.getElementById('user_login_form_remember_password').checked;
        $.post('<?php echo U('api/user/login');?>', {username: username, password: password, type: (rememberPassword? 1 : 0)}, function(data){
            switch (data)
            {
            case -1:
                alert('用户名不能为空！');
                $("#user_login_form_username").focus();
            break;
            case -2:
                alert('密码不能为空！');
                $("#user_login_form_password").focus();
            break;
            case -3:
                alert('用户不存在！');
                $("#user_login_form_username").focus();
            break;
            case -4:
                alert('密码不正确！');
                $("#user_login_form_password").focus();
            break;
            case 1:
                alert('登录成功！');
                location.href = "<?php echo U('/');?>";
            break;
            default:
                alert('未知错误，请联系管理员！');
            break;
            }
        });
    });

});
</script>
</body>
</html>