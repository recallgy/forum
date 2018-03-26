<?php
/**
 *TestGuest Version1.0
 *=========================================
 *copy 2017
 *=======================================
 *Author:Recall
 *Date:2017年10月30日
 */

define('IN_TG', True);
define('CSS', 'reg');
require dirname(__FILE__).'/includes/common.inc.php';


?>
<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="ooopic_1509195663.ico" type="image/x-icon" >
	<link rel="stylesheet" type="text/css" href="styles/1/basic.css">
	<link rel="stylesheet" type="text/css" href="styles/1/reg.css">
	<meta charset="utf-8">
	<title>注册页面</title>

<!-- 	<script type="text/javascript">
		function face()
		{
			window.open('face.php','face');
		}

	</script> -->

</head>
<body>

	<?php 
	require ROOT_PATH.'includes/header.inc.php';
	?>

<div id="reg">
	<h2>会员注册</h2>
	<form method="post" action="post.php">
		<dl>
			<dt>请认真填写下列内容</dt>
			<dd>用&nbsp&nbsp户&nbsp&nbsp名:<input type="text" name="username" class="text">(必填，至少两位)</dd>
			<dd>密&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp码:<input type="password" name="password" class="text">(必填，至少六位)</dd>
			<dd>确认密码:<input type="password" name="checkpassword" class="text">(必填，至少六位)</dd>
			<dd>密码提示:<input type="text" name="passt" class="text">(必填，至少两位)</dd>
			<dd>密码回答:<input type="text" name="passd" class="text">(必填，至少两位)</dd>
			<dd>性	 别:<input type="radio" name="sex" value="男" checked="checked">男									<input type="radio" name="sex" value="女" >女</dd>
			<dd class="face">选择头像:<img  src="face/01.jpg" alt="头像选择" onclick="window.open('face.php','face')"></dd>
			<dd>电子邮件:<input type="text" name="email" class="text"></dd>
			<dd>&nbsp&nbsp&nbspQ&nbsp&nbsp&nbspQ&nbsp&nbsp:<input type="text" name="qq" class="text"></dd>
			<dd>主页地址:<input type="text" name="url" class="text" value="http://"></dd>
			<dd>验&nbsp&nbsp证&nbsp&nbsp码:<input type="text" name="yzm" class="text yzm" ></dd>
			<dd><input type="submit" class="submit" value="注册"></dd>
		</dl>
		
	</form>
</div>

<?php 
require ROOT_PATH.'includes/footer.inc.php';

?>
</body>
</html>