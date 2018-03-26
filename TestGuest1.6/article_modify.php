<?php
/**
 *TestGuest Version1.0
 *=========================================
 *copy 2017
 *=======================================
 *Author:Recall
 *Date:2017年10月30日
 */
session_start();

define('IN_TG', True);
define('CSS', 'article_modify');

require dirname(__FILE__).'/includes/common.inc.php';

//登陆后的会员才可发帖
if (!isset($_COOKIE['username'])){
    _location('你尚未登陆', 'RegesterPage.php');
}

//修改
if($_GET['action']=='modify'){
//防止恶意注册，跨站攻击
_check_code($_POST['yzm'],$_SESSION['code']);
if(!!$_rows=_fetch_array(_query("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1")))
{
    //防止cookie伪造,比对唯一标识符
    _uniqid($_rows['tg_uniqid'], $_COOKIE['uniqid']);
    //开始修改
    include ROOT_PATH.'includes/regester.func.inc.php';
    //接收帖子数据
    $_clean=array();
    $_clean['type']=$_POST['type'];
    $_clean['id']=$_POST['id'];
    $_clean['title']=_check_post_title($_POST['title'],2,40);
    $_clean['content']=_check_post_content($_POST['content'],3);
    $_clean=_mysql_string($_clean);
    //执行sql
    _query("UPDATE tg_article SET tg_type='{$_clean['type']}',tg_title='{$_clean['title']}',tg_content='{$_clean['content']}',tg_lastmodify_date=NOW()  WHERE tg_id='{$_clean['id']}'");
    if (_affected_rows()==1){
       
        _close();
     //   _session_destroy();
        _location('恭喜你,帖子修改成功', 'article.php?id='.$_clean['id']);
        
    }
    else {
        _close();
      //  _session_destroy();
        _alert_back('帖子修改失败');
    }
}else {
    _alert_back('非法登陆');
}

}
//读取数据
if (isset($_GET['id'])){
    if(!!$_rows=_fetch_array(_query("SELECT * FROM tg_article WHERE tg_reid=0 AND tg_id='{$_GET['id']}'")))
    {
        //存在
        $_html=array();
        $_html['id']=$_GET['id'];
        $_html['username']=$_rows['tg_username'];
        $_html['title']=$_rows['tg_title'];
        $_html['type']=$_rows['tg_type'];
        $_html['content']=$_rows['tg_content'];
        $_html=_html($_html);
        
        
        //判断权限
        if($_COOKIE['username']!=$_html['username'])
        {
            _alert_back('你没有权限');
        }
    }else {
        _alert_back('不存在此帖子');
    }
}else {
    _alert_back('非法操作');
}

?>
<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="javascript/code.js">
</script>
<script type="text/javascript" src="javascript/post.js">
</script>
	<meta charset="utf-8">
	<title>修改帖子页面</title>
<?php 
    require ROOT_PATH.'includes/title.inc.php';
?>
</head>
<body>
	<?php 
	require ROOT_PATH.'includes/header.inc.php';
	?>
<div id="post">
	<h2>修改帖子</h2>
	<form method="post"  name="post" action="?action=modify">
	<input type="hidden"  value="<?php echo $_html['id']?>"  name="id">
	<input type="hidden"  name="action"value="post">
		<dl>
			<dt>请认真修改下列内容</dt>
			<dd>
			类型：
			
			<?php 
			 foreach (range(1,16) as $_num){
			     if($_num==$_html['type'])
			     {
			         echo '<label for="type'.$_num.'"><input type="radio" id="type'.$_num.'"name="type" class="radio"value="'.$_num.'" checked="checked">'.$_num.'</label>';
			     }
			     else {
			     echo '<label for="type'.$_num.'"><input type="radio"  id="type'.$_num.'" name="type" class="radio" value="'.$_num.'">'.$_num.'</label>';
			              }
			              if($_num==8)
			              {
			                  echo '<br/>            ';
			              }
			 }
			?>
			</dd>
			<dd>标题:<input type="text"  value="<?php echo $_html['title']?>"name="title" class="text"></dd>
			<dd>贴图：  系列一  系列二 系列三</dd>
			<dd>
			<div id="ubb">
					<input type="text" value="字体大小">
					<input type="text" value="2">
					<input type="text" value="3">
					<input type="text" value="4">
					<input type="text" value="5">
					<input type="text" value="6">
					<input type="text" value="7">
					<input type="text" value="8">
					<input type="text" value="9">
					<input type="text" value="0">
					
			</div>
			<div id="font">
			<strong onclick="font(12)">12px</strong>
			<strong>12px</strong>
			<strong>12px</strong>
			<strong>12px</strong>
			<strong>12px</strong>
			<strong>12px</strong>
			</div>
			<div id="color">
			</div>
			<textarea rows="" cols="" name="content" ><?php echo $_html['content']?></textarea></dd>
			<dd>验&nbsp&nbsp证&nbsp&nbsp码:<input type="text" name="yzm" class="text yzm" ><img src="code.php" id="code"><input type="submit" class="submit" value="发表帖子"></dd>
		</dl>
	</form>
</div>

<?php 
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>