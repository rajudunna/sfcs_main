var app = angular.module('configManager', []);
app.controller("dbController", function($scope){
    $scope.databases = [{
        sql_file: null,
        sql_title: null,
        sql_description: null
    }];

    $scope.add = function(){
        $scope.databases.push({
            sql_file: null,
            sql_title: null,
            sql_description: null
        });
    };

    $scope.remove = function(database){
        $scope.databases.splice($scope.databases.indexOf(database), 1);   
    }

    $scope.removeSpace = function(index){
        $scope.databases[index].sql_title = $scope.databases[index].sql_title.replace(/\s/g,'');
    }
});