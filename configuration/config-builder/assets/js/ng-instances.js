var app = angular.module('configManager', []);
app.controller("instancesCtl", function($scope, $http){
    $scope.instances = [{
        name: null,
        url: null
    }];

    $scope.add = function(){
        $scope.instances.push({
            name: null,
            url: null
        });
    };

    $scope.remove = function(instance){
        $scope.instances.splice($scope.instances.indexOf(instance), 1);   
    }

    $scope.removeSpace = function(index){
        $scope.instances[index].url = $scope.instances[index].url.replace(/\s/g,'');
    }

    $http.get("saved_fields/instances.json").then(function(res){
        $scope.instances = res.data;
    });

    $scope.setting = function(instance){
        window.location = "create.php?instanceURL=" + instance.url;
    }
});