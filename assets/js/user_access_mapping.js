
var app = angular.module('brandix', []);
app.controller('accessmenuctrl', function ($scope, $http,$window) {
    // a = this;
    $scope.access_mapping_data = {};
    $scope.rbac_permission = {};
    $scope.perms = {};

    $scope.edit_mapping_data = {};

    $scope.$watch('mapping_data', function (mapping_data) { 
        // console.log(mapping_data);
        $scope.access_mapping_data = mapping_data;
        // console.log($scope.access_mapping_data);
    });
    $scope.$watch('rbac_permissions', function (rbac_permissions) {
        $scope.rbac_permission = rbac_permissions;
        console.log($scope.rbac_permission);
        // console.log($scope.access_mapping_data);
    });
    $scope.edit = function(data){
        $scope.edit_mapping_data = data;
        console.log($scope.edit_mapping_data);
        console.log($scope.rbac_permission);
        // $window.location.href = "/";
    }

});
angular.bootstrap(document.getElementById("App3"), ['brandix']);

