function toast(message) {
    // Get the snackbar DIV
    var x = document.getElementById("snackbar")
    x.innerHTML = message;

    // Add the "show" class to DIV
    x.className = "show";

    // After 3 seconds, remove the show class from DIV
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

if(typeof instancesStatus !== 'undefined'  && instancesStatus == 1){
    toast("Instances are saved.");
}else if(typeof instancesStatus !== 'undefined'  && instancesStatus == 0){
    toast("Instances are not saved.");
}