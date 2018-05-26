// Popup window function
function basicPopup(url,title) {
	//var popupWindow = window.open(url,'POPUP','height='+(screen.height-200)+',width='+(screen.width-200)+',left=100,top=100,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no, status=no, fullscreen=no');
	
    if (title === undefined) hostname = "POPUP";

	var popupWindow = window.open(url,title,'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, height='+(screen.height-200)+',width='+(screen.width-200)+',left=100,top=23');
    popupWindow.document.title = 'FSP RM Forecast '+title;
    popupWindow.focus();
	/*
	var popup = window.open(url, "POPUP", 
	    "menubar=0,location=0,toolbar=0,status=0,directories=0,resizable=yes,scrollbars=yes,width=" + screen.width-100 + ",height=" + screen.height-100);
		*/
	//popupWindow.moveTo(0, 0); 
	
	if (window.focus) {
		popupWindow.focus();
	}
	
	return false;

}