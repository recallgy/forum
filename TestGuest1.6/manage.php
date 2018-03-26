<?php
/**
*TestGuest Version1.0
*=========================================
*copy 2017
*=======================================
*Author:Recall
*Date:2017年12月4日
*/
session_start();
define('IN_TG', True);
define('CSS', 'manage');
require dirname(__FILE__).'/includes/common.inc.php';
//必须是管理员才能登陆
_manage_login();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>后台管理中心</title>
	<?php 
require ROOT_PATH.'includes/title.inc.php';
?>
</head>
<body>
	<?php 
	require ROOT_PATH.'includes/header.inc.php';
	?>
	<div id="member">
		<?php  require ROOT_PATH.'includes/manage.inc.php';?>
		<div id="member_main">
			<h2>后台管理中心</h2>
			<dl>
			<dd>用 户 名:<?php echo $_html['username']?></dd>
			<dd>性		别:<?php echo $_html['sex']?></dd>
			<dd>头		像:<?php echo $_html['face']?></dd>
			<dd>电子邮件:<?php echo $_html['email']?></dd>
			<dd>主		页:<?php echo $_html['url']?></dd>
			<dd>Q		Q:<?php echo $_html['qq']?></dd>
			<dd>注册时间:<?php echo $_html['regtime']?></dd>
			<dd>身		份:<?php echo $_html['level']?></dd>
			</dl>
		</div>

	</div>
	
	
<?php 
require ROOT_PATH.'includes/footer.inc.php';

?>

</body>
</html>