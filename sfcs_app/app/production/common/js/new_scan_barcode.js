var app = angular.module('scanning_interface_new', []);
app.controller('scancode_ctrl', function ($scope, $http, $window) {
    $scope.barcode_value = '';
    $scope.module = '';
    $scope.op_code = '';
    $scope.tran_mode = '';
    $scope.url = '';

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