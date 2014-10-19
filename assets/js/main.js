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

    $scope.closeTrade = function(trade) {
        var r = confirm("Sell "+trade.shares+" units of "+trade.stock.toUpperCase()+"?");
        if ( r == true ) {
            $http({
                'method': 'PUT',
                'url': '/trades',
                'data': {
                    'trade_id' : trade.id
                }
            }).success(function(data, status, headers, config) {
                $scope.executeLoad();
            }).error(function(data, status, headers, config) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
            });
        } else {
            return;
        }
    };

    $scope.getAccountInformation = function() {
        $http({
            'method': 'GET',
            'url': '/account'
        }).success(function(data, status, headers, config) {
            $scope.accountInformation = data;
            angular.forEach(data.active_trades, function(trade, key){
                $scope.getStock(trade.stock, function(stock){
                    if ( stock.LastTradePriceOnly ) {
                         $scope.accountInformation.active_trades[key].profit = ((stock.LastTradePriceOnly-trade.opened_price)*trade.shares);
                    } else {
                        return false;
                    }
                });
            });

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
            'url': '/trades/history'
        }).success(function(data, status, headers, config) {
            angular.forEach(data, function(trade, key){
                data[key].profit = ((trade.closed_price-trade.opened_price)*trade.shares);
            });

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

    $scope.getClosedTradeProfit = function(trade) {
        if ( trade.closed_price ) {
            // This is a closed trade, use recorded closing price
            return ((trade.closed_price-trade.opened_price)*trade.shares);
        } else {
            // This is an active trade, can't handle this here
            return false;
        }
    };

    $scope.getStock = function(symbol, callback) {
        $http({
            'method': 'GET',
            'url': '/stocks?symbol=' + symbol
        }).success(function(data, status, headers, config) {
            callback(data);
        }).error(function(data, status, headers, config) {
            callback(false);
        });
    }

    $scope.switchTab = function(tab) {
        if ( tab == 'active' ) {
            $scope.selectedTab = tab;
        } else if ( tab == 'history' ) {
            $scope.selectedTab = tab;
        } else if ( tab == 'open' ) {
            $scope.selectedTab = tab;
        } else {
            $scope.switchTab('active');
        }
        $scope.executeLoad(true);
    }

    $scope.executeLoad = function(hardReset) {
        $scope.getAccountBalances();
        
        if ( $scope.selectedTab == 'active' ) {
            $scope.getAccountInformation();
            if ( hardReset ) {
                delete $scope.accountInformation.active_trades;
            }
        } 
        
        if ( $scope.selectedTab == 'history' ) {
            $scope.getTradeHistory();
            if ( hardReset ) {
                delete $scope.tradeHistory;
            }
        }

        if ( window.innerWidth > 1200 ) {
            $scope.getActiveUsers();
        }
    };

    // Always initialize
    $scope.executeLoad();

}).filter('facebookImage', function() {
    return function(facebookId) {
        return '//graph.facebook.com/' + facebookId + '/picture?width=200&height=200';
    };
}).filter('tooltipProfile', function() {
    return function(user) {
        var html = '';
        html += '<img class="img-rounded profile-picture" src="//graph.facebook.com/' + user.id + '/picture?width=200&height=200">';
        html += '<br>';
        html += user.name;
        return html;
    };
}).filter('firstName', function() {
    return function(facebookName) {
        var explodeName = facebookName.split(' ');
        return explodeName[0];
    };
});

