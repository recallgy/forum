<?php
/**
*TestGuest Version1.0
*=========================================
*copy 2017
*=======================================
*Author:Recall
*Date:2017年12月18日
*/
session_start();
define('IN_TG', True);
define('CSS', 'member_friend');
require dirname(__FILE__).'/includes/common.inc.php';
//判断是否登陆
if(!isset($_COOKIE['username']))
{
    _alert_back('请先登录!');
}
//验证好友
if($_GET['action']=='check'&&isset($_GET['id'])){
    if(!!$_rows2=_fetch_array(_query("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1")))
    {
        //修改表中state，从而通过验证
        _query("UPDATE tg_friend SET tg_state=1 WHERE tg_id='{$_GET['id']}'");
        if (_affected_rows()==1){
            _close();
            _location('验证成功', 'member_friend.php');
            
        }
        else {
            _close();
            _location('验证失败', 'member_message.php');
        }
    }
    else {
        _alert_back('非法登陆');
    }
}

//批量好友
if($_GET['action']=='delete'&&isset($_POST['ids']))
{
    $_clean=array();
    $_clean['ids']=mysqli_real_escape_string($GLOBALS['con'], implode(',', $_POST['ids']));
    if(!!$_rows2=_fetch_array(_query("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1")))
    {
        //防止cookie伪造,比对唯一标识符
        _uniqid($_rows2['tg_uniqid'], $_COOKIE['uniqid']);
        _query("DELETE FROM tg_friend WHERE tg_id IN ({$_clean['ids']})");
        if (_affected_rows()){
            _close();
            _location('删除成功', 'member_friend.php');
            
        }
        else {
            _close();
            _session_destroy();
            _location('删除失败', 'member_message.php');
        }
        
    }
    else {
        _alert_back('非法登陆');
    }
}

//分页
global $_pagesize,$_pagenum;
_page("SELECT tg_id  FROM tg_friend WHERE tg_touser='{$_COOKIE['username']}'  OR  tg_fromuser='{$_COOKIE['username']}'",9);  //第一个参数获取总共条数，第二个参数表示每页多少条
$_result=_query("SELECT tg_id,tg_state,tg_touser,tg_fromuser,tg_content,tg_date FROM tg_friend WHERE tg_touser='{$_COOKIE['username']}' OR tg_fromuser='{$_COOKIE['username']}' ORDER BY tg_date DESC LIMIT $_pagenum,$_pagesize");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>好友界面</title>
		<?php 
require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript"  src="javascript/member_message.js" ></script>
</head>
<body>
	<?php 
	require ROOT_PATH.'includes/header.inc.php';
	?>
	<div id="member">
		<?php  require ROOT_PATH.'includes/member.inc.php';?>
		<div id="member_main">
			<h2>好友中心</h2>
			<form method="post" action="?action=delete">
			<table cellspacing="1">
	<tr><th>好友</th><th>请求内容</th><th>时间</th><th>状态</th><th>操作</th></tr>
	 <?php
	 while(!!$_rows=mysqli_fetch_array($_result)){
    	     $_html=array();
    	     $_html['id']=$_rows['tg_id'];
    	     $_html['touser']=$_rows['tg_touser'];
    	     $_html['fromuser']=$_rows['tg_fromuser'];
    	     $_html['content']=$_rows['tg_content'];
    	     $_html['state']=$_rows['tg_state'];
    	     $_html['date']=$_rows['tg_date'];
    	     $_html=_html($_html);	    
    	     if ($_html['touser']==$_COOKIE['username'])
    	     {
    	         $_html['friend']=$_html['fromuser'];
    	         if(empty($_html['state']))
    	         {
    	             $_html['state_html']='<a href="?action=check&id='.$_html['id'].'">你未验证</a>';
    	         }
    	         else {
    	             $_html['state_html']='通过';
    	         }
    	     }
    	     elseif ($_html['fromuser']==$_COOKIE['username'])
    	     {
    	         $_html['friend']=$_html['touser'];
    	         if(empty($_html['state']))
    	         {
    	             $_html['state_html']='对方未验证';
    	         }
    	         else {
    	             $_html['state_html']='通过';
    	         }
    	     }
	     ?>
	<tr><td><?php echo $_html['friend']?></td><td title="<?php  echo $_html['content']?>"><?php echo _title($_html['content'],14)?></td><td><?php  echo $_html['date']?></td><td><?php echo $_html['state_html']?></td><td><input  name="ids[]" value="<?php echo $_html['id']?>" type="checkbox"></td></tr>
	
<?php 	}

_free_result($_result);
?>


<tr><td colspan="5"><label for="all">全选<input type="checkbox" name="chkall" id="all"></label><input type="submit" value="删除"></td></tr>

	</table>
	</form>
	<?php  

//paging表示调用哪个分页
_paging(2);
    ?>
			</div>
			</div>
<?php 
require ROOT_PATH.'includes/footer.inc.php';

?>

</body>
</html>