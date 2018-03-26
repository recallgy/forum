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
define('CSS', 'member');
require dirname(__FILE__).'/includes/common.inc.php';
//判断是否登陆
if(isset($_COOKIE['username']))
{
    //获取数据
    $_rows=_fetch_array(_query("SELECT * FROM tg_user WHERE tg_username='{$_COOKIE['username']}'"));
    if($_rows)
    {
        $_html=array();
        $_html['username']=$_rows['tg_username'];
        $_html['sex']=$_rows['tg_sex'];
        $_html['face']=$_rows['tg_face'];
        $_html['email']=$_rows['tg_email'];
        $_html['qq']=$_rows['tg_qq'];
        $_html['url']=$_rows['tg_url'];
        $_html['regtime']=$_rows['tg_regtime'];
        switch ($_rows['tg_level'])
        {
            case 0:
                $_html['level']='普通会员';
                break;
            case 1:
                $_html['level']='管理员';
                break;
            default:
                $_html['level']='信息错误';
        }
        $_html=_html($_html);
    }
    else {
        _alert_back('此用户不存在');
    }
}
    else {
        
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>个人中心</title>
	<?php 
require ROOT_PATH.'includes/title.inc.php';
?>
</head>
<body>
	<?php 
	require ROOT_PATH.'includes/header.inc.php';
	?>
	<div id="member">
		<?php  require ROOT_PATH.'includes/member.inc.php';?>
		<div id="member_main">
			<h2>会员管理中心</h2>
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