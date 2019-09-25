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
	// console.log($('input[name="no_reason"]').val());
	// console.log(qty_data);
	// console.log(reason_data);
	// console.log($('#reason').val());
	if(qty_data.length == reason_data.length && $('#reason').val() > 0){
		$('#'+id+'qty_data').val(qty_data);
		$('#'+id+'reason_data').val(reason_data);
		$('#'+id+'tot_reasons').val($('input[name="no_reason"]').val());
        $('#myModal').modal('toggle');
        var reject_data = reason_data.reduce((acc, value, i) => (acc[value] = qty_data[i], acc), {});
        console.log(reject_data);
        //$("#rej_data").val("hello");
        var controllerElement = document.querySelector('[ng-controller="scancode_ctrl"]');
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
        $('#reason').val(0);
        $('#reason').change();
    }

$("#reason").change(function(){
    
    var tot = $('#changed_rej').val();
	var result = $('#reason').val();
	if(Number(result) > Number(tot))
	{
		sweetAlert("","No. Of reasons should not greater than bundle eligible quantity","error");
        $('#reason').val(0);
        $('#reason').change();
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
                barcode_info: $scope.barcode_value,
                op_code: $scope.op_code
            }),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (data, status, headers, config) {
            var validate_barcode=data.validate_barcode;
            $('#loading-image').hide();
            if(validate_barcode>0){
                $scope.style=data.style.trim();
                $scope.color=data.color.trim();
                $scope.bundle_qty=data.original_qty;
                //$scope.changed_rej=data.bundle_eligibl_qty;
                $('#changed_rej').val(data.bundle_eligibl_qty);
                $scope.eligible_qty=data.bundle_eligibl_qty;
                $scope.schedule= data.schedule;
                $scope.size_title= data.size_title;
                $scope.operation_name= data.operation_name;
                $scope.global_facility_code=data.global_facility_code;
                $scope.zfeature=data.zfeature;
                $scope.vpo=data.vpo;
                $scope.scanned_status=data.status;
                $scope.color_cod=data.color_code;
                //$scope.scanned_status="Please Proceed";

                

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
                $scope.scanned_status=data.status;
                $scope.color_cod=data.color_code;
                //$scope.scanned_status="Please Verify Barcode Once..!";
            }

        }).error(function (data, status, headers, config) {
            // handle error things
           
        });
    }

    $scope.functionRESET=function(){
        $scope.count=0;
        $scope.scanned_count = [];
        };

        $scope.scanned_count = [];
    
    $scope.barcode_submit = function(taskId){
        var sum =0;
        $('#loading-image').show();
            var task_action=taskId;
            $http({
                method: 'POST',
                url: $scope.url,
                data: $.param({
                    barcode_value: $scope.barcode_value,
                    module:$scope.module,
                    op_code: $scope.op_code,
                    trans_mode:$scope.trans_mode,
                    shift:$scope.shift,
                    trans_action:task_action,
                    rej_data:$scope.rej_data
                }),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (data, status, headers, config) {
                $('#loading-image').hide();
                if(data.present_eligibqty){
                    if(data.present_eligibqty>data.counted_qty){
                        //sweetAlert("","Eligible Qty " +data.present_eligibqty+ " greater than Reported " +data.counted_qty+ " Qty","info");
                        sweetAlert("","You reported Qty " +data.counted_qty+ " less than Eligible Qty " +data.present_eligibqty ,"info");

                    }
                }
                $scope.color_cod=data.color_code;
                $scope.scanned_status=data.status;
                if(data.counted_qty){
                    var rep_qty=data.counted_qty;
                }else{
                    var rep_qty=0;
                }
                $scope.scanned_count.push(rep_qty);
                console.log($scope.scanned_count);
                sum = $scope.scanned_count.reduce( (sum, current) => sum + current, 0 );
                console.log(sum);
                $scope.count=sum;
                $scope.prev_good=(data.prev_good.padStart(6,' '));
                $scope.prev_reject=(data.prev_reject.padStart(6,' '));
                $scope.prev_rework=(data.prev_rework.padStart(6,' '));
                $scope.current_good=(data.current_good.padStart(6,' '));
                $scope.current_reject=(data.current_reject.padStart(6,' '));
                $scope.curr_rework=(data.curr_rework.padStart(6,' '));
            }).error(function (data, status, headers, config) {
                // handle error things
            });
    };
});
angular.bootstrap($('#scanned_barcode'), ['scanning_interface_new']);