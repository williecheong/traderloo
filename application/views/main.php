<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html ng-app="myApp" ng-controller="myController"> <!--<![endif]-->
    <head>
        <title ng-bind-template="<?=APP_NAME?> :: {{ accountInformation.current_balance || 0 | currency }}"></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="<?=APP_DESCRIPTION?>">
        <link rel="image_src"  href="/assets/img/updownfire.gif">
        <link rel="icon" href="/assets/img/<?=ENVIRONMENT?>.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/assets/img/<?=ENVIRONMENT?>.ico" type="image/x-icon">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/assets/css/main.css">
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <div class="container full">
            <div class="well well-sm full" id="visualizations">
                <div class="row full">
                    <div class="col-lg-12 full">
                        <div class="full" id="balanceInformation">
                            <pre ng-bind="accountBalances | json"></pre>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row full" id="interactions">
                <div class="col-lg-10 full">
                    <div class="well well-sm full">
                        <div class="row full">
                            <div class="col-lg-2 full" id="tabs">
                                <ul class="nav nav-pills nav-stacked" role="tablist">
                                    <li ng-class="{'active':selectedTab=='active'}" ng-click="switchTab('active')">
                                        <a href="">Active</a>
                                    </li>
                                    <li ng-class="{'active':selectedTab=='history'}" ng-click="switchTab('history')">
                                        <a href="">History</a>
                                    </li>
                                    <li ng-class="{'active':selectedTab=='open'}" ng-click="switchTab('open')">
                                        <a href="">Open</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-10 full">
                                <div class="full" id="tabContent" ng-show="selectedTab=='active'">
                                    <table class="table table-condensed" ng-if="accountInformation.active_trades">
                                        <thead>
                                            <tr>
                                                <th>Trader</th>
                                                <th>Stock</th>
                                                <th>Shares</th>
                                                <th>Opened on</th>
                                                <th>Net profit</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="trade in accountInformation.active_trades">
                                                <td>
                                                    <a href="" tooltip-html-unsafe="{{ trade.opened_user | tooltipProfile }}">
                                                        <i class="fa fa-user"></i>
                                                        {{ trade.opened_user.name | firstName }}
                                                    </a>
                                                </td>
                                                <td ng-bind="trade.stock | uppercase"></td>
                                                <td ng-bind-template="{{trade.shares}} units"></td>
                                                <td>
                                                    <a href="" tooltip="{{''+trade.opened_datetime+'000' | date:'shortTime'}}">
                                                        <i class="fa fa-clock-o fa-lg"></i>
                                                    </a>
                                                    {{ ''+trade.opened_datetime+'000' | date:'longDate' }}
                                                    @ {{ trade.opened_price | currency }}
                                                </td>
                                                <td>
                                                    <div ng-if="trade.profit">
                                                        <strong class="text-success" ng-if="trade.profit>0" ng-bind="trade.profit"></strong>
                                                        <strong class="text-danger" ng-if="trade.profit=<0" ng-bind="trade.profit * -1"></strong>
                                                    </div>
                                                    <div ng-if="!trade.profit">
                                                        <i class="fa fa-gear fa-spin"></i> Calculating
                                                    </div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-warning btn-xs" ng-click="closeTrade(trade)">
                                                        <i class="fa fa-legal"></i> Sell
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="text-center" ng-if="accountInformation.active_trades.length==0">
                                        <i class="fa fa-frown-o"></i>
                                        NO ACTIVE TRADES TO SHOW
                                        <i class="fa fa-frown-o"></i>
                                        <br>
                                        <a class="lead" href="" ng-click="switchTab('open')">
                                            Open a trade
                                        </a> 
                                    </div>
                                    <div class="text-center lead" ng-if="!accountInformation.active_trades">
                                        <i class="fa fa-gear fa-spin"></i> LOADING
                                    </div>
                                </div>
                                <div class="full" id="tabContent" ng-show="selectedTab=='history'">
                                    <table class="table table-condensed" ng-if="tradeHistory">
                                        <thead>
                                            <tr>
                                                <th>Stock</th>
                                                <th>Shares</th>
                                                <th>Opening</th>
                                                <th>Closing</th>
                                                <th>Net profit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="trade in tradeHistory">
                                                <td ng-bind="trade.stock | uppercase"></td>
                                                <td ng-bind-template="{{trade.shares}} units"></td>
                                                <td>
                                                    <a href="" tooltip-html-unsafe="{{ trade.opened_user | tooltipProfile }}">
                                                        <i class="fa fa-user fa-lg"></i>
                                                    </a>
                                                    <a href="" tooltip="{{''+trade.opened_datetime+'000' | date:'shortTime'}}">
                                                        <i class="fa fa-clock-o fa-lg"></i>
                                                    </a>
                                                    {{ ''+trade.opened_datetime+'000' | date:'longDate' }}
                                                </td>
                                                <td>
                                                    <a href="" tooltip-html-unsafe="{{ trade.closed_user | tooltipProfile }}">
                                                        <i class="fa fa-user fa-lg"></i>
                                                    </a>
                                                    <a href="" tooltip="{{''+trade.closed_datetime+'000' | date:'shortTime'}}">
                                                        <i class="fa fa-clock-o fa-lg"></i>
                                                    </a>
                                                    {{ ''+trade.closed_datetime+'000' | date:'longDate' }}
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="text-center lead" ng-if="!tradeHistory">
                                        <i class="fa fa-gear fa-spin"></i> LOADING
                                    </div>
                                </div>
                                <div class="full" id="tabContent" ng-show="selectedTab=='open'">
                                    mess around with new trades
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 visible-lg full">
                    <div class="well well-sm full">
                        <div class="row full">
                            <div class="col-lg-12 full">
                                <div class="full" id="activeUsers">
                                    <div class="padding-xs" ng-repeat="user in activeUsers">
                                        <img class="img-rounded" id="active-picture" src="{{ user.id | facebookImage }}" tooltip-html-unsafe="<i class='fa fa-circle text-success'></i> {{user.name}}">
                                    </div>
                                    <div class="padding-xs">
                                        <a class="btn btn-danger btn-sm" href="<?=$this->facebook_url?>">
                                            <i class="fa fa-sign-out"></i> <?=$this->session->userdata('name')?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center" id="fineprint">
            <span class="lead">
                <i class="fa fa-cubes"></i>
                <?=APP_NAME?> 
                <?=date('Y')?>
            </span>
        </div>
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.10.0/ui-bootstrap-tpls.min.js"></script>
        <script src="/assets/js/main.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <!--
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X');ga('send','pageview');
        </script>
        -->
    </body>
</html>
