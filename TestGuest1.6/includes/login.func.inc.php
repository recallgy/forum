<?php
/**
*TestGuest Version1.0
*=========================================
*copy 2017
*=======================================
*Author:Recall
*Date:2017年11月22日
*/
if (!defined('IN_TG')){
    exit('Access Defined');
}
if(!function_exists('_alert_back'))
{
    exit('_alert_back()函数不存在，请检查！');
}
/**
 * 生成登录cookies
 * @param unknown $_username
 * @param unknown $_uniqid
 */
function  _setcookies($_username,$_uniqid,$_time)
{
    
    switch ($_time)
    {
        case '0'://浏览器进程
            setcookie('username',$_username);
            setcookie('uniqid',$_uniqid);
            break;
        case '1'://一天
            setcookie('username',$_username,time()+86400);
            setcookie('uniqid',$_uniqid,time()+86400);
            break;
        case '2'://一周
            setcookie('username',$_username,time()+604800);
            setcookie('uniqid',$_uniqid,time()+604800);
            break;
        case '3':
            setcookie('username',$_username,time()+259230);
            setcookie('uniqid',$_uniqid,time()+259230);
            break;
    }
}
/**
 * 该函数用于过滤用户名
 * @access public
 * @return string
 * @param string $_string
 * @param int $_min_num
 * @param int $_max_num
 * @return unknown
 */
function _check_username($_string,$_min_num,$_max_num)
{
    $_string=trim($_string);
    
    //限制敏感字符
    $_char_pattern='/select|insert|update|CR|document|LF|eval|delete|script|alert|\'|\/\*|\#|\--|\ --|\/|\*|\-|\+|\=|\~|\*@|\*!|\$|\%|\^|\&|\(|\)|\/|\/\/|\.\.\/|\.\/|union|into|load_file|outfile|\ |\     /';
    if(preg_match($_char_pattern, $_string))
    {
        _alert_back('用户名不得包含敏感字符！');
    }
    //限定用户名长度大于2位小于20
    if(mb_strlen($_string,'utf-8')<2||mb_strlen($_string,'utf-8')>20)
    {
        _alert_back('长度不能小于'.$_min_num.'或者大于'.$_max_num.'！');
    }
    //将用户名转义后返回
    return mysqli_real_escape_string($GLOBALS['con'],$_string);
}


function  _check_password($_string,$_min_num){
    if(strlen($_string)<$_min_num)
    {
        _alert_back('密码不得小于'.$_min_num.'位!');
    }
    return sha1($_string);
}

function _check_time($_string){
    return mysqli_real_escape_string($GLOBALS['con'], $_string);
}
?>