//validation for numeric values in barcode input
function validateQty(e,t) 
    {
        if(e.keyCode == 13)
                return;
            var p = String.fromCharCode(e.which);
            var c = /^[0-9]*\.?[0-9]*$/;
            var v = document.getElementById(t.id);
            if( !(v.value.match(c)) && v.value!=null ){
                v.value = '';
                return false;
            }
            return true;
    }
//validation for no of reasons and reason quantities
function validateQty1(e,t) 
	{
		console.log(e.Keycode);
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
            var  tot = $('#changed_rej').val();
            if(result>0){

                if(Number(tot)>=Number(result))
                {
                    $('#footer').show();
                }
                else
                {
                    // sweetAlert('','Please Check Rejection Quantity','error');
                    $('#footer').hide();
                }
            }else{
                $('#footer').hide();
            }
                   
    }

//mandatory validations for rejection reasons in modal
$('#rejec_reasons').on('click', function(){
	var qty_data = [];
	var reason_data = [];
	var id = $('#changed_rej_id').val();
	
	$('input[name="quantity[]"]').each(function(key, value){
		console.log($(this).val());
		if($(this).val() != '') {
			qty_data.push($(this).val());
		}
	});
	$('select[name="reason[]"]').each(function(key, value){
		if($(this).val() != '') {
			reason_data.push($(this).val());
		}
	});
	// console.log($('input[name="no_reason"]').val());
	// console.log(qty_data);
	// console.log(reason_data);
	console.log($('#reason').val());
	if(qty_data.length == reason_data.length && $('#reason').val() > 0){
		$('#'+id+'qty_data').val(qty_data);
		$('#'+id+'reason_data').val(reason_data);
		$('#'+id+'tot_reasons').val($('input[name="no_reason"]').val());
		$('#myModal').modal('toggle');
		//$('#'+id+'rejections').prop('readonly', true);
	}else{
		sweetAlert('','Please Fill all details in form','error');
	}
	console.log($('#'+id+'qty_data').val());
	console.log($('#'+id+'reason_data').val());
	
})    

function neglecting_function()
    {
        $('#reason').val(0);
        $('#reason').change();
    }

$("#reason").change(function(){
	var tot = $('#changed_rej').val();
	var result = $('#reason').val();
	// console.log(tot);
	// console.log(result);
	if(Number(result) > Number(tot))
	{
		sweetAlert("","No. Of reasons should not greater than Bundle quantity","error");
		$('#reason').val(0);
	}
	else
	{
		$("#tablebody").html('');
		var res = $("#reason").val();
		for(var i=1;i<=res;i++)
		{
			html_markup = "<tr><td>"+i+"</td>"+$('#repeat_tr').html()+"</tr>";
			// console.log(html_markup);
			$("#tablebody").append(html_markup);
		}
	}
	
});

var app = angular.module('scanning_interface_new', []);
app.controller('scancode_ctrl', function ($scope, $http, $window) {
    $scope.barcode_value = '';
    $scope.module = '';
    $scope.op_code = '';
    $scope.tran_mode = '';
    $scope.url = '';

    this.showModal = false;
    this.showView = false;
    this.counter = 1;
    this.toggleDialog = function () {
        this.showModal = !this.showModal;
    }
    this.toggleView = function () {
        this.showView = !this.showView;
    }
    this.changeDisplay = function () {
        this.counter++;
    }

    $scope.scanned = function(){
        $('#loading-image').show();
        // alert($scope.barcode_value);
        // $scope.barcode=$scope.barcode_value;
        $http({
            method: 'POST',
            url: $scope.url,
            data: $.param({
                barcode_info: $scope.barcode_value
            }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (data, status, headers, config) {
            var validate_barcode=data.validate_barcode;
            if(validate_barcode>0){
                $scope.style=data.style.trim();
                $scope.color=data.color.trim();
                $scope.changed_rej=data.original_qty;
                $scope.schedule= data.schedule;
                $scope.size_title= data.size_title;
                $scope.operation_name= data.operation_name;
                $scope.global_facility_code=data.global_facility_code;
                $scope.zfeature=data.zfeature;
                $scope.vpo=data.vpo;
                $scope.scanned_status="Please Proceed";

            }else{
                $scope.style="";
                $scope.color="";
                $scope.original_qty="";
                $scope.schedule="";
                $scope.size_title="";
                $scope.operation_name="";
                $scope.global_facility_code="";
                $scope.zfeature="";
                $scope.vpo="";
                $scope.scanned_status="Please Verify Barcode Once..!";
            }

        }).error(function (data, status, headers, config) {
            // handle error things
           
        });
    }


    $scope.barcode_submit = function(taskId){    
            $http({
                method: 'POST',
                url: $scope.url,
                data: $.param({
                    barcode_value: $scope.barcode_value,
                    module:$scope.module,
                    op_code: $scope.op_code,
                    trans_mode:$scope.trans_mode
                }),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (data, status, headers, config) {
                 //console.log(data)
            }).error(function (data, status, headers, config) {
                // handle error things
            });
    };
});
angular.bootstrap($('#scanned_barcode'), ['scanning_interface_new']);