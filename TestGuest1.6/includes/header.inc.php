<?php
/**
*TestGuest Version1.0
*=========================================
*copy 2017
*=======================================
*Author:Recall
*Date:2017年10月28日
*/

if (!defined('IN_TG')){
    exit('Access Defined');
}

?>
<div id="header">
		<h1><a href="index.php">RecallGY练手</a></h1>
		<ul>
			<li><a href="index.php">首页</a></li>

			<?php 
			     if(isset($_COOKIE['username']))
			     {
			         echo '<li><a href="member.php">'.$_COOKIE['username'].'·个人中心</a></li>';
			     }
			     else {
			         echo '<li><a href="RegesterPage.php">注册</a></li>';
			         echo "\n";
			         echo "\t\t";
			         echo '<li><a href="login.php">登录</a></li>';
			         echo "\n";
			     }
			?>
			<li><a href="blog.php">博友</a></li>
			<li>风格</li>
			
			<?php 
			if (isset($_COOKIE['username'])&&isset($_SESSION['admin']))
			{
			    echo '<li><a href="manage.php">管理 </a></li> ';
			}
			
			
			
			
			
			if(isset($_COOKIE['username']))
			{
			    echo '<li><a href="logout.php">退出</a></li>';
			}
			?>
			
		</ul>
	</div>