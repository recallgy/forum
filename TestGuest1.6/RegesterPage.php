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
define('CSS', 'reg');

require dirname(__FILE__).'/includes/common.inc.php';

//登录状态判断
_login_state();


//注册页面提交后的数据接收
if($_POST['action']=='RegesterPage')
{
    //防止恶意注册，跨站攻击
    _check_code($_POST['yzm'],$_SESSION['code']);
    include  ROOT_PATH.'includes/regester.func.inc.php';
    
    //创建数组，存放提交的合法数据
    $_clean=array();
    //通过唯一标识符来防止恶意注册及攻击
    $_clean['uniqid']=_check_uniqid($_POST['uniqid'], $_SESSION['uniqid']);
    $_clean['active']=_sha1_uniqid();
    $_clean['username']=_check_username($_POST['username'],2,20);
    $_clean['password']=_check_password($_POST['password'],$_POST[checkpassword],6);
    $_clean['question']=_check_question($_POST['question']);
    $_clean['answer']=_check_answer($_POST['question'],$_POST['answer']);
    $_clean['email']=_check_email($_POST['email']);
    $_clean['qq']=_check_qq($_POST['qq']);
    $_clean['url']=_check_url($_POST['url']);
    $_clean['sex']=_check_sex($_POST['sex']);
    $_clean['face']=_check_face($_POST['facetext']);
    
    
_is_repeat("SELECT tg_username From tg_user WHERE tg_username='{$_clean['username']}'",'对不起此用户已被注册');
    _query("INSERT INTO tg_user(
                                                            tg_uniqid,
                                                            tg_active,
                                                            tg_username,
                                                            tg_password,
                                                            tg_question,
                                                            tg_answer,
                                                            tg_email,
                                                            tg_qq,
                                                            tg_url,
                                                            tg_sex,
                                                            tg_face,
                                                            tg_regtime,
                                                            tg_lasttime,
                                                            tg_lastip
                                                            ) 
                                             VALUES(
                                                            '{$_clean['uniqid']}',
                                                            '{$_clean['active']}',
                                                            '{$_clean['username']}',
                                                            '{$_clean['password']}',
                                                            '{$_clean['question']}',
                                                            '{$_clean['answer']}',
                                                            '{$_clean['email']}',
                                                            '{$_clean['qq']}',
                                                            '{$_clean['url']}',
                                                            '{$_clean['sex']}',
                                                            '{$_clean['face']}',
                                                             NOW(),
                                                             NOW(),
                                                             '{$_SERVER['REMOTE_ADDR']}'
                                                            )");
    if (_affected_rows()==1){
    _close();
 //   _session_destroy();
    //生成xml
    _location('恭喜你,注册成功', 'active.php?active='.$_clean['active']);
    
}
    else {
        _close();
     //   _session_destroy();
        _location('注册失败', 'RegesterPage.php');
    }
}
   $_SESSION['uniqid']=$_uniqid=_sha1_uniqid();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>注册页面</title>
<?php 
    require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="javascript/code.js">
</script>
<script type="text/javascript" src="javascript/regester.js">
</script>
</head>
<body>
	<?php 
	require ROOT_PATH.'includes/header.inc.php';
	?>
<div id="reg">
	<h2>会员注册</h2>
	<form method="post"  name="reg" action="RegesterPage.php">
	<input type="hidden" name="uniqid"  value=<?php echo $_uniqid?>>
	<input type="hidden"  name="action"value="RegesterPage">
		<dl>
			<dt>请认真填写下列内容</dt>
			<dd>用&nbsp户&nbsp名:<input type="text" name="username" class="text"> (必填，至少两位)</dd>
			<dd>密&nbsp&nbsp&nbsp&nbsp码:<input type="password" name="password" class="text"> (必填，至少六位)</dd>
			<dd>确认密码:<input type="password" name="checkpassword" class="text"> (必填，至少六位)</dd>
			<dd>密码提示:<input type="text" name="question" class="text"> (必填，至少两位)</dd>
			<dd>密码回答:<input type="text" name="answer" class="text"> (必填，至少两位)</dd>
			<dd>性	 别:<input type="radio" name="sex" value="男" checked="checked">男									<input type="radio" name="sex" value="女" >女</dd>
			<dd class="face">选择头像:<input type="hidden" name="facetext" value="face/01.jpg"  class="facetext"><img  src="face/01.jpg" alt="头像选择"  id="faceimg"></dd>
			<dd>电子邮件:<input type="text" name="email" class="text">(*必填)</dd>
			<dd>&nbsp&nbspQ&nbsp&nbspQ&nbsp&nbsp:<input type="text" name="qq" class="text"></dd>
			<dd>主页地址:<input type="text" name="url" class="text" value=""></dd>
			<dd>验&nbsp&nbsp证&nbsp&nbsp码:<input type="text" name="yzm" class="text yzm" ><img src="code.php" id="code"></dd>
			<dd><input type="submit" class="submit" value="注册"></dd>
		</dl>
		
	</form>
</div>

<?php 
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>