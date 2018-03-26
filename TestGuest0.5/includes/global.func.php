<?php
/**
*TestGuest Version1.0
*=========================================
*copy 2017
*=======================================
*Author:Recall
*Date:2017年10月28日
*/

/**
 * _runtime()是用来获取执行耗时的
 * @access public 
 * @return float
 */
function  _runtime()
{
$_mtime=explode(' ', microtime());
 return $_start_time=$_mtime[1]+$_mtime[0];
    
}

?>