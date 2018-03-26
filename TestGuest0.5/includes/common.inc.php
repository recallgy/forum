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
define('ROOT_PATH', substr(dirname(__FILE__),0,-8));

if (PHP_VERSION<'4.1.0')
{
    exit('Version is too low');
}

//引入核心函数库
require ROOT_PATH.'includes/global.func.php';


//执行耗时
define('START_TIME', _runtime());






?>