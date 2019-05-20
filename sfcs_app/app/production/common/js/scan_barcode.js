var app = angular.module('scanning_interface', []);
app.controller('scanctrl', function ($scope, $http, $window) {
    // a = this;
    $scope.barcode = '';
    $scope.url = '';
    $scope.user_permission = '';
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
    $scope.scanned = function(event){
        if(event.charCode == 13){
            $('#loading-image').show();
            if($scope.op_code != undefined)
            {
               $scope.last_barcode = $scope.barcode+'-'+$scope.op_code;
            }
            else
            {
                $scope.last_barcode = $scope.barcode;
            }
            console.log($scope.last_barcode);
            $scope.last_barcode_status = 'In-Progress';
            $scope.last_barcode_status_remarks = '';
            $scope.showtable = true;
            $('.bgcolortable').css("background-color", "white");
            if($scope.barcode != ''){
                if($scope.last_barcode.includes('-')){
                    var split = $scope.last_barcode.split('-');
                    if(split.length == 2){
                        var bundle_num = split[0];
                        var op_no = split[1];                        
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
                                shift: $scope.shift
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
