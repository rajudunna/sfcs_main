function getURL(basepath){
    if(basepath!=''){
        
    }
}

$(document).ready(function() {
    $('li.current-page').parent().css('display','block');
	$('li.current-page').parent().parent().parent().css('display','block');
    $('li.current-page').parent().parent().parent().parent().parent().css('display','block');
});

function validateQty(event) 
{
	event = (event) ? event : window.event;
	var charCode = (event.which) ? event.which : event.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57))
        {
		return false;
	}
	return true;
}









