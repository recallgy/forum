<?php
/**
*TestGuest Version1.0
*=========================================
*copy 2017
*=======================================
*Author:Recall
*Date:2017年12月19日
*/
session_start();
define('IN_TG', True);
define('CSS', 'member_message_detail');
require dirname(__FILE__).'/includes/common.inc.php';
//判断是否登陆
if(!isset($_COOKIE['username']))
{
    _alert_back('请先登录!');
}

//删除短信模块

    if($_GET['action']=='delete'&&isset($_GET['id']))
    {
        //验证短信的合法
        if(!!$_rows=_fetch_array(_query("SELECT tg_id FROM tg_message WHERE tg_id='{$_GET['id']}'")))
        {
            //对唯一标识符进行验证
            if(!!$_rows2=_fetch_array(_query("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1")))
            {
                //防止cookie伪造,比对唯一标识符
                _uniqid($_rows2['tg_uniqid'], $_COOKIE['uniqid']);
                //删除单条短信
                _query("DELETE FROM tg_message WHERE tg_id='{$_GET['id']}'  LIMIT 1");
            
                if (_affected_rows()==1){
                    _close();
                    _location('删除成功', 'member_message.php');
                    
                }
                else {
                    _close();
                 //   _session_destroy();
                    _location('删除失败', 'member_message.php');
                }
            }
            else {
                _alert_back('非法登陆');
            }
        } 
        else {
                _alert_back('此短信不存在');
            } 
}

//处理id
if(isset($_GET['id']))
{
     $_rows=_fetch_array(_query("SELECT * FROM tg_message WHERE tg_id='{$_GET['id']}'"));
    if($_rows)
    {
        //将state状态设置为1
        if(empty($_rows['tg_state']))
        {
            _query("UPDATE tg_message SET tg_state=1 WHERE tg_id='{$_GET['id']}'");
            if(!_affected_rows()==1)
            {
                _alert_back('异常');
            }
        }
        $_html=array();
        $_html['id']=$_rows['tg_id'];
        $_html['fromuser']=$_rows['tg_fromuser'];
        $_html['content']=$_rows['tg_content'];
        $_html['date']=$_rows['tg_date'];
        $_html=_html($_html);
 
    }
    else 
    {
        _alert_back('此短信不存在');
    }

}
else {
    _alert_back('非法登陆');
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>短信查询界面</title>
		<?php 
require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="javascript/member_message_detail.js"></script>
</head>
<body>
	<?php 
	require ROOT_PATH.'includes/header.inc.php';
	?>
	<div id="member">
		<?php  require ROOT_PATH.'includes/member.inc.php';?>
		<div id="member_main">
			<h2>短信内容</h2>
			<dl>
			<dd>发信人:<?php echo$_html['fromuser']?></dd>
			<dd>内	 容:<strong><?php echo$_html['content']?></strong></dd>
			<dd>发信时间:<?php echo$_html['date']?></dd>
			<dd class="button"><input type="button"  value="返回列表"  id="return"><input type="button"  name="<?php echo $_html['id']?>"   value="删除短信" id="delete"></dd>
			
			</dl>
			</div>
			</div>
			
			
			<?php 
require ROOT_PATH.'includes/footer.inc.php';

?>

</body>
</html>