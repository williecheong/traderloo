<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" ng-app="myApp" ng-controller="myController"> <!--<![endif]-->
    <head>
        <title ng-bind-template="<?=APP_NAME?> :: {{ account.current_balance || 0 | currency }}"></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="Everybody trades from one account. Don't fuck me over.">
        <link rel="image_src"  href="/assets/img/updownfire.gif">
        <link rel="icon" href="/assets/img/<?=ENVIRONMENT?>.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/assets/img/<?=ENVIRONMENT?>.ico" type="image/x-icon">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/assets/css/normalize.min.css">
        <link rel="stylesheet" href="/assets/css/main.css">

        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
    </head>
    <body >
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <div class="container">
            <div class="well well-sm" id="visualizations">
                visualizations {{ hello }}
            </div>
            <div class="row" id="interactions">
                <div class="col-lg-10">
                    <div class="well well-sm">
                        <div class="row">
                            <div class="col-lg-2" id="tabs">
                                <ul class="nav nav-pills nav-stacked" role="tablist">
                                    <li ng-class="{'active':selectedTab=='active'}" ng-click="selectedTab='active'">
                                        <a href="">Active</a>
                                    </li>
                                    <li ng-class="{'active':selectedTab=='history'}" ng-click="selectedTab='history'">
                                        <a href="">History</a>
                                    </li>
                                    <li ng-class="{'active':selectedTab=='open'}" ng-click="selectedTab='open'">
                                        <a href="">Open</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-10">
                                <div id="tabContent" ng-show="selectedTab=='active'">
                                    <i class="fa fa-cubes"></i>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                    activeTradesTable<br>
                                </div>
                                <div id="tabContent" ng-show="selectedTab=='history'">
                                    history table
                                </div>
                                <div id="tabContent" ng-show="selectedTab=='open'">
                                    mess around with new trades
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 visible-lg">
                    <div class="well well-sm">
                        activeUsers
                        <a class="btn btn-danger btn-sm" href="<?=$this->facebook_url?>">
                            <i class="fa fa-sign-out"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center" id="fineprint">
            <span class="lead">
                <i class="fa fa-copyright"></i>
                <?=APP_NAME?> 
                <?=date('Y')?>
            </span>
        </div>
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.10.0/ui-bootstrap.min.js"></script>
        <script src="/assets/js/plugins.js"></script>
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
