<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" ng-app="myApp" ng-controller="myController"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="Everybody trades from one account. Don't fuck me over.">
        <link rel="image_src"  href="/assets/img/updownfire.gif">
        <link rel="icon" href="/assets/img/<?=ENVIRONMENT?>.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/assets/img/<?=ENVIRONMENT?>.ico" type="image/x-icon">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/assets/css/normalize.min.css">
        <link rel="stylesheet" href="/assets/css/main_logged_out.css">

        <title><?=APP_NAME?></title>
        
        <script src="/assets/js/vendor/modernizr-2.6.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <!-- Intro Header -->
        <header class="intro">
            <div class="intro-body">
                <div class="row" id="main-content">
                    <div class="col-md-8 col-md-offset-2">
                        <h1 class="brand-heading"><?=APP_NAME?></h1>
                        <p class="intro-text">
                            One account <i class="fa fa-times-circle"></i> Many traders
                            <br>
                            <small>
                                "Don't fuck me over" - <a href="//williecheong.com" target="_blank">w.cheong</a>
                            </small>
                        </p>
                        <a class="btn btn-default btn-lg btn-wide" href="<?= $this->facebook_url; ?>">
                            <i class="fa fa-facebook-square fa-lg"></i>
                            Join the party
                        </a>
                    </div>
                </div>
            </div>
        </header>
        
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.10.0/ui-bootstrap.min.js"></script>
        <script src="/assets/js/plugins.js"></script>
        <script src="/assets/js/main_logged_out.js"></script>

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
