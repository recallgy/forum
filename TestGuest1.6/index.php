<?php
/**
*TestGuest Version1.0
*=========================================
*copy 2017
*=======================================
*Author:Recall
*Date:${date}
*/
session_start();
define('IN_TG', True);
define('CSS', 'index');
require dirname(__FILE__).'/includes/common.inc.php';

//读取帖子列表
global $_pagesize,$_pagenum;
_page("SELECT tg_id  FROM tg_article",10);
$_result=_query("SELECT * FROM tg_article WHERE tg_reid=0 ORDER BY tg_date DESC LIMIT $_pagenum,$_pagesize");//desc倒叙
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<?php 
require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript"  src="javascript/blog.js"></script>
</head>
<body>
	<?php 
	require ROOT_PATH.'includes/header.inc.php';
	?>

	<div id="list">
		<h2>帖子列表</h2>
		<a href="post.php" class="post">发表文章</a>
		<ul class="article">
		
		<?php 
		$_htmllist=array();
		while(!!$_rows=mysqli_fetch_array($_result)){
		    $_htmllist['id']=$_rows['tg_id'];
		    $_htmllist['type']=$_rows['tg_type'];
		    $_htmllist['readcount']=$_rows['tg_readcount'];
		    $_htmllist['commendcount']=$_rows['tg_commendcount'];
		    $_htmllist['title']=$_rows['tg_title'];
		    $_htmllist=_html($_htmllist);
		    echo '<li>	<em>阅读 <strong>'.$_htmllist['readcount'].'</strong> 评论<strong>'.$_htmllist['commendcount'].'</strong></em><a href="article.php?id='.$_htmllist['id'].'">'. _title($_htmllist['title'],20).'</a></li>';
		}
		_free_result($_result);

		?>  	
		</ul>	
		<?php 
		//paging表示调用哪个分页
		_paging(2);		
		
		?>
		</div>

	<div id="user">
		<h2>新进会员</h2>
			<dl>
	<dd class="username">recall</dd>
	<dt><img alt="" src=""></dt>
	<dd class="message"><a href=""  name="message" title="1">私信</a></dd>
	<dd><a href=""  name="friend" title="1">加为好友</a></dd>
	<dd>写留言</dd>
	<dd>送花</dd>
	<dd class="email">邮件:http://</dd>
	<dd class="url">网址:http://</dd>
	</dl>
	</div>

	<div id="pics">
		<h2>最新图片</h2>
	</div>
<?php 
require ROOT_PATH.'includes/footer.inc.php';

?>

</body>
</html>