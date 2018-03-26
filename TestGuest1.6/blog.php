<?php
/**
*TestGuest Version1.0
*=========================================
*copy 2017
*=======================================
*Author:Recall
*Date:2017年11月29日
*/
session_start();
define('IN_TG', True);
define('CSS', 'blog');
require dirname(__FILE__).'/includes/common.inc.php';
//数据分页
global $_pagesize,$_pagenum;
_page("SELECT tg_id  FROM tg_user",9);

//取得用户数据
$_result=_query("SELECT tg_id,tg_username,tg_sex,tg_face FROM tg_user ORDER BY tg_regtime DESC LIMIT $_pagenum,$_pagesize");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>用户页面</title>
<?php 
    require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="javascript/blog.js"></script>
</head>
<body>
	<?php 
	require ROOT_PATH.'includes/header.inc.php';
	?>
	
	<div id="blog">
	<h2>博友列表</h2>
	<?php 
	       while(!!$_rows=mysqli_fetch_array($_result)){
	           $_html=array();
	           $_html['id']=$_rows['tg_id'];
	           $_html['username']=$_rows['tg_username'];
	           $_html['sex']=$_rows[1];
	           $_html['face']=$_rows['tg_face'];
	           $_html=_html($_html);
	           ?>
	<dl>
	<dd class="username"><?php echo $_html['username']?>(<?php echo  $_html['sex']?>)</dd>
	<dt><img alt="" src="<?php echo $_html['face']?>"></dt>
	<dd class="message"><a href=""  name="message" title="<?php echo $_html['id']?>">私信</a></dd>
	<dd><a href=""  name="friend" title="<?php echo $_html['id']?>">加为好友</a></dd>
	<dd>写留言</dd>
	<dd>送花</dd>
	</dl>
	<?php 
	       }
	_free_result($_result);
	//paging表示调用哪个分页
	_paging(1);
	
	?>
	

	</div>
	
	<?php 
require ROOT_PATH.'includes/footer.inc.php';

?>

</body>
</html>