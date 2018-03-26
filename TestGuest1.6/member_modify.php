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
define('CSS', 'member_modify');
require dirname(__FILE__).'/includes/common.inc.php';

//修改资料
if($_GET['action']=='modify')
{
    
    _check_code($_POST['yzm'],$_SESSION['code']);
    if(!!$_rows=_fetch_array(_query("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1")))
    {
        //防止cookie伪造,比对唯一标识符
        _uniqid($_rows['tg_uniqid'], $_COOKIE['uniqid']);
        include  ROOT_PATH.'includes/regester.func.inc.php';
    $_clean=array();
    $_clean['password']=_check_modify_password($_POST['password'],6);
    $_clean['email']=_check_email($_POST['email']);
    $_clean['qq']=_check_qq($_POST['qq']);
    $_clean['url']=_check_url($_POST['url']);
    $_clean['sex']=_check_sex($_POST['sex']);
    $_clean['face']=_check_face($_POST['facetext']);
    
    //开始修改
    if(empty($_clean['password']))
    {
        _query("UPDATE tg_user SET  tg_sex='{$_clean['sex']}',
                                                            tg_face='{$_clean['face']}',
                                                            tg_email='{$_clean['email']}',
                                                            tg_qq='{$_clean['qq']}',
                                                            tg_url='{$_clean['url']}'
                                                            WHERE
                                                             tg_username='{$_COOKIE['username']}'
    ");
    }
    else 
    {
        _query("UPDATE tg_user SET tg_password='{$_clean['password']}',
        tg_sex='{$_clean['sex']}',
        tg_face='{$_clean['face']}',
        tg_email='{$_clean['email']}',
        tg_qq='{$_clean['qq']}',
        tg_url='{$_clean['url']}'
        WHERE
        tg_username='{$_COOKIE['username']}'
 ");
    }
    }
    //判断修改是否成功
    if (_affected_rows()==1){
        _close();
      //  _session_destroy();
        _location('恭喜你,修改成功', 'member.php');
        
    }
    else {
        _close();
      //  _session_destroy();
        _location('资料没有变化',  'member_modify.php');
    }
}
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
        $_html=_html($_html);
//性别选择
         if($_html['sex']=='男')
         {
             $_html['sex_html']='<input type="radio" name="sex" value="男"checked="checked">男<input type="radio" name="sex" value="女">女';
         }
         elseif ($_html['sex']=='女')
         {
             $_html['sex_html']='<input type="radio" name="sex" value="男">男<input type="radio" name="sex" value="女" checked="checked">女';
         }
        //头像选择
        $_html['face_html']='<select name="face">';
         foreach (range(1,8) as $_num)
         {
             $_html['face_html'].='<option value="face/0'.$_num.'.jpg">face/'.$_num.'.jpg</option>';
         }
         $_html['face_html'].='</select>';
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

<script type="text/javascript" src="javascript/code.js"></script>
<script type="text/javascript" src="javascript/member_modify.js"></script>
</head>
<body>
	<?php 
	require ROOT_PATH.'includes/header.inc.php';
	?>
	<div id="member">
		<?php  require ROOT_PATH.'includes/member.inc.php';?>
		<div id="member_main">
			<h2>会员管理中心</h2>
			<form name="modify" action="member_modify.php?action=modify"  method="post">
			<dl>
			<dd>用 户 名:<?php echo $_html['username']?></dd>
			<dd>密		码:<input type="password" class="text" name="password"></dd>
			<dd>性		别:<?php echo $_html['sex_html']?></dd>
			<dd>头		像:<?php echo $_html['face_html']?></dd>
			<dd>电子邮件:<input type="text"  name="email" class="text"value="<?php echo $_html['email']?>"></dd>
			<dd>主		页:<input type="text"  name="url" class="text" value="<?php echo $_html['url']?>"></dd>
			<dd>Q		Q:<input type="text"  name="qq" class="text"  value="<?php echo $_html['qq']?>"></dd>
			<dd>验&nbsp&nbsp证&nbsp&nbsp码:<input type="text" name="yzm" class="text yzm" ><img src="code.php" id="code"></dd>
			<dd><input type="submit" class="submit" value="修改资料"></dd>
			</dl>
			</form>
		</div>

	</div>
	
	
<?php 
require ROOT_PATH.'includes/footer.inc.php';

?>

</body>
</html>