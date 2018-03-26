<?php
/**
*TestGuest Version1.0
*=========================================
*copy 2017
*=======================================
*Author:Recall
*Date:2017年11月18日
*/
if (!defined('IN_TG')){
    exit('Access Defined');
}
/*
 * 连接服务器
 */

function _connect()
{   
    $GLOBALS['con']=mysqli_connect(DB_HOST,DB_USER,DB_PWD);
    if(!$GLOBALS['con']){
        exit('数据库连接失败');
    }
}
/*
 * 选择数据库
 */
function  _select_db()
{
    if(!mysqli_select_db($GLOBALS['con'],DB_NAME))
    {
        exit('找不到指定数据库');
    }
    
}
/**
 * 设置字符集
 */
function _set_names(){
    $_query='SET NAMES UTF8';
    
    if(!mysqli_query($GLOBALS['con'], $_query))
    {
        exit('字符集错误');
    }
}

function  _query($_sql){
    if(!$_result=mysqli_query($GLOBALS['con'], $_sql))
    {
       exit('SQL执行失败'.mysqli_error($GLOBALS['con']));
    }
    else {
    return $_result;
}
}
 
function _num_rows($_result)
{
    return mysqli_num_rows($_result);
}
/**
 * 销毁结果集
 * @param unknown $_string
 */
function _free_result($_string)
{
    mysqli_free_result($_string);
}

function _fetch_array($_result){
   return  mysqli_fetch_array($_result);
}

function  _is_repeat($_sql,$_info)
{
    if(_fetch_array(_query($_sql)))
    {
        _alert_back($_info);
    }
}

function _close()
{
    if(!mysqli_close($GLOBALS['con']))
        exit('数据库关闭异常');
}
/*
 * 返回此次操作影响到的数据库表行数
 */
function _affected_rows(){
    return mysqli_affected_rows($GLOBALS['con']);
}

?>