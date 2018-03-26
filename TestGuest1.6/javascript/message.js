/**
 * 
 */

window.onload=function()
{
	code();
	var fm=document.getElementsByTagName('form')[0];
	fm.onsubmit=function()
	{
		//验证码验证
		if(fm.yzm.value.length!=4)
	{
		 	alert('验证码不正确');
			fm.yzm.focus();
			return false;
	}
		if (fm.content.value.length<10||fm.content.value.length>200) {
			alert('短信内容不得小于10位或大于200位');
			fm.password.focus();
			return false;
		}
	}
	}