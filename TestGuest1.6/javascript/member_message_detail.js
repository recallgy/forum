/**
 * 
 */
window.onload=function()
{
	var ret=document.getElementById('return');
	var del=document.getElementById('delete');
	ret.onclick=function()
	{
		history.back();
	};
	del.onclick=function()
	{
		if(window.confirm('确认删除'))
			{
			location.href='member_message_detail.php?action=delete&id='+del.name;
			}
	}
	
	};