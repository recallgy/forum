/**
 * 
 */
window.onload=function()
{
	code();
	var faceimg=document.getElementById('faceimg');
	faceimg.onclick=function()
	{
		window.open('face.php','_blank');
	}
	
//	var yzmimg=document.getElementById('code');
//	yzmimg.onclick=function()
//	{
//		this.src='code.php';
//	}
	//表单js客户端验证
	var fm=document.getElementsByTagName('form')[0];
	fm.onsubmit=function(){
	//用户名验证
	if(fm.username.value.length<2||fm.username.value.length>20)
	{
		alert('用户名不得小于两位或者大于20位');
		fm.username.value='';
		fm.username.focus();
		return false;
	}
	if (/[<>\'\"\ \	]/.test(fm.username.value)) {
		alert('用户名不得包含非法字符');
		fm.username.value='';
		fm.username.focus();
		return false;
	}
	//密码验证
	if (fm.password.value.length<6) {
		alert('密码不得小于6位');
		fm.password.value='';
		fm.password.focus();
		return false;
	}
	if (fm.password.value!=fm.checkpassword.value) {
		alert('密码和密码确认不一致');
		fm.checkpassword.value='';
		fm.checkpassword.focus();
		return false;
	}
	//密码提示与回答验证
	if (fm.question.value.length<2||fm.question.value.length>20) {
		alert('密码提示不得小于两位或大于二十位');
		fm.question.value='';
		fm.question.focus();
		return false;
	}
	if (fm.answer.value.length<2||fm.answer.value.length>20) {
		alert('密码回答不得小于两位或大于二十位');
		fm.answer.value='';
		fm.answer.focus();
		return false;
	}
	if (fm.answer.value==fm.question.value) {
		alert('密码回答与密码提示不得相同');
		fm.answer.value='';
		fm.answer.focus();
		return false;
	}
	//邮箱验证
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


     




