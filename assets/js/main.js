var app = angular.module('myApp', ['ui.bootstrap', 'ngSanitize', 'ngResize', 'toaster']);
//app.service('swal', sweetAlertService);
app.controller('myController', function( $scope, $sce, $http, $filter, toaster ) {
	$scope.selectedTab = 'active';

    $scope.openTrade = function(symbol, quantity) {
        if ( quantity && quantity > 0) {
            swal({
                title: '<i class="fa fa-fax fa-2x"></i>',
                text: "<em>Trades are locked in for 3 days after opening</em><br><strong>Buy</strong> "+quantity+" shares of "+symbol.toUpperCase()+"?",
                showCancelButton: true,
                confirmButtonColor: "#5CB85C",
                confirmButtonText: 'Yes, open trade',
                cancelButtonText: 'No',
                closeOnConfirm: false,
                closeOnCancel: true,
                allowHtml: true
            }, function(isConfirm){
                $scope.loadingOpenTrade = true;
                $http({
                    'method': 'POST',
                    'url': '/trades',
                    'data': {
                        'symbol' : symbol,
                        'quantity' : quantity
                    }
                }).success(function(data, status, headers, config) {
                    $scope.loadingOpenTrade = false;
                    $scope.switchTab('active');
                }).error(function(data, status, headers, config) {
                    $scope.loadingOpenTrade = false;
                    toaster.pop('error', 'Error: ' + status, data.message);
                });
            });
        } else {
            toaster.pop('error', 'Error: 406', 'Invalid quantity of shares');
            return;
        }
    };

    $scope.closeTrade = function(trade) {
        swal({
            title: '<i class="fa fa-legal fa-2x"></i>',
            text: "<strong>Sell</strong> "+trade.shares+" units of "+trade.stock.toUpperCase()+"?",
            showCancelButton: true,
            confirmButtonColor: "#F0AD4E",
            confirmButtonText: 'Yes, close trade',
            cancelButtonText: 'No',
            closeOnConfirm: false,
            closeOnCancel: true,
            allowHtml: true
        }, function(isConfirm){
            $scope.loadingCloseTrade = true;
            $http({
                'method': 'PUT',
                'url': '/trades',
                'data': {
                    'trade_id' : trade.id
                }
            }).success(function(data, status, headers, config) {
                $scope.loadingCloseTrade = false;
                $scope.executeLoad(true);
            }).error(function(data, status, headers, config) {
                $scope.loadingCloseTrade = false;
                toaster.pop('error', 'Error: ' + status, data.message);
            });
        });
    };

    $scope.findStock = function(symbol) {
        $scope.loadingFindStock = true;
        $scope.showStock = false;
        $scope.selectedStock = new Object;
        $scope.quantityToPurchase = "";
                
        $scope.getStock(symbol, function(stock) {
            if (stock) {
                $scope.selectedStock = stock;
                $scope.showStock = true;
                $scope.loadingFindStock = false;
            } else {
                $scope.loadingFindStock = false;
            }
        });
    };

    $scope.getAccountInformation = function() {
        $scope.loadingAccountInformation = true;
        $http({
            'method': 'GET',
            'url': '/account'
        }).success(function(data, status, headers, config) {
            $scope.accountInformation = data;
            
            angular.forEach(data.active_trades, function(trade, key){
                $scope.getStock(trade.stock, function(stock){
                    if ( stock.LastTradePriceOnly ) {
                        $scope.accountInformation.active_trades[key].currentValue = stock.LastTradePriceOnly;
                        $scope.accountInformation.active_trades[key].profit = ((stock.LastTradePriceOnly-trade.opened_price)*trade.shares);
                    } else {
                        return false;
                    }
                });
            });
            
            $scope.loadingAccountInformation = false;

        }).error(function(data, status, headers, config) {
            $scope.loadingAccountInformation = false;
            toaster.pop('error', 'Error: ' + status, data.message);
        });
    };
    
    $scope.getAccountBalances = function() {
        $scope.loadingAccountBalances = true;
        $http({
            'method': 'GET',
            'url': '/account/balances'
        }).success(function(data, status, headers, config) {
            $scope.accountBalances = data;

            var chartData = [];
            angular.forEach(data, function(balance) {
                dateParts = balance.last_updated.split("-");
                chartData.push({
                    label   : $filter('balanceTooltipTemplate')(balance),
                    x       : new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0, 2), dateParts[2].substr(3, 2), dateParts[2].substr(6, 2), dateParts[2].substr(9, 2)),
                    y       : parseFloat(balance.value)
                });
            });
            $scope.chart.options.data[0].dataPoints = chartData;
            $scope.chart.options.title.text = "Account Balances";
            $scope.chart.options.backgroundColor = "rgb(230, 230, 230)";
            $scope.chart.render();
            $scope.loadingAccountBalances = false;
        }).error(function(data, status, headers, config) {
            $scope.loadingAccountBalances = false;
            toaster.pop('error', 'Error: ' + status, data.message);
        });
    };

    $scope.getTradeHistory = function() {
        $scope.loadingTradeHistory = true;
        $http({
            'method': 'GET',
            'url': '/trades/history'
        }).success(function(data, status, headers, config) {
            angular.forEach(data, function(trade, key){
                data[key].profit = ((trade.closed_price-trade.opened_price)*trade.shares);
            });
            $scope.tradeHistory = data;
            $scope.loadingTradeHistory = false;
        }).error(function(data, status, headers, config) {
            $scope.loadingTradeHistory = false;
            toaster.pop('error', 'Error: ' + status, data.message);
        });
    };

    $scope.getActiveUsers = function() {
        $http({
            'method': 'GET',
            'url': '/users'
        }).success(function(data, status, headers, config) {
            $scope.activeUsers = data;
        }).error(function(data, status, headers, config) {
            toaster.pop('error', 'Error: ' + status, data.message);
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
            toaster.pop('error', 'Error: ' + status, data.message);
            callback(false);
        });
    };

    $scope.switchTab = function(tab) {
        if ( tab == 'active' || tab == 'history' || tab == 'open' ) {
            $scope.selectedTab = tab;
        } else {
            $scope.switchTab('active');
        }
        $scope.executeLoad(true);
    };

    $scope.setWindowDimensions = function () {
        $scope.windowInnerWidth = window.innerWidth;
        $scope.windowInnerHeight = window.innerHeight;
    }

    $scope.executeLoad = function(hardReset) {
        $scope.getAccountBalances();
        
        if ( $scope.selectedTab == 'active' ) {
            if ( hardReset ) {
                delete $scope.accountInformation.active_trades;
            }
            $scope.getAccountInformation();            
        } 
        
        if ( $scope.selectedTab == 'history' ) {
            if ( hardReset ) {
                delete $scope.tradeHistory;
            }
            $scope.getTradeHistory();
        }

        if ( $scope.selectedTab == 'open' ) {
            if ( hardReset ) {
                $scope.inputSymbol = "";
                $scope.quantityToPurchase = "";
                $scope.selectedStock = new Object();
                $scope.showStock = false;
            }
        }

        if ( $scope.windowInnerWidth > 1200 ) {
            $scope.getActiveUsers();
        }
    };

    // Always initialize
    CanvasJS.addCultureInfo('default', {
        panText : '<i class="fa fa-arrows"></i> Drag',
        zoomText : '<i class="fa fa-search-plus"></i> Zoom',
        resetText : '<i class="fa fa-refresh"></i> Reset'
    });

    $scope.chart = new CanvasJS.Chart("balanceInformation", {
        zoomEnabled : true,
        culture : 'default',
        animationEnabled : true,
        backgroundColor : 'transparent',
        creditText : '',
        content: function(e){
            var content;
            content = e.entries[0].dataSeries.name + " <strong>"+e.entries[0].dataPoint.y  ;
            return content;
        },
        title : {
            title: ''
        },
        toolTip : {
            content : function(e) {
                return e.entries[0].dataPoint.label;
            }
        },
        axisX : {
            title: "Timeline",
            labelFontFamily : "inherit",
            titleFontFamily : "inherit",
            gridThickness: 1
        },
        axisY : {
            title: "Balance",
            labelAngle: 315,
            labelFontFamily : "inherit",
            titleFontFamily : "inherit" 
        },
        data : [{        
            type: "line",
            dataPoints: []
        }]
    });
    $scope.setWindowDimensions();
    $scope.chart.render();
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
}).filter('balanceTooltipTemplate', function($filter) {
    return function(balance) {
        var html = "";
        if (balance.reason == 'opened_trade') {
            html += "Bought: ";
            html += "<strong>" + balance.reason_detail.stock.toUpperCase() + "</strong>";
            html += "<br>";

            html += "Shares: ";
            html += "<strong>" + parseFloat(balance.reason_detail.shares) + " units</strong>";
            html += "<br>"; 

            html += "Net cost: ";
            html += "<strong>" + $filter('currency')(balance.reason_detail.shares*balance.reason_detail.opened_price) + "</strong>";
            html += "<br>"; 
            
            html += "Trader: ";
            html += "<strong>" + balance.reason_detail.opened_user.name + "</strong>";
            html += "<br>"; 
            
        } else if (balance.reason == 'closed_trade') {
            html += "Sold: ";
            html += "<strong>" + balance.reason_detail.stock.toUpperCase() + "</strong>";
            html += "<br>";

            html += "Shares: ";
            html += "<strong>" + parseFloat(balance.reason_detail.shares) + " units</strong>";
            html += "<br>"; 

            html += "Net gain: ";
            html += "<strong>" + $filter('currency')(balance.reason_detail.shares*balance.reason_detail.closed_price) + "</strong>";
            html += "<br>"; 
            
            html += "Net profit: ";
            html += "<strong>" + $filter('currency')(balance.reason_detail.shares*(balance.reason_detail.closed_price-balance.reason_detail.opened_price)) + "</strong>";
            html += "<br>"; 

            html += "Trader: ";
            html += "<strong>" + balance.reason_detail.opened_user.name + "</strong>";
            html += "<br>"; 
        } else if (balance.reason == 'initial_deposit') {
            html += "Initial Deposit: ";
            html += "<strong>" + $filter('currency')(balance.value) + "</strong>";
            html += "<br>";
        }
        html += "Date: ";
        html += "<strong>" + $filter('date')(new Date(balance.last_updated.replace(' ', 'T')).getTime(), 'MMM d, yy @ h:mm a') + "</strong>";
        
        return html;
    };
}).directive('validNumber', function() {
    return {
        require: '?ngModel',
        link: function(scope, element, attrs, ngModelCtrl) {
            if(!ngModelCtrl) {
                return; 
            }

            ngModelCtrl.$parsers.push(function(val) {
                var clean = val.replace( /[^0-9]+/g, '');
                if (val !== clean) {
                    ngModelCtrl.$setViewValue(clean);
                    ngModelCtrl.$render();
                }
                return clean;
            });

            element.bind('keypress', function(event) {
                if(event.keyCode === 32) {
                    event.preventDefault();
                }
            });
        }
    };
});
