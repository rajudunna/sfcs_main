
	var ctrlPressed = false;
	$(document).keydown(function(evt) {
	  //if (evt.which == 17 || evt.which == 13) { 
	if (evt.which == 17) { 
	// ctrl
	    ctrlPressed = true;
		alert("This key has been disabled.");
	  }
	}).keyup(function(evt) {
	  if (evt.which == 17) { // ctrl
	    ctrlPressed = false;
	  }
	});
	
	$(document).click(function() {
	  if (ctrlPressed) {
	    // do something
		//alert("Test");
	  } else {
	    // do something else
	  }
	});