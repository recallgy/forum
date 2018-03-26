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
define('CSS', 'manage_set');
require dirname(__FILE__).'/includes/common.inc.php';
//必须是管理员才能登陆
_manage_login();
//修改系统表
if ($_GET['action']=='set'){
    if(!!$_rows=_fetch_array(_query("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1")))
    {
        _uniqid($_rows['tg_uniqid'], $_COOKIE['uniqid']);
        $_clean=array();
        $_clean['webname']=$_POST['webname'];
        $_clean['article']=$_POST['article'];
        $_clean['blog']=$_POST['blog'];
        $_clean['photo']=$_POST['photo'];
        $_clean['skin']=$_POST['skin'];
        $_clean['post']=$_POST['post'];
        $_clean['re']=$_POST['re'];
        $_clean['code']=$_POST['code'];
        $_clean['register']=$_POST['register'];
        $_clean['string']=$_POST['string'];
        $_clean=_mysql_string($_clean);
        
        //写入数据库
        _query("UPDATE tg_system SET tg_webname='{$_clean['webname']}',tg_article='{$_clean['article']}',tg_blog='{$_clean['blog']}',tg_photo='{$_clean['photo']}',tg_skin='{$_clean['skin']}',tg_post='{$_clean['post']}',tg_re='{$_clean['re']}',tg_code='{$_clean['code']}',tg_register='{$_clean['register']}',tg_string='{$_clean['string']}' WHERE tg_id=1 LIMIT 1");
        
        //判断修改是否成功
        if (_affected_rows()==1){
            _close();
            //  _session_destroy();
            _location('恭喜你,修改成功', 'manage_set.php');
            
        }
        else {
            _close();
            //  _session_destroy();
            _location('资料没有变化', 'manage_set.php');
        }
    }else {
        _alert_back('异常');
    }
}

//读取系统表
if(!!$_rows=_fetch_array(_query("SELECT * FROM tg_system WHERE tg_id=1 LIMIT 1")))
{
    $_html=array();
    $_html['webname']=$_rows['tg_webname'];
    $_html['article']=$_rows['tg_article'];
    $_html['blog']=$_rows['tg_blog'];
    $_html['photo']=$_rows['tg_photo'];
    $_html['skin']=$_rows['tg_skin'];
    $_html['string']=$_rows['tg_string'];
    $_html['post']=$_rows['tg_post'];
    $_html['re']=$_rows['tg_re'];
    $_html['code']=$_rows['tg_code'];
    $_html['register']=$_rows['tg_register'];
    $_html=_html($_html);
    //文章
    if($_html['article']==10)
    {
        $_html['article_html']='<select name="article"  ><option value="10" selected="selected">每页十篇</option><option value="15">每页十五篇</option></select>';

    }elseif ($_html['article']==15){
        $_html['article_html']='<select name="article"  ><option value="10" >每页十篇</option><option value="15" selected="selected">每页十五篇</option></select>';
    }
    //博友
    if($_html['blog']==10)
    {
        $_html['blog_html']='<select name="blog"  ><option value="10" selected="selected">每页十个</option><option value="15">每页十五个</option></select>';
        
    }elseif ($_html['blog']==15){
        $_html['blog_html']='<select name="blog"  ><option value="10" >每页十个</option><option value="15" selected="selected">每页十五个</option></select>';
    }
    
    //相册
    if($_html['photo']==8)
    {
        $_html['photo_html']='<select name="photo"  ><option value="8" selected="selected">每页8个</option><option value="12">每页12个</option></select>';
        
    }elseif ($_html['photo']==12){
        $_html['photo_html']='<select name="photo"  ><option value="8" >每页8个</option><option value="12" selected="selected">每页12个</option></select>';
    }
    //皮肤
    if($_html['skin']==1)
    {
        $_html['skin_html']='<select name="skin"  ><option value="1" selected="selected">1</option><option value="2">2</option><option value="3">3</option></select>';
        
    }elseif ($_html['skin']==2){
        $_html['skin_html']='<select name="skin"  ><option value="1" >1</option><option value="2" selected="selected">2</option><option value="3">3</option></select>';
    }elseif ($_html['skin']==3){
        $_html['skin_html']='<select name="skin"  ><option value="1" >1</option><option value="2" >2</option><option value="3" selected="selected">3</option></select>';
    }
    
    //发帖限制
    if($_html['post']==30){
        $_html['post_html']='<input  type="radio" name="post" value="30" checked="checked">30秒<input  type="radio" name="post" value="60">60秒<input  type="radio" name="post" value="180">180秒';
    }elseif ($_html['post']==60) {
        $_html['post_html']='<input  type="radio" name="post" value="30" >30秒<input  type="radio" name="post" value="60" checked="checked">60秒<input  type="radio" name="post" value="180">180秒';
    }elseif ($_html['post']==180){
        $_html['post_html']='<input  type="radio" name="post" value="30" >30秒<input  type="radio" name="post" value="60" >60秒<input  type="radio" name="post" value="180" checked="checked">180秒';
    }
    //回帖限制
    if($_html['re']==15){
        $_html['re_html']='<input  type="radio" name="re" value="15" checked="checked">15秒<input  type="radio" name="re" value="30">30秒<input  type="radio" name="re" value="45">45秒';
    }elseif ($_html['re']==30){
        $_html['re_html']='<input  type="radio" name="re" value="15" >15秒<input  type="radio" name="re" value="30" checked="checked">30秒<input  type="radio" name="re" value="45">45秒';
    }elseif ($_html['re']==45){
        $_html['re_html']='<input  type="radio" name="re" value="15" >15秒<input  type="radio" name="re" value="30">30秒<input  type="radio" name="re" value="45" checked="checked">45秒';
    }
    
    //验证码
    if($_html['code']==1){
        $_html['code_html']='<input  type="radio" name="code" value="1" checked="checked">启用 <input  type="radio" name="code" value="0" >关闭';
    }else{
        $_html['code_html']='<input  type="radio" name="code" value="1" >启用 <input  type="radio" name="code" value="0" checked="checked">关闭';
    }
    //开放注册
    if($_html['register']==1){
        $_html['register_html']='<input  type="radio" name="register" value="1" checked="checked">启用 <input  type="radio" name="register" value="0" >关闭';
    }else{
        $_html['register_html']='<input  type="radio" name="register" value="1">启用 <input  type="radio" name="register" value="0"  checked="checked">关闭';
    }
    
    
}else{
    _alert_back('系统表读取错误');
}
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
			<form action="?action=set" method="post">
			<dl>
					<dd>网站名称：<input type="text"  name="webname" class="text" value="<?php echo $_html['webname'];?>"></dd>
					<dd>每页文章数量:<?php echo $_html['article_html'];?></dd>
					<dd>博客每页列表:<?php echo $_html['blog_html'];?></dd>
					<dd>相册每页数量:<?php echo $_html['photo_html'];?></dd>
					<dd>站点默认皮肤:<?php echo $_html['skin_html'];?></dd>
					<dd>非法字符过滤<input type="text" name="string"  class="text" value="<?php echo $_html['string']?>"></dd>
					<dd>每次发帖限制 :<?php echo $_html['post_html']?></dd>
					<dd>每次回帖限制 :<?php echo $_html['re_html']?></dd>
					<dd>验证码启用 :<?php echo $_html['code_html']?></dd>
					<dd>是否开放注册:<?php echo $_html['register_html']?></dd>
					<dd><input type="submit" value="修改系统设置" class="submit"></dd>
			</dl>
			</form>
		</div>

	</div>
	
	
<?php 
require ROOT_PATH.'includes/footer.inc.php';

?>

</body>
</html>