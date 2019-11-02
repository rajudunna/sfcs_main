//validation for numeric values in barcode input
function validateQty(e,t) 
    {
        // if(e.keyCode == 13)
        //         return;
        //     var p = String.fromCharCode(e.which);
        //     var c = /^[0-9]*\.?[0-9]*$/;
        //     var v = document.getElementById(t.id);
        //     if( !(v.value.match(c)) && v.value!=null ){
        //         v.value = '';
        //         return false;
        //     }
        //     return true;
    }
//validation for no of reasons and reason quantities
function validateQty1(e,t) 
	{
		//console.log(e.Keycode);
		if(e.keyCode == 13)
				return;
			var p = String.fromCharCode(e.which);
			var c = /^[0-9]+$/;
			var v = document.getElementById(t.id);
			
			if( !(v.value.match(c)) && v.value!=null ){
				v.value = '';
				return false;
			}
			return true;
    }
//valudation for reasons cummulative
function validating_cumulative(e,t)
    {  
            var result = 0;
            $('input[name="quantity[]"]').each(function(){
                if(isNaN($(this).val()))
                {
                    $(this).val('');
                }
                else
                {
                    result += Number($(this).val());
                }
            });
			// alert(result);
            if(result>0){
                 $('#footer').show();
				 $('#rej_id').val(result);
            }else{
                $('#footer').hide();
            }
                   
    }

//mandatory validations for rejection reasons in modal
$('#rejec_reasons').on('click', function(){
	var qty_data = [];
    var reason_data = [];
    //console.log(reason_data);
    //console.log(qty_data);

	var id = $('#changed_rej_id').val();
	
	$('input[name="quantity[]"]').each(function(key, value){
		//console.log($(this).val());
		if($(this).val() != '') {
			qty_data.push($(this).val());
		}
	});
	$('select[name="reason[]"]').each(function(key, value){
		if($(this).val() != '') {
			reason_data.push($(this).val());
		}
	});
	if(qty_data.length == reason_data.length && $('#reason').val() > 0){
		$('#'+id+'qty_data').val(qty_data);
		$('#'+id+'reason_data').val(reason_data);
		$('#'+id+'tot_reasons').val($('input[name="no_reason"]').val());
        $('#myModal').modal('toggle');
        var reject_data = reason_data.reduce((acc, value, i) => (acc[value] = qty_data[i], acc), {});
        console.log(reject_data);
        //$("#rej_data").val("hello");
        var controllerElement = document.querySelector('[ng-controller="scanctrl"]');
        var scope = angular.element(controllerElement).scope();
        scope.$apply(function () {
            scope.rej_data = reject_data;
        });
        
		//$('#'+id+'rejections').prop('readonly', true);
	}else{
		sweetAlert('','Please Fill all details in form','error');
	}
	// console.log($('#'+id+'qty_data').val());
	// console.log($('#'+id+'reason_data').val());
	//console.log(reject_data);
})    

function neglecting_function()
    {
        $('#rej_id').val(0);
        $('#reason').change();
    }


//onchange popup for rejection
$("#reason").change(function(){
    
	$('#rej_id').val(0);
    var tot = $('#rej_id').val();
	var result = $('#reason').val();;
	// if(Number(result) > Number(tot))
	// {
		// sweetAlert("","No. Of reasons should not greater than bundle eligible quantity","error");
        // $('#reason').val(0);
        // $('#reason').change();
	// }
	// else
	// {
		$("#tablebody").html('');
		var res = $("#reason").val();
		for(var i=1;i<=res;i++)
		{
			html_markup = "<tr><td>"+i+"</td>"+$('#repeat_tr').html()+"</tr>";
			// console.log(html_markup);
			$("#tablebody").append(html_markup);
		}
	// }
	validating_cumulative();
});

//validation for no of reasons and reason quantities
function validateQty1(e,t) 
	{
		//console.log(e.Keycode);
		if(e.keyCode == 13)
				return;
			var p = String.fromCharCode(e.which);
			var c = /^[0-9]+$/;
			var v = document.getElementById(t.id);
			
			if( !(v.value.match(c)) && v.value!=null ){
				v.value = '';
				return false;
			}
			return true;
	}

var app = angular.module('scanning_interface', []);
app.controller('scanctrl', function ($scope, $http, $window) {
    // a = this;
    $scope.barcode = '';
    $scope.url = '';
    $scope.user_permission = '';
    $scope.pass_id = '';
//$scope.rej_id = '';
    $scope.showtable = false;
    $scope.showscanlist = false;
    $scope.scanned_barcode_details = [];
    $scope.session_barcodes = [];
   
    $scope.shift = '';
    $scope.$watch('shift', function(shift){
        $scope.shift = shift;
    });
$scope.$watch('op_code', function(op_code){
        $scope.op_code = op_code;
    });
// $scope.$watch('seqno', function(seqno){
        // $scope.seqno = seqno;
    // });
    $scope.scanned = function(event){
       if(event.charCode == 13){
            $('#loading-image').show();
            if($scope.op_code != undefined)
            {
               $scope.last_barcode = $scope.barcode+'-'+$scope.op_code+'-'+$scope.seqno;
            }
            else
            {
                $scope.last_barcode = $scope.barcode;
            }
            console.log($scope.last_barcode);
            console.log($scope.pass_id);
            $scope.last_barcode_status = 'In-Progress';
            $scope.last_barcode_status_remarks = '';
            $scope.showtable = true;
            $('.bgcolortable').css("background-color", "white");
            if($scope.barcode != ''){
                if($scope.last_barcode.includes('-')){
                    var split = $scope.last_barcode.split('-');
                    if(split.length == 3){
                        var bundle_num = split[0];
                        var op_no = split[1];
						var seqno = split[2];
                        if (isNaN(bundle_num) || isNaN(op_no)){
                            //$('#barcode_scan').focus();
                            $('#loading-image').hide();
                            $scope.last_barcode_status = 'Error';
                            $scope.last_barcode_status_remarks = 'Please Check Barcode you scanned';
                            // swal({
                            //     title: "Error",
                            //     text: "Please Check Barcode you scanned",
                            //     timer: 1000
                            // });
                            // swal('Please Check Barcode you scanned.');
                            $scope.barcode = '';
                        }else{
                            var params = $.param({
                                auth: $scope.user_permission,
                                barcode: $scope.last_barcode,
                                shift: $scope.shift,
                                gate_id: $scope.pass_id,
								rej_id:$scope.rej_id,
								rej_data:$scope.rej_data,
                            });
                            var req = {
                                method: 'POST',
                                url: $scope.url,
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                                },
                                data: params
                            };
                            $http(req).then(function(response) {
                                console.log(response);
                                console.log(response.data.msg);
                                console.log(angular.isString(response.data));
                                if(response.data.status){
                                    $('#loading-image').hide();
                                    $scope.last_barcode_status = 'Not Done';
                                    $scope.last_barcode_status_remarks = response.data.status;
                                    $('.bgcolortable').css("background-color", "#d04d4d70");
                                    // swal({
                                    //     title: "Error",
                                    //     text: response.data.status,
                                    //     timer: 2000
                                    // });
                                    // swal(response.data.status);
                                }else{
                                    $scope.showscanlist = true;
                                    $scope.scanned_barcode_details.push({
                                        'data' : response.data,
                                    });
                                    $('#loading-image').hide();
                                    $scope.last_barcode_status = 'Completed';
                                    $scope.last_barcode_status_remarks = 'Bundle qty inserted.';
                                    console.log($scope.scanned_barcode_details);
                                    $('.bgcolortable').css("background-color", "#00800085");
									$scope.rej_id=0;
									$('#rej_id').val(0);
									$('#reason').val('');
									$scope.rej_data='';
									$("#tablebody").html('');
									$scope.rej_data=[];
									
                                }

                            });
                            $scope.barcode = '';
                        }

                    }else{
                        $scope.last_barcode_status = 'Error';
                        $scope.last_barcode_status_remarks = 'Please Check Barcode you scanned';
                        $('.bgcolortable').css("background-color", "#d04d4d70");
                        // swal({
                        //     title: "Error",
                        //     text: "Please Check Barcode you scanned",
                        //     timer: 1000
                        // });
                        $('#loading-image').hide();
                    }
                    $scope.showtable = true;

                }else{
                    // swal({
                    //     title: "Error",
                    //     text: "Please Check Barcode you scanned",
                    //     timer: 1000
                    // });
                    $scope.last_barcode_status = 'Error';
                    $scope.last_barcode_status_remarks = 'Please Check Barcode you scanned';
                    $('.bgcolortable').css("background-color", "#d04d4d70");
                    $('#loading-image').hide();
                }
                $scope.barcode = '';
                //$('#barcode_scan').focus();
            }else{
                $scope.last_barcode_status = 'Error';
                $scope.last_barcode_status_remarks = 'Please Check Barcode you scanned';
                $('.bgcolortable').css("background-color", "#d04d4d70");
                //$('#barcode_scan').focus();
                $('#loading-image').hide();

                // swal({
                //     title: "Error",
                //     text: "Please Check Barcode you scanned",
                //     timer: 1000
                // });
            }
        }

    }

   
});
angular.bootstrap($('#scanBarcode'), ['scanning_interface']);
