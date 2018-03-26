<?php
/**
 *TestGuest Version1.0
 *=========================================
 *copy 2017
 *=======================================
 *Author:Recall
 *Date:2017年10月31日
 */
session_start();
define('IN_TG', True);
define('CSS', 'face');
require dirname(__FILE__).'/includes/common.inc.php';


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>头像选择</title>
		<?php 
require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="javascript/opener.js">
	
</script>
</head>
<body>
	<div id="face">
		<h3>选择头像</h3>
		<dl>
		<?php foreach (range(1,8) as $num){?>
			<dd><img src="face/0<?php echo $num?>.jpg" title="头像<?php echo $num?>" ></dd>
			<?php }?>
			
		</dl>
	</div>
</body>
</html>