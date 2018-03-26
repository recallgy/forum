<?php
/**
*TestGuest Version1.0
*=========================================
*copy 2017
*=======================================
*Author:Recall
*Date:2017年11月19日
*/
session_start();
define('IN_TG', True);
define('CSS', 'active');

require dirname(__FILE__).'/includes/common.inc.php';
//开始激活处理
if(!isset($_GET['active'])){
    _alert_back('非法操作');
}
if(isset($_GET['action'])&&isset($_GET['active'])&&$_GET['action']=='ok')
{
       $_active=mysqli_real_escape_string($GLOBALS['con'], $_GET['active']);
       if(_fetch_array( _query("SELECT tg_active FROM tg_user WHERE tg_active='$_active'")))
    {
        _query("UPDATE tg_user SET tg_active=NULL WHERE tg_active='$_active'");
        if(_affected_rows()==1)
        {
            _close();
            _location('账户激活成功', 'login.php');
        }
        else {
            _close();
            _location('账户激活成功', 'login.php');
        }
    }
    
}







?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>激活页面</title>
<?php 
    require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="javascript/regester.js">
</script>
</head>
<body>
	<?php 
	require ROOT_PATH.'includes/header.inc.php';
	?>
	<div id='active'>
	<h2>激活账户</h2>
	<p>点击下列链接激活账户</p>
	<p> <a href="active.php?action=ok&amp;active=<?php echo $_GET['active']?>"><?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']?>active.php?action=ok&amp;active=<?php $_GET['active']?></a></p>
	</div>
	<?php 
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>