function dodisable() {
    enableButton();
    enableButton1();
    document.getElementById('process_message').style.visibility = "hidden";

}

function dodisable() {

    enableButton();
    enableButton1();
    // document.getElementById('process_message').style.visibility="hidden";
}

function enableButton() {

    if (document.getElementById('option').checked) {
        document.getElementById('put').disabled = '';

    } else {
        document.getElementById('put').disabled = 'true';
    }

    if (document.getElementById('option').checked) {
        //document.getElementById('reject').disabled = '';
    } else {
        //document.getElementById('reject').disabled = 'true';
    }
}

function enableButton() {

    if (document.getElementById('option').checked) {
        document.getElementById('put').disabled = '';

    } else {
        document.getElementById('put').disabled = 'true';
    }

    if (document.getElementById('option').checked) {
        document.getElementById('reject').disabled = '';
    } else {
        document.getElementById('reject').disabled = 'true';
    }
}


function check(x, y) {
    if (x < 0) {
        sweetAlert("You cant enter a value less than 0", "", "info");
        return 1010;
    }
    if ((x > y)) {
        sweetAlert("Transfer Qty Must be Less Than Available Qty", "", "warning");
        return 1010;
    }
}

function check2(x) {
    if (x < 0) {
        sweetAlert("You cant enter a value less than 0", "", "info");
        return 1010;
    }
}

function roundNumber(num, dec) {
    var result = Math.round(num * Math.pow(10, dec)) / Math.pow(10, dec);
    return result;
}

function check3(x, y) {

    if (x < 0) {
        sweetAlert("You cant enter a value less than 0", "", "info");
        return 1010;
    }

    if (x > y) {
        sweetAlert("You cant enter more than available qty", "", "warning");
        return 1010;
    }


    for (var i = 0; i < document.test.convert.length; i++) {
        if (document.test.convert[i].checked) {
            var rad_val = document.test.convert[i].value;
        }
    }

    //alert(rad_val);
    if (rad_val == 2) {
        var sumx = 0;
        for (i = 0; i < 100; i++) {
            var temp = document.test["qty[" + i + "]"].value;
            //alert(temp);
            if (temp > 0) {
                //sumx = sumx + roundNumber((parseFloat(temp) / 0.9144), 2);
                sumx = sumx + roundNumber((parseFloat(temp)), 2);
            }
        }
    } else {
        var sumx = 0;
        for (i = 0; i < 100; i++) {
            var temp = document.test["qty[" + i + "]"].value;
            //alert(temp);
            if (temp > 0) {
                sumx = sumx + parseFloat(temp);
            }
        }
    }

    if (sumx > y) {
        sweetAlert("You cant enter more than available qty", "", "warning");
        return 1010;
    }

    document.getElementById('balance_new11').value = (y - sumx).toFixed(2);
}

function verify_dup_box_no(t) {
    var count = 0;
    var val = t.value;
    for (i = 0; i < 100; i++) {
        if (val == document.test["ref2[" + i + "]"].value && val.length > 0) {
            count++;
            if (count > 1) {
                sweetAlert('The box number is already entered', '', 'warning');
                t.value = '';
            }
        }
    }
}

function fill_sr() {
    var start = document.test.s_start.value;
    var x = parseInt(start);
    //alert(x);
    for (i = 0; i < 100; i++) {
        if (start == 9999) {
            document.test["ref2[" + i + "]"].value = "";
        } else {
            document.test["ref2[" + i + "]"].value = x;
        }
        x = x + 1;
    }
}

function clear_sr() {
    var available = document.getElementById('available').value;
    var fill_q = document.getElementById('auto_qty').value;
    var fill_r = document.getElementById('auto_rows').value;


    var tot = Number(fill_q) * Number(fill_r);

    var finalqty = Number(available) - Number(tot);
    //alert(available);
    document.getElementById('balance_new11').value = available;
    for (i = 0; i < 100; i++) {
        document.test["qty[" + i + "]"].value = " ";
    }
    document.getElementById('auto_qty').value = '0';
    document.getElementById('auto_rows').value = '0';
}

function button_disable() {
    if($('#selectsearch1').val() == 'Yes')
    {
        return;
    }


    var count = 0;
    for (i = 0; i < 100; i++) {
        if (Number(document.test["qty[" + i + "]"].value) <= 0)
            count++;
    }

    if (count == 100) {
        sweetAlert('Fill quantity must be greater than 0 ', '', 'warning');
        return false;
    }

    if (check_box_no()) {
        document.getElementById('process_message').style.visibility = "visible";
        document.getElementById('option').style.visibility = "hidden";
        document.getElementById('put').style.visibility = "hidden";
        document.getElementById('confirm').style.visibility = "hidden";
    } else {
        return false;
    }
}

// function check_box_no() {
//     var box = 0;
//     var qty = 0;
//     var count = 0;
//     var txt_msg = document.getElementById('label').value;
//     for (i = 0; i < 100; i++) {
//         box = document.test["ref2[" + i + "]"].value;
//         qty = document.test["qty[" + i + "]"].value;
//         if (Number(qty) > 0) {
//             if (box.length == 0) {
//                 count++;
//             }
//         }
//     }
//     console.log(count);
//     if (Number(count) > 0) {
//         sweetAlert('Please fill all ' + txt_msg + "'s", '', 'warning');
//         return false;
//     }
//     return true;
// }



function quantity(t) {

    var available = document.getElementById('available').value;
    var total = 0;
    var sumx = 0;
    var balance = parseFloat(document.getElementById('dummy_available').value);
    for (i = 0; i < 100; i++) {
        var temp = document.test["qty[" + i + "]"].value;

        total = Number(total) + Number(temp);
        if (Number(total) > Number(available)) {
            sweetAlert('Error!', 'The allocated quantity is exceeding available balance ', 'warning');
            t.value = '';
            for (i = 0; i < 100; i++)

                balance = Number(balance) - Number(document.test["qty[" + i + "]"].value);
            document.getElementById('balance_new11').value = balance.toFixed(2);
            document.getElementById('balance_new11_qty').value = balance.toFixed(2);
            return;
        }
        if (temp > 0) {
            sumx = sumx + parseFloat(temp);
        }
    }

    $total_qty = parseFloat(available) - parseFloat(sumx);
    if (available < sumx) {
        sweetAlert("Can't Fill excess Quantity", '', 'warning');
    }
    document.getElementById('balance_new11').value = $total_qty.toFixed(2);
    document.getElementById('balance_new11_qty').value = $total_qty.toFixed(2);
}




function fill_vsr() {
    var available = document.getElementById('available').value;
    var fill_q = document.getElementById('auto_qty').value;
    var fill_r = document.getElementById('auto_rows').value;
    var tot = Number(fill_q) * Number(fill_r);

    if (Number(available) < Number(tot)) {
        sweetAlert('Error!', 'The allocating quantity is more than available balance', 'warning');
        document.getElementById('auto_rows').value = 0;
        return;
    }

    var finalqty = Number(available) - Number(tot);
    //alert(available);
    for (i = 0; i < 100; i++) {
        document.test["qty[" + i + "]"].value = " ";
    }
    document.getElementById('balance_new11').value = finalqty.toFixed(2);

    for (var i = 0; i < document.test.convert.length; i++) {
        if (document.test.convert[i].checked) {
            var rad_val = document.test.convert[i].value;

        }
    }

    //alert(rad_val);
    if (rad_val == 2) {
        var sumx = 0;
        for (i = 0; i < 100; i++) {
            var temp = document.test["qty[" + i + "]"].value;
            //alert(temp);
            if (temp > 0) {
                //sumx = sumx + roundNumber((parseFloat(temp) / 0.9144), 2);
                sumx = sumx + roundNumber((parseFloat(temp)), 2);
            }
        }

        //var new_qty = roundNumber(parseFloat((fill_q * fill_r) / 0.9144), 2);
        var new_qty = roundNumber(parseFloat((fill_q * fill_r)), 2);
    } else {
        var sumx = 0;
        for (i = 0; i < 100; i++) {
            var temp = document.test["qty[" + i + "]"].value;
            //alert(temp);
            if (temp > 0) {
                sumx = sumx + parseFloat(temp);
            }
        }
        //alert(sumx);
        var new_qty = parseFloat(fill_q * fill_r);
    }

    // alert(sumx);
    // alert(new_qty);
    // alert(available);
    if (sumx + new_qty > available) {
        sweetAlert("Can't Fill excess Quantity", '', 'warning');
        if (finalqty < 0) {
            finalqty = available;
        }
        document.getElementById('balance_new11').value = available;
        document.getElementById('auto_qty').value = '0';
        document.getElementById('auto_rows').value = '0';
    } else {
        for (i = 0; i < 100; i++) {
            var temp = document.test["qty[" + i + "]"].value;
            //alert(temp);
            if (temp > 0) {

            } else {
                for (j = 1; i < fill_r; j++) {
                    document.test["qty[" + i + "]"].value = fill_q;
                    i++;
                }
                break;
            }
        }
    }
}