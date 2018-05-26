function displayval() 
{
document.input.total.value = (parseInt(document.input.in_xs.value) + parseInt(document.input.in_s.value) + parseInt(document.input.in_m.value) + parseInt(document.input.in_l.value) + parseInt(document.input.in_xl.value) + parseInt(document.input.in_xxl.value) + parseInt(document.input.in_xxxl.value));
}

function dodisable()
{
enableButton();
document.input.tran_order_tid.style.visibility="hidden"; 
}


function enableButton() 
{
	if(document.getElementById('option').checked)
	{
		document.getElementById('update').disabled ='';
	} 
	else 
	{
		document.getElementById('update').disabled='true';
	}
}



