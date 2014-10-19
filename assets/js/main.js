var app = angular.module('myApp', ['ui.bootstrap']);

app.controller('myController', function( $scope, $sce, $http, $filter ) {
	$scope.selectedTab = 'active';

    $scope.getAccount = function() {
        $http({
            'method': 'GET',
            'url': '/account',
        }).success(function(data, status, headers, config) {
            $scope.account = data;
        }).error(function(data, status, headers, config) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    }

    $scope.getAccount();
});