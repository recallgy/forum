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
define('CSS', 'article');
require dirname(__FILE__).'/includes/common.inc.php';
//处理回帖
if($_GET['action']=='rearticle')
{
    //防止恶意注册，跨站攻击
    _check_code($_POST['yzm'],$_SESSION['code']);
    if(!!$_rows=_fetch_array(_query("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1")))
    {
        //防止cookie伪造,比对唯一标识符
        _uniqid($_rows['tg_uniqid'], $_COOKIE['uniqid']);
        //接受数据
        $_clean=array();
        $_clean['reid']=$_POST['reid'];
        $_clean['type']=$_POST['type'];
        $_clean['title']=$_POST['title'];
        $_clean['content']=$_POST['content'];
        $_clean['username']=$_COOKIE['username'];
        $_clean=_mysql_string($_clean);
        //写入数据库
        _query("INSERT INTO tg_article(tg_reid,tg_username,tg_title,tg_type,tg_content,tg_date) VALUES('{$_clean['reid']}','{$_clean['username']}','{$_clean['title']}','{$_clean['type']}','{$_clean['content']}',NOW())");
       
        if (_affected_rows()==1){
            _query("UPDATE tg_article SET tg_commendcount=tg_commendcount+1 WHERE tg_reid=0 AND tg_id='{$_clean['reid']}'");
            _close();
           // _session_destroy();
            _location('恭喜你,回帖成功', 'article.php?id='.$_clean['reid']);
            
        }
        else {
            _close();
         //   _session_destroy();
            _alert_back('回帖失败');
        }
    
    }else{
        _alert_back('非法登陆');
    }
}else {
    
}

//读取数据库
if(isset($_GET['id'])){
    if(!!$_rows=_fetch_array(_query("SELECT * FROM tg_article WHERE tg_reid=0 AND tg_id='{$_GET['id']}'")))
    {
        //阅读量处理
        _query("UPDATE tg_article SET tg_readcount=tg_readcount+1 WHERE tg_id='{$_GET['id']}'");
        
        
       //存在 
       $_html=array();
       $_html['reid']=$_rows['tg_id'];
       $_html['username_subject']=$_rows['tg_username'];
       $_html['title']=$_rows['tg_title'];
       $_html['type']=$_rows['tg_type'];
       $_html['content']=$_rows['tg_content'];
       $_html['readcount']=$_rows['tg_readcount'];
       $_html['commendcount']=$_rows['tg_commendcount'];
       $_html['lastmodify_date']=$_rows['tg_lastmodify_date'];
       $_html['date']=$_rows['tg_date'];
       
    
       
       
       //根据用户名查找用户信息
       if(!!$_rows=_fetch_array(_query("SELECT tg_id,tg_sex,tg_face,tg_email,tg_url FROM tg_user WHERE tg_username='{$_html['username_subject']}'")))
       {
           //提取用户信息
           $_html['userid']=$_rows['tg_id'];
           $_html['sex']=$_rows['tg_sex'];
           $_html['face']=$_rows['tg_face'];
           $_html['email']=$_rows['tg_email'];
           $_html['url']=$_rows['tg_url'];
           $_html=_html($_html);
           
           
           //创建一个全局变量，制作带参分页
           global $_id;
           $_id='id='.$_html['reid'].'&';
           
           //主题帖子修改
           if($_html['username_subject']==$_COOKIE['username'])
           {
               $_html['subject_modify']='[<a href="article_modify.php?id='.$_html['reid'].'">修改</a>]';
           }
           //读取最后修改时间
           if($_html['lastmodify_date']!='0000-00-00 00:00:00'){
               $_html['lastmodify_date_string']='本贴已由['.$_html['username_subject'].']于'.$_html['lastmodify_date'].'修改过';
           }
           
           //读取回帖
           
           
           //数据分页
           global $_pagesize,$_pagenum,$_page;
           _page("SELECT tg_id  FROM tg_article WHERE tg_reid='{$_html['reid']}'",2);
           //取得用户数据
           $_result=_query("SELECT * FROM tg_article WHERE  tg_reid='{$_html['reid']}' ORDER BY tg_date ASC LIMIT $_pagenum,$_pagesize");//ASC正序\
           
           
           
           
       }else {
           //这个用户已被删除
       }
    }else {
        _alert_back('不存在');
    }
      


}
else {
    _alert_back('非法操作');
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>帖子内容</title>
<?php 
    require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript"  src="javascript/code.js"></script>
<script type="text/javascript"  src="javascript/article.js"></script>
</head>
<body>
	<?php 
	require ROOT_PATH.'includes/header.inc.php';
	?>
	
	<div id="article">
	<h2>帖子内容</h2>
	
	<?php 
	
	if($_page==1){
	?>
	
	<div id="subject">
	
			<dl>
        	<dd class="username"><?php echo $_html['username_subject']?>(<?php echo $_html['sex']?>)[楼主]</dd>
        	<dt><img alt="" src="<?php echo $_html['face']?>"></dt>
        	<dd class="message"><a href=""  name="message" title="<?php echo $_html['userid']?>">私信</a></dd>
        	<dd><a href=""  name="friend" title="<?php echo $_html['userid']?>">加为好友</a></dd>
        	<dd>写留言</dd>
        	<dd>送花</dd>
        	<dd class="email"><?php echo $_html['email']?></dd>
        	<dd class="url"><?php echo $_html['url']?></dd>
        	</dl>
        		<div class="content">
		<div class="user">
		<span><?php echo $_html['subject_modify'];?>1#</span><?php echo $_html['username_subject']?> 发表于:<?php echo $_html['date']?>
		</div>
		<h3>主题:<?php echo $_html['title']?></h3>
		<div class="detail">
		<?php echo $_html['content']?>
		</div>
		<div class="read">
		<p><?php echo  $_html['lastmodify_date_string']?></p>
		阅读量:(<?php echo $_html['readcount']?>) 评论量:(<?php echo $_html['commendcount']?>)
		</div>
			</div>
	</div>
	
	
	<?php }?>
	<p class="line"></p>
	
	<?php 
	       $_i=2;
        	while(!!$_rows=mysqli_fetch_array($_result)){
        	    $_html['username']=$_rows['tg_username'];
        	    $_html['type']=$_rows['tg_type'];
        	    $_html['retitle']=$_rows['tg_title'];
        	    $_html['content']=$_rows['tg_content'];
        	    $_html['date']=$_rows['tg_date'];
        	    $_html=_html($_html);
        	    
        	 
        	    
        	    //根据用户名查找用户信息
        	    if(!!$_rows=_fetch_array(_query("SELECT tg_id,tg_sex,tg_face,tg_email,tg_url FROM tg_user WHERE tg_username='{$_html['username']}'")))
        	    {
        	        //提取用户信息
        	        $_html['userid']=$_rows['tg_id'];
        	        $_html['sex']=$_rows['tg_sex'];
        	        $_html['face']=$_rows['tg_face'];
        	        $_html['email']=$_rows['tg_email'];
        	        $_html['url']=$_rows['tg_url'];
        	        $_html=_html($_html);
        	        
        	        if($_page==1&&$_i==2)
        	        {
        	            if($_html['username']==$_html['username_subject'])
        	            {
        	                $_html['username_html']=$_html['username'].'(楼主)';
        	            }else {
        	                $_html['username_html']=$_html['username'].'(沙发)';
        	            }
        	            
        	            }else {
        	                $_html['username_html']=$_html['username'];
        	            }
        	        
        	    } else {
        	        //用户不存在
        	    }
	?>
	
		<div class="re">
	
			<dl>
        	<dd class="username"><?php echo $_html['username_html']?>(<?php echo $_html['sex']?>)</dd>
        	<dt><img alt="" src="<?php echo $_html['face']?>"></dt>
        	<dd class="message"><a href=""  name="message" title="<?php echo $_html['userid']?>">私信</a></dd>
        	<dd><a href=""  name="friend" title="<?php echo $_html['userid']?>">加为好友</a></dd>
        	<dd>写留言</dd>
        	<dd>送花</dd>
        	<dd class="email"><?php echo $_html['email']?></dd>
        	<dd class="url"><?php echo $_html['url']?></dd>
        	</dl>
        		<div class="content">
		<div class="user">
		<span><?php echo ($_i+($_page-1)*$_pagesize);?>#</span><?php echo $_html['username']?> 发表于:<?php echo $_html['date']?>
		</div>
		<h3>主题:<?php echo $_html['retitle']?></h3>
		<div class="detail">
		<?php echo $_html['content']?>
		</div>
			</div>
	</div>
	
	
	
	<p class="line"></p>
	<?php 
	       $_i++;
	
        	}
        	_free_result($_result);
        	//paging表示调用哪个分页
        	_paging(1);
	?>
	<?php if (isset($_COOKIE['username'])){?>
	<form action="?action=rearticle" method="post">
	<input type="hidden" name="reid" value="<?php echo $_html['reid']?>">
		<input type="hidden" name="type" value="<?php echo $_html['type']?>">
			<dl>
			<dd>标题:<input type="text" name="title" class="text" value="re:<?php echo $_html['title']?>"></dd>
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
			<textarea rows="" cols="" name="content" ></textarea></dd>
			<dd>验&nbsp&nbsp证&nbsp&nbsp码:<input type="text" name="yzm" class="text yzm" ><img src="code.php" id="code"><input type="submit" class="submit" value="发表帖子"></dd>
		</dl>
	</form>
	<?php }?>
	
	
	</div>
	
	<?php 
require ROOT_PATH.'includes/footer.inc.php';

?>

</body>
</html>