angular.module('nginxLogApp')
        .config(function($routeProvider) {
            $routeProvider
                .when('/', { templateUrl:  'scripts/nginx-log-grid.html', controller: 'nginxCtrl'})
        });