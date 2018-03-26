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

header('Content-type:text/html;charset=utf-8;');

define('ROOT_PATH', substr(dirname(__FILE__),0,-8));

if (PHP_VERSION<'4.1.0')
{
    exit('Version is too low');
}

require 'mysql.inc.php';

//引入核心函数库
require ROOT_PATH.'includes/global.func.php';
require ROOT_PATH.'includes/mysql.func.php';


//执行耗时
define('START_TIME', _runtime());


define('DB_USER', 'root');
define('DB_PWD', 'VIVyu5suYdETHm8e');
define('DB_HOST', 'localhost');
define('DB_NAME', 'testguest');
//初始化数据库
_connect();
_select_db();
_set_names();

// //短信提醒模块
// $_message=_fetch_array(_query("SELECT COUNT (tg_id) AS t FROM tg_message"));


        //网站系统设置初始化
if(!!$_rows=_fetch_array(_query("SELECT * FROM tg_system WHERE tg_id=1 LIMIT 1")))
{
    $_system=array();
    $_system['webname']=$_rows['tg_webname'];
    
    $_system=_html($_system);
}else {
    exit('系统表异常，请检查');
}









?>