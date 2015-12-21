<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title><?php echo C('WEBSITE_TITLE');?></title>
<script type="text/javascript" src="/daily/Public/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="/daily/Public/js/jquery.cookie.js"></script>
</head>
<body>
<div class="wrap">
    <div class="header">
        <div class="logo"><a href="<?php echo U('/');?>"><img alt="<?php echo C('WEBSITE_TITLE');?> Logo" src="/daily/Public/img/logo.png" /></a></div>
        <!-- 导航菜单开始 -->
        <div class="nav-menu">
            <ul>
                <li><a href="<?php echo U('/');?>">首页</a></li>
                    <li><a id="link_user_photo" href="javascript:;"><?php echo ($user["username"]); ?></a></li>
                    <li><a id="link_user_logout" href="javascript:;">退出登录</a></li>
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
            <!-- 日报撰写表单开始 -->
            <div id="write_daily_form_view" style="display:none;">
                <div><label for="write_daily_form_title">日报标题：</label><input type="text" id="write_daily_form_title" value="" size="100" maxsize="100" /></div>
                <div><label for="write_daily_form_content">日报正文：</label></div>
                <div><textarea id="write_daily_form_content" rows="50" cols="50"></textarea></div>
                <div><button id="btn_write_daily_form_write" type="button">提交</button></div>
                <div><button id="btn_write_daily_form_close" type="button">关闭</button></div>
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
            $("#user_selector").html('');
            for (var i = 0; i < data.length; i++)
                $("#user_selector").append('<option value="' + data[i].id + '">' + data[i].username + '</option>');
    });
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
        case -1:
            alert('日报没有找到！');
        break;
        default:
            $(".daily-detail-title").html(data.title);
            $(".daily-detail-author").html(data.author);
            $(".daily-detail-update-time").html(data.update_time);
            $(".daily-detail-content").html(data.content);
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
        for (var i = 0; i < data.length; i++)
                $("#daily_table_tbody").append('<tr><td><a class="daily-item-title" onclick="detailDaily(' + data[i].id + ')" href="javascript:;">' + data[i].title + '</a></td><td>' + data[i].author + '</td><td>' + data[i].update_time + '</td><td><a class="daily-item-edit" onclick="editDaily(' + data[i].id + ')" href="javascript:;">编辑</a></td><td><a class="daily-item-delete" onclick="deleteDaily(' + data[i].id + ')" href="javascript:;">删除</a></td></tr>');
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
        case -1:
            alert('您尚未登录，无法进行此操作！');
        break;
        case -2:
            alert('您要删除的日报不存在！');
        break;
        case -3:
            alert('您无权删除他人日报！');
        break;
        case 1:
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

    // 点击退出登录链接
    $("#link_user_logout").click(function(){
        $.post('<?php echo U('/api/user/logout');?>', {}, function(data){
            location.href = "<?php echo U('/login');?>";
        });
    });

    // 点击撰写日报链接
    $("#link_write_daily").click(function(){
        if ($("#link_user_photo").is(":hidden"))
        {
            alert('您还没有登录，请先登录！');
            hideUserRegisterForm();
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
            case -11:
                alert('您还没有登录，无法提交日报,请先登录！');
                showUserLoginForm();
            break;
            case -1:
                alert('日报标题不能为空！');
                $("#write_daily_form_title").focus();
            break;
            case -2:
                alert('同名日报已经存在！');
                $("#write_daily_form_title").focus();
            break;
            case -3:
                alert('日报内容不能为空！');
                $("#write_daily_form_content").focus();
            break;
            case 1:
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