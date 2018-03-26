<?php
/**
*TestGuest Version1.0
*=========================================
*copy 2017
*=======================================
*Author:Recall
*Date:2017年12月15日
*/
session_start();

define('IN_TG', True);
define('CSS', 'message');
require dirname(__FILE__).'/includes/common.inc.php';
//判断是否登陆
if(!isset($_COOKIE['username']))
{
    _alert_close('请先登录!');
}

//写短信
if ($_GET['action']=='write')
{
    _check_code($_POST['yzm'],$_SESSION['code']);
    if(!!$_rows=_fetch_array(_query("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1")))
    {
        _uniqid($_rows['tg_uniqid'], $_COOKIE['uniqid']);
    include ROOT_PATH.'includes/regester.func.inc.php';
        
    $_clean=array();
    $_clean['touser']=$_POST['touser'];
    $_clean['fromuser']=$_COOKIE['username'];
    $_clean['content']=_check_content($_POST['content']);
    $_clean=_mysql_string($_clean);
    //写入数据库
    _query("INSERT INTO tg_message (
                                            tg_touser,
                                            tg_fromuser,
                                            tg_content,
                                            tg_date
                                            )
                             VALUES(
                                            '{$_clean['touser']}',
                                            '{$_clean['fromuser']}',
                                            '{$_clean['content']}',
                                            NOW()
                                            )
");
    //新增成功
    if (_affected_rows()==1){
        _close();
       // _session_destroy();
        _alert_close('短信发送成功');
        
    }
    else {
        _close();
        //_session_destroy();
        _alert_back('短信发送失败');
    }
}
else 
{
    _alert_close('非法登陆!');
}
}
//获取数据
if(isset($_GET['id']))
{
    if(!!$_rows=_fetch_array(_query("SELECT tg_username FROM tg_user WHERE tg_id='{$_GET['id']}'")))
    {
        $_html=array();
        $_html['touser']=$_rows['tg_username'];
        $_html=_html($_html);
    }
    else {
        _alert_close('不存在此用户');
    }

}
else {
    _alert_close('非法操作!');
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>私信界面</title>
	<?php 
require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="javascript/code.js"></script>
<script type="text/javascript" src="javascript/message.js"></script>
</head>
<body>

<div id="message">
	<h3>写短信</h3>
	<form method="post"  action="?action=write">
	<input type="hidden" name="touser" value="<?php echo $_html['touser']?>">
	<dl>
		<dd><input type="text"  readonly="readonly"  value="TO:<?php echo  $_html['touser']?>" class="text" ></dd>
		<dd><textarea  name="content" rows="" cols=""></textarea></dd>
		<dd>验&nbsp&nbsp证&nbsp&nbsp码:<input type="text" name="yzm" class="text yzm" ><img src="code.php" id="code"><input type="submit" class="submit" value="发送短信"></dd>
	
	</dl>
	</form>
</div>
	
</body>
</html>