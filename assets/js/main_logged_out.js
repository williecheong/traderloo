var app = angular.module('myApp', ['ui.bootstrap']);

app.controller('myController', function( $scope, $sce, $http, $filter ) {
    $scope.tooltipContent = function() {
        var html = '';
            html += '<span class="lead text-muted">';
            html +=     'Experiment inspired by: ';
            html +=     '<a href="//twitch.tv/twitchplayspokemon" target="_blank">';
            html +=         '<i class="fa fa-twitch fa-lg"></i>';
            html +=     '</a>';
            html += '</span>';
        return html;
    };
});