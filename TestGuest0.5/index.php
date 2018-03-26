<?php
/**
*TestGuest Version1.0
*=========================================
*copy 2017
*=======================================
*Author:Recall
*Date:${date}
*/
define('IN_TG', True);
define('CSS', 'index');
require dirname(__FILE__).'/includes/common.inc.php';

?>
<!DOCTYPE html>
<html>
<head>
	<title>论坛首页</title>
	<meta charset="utf-8">
	<?php 
require ROOT_PATH.'includes/title.inc.php';
?>
</head>
<body>
	<?php 
	require ROOT_PATH.'includes/header.inc.php';
	?>

	<div id="list">
		<h2>帖子列表</h2>
	</div>

	<div id="user">
		<h2>新进会员</h2>
	</div>

	<div id="pics">
		<h2>最新图片</h2>
	</div>
<?php 
require ROOT_PATH.'includes/footer.inc.php';

?>

</body>
</html>