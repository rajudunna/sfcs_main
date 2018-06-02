
function dodisable()
{
enableButton();
document.getElementById('process_message').style.visibility="hidden";
}


function enableButton() 
{
	if(document.getElementById('option').checked)
	{
		document.getElementById('update').disabled='';
	} 
	else 
	{
		document.getElementById('update').disabled='true';
	}
}

function button_disable()
{
	document.getElementById('process_message').style.visibility="visible";
	document.getElementById('option').style.visibility="hidden";
	document.getElementById('update').style.visibility="hidden";
}

function check(x,y)
{
	if(x<0)
	{
		alert("You cant enter a value less than 0");
		return 1010; 
	}
	if((x>y))
	{
		alert("Please enter correct Qty");
		return 1010; 
	}	
}


function check3(x,y)
{
	if(x<0)
	{
		alert("You cant enter a value less than 0");
		return 1010; 
	}
	if((x>y))
	{
		if(x==9999)
		{
			
		}
		else{
					alert("Please enter correct Qty");
			return 1010; 
		}
	}	
}

function check2(x,y)
{
	if(x<0)
	{
		alert("You cant enter a value less than 0");
		return 1010; 
	}
}