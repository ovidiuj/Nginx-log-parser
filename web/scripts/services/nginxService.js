angular.module('nginxLogApp')
        .factory('Log', function($http) {
            var nginxLogUrl = '/json';
            function findAll() {
                return  $http.get(nginxLogUrl).then(function(logsResponse) {
                    return logsResponse.data;
                });
            }

            return {
                findAll: findAll
            }
        });