/**
 * 
 */


window.onload=function()
{
	var img=document.getElementsByTagName('img'); 
	for(i=0;i<img.length;i++)
	{
		img[i].onclick=function()
		{
			_opener(this.src);
		}
	}
}
function _opener(src)
{	
	window.opener.document.getElementById('faceimg').src=src;
	//	window.opener.document.reg.facetext.value = src;
	var textvalue=window.opener.document.getElementsByClassName('facetext');
	textvalue[0].value=src;
}

