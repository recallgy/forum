<?php
/**
*TestGuest Version1.0
*=========================================
*copy 2017
*=======================================
*Author:Recall
*Date:2017年11月19日
*/
session_start();
define('IN_TG', True);
define('CSS', 'login');
require dirname(__FILE__).'/includes/common.inc.php';

//登录状态判断
_login_state();
//处理登录
if($_GET['action']=='login')
{
    _check_code($_POST['yzm'],$_SESSION['code']);
    include  ROOT_PATH.'includes/login.func.inc.php';
    
    $_clean=array();
    $_clean['username']=_check_username($_POST['username'], 2, 20);
    $_clean['password']=_check_password($_POST['password'], 6);
    $_clean['time']=_check_time($_POST['time']);
    
    //数据库中验证

    if(!! $_rows=_fetch_array(_query("SELECT tg_username,tg_uniqid,tg_level FROM tg_user WHERE tg_username='{$_clean['username']}' AND tg_password='{$_clean['password']}' AND tg_active='' LIMIT 1")))
   {
       //登陆成功后，记录登陆信息
       _query("UPDATE tg_user SET tg_lasttime=NOW(),tg_lastip='{$_SERVER['REMOTE_ADDR']}',tg_login_count=tg_login_count+1 WHERE tg_username='{$_rows['tg_username']}'");
       _close();
      // _session_destroy();
       _setcookies($_rows['tg_username'], $_rows['tg_uniqid'],$_clean['time']);
       if($_rows['tg_level']==1)
       {
           $_SESSION['admin']=$_rows['tg_username'];
       }
       header('Location:member.php');
   }
   else{
       _close();
      // _session_destroy();
       _location('用户名或密码不正确或该账户未被激活', 'login.php');
   }
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>登录页面</title>
<?php 
    require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="javascript/code.js">
</script>
<script type="text/javascript" src="javascript/login.js">
</script>
</head>
<body>
	<?php 
	require ROOT_PATH.'includes/header.inc.php';
	?>
	<div id="login">
	<h2>登录</h2>
	<form method="post"  name="login" action="login.php?action=login">
		<dl>
			<dt>&nbsp</dt>
			<dd>用&nbsp户&nbsp名:<input type="text" name="username" class="text"> </dd>
			<dd>密&nbsp&nbsp&nbsp&nbsp码:<input type="password" name="password" class="text"></dd>
			<dd>保&nbsp&nbsp&nbsp&nbsp留:<input type="radio" name="time" value="0" checked="checked"> 不保留:<input type="radio" name="time" value="1" > 一天<input type="radio" name="time" value="2" >一周<input type="radio" name="time" value="3" >一个月</dd>
			<dd>验&nbsp证&nbsp码:<input type="text" name="yzm" class="text yzm" ><img src="code.php" id="code"></dd>
			<dd><input type="submit" value="登录" class="button"><input type="button" value="注册" id="location"class="button  location"></dd>
			</dl>	
			</form>
	</div>
	<?php 
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>