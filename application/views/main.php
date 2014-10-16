<!DOCTYPE html ng-app="myApp" ng-controller="myController">
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?=APP_NAME?> - {{ balance }}</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/assets/css/normalize.min.css">
        <link rel="stylesheet" href="/assets/css/main.css">

        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <div class="container">
            <div>
                {{ visualizations }}
            </div>
            <div class="row">
                <div class="col-lg-10">
                    <div class="well well-sm">
                        {{ activeTradesTable }}
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="well well-sm">
                        {{ activeUsers }}
                    </div>
                </div>
            </div>
            <a class="btn btn-danger btn-sm" href="<?=$this->facebook_url?>">
                <i class="fa fa-sign-out"></i>
                Sign out
            </a>
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/angular-ui/0.4.0/angular-ui.js"></script>
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
