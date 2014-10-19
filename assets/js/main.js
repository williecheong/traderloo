var app = angular.module('myApp', ['ui.bootstrap']);

app.controller('myController', function( $scope, $sce, $http, $filter ) {
	$scope.selectedTab = 'active';

    $scope.openTrade = function() {
        $http({
            'method': 'POST',
            'url': '/trades',
            'data': {
                'symbol' : $scope.selectedStockSymbol,
                'quantity' : $scope.quantityToPurchase
            }
        }).success(function(data, status, headers, config) {
            $scope.executeLoad();
        }).error(function(data, status, headers, config) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    };

    $scope.closeTrade = function(trade_id) {
        $http({
            'method': 'PUT',
            'url': '/trades',
            'data': {
                'trade_id' : trade_id
            }
        }).success(function(data, status, headers, config) {
            $scope.executeLoad();
        }).error(function(data, status, headers, config) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    };

    $scope.getAccountInformation = function() {
        $http({
            'method': 'GET',
            'url': '/account'
        }).success(function(data, status, headers, config) {
            $scope.accountInformation = data;
        }).error(function(data, status, headers, config) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    };
    
    $scope.getAccountBalances = function() {
        $http({
            'method': 'GET',
            'url': '/account/balances'
        }).success(function(data, status, headers, config) {
            $scope.accountBalances = data;
        }).error(function(data, status, headers, config) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    };

    $scope.getTradeHistory = function() {
        $http({
            'method': 'GET',
            'url': '/trades'
        }).success(function(data, status, headers, config) {
            $scope.tradeHistory = data;
        }).error(function(data, status, headers, config) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    };

    $scope.getActiveUsers = function() {
        $http({
            'method': 'GET',
            'url': '/users'
        }).success(function(data, status, headers, config) {
            $scope.activeUsers = data;
        }).error(function(data, status, headers, config) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    };

    $scope.executeLoad = function() {
        $scope.getAccountInformation();
        $scope.getAccountBalances();
        $scope.getTradeHistory();
        $scope.getActiveUsers();
    };

    // Always initialize
    $scope.executeLoad();
});