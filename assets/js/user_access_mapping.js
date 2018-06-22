var app = angular.module('brandix', []);
app.controller('accessmenuctrl', function($scope, $http, $window) {
    // a = this;
    $scope.access_mapping_data = {};
    $scope.rbac_permission = {};
    $scope.perms = {};
    $scope.rbac = {};
    $scope.edit_mapping_data = {};

    $scope.$watch('mapping_data', function(mapping_data) {
        // console.log(mapping_data);
        $scope.access_mapping_data = mapping_data;
        // console.log($scope.access_mapping_data);
    });
    $scope.$watch('rbac_permissions', function(rbac_permissions) {
        $scope.rbac_permission = rbac_permissions;
        console.log($scope.rbac_permission);
        // console.log($scope.access_mapping_data);
    });
    $scope.edit = function(data) {
        for (var i = 0; i < $scope.rbac_permissions.length; i++) {
            $scope.rbac_permissions[i].isChecked = false;
        }
        var CheckedRbacList = $scope.rbac_permissions.filter(
            function(value) {
                if (value.isChecked == true) {
                    return true;
                } else {
                    return false;
                }
            }
        );
        if (CheckedRbacList.length == $scope.rbac_permissions.length) {
            $scope.Checkedall = true;
        } else {
            $scope.Checkedall = false;
        }
        $scope.edit_mapping_data = data;
        // console.log($scope.edit_mapping_data);
        // console.log($scope.rbac_permission);
        for (var i = 0; i < $scope.rbac_permissions.length; i++) {
            for (var j = 0; j < $scope.edit_mapping_data.permission_ids.length; j++) {
                if ($scope.rbac_permissions[i].permission_id == $scope.edit_mapping_data.permission_ids[j]) {
                    $scope.rbac_permissions[i].isChecked = true;
                }
            }
        }
        // $window.location.href = "/";
    }
    $scope.Checkall = function() {
        for (var i = 0; i < $scope.rbac_permissions.length; i++) {
            if ($scope.Checkedall) {
                $scope.rbac_permissions[i].isChecked = true;
            } else {
                $scope.rbac_permissions[i].isChecked = false;
            }
        }
    }
    $scope.SaveData = function() {
        var CheckedRbacList = $scope.rbac_permissions.filter(
            function(value) {
                if (value.isChecked == true) {
                    return true;
                } else {
                    return false;
                }
            }
        );

        $scope.role_menu_id = $scope.edit_mapping_data.role_menu_id;
        $scope.ids = $scope.edit_mapping_data.ids;
        $scope.permission_ids = CheckedRbacList;

        // var params = $.param({
        //     role_menu_id: $scope.edit_mapping_data.role_menu_id,
        //     ids: $scope.edit_mapping_data.ids,
        //     permission_ids: CheckedRbacList,
        // });
        // var req = {
        //     method: 'POST',
        //     url: 'index.php?r=template/ua/update_test_page.php',
        //     headers: {
        //         'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
        //     },
        //     data: params
        // };
        // $http(req).then(function(response) {
        //     console.log(response);
        // });
    }


});
angular.bootstrap(document.getElementById("App3"), ['brandix']);