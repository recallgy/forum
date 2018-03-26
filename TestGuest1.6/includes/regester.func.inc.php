<?php

/**
*TestGuest Version1.0
*=========================================
*copy 2017
*=======================================
*Author:Recall
*Date:2017年11月13日
*/


if (!defined('IN_TG')){
    exit('Access Defined');
}

function _check_content($_string)
{
    if(mb_strlen($_string,'utf-8')<10||mb_strlen($_string,'utf-8')>200)
    {
        _alert_back('短信不得小于10位或者大于200位');
    }
    return $_string;
}


if(!function_exists('_alert_back'))
{
    exit('_alert_back()函数不存在，请检查！');
}
/**
 * @access public
 * @param string $_first_uniqid
 * @param string $_end_uniqid
 * @return string
 */
function  _check_uniqid($_first_uniqid,$_end_uniqid){
    if(strlen($_first_uniqid)!=40||($_first_uniqid!=$_end_uniqid))
    {
        _alert_back('唯一标识符异常');
    }
    return  mysqli_real_escape_string($GLOBALS['con'],$_first_uniqid); 
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
    $_char_pattern='/select|insert|update|CR|document|LF|eval|delete|script|alert|\'|\/\*|\#|\--|\ --|\/|\*|\-|\+|\=|\~|\*@|\*!|\$|\%|\^|\&|\(|\)|\/|\/\/|\.\.\/|\.\/|union|into|load_file|outfile|\ /';
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

/**
 * 
 * @access public
 * @param string $_string
 * @return NULL|string
 */

function _check_url($_string)
{
    if(empty($_string)||$_string=='http://')
    {
        return null;
    }
    else{
        if(!preg_match('/^http(s)?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/', $_string))
        {
            _alert_back('网址不正确');
        }
    }
    return $_string;
}

function  _check_qq($_string)
{
    if(empty($_string))
    {
        return null;
    }
    else {
        if(!preg_match('/^[1-9]{1}[0-9]{4,9}$/',$_string))
        {
            _alert_back('qq号码不正确');
        }
    }
    return $_string;
}

/**
 * _check_email()检测邮箱是否合法
 * @access public
 * @param string $_string
 * @return string 验证后的邮箱
 */
function  _check_email($_string){

      if(!preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/', $_string)){
        
        _alert_back('邮件格式不正确！');
    }   
    
    return $_string;
}

function _check_answer($_ques,$_answ)
{
    $_answ=trim($_answ);
    //密码提示与回答不能一致
    if($_ques==$_answ)
        _alert_back('密码提示与回答不能一致');
    
        
        return  sha1($_answ);
}
/**
 * 
 * _check_question 返回密码提示
 * @param string $_string
 * @return string
 */
function  _check_question($_string)
{
    $_string=trim($_string);
    return mysqli_real_escape_string($GLOBALS['con'],$_string);
}

function _check_sex($_string)
{
    return  mysqli_real_escape_string($GLOBALS['con'],$_string);
}

/**
 * 
 * @param string $_string
 * @return string
 */
function _check_face($_string)
{
    return  mysqli_real_escape_string($GLOBALS['con'],$_string);
}

/**
 * _check_password 验证密码
 * @access public
 * @param string $_first_pass
 * @param string $_end_pass
 * @param int $_min_num
 * @return string $_first_pass
 */
function  _check_password($_first_pass,$_end_pass,$_min_num){
    if(strlen($_first_pass)<$_min_num)
    {
        _alert_back('密码不得小于'.$_min_num.'位!');
    }
    if($_first_pass!=$_end_pass)
    {
        _alert_back('密码和确认密码不一致！');
    }
    return sha1($_first_pass);
}

function _check_modify_password($_string,$_min_num)
{
    if(!empty($_string))
    {
    if(strlen($_string)<$_min_num)
    {
        _alert_back('密码不得小于'.$_min_num.'位!');
    }
    return sha1($_string);
}
else 
{
    return null;
}
    
}


function _check_post_title($_string,$_min,$_max)
{
    if(mb_strlen($_string,'utf-8')<$_min||mb_strlen($_string,'utf-8')>$_max)
    {
        _alert_back('帖子标题不得小于'.$_min.'位或者大于'.$_max.'位');
    }
    return $_string;
}

function _check_post_content($_string,$_num)
{
    if(mb_strlen($_string,'utf-8')<$_num)
    {
        _alert_back('帖子标题不得小于'.$_num.'位');
    }
    return $_string;
}
?>