var app = angular.module("app", []);
app.controller("userAccessController", function($scope) {

    alert('hai');

    $scope.firstname = "John";

});
angular.bootstrap(document.getElementById("App2"), ['app']);