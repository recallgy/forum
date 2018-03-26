/**
 * 
 */

window.onload=function()
{
	code();
	//表单js客户端验证
	var fm=document.getElementsByTagName('form')[0];
	fm.onsubmit=function(){
		//密码验证
		if(fm.password.value!=''){
		if (fm.password.value.length<6) {
			alert('密码不得小于6位');
			fm.password.value='';
			fm.password.focus();
			return false;
		}
		
	}
		if (!/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test(fm.email.value)) {
			alert('邮件格式不正确');
			fm.email.value='';
			fm.email.focus();
			return false;
		}
		//qq验证
		if(fm.qq.value!=''){
		if (!/^[1-9]{1}[0-9]{4,9}$/.test(fm.qq.value)) {
			alert('qq号码格式不正确');
			fm.qq.value='';
			fm.qq.focus();
			return false;
		}
	}
		//个人主页验证
		if(fm.url.value!=''){
			if (!/^http(s)?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/.test(fm.url.value)) {
			alert('个人主页格式不正确');
			fm.url.value='';
			fm.url.focus();
			return false;
		}
	}
		//验证码验证
		if(fm.yzm.value.length!=4)
	{
		 	alert('验证码不正确');
			fm.yzm.value='';
			fm.yzm.focus();
			return false;
	}
		return true;
		
	}
	
	
}