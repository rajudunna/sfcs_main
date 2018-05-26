function displayval() 
{
document.input.total.value = (parseInt(document.input.in_xs.value) + parseInt(document.input.in_s.value) + parseInt(document.input.in_m.value) + parseInt(document.input.in_l.value) + parseInt(document.input.in_xl.value) + parseInt(document.input.in_xxl.value) + parseInt(document.input.in_xxxl.value));
}

function dodisable()
{
enableButton();
document.input.tran_order_tid.style.visibility="hidden"; 
document.input.check_id.style.visibility="hidden"; 

}


function enableButton() 
{
	if(document.getElementById('option').checked)
	{
		document.getElementById('update').style.display='block';
	} 
	else 
	{
		document.getElementById('update').style.display='none';
	}
}

// function enableButton(){
// 	var elem = document.getElementById('update'),
//     checkBox = document.getElementById('option');
//     checkBox.checked = false;
//     checkBox.onchange = function doruc() {
//         elem.style.display = this.checked ? 'block' : 'none';
//     };
//     checkBox.onchange();
// }


window.onload = function() {
    var elem = document.getElementById('update'),
    checkBox = document.getElementById('option');
    checkBox.checked = false;
    checkBox.onchange = function doruc() {
        elem.style.display = this.checked ? 'block' : 'none';
    };
    checkBox.onchange();
};



