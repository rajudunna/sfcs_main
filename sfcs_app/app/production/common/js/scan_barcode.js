var app = angular.module('scanning_interface', []);
app.controller('scanctrl', function ($scope, $http, $window) {
    // a = this;
    $scope.barcode = '';
    $scope.url = '';
    $scope.showtable = false;
    $scope.showscanlist = false;
    $scope.scanned_barcode_details = [];
    $scope.session_barcodes = [];
     
    $scope.scanned = function(){
        $('#loading-image').show();
        $scope.last_barcode = $scope.barcode;
        $scope.last_barcode_status = 'In-Progress';
        $scope.last_barcode_status_remarks = '';
        $scope.showtable = true;
        if($scope.barcode != ''){
            if($scope.barcode.includes('-')){
                var split = $scope.barcode.split('-');
                if(split.length == 2){
                    var bundle_num = split[0];
                    var op_no = split[1];
                    if (isNaN(bundle_num) || isNaN(op_no)){
                        //$('#barcode_scan').focus();
                        $('#loading-image').hide();
                        $scope.last_barcode_status = 'Error';
                        $scope.last_barcode_status_remarks = 'Please Check Barcode you scanned';
                        swal({
                            title: "Error",
                            text: "Please Check Barcode you scanned",
                            timer: 1000
                        });
                        // swal('Please Check Barcode you scanned.');
                        $scope.barcode = '';
                    }else{
                        var params = $.param({
                            barcode: $scope.last_barcode
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
                            if(response.data.status){
                                $('#loading-image').hide();
                                $scope.last_barcode_status = 'Not Done';
                                $scope.last_barcode_status_remarks = response.data.status;
                                swal({
                                    title: "Error",
                                    text: response.data.status,
                                    timer: 2000
                                });
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
                            }

                        });
                        $scope.barcode = '';
                    }

                }else{
                    $scope.last_barcode_status = 'Error';
                    $scope.last_barcode_status_remarks = 'Please Check Barcode you scanned';
                    swal({
                        title: "Error",
                        text: "Please Check Barcode you scanned",
                        timer: 1000
                    });
                    $('#loading-image').hide();
                }
                $scope.showtable = true;

            }else{
                swal({
                    title: "Error",
                    text: "Please Check Barcode you scanned",
                    timer: 1000
                });
                $scope.last_barcode_status = 'Error';
                $scope.last_barcode_status_remarks = 'Please Check Barcode you scanned';
                $('#loading-image').hide();
            }
            $scope.barcode = '';
            //$('#barcode_scan').focus();
        }else{
            $scope.last_barcode_status = 'Error';
            $scope.last_barcode_status_remarks = 'Please Check Barcode you scanned';
            //$('#barcode_scan').focus();
            $('#loading-image').hide();

            swal({
                title: "Error",
                text: "Please Check Barcode you scanned",
                timer: 1000
            });
        }

    }

});
angular.bootstrap($('#scanBarcode'), ['scanning_interface']);
