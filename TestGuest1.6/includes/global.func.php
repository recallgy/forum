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
 * 登录状态判断
 */
function _login_state()
{
    if(isset($_COOKIE['username']))
    {
        _alert_back('登录状态无法进行本操作');
    }
}
/**
 * 判断唯一标识符是否异常
 * @param unknown $_mysql_uniqid
 * @param unknown $_cookie_uniqid
 */
function _uniqid($_mysql_uniqid,$_cookie_uniqid)
{
    if($_mysql_uniqid!=$_cookie_uniqid)
    {
        _alert_back('唯一标识符异常!');
    }
}

function _manage_login()
{
    if((!isset($_COOKIE['username']))||(!isset($_SESSION['admin'])))
    {
        _alert_back('非法登陆');
    }
}

/**
 * 此函数表示对字符串进行html过滤显示，分数组方式和单独字符串方式
 * @param array or string $_string
 * @return string
 */
function  _html($_string)
{
    if(is_array($_string))
    {
        foreach ($_string as $_key=>$_value)
        {
            $_string[$_key]=_html($_value);
        }
    }
    
        else{
            $_string=htmlspecialchars($_string);
    }  
        return $_string;
}

function _mysql_string($_string)
{
   if (!GPC)
    {
//          return mysqli_real_escape_string($GLOBALS['con'], $_string);
//     }
    if(is_array($_string))
    {
        foreach ($_string as $_key=>$_value)
        {
            $_string[$_key]=_mysql_string($_value);
        }
    }
    else{
        $_string=mysqli_real_escape_string($GLOBALS['con'], $_string);
    }  
    }
    return $_string;
}

function _page($_sql,$_size)
{
    global $_pagesize,$_pagenum,$_pageabsolute,$_num,$_page;
    if(isset($_GET['page']))
    {
        $_page=$_GET['page'];
        if(empty($_page||$_page<=0||!is_numeric($_page)))
        {
            $_page=1;
        }
        else
        {
            $_page=intval($_page);
        }
    }
    else {
        $_page=1;
    }
    $_pagesize=$_size;
    $_num=_num_rows(_query($_sql));
    if($_num==0)
    {
        $_pageabsolute=1;
    }
    else
    {
        $_pageabsolute=ceil($_num/$_pagesize);
    }
    if($_page>$_pageabsolute)
    {
        $_page=$_pageabsolute;
    }
    $_pagenum=($_page-1)*$_pagesize;
    
}

/**
 * _titlecontent截取
 * @param unknown $_string
 * @return string
 */
function _title($_string,$_strlen)
{
    if(mb_strlen($_string,'utf-8')>$_strlen)
    {
        $_string=mb_substr($_string, 0,$_strlen,'utf-8').'...';
        
    }
    return $_string;
}

/**
 * 分页函数
 * @param int $_type
 */
function _paging($_type)
{
    global $_pageabsolute,$_page,$_num,$_id;
    if($_type==1)
    {
       echo '<div id="page_num">';
       echo '<ul>';
         for($i=0;$i<$_pageabsolute;$i++){
            if($_page==($i+1))
            {
                echo '<li><a href="'.CSS.'.php?'.$_id.'page='.($i+1).'" class="selected">'.($i+1).'</a></li>';
            }
            else {
                echo '<li><a href="'.CSS.'.php?'.$_id.'page='.($i+1).'">'.($i+1).'</a></li>';
            }
        }
		echo'</ul>';
	 echo '</div>';
    }
    elseif ($_type==2)
    {
       echo '<div id="page_text">';
	echo '<ul>';
	echo '<li>'. $_page.'/'. $_pageabsolute.'页</li>';
	echo '<li>|共有<strong>'. $_num.'</strong>条数据</li>';
	if($_page==1)
	{
	    echo '<li>|首页|</li>';
	    echo '<li>上一页|</li>';
	}
	else {
	    echo '<li><a href="'.CSS.'.php">|首页|</a></li>';
	    echo '<li><a href="'.CSS.'.php?'.$_id.'page='.($_page-1).'">上一页|</a></li>';
	}
	if($_page==$_pageabsolute)
	{
	    echo '<li>下一页|</li>';
	    echo '<li>尾页</li>';
	}
	else {
	    echo '<li><a href="'.CSS.'.php?'.$_id.'page='.($_page+1).'">下一页|</a></li>';
	    echo '<li><a href="'.CSS.'.php?'.$_id.'page='.$_pageabsolute.'">尾页</a></li>';
	}
	echo '</ul>';
	echo '</div>';
    }else {
     _paging(2);
    }
}

/**
 * 跳转页面并弹窗
 * @param unknown $_info
 * @param unknown $_url
 */
function  _location($_info,$_url){
    echo "<script type='text/javascript'>alert('".$_info."');location.href='$_url';</script>";
    exit();
}

function  _check_code($_first_code,$_end_code)
{
    if($_first_code!=$_end_code)
    {
        _alert_back('验证码不正确！');
    }
}

function  _unsetcookies()
{
    setcookie('uniqid','',time()-1);
    setcookie('username','',time()-1);
    _session_destroy();
    header('Location:index.php');
   // _location(null, 'index.php');
    
}
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

function _sha1_uniqid()
{
    return mysqli_real_escape_string($GLOBALS['con'],sha1(uniqid(rand(),true)));
}
/**
 * 此函数位js弹窗函数
 * @param unknown $_info
 * @return void
 */
function _alert_back($_info)
{
    echo "<script type='text/javascript'>alert('".$_info."');history.back();</script>";
    exit();
}



/**
 * _code()是验证码函数
 * @access public
 * @return void 这个函数执行后产生验证码
 * @param int $_width 表示验证码宽度
 * @param int $_height 表示验证码长度
 * 
 */
function  _code($_width=75,$_height=25)
{
    
    for ($i=0;$i<4;$i++){
        $_nmsg.=dechex(mt_rand(0,15));
    }
    $_SESSION['code']=$_nmsg;
    
    
    $_img=imagecreatetruecolor($_width, $_height);
    
    $_white=imagecolorallocate($_img, 255, 255, 255);
    
    imagefill($_img, 0, 0, $_white);
    
    $_flag=false;
    if($_flag)
    {
        $_black=imagecolorallocate($_img, 0, 0, 0);
        
        imagerectangle($_img, 0, 0, $_width-1, $_height-1, $_black);
    }
    
    for ($i=0;$i<5;$i++)
    {
        $_rnd_color=imagecolorallocate($_img, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));
        imageline($_img, mt_rand(0,$_width), mt_rand(0,$_height), mt_rand(0,$_width), mt_rand(0,$_height), $_rnd_color);
    }
    
    for ($i=0;$i<15;$i++)
    {
        $_rnd_color=imagecolorallocate($_img, mt_rand(200,255), mt_rand(200,255), mt_rand(200,255));
        imagestring($_img, 1, mt_rand(1,$_width), mt_rand(1,$_height), '*', $_rnd_color);
    }
    
    for ($i=0;$i<strlen($_SESSION['code']);$i++)
    {
        $_rnd_color=imagecolorallocate($_img, mt_rand(0,111), mt_rand(0,111), mt_rand(0,111));
        imagestring($_img, mt_rand(3,5), $i*$_width/4+mt_rand(1,10), mt_rand(1,$_height/2), $_SESSION['code'][$i], $_rnd_color);
    }
    
    header('Content-Type:image/png');
    imagepng($_img);
    
    imagedestroy($_img);
}

function _alert_close($_info)
{
    echo "<script type='text/javascript'>alert('".$_info."');window.close();</script>";
    exit();
}

/*
 * 
 */
function  _session_destroy()
{
    if(session_start()){
    session_destroy();
    
    }
}
?>