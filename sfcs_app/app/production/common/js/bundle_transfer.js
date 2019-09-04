var app = angular.module('scanning_interface', []);
app.controller('scanctrl', function ($scope, $http, $window) {
    $scope.barcode = '';
    $scope.url = '';
    $scope.showtable = false;
    $scope.showscanlist = false;
    $scope.scanned_barcode_details = [];
    $scope.session_barcodes = [];
    
    $scope.op_code = '';
    $scope.$watch('op_code', function(op_code){
        $scope.op_code = op_code;
    });
    $scope.$watch('module', function(module){
        $scope.module = module; 
    });
	
    $scope.scanned = function(event){
       

	        if(event.charCode == 13){
            $('#loading-image').show();
            if($scope.op_code != undefined)
            {
               $scope.last_barcode = $scope.barcode+'-'+$scope.op_code;
               $scope.bundle=$scope.barcode;
            }
            else
            {
                $scope.last_barcode = $scope.barcode;
            }
           
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
                           
                            $('#loading-image').hide();
                            $scope.last_barcode_status = 'Error';
                            $scope.last_barcode_status_remarks = 'Please Check Barcode you scanned';
                           
                            $scope.barcode = '';
                        }else{
                            var params = $.param({
                                
                                barcode: $scope.last_barcode,
                                op_code: $scope.op_code,
                                module: $scope.module
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
                                
                                if(response.data.status){
                                    $('#loading-image').hide();
                                                                       
                                    $scope.last_barcode_status = 'Not Done';
                                    $scope.last_barcode_status_remarks = response.data.status;
                                    $('.bgcolortable').css("background-color", "#d04d4d70");
                                   
                                }else{
                                    $scope.showscanlist = true;
                                    $scope.scanned_barcode_details.push({
                                        'data' : response.data,
                                    });
                                    $('#loading-image').hide();
                                                                        
                                    $scope.last_barcode_status = 'Success';
                                    
                                    $scope.last_barcode_status_remarks =response.data;
                                    
                                    $('.bgcolortable').css("background-color", "#00800085");
                                }

                            });
                            $scope.barcode = '';
                        }

                    }else{
                        $scope.last_barcode_status = 'Error';
                        $scope.last_barcode_status_remarks = 'Please Check Barcode you scanned';
                        $('.bgcolortable').css("background-color", "#d04d4d70");
                        
                        $('#loading-image').hide();
                    }
                    $scope.showtable = true;

                }else{
                    
                    $scope.last_barcode_status = 'Error';
                    $scope.last_barcode_status_remarks = 'Please Check Barcode you scanned';
                    $('.bgcolortable').css("background-color", "#d04d4d70");
                    $('#loading-image').hide();
                }
                $scope.barcode = '';
                
            }else{
                $scope.last_barcode_status = 'Error';
                $scope.last_barcode_status_remarks = 'Please Check Barcode you scanned';
                $('.bgcolortable').css("background-color", "#d04d4d70");
                
                $('#loading-image').hide();

                
            }
        }

    }

    
});
angular.bootstrap($('#scanBarcode'), ['scanning_interface']);
