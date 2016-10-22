angular.module('nginxLogApp')
    .controller('nginxCtrl', function($scope, Log, $filter){
        $scope.name = 'NGINX log Parser';

        Log.findAll().then(function(logsArray) {
            $scope.logs = logsArray;
        });

        $scope.filterAs = function(input){
            return (input.name.indexOf($scope.search) === 0);
        };

        $scope.calculateCount = function () {
            if (angular.isDefined($scope.logs)) {
                return $scope.logs.length;
            }
        };
        $scope.$watch("search", function(query){
            $scope.calculateCount = function () {
                if (angular.isDefined($scope.logs)) {
                    return $filter("filter")($scope.logs, query).length;
                }
            }
        });

    })
    .controller('tableSortableCtrl', function($scope) {
        $scope.sort = { column: 'timeLocal', direction: false };

        $scope.sortBy = function(a) {
            if($scope.sort.column === a) {
                $scope.sort.direction = !$scope.sort.direction;
            } else {
                $scope.sort.column = a;
            }
        };
    })
    .directive('tableSortable', function(){
        return {
            restrict: 'A',
            scope: true,
            controller: 'tableSortableCtrl'
        };
    })
    .directive('thSortable', function(){
        return {
            restrict: 'A',
            transclude: true,
            scope: true,
            template: '<a href ng-click="sortBy(thSortable)" ' +
                'ng-class="{ ' +
                    'active: sort.column == thSortable, ' +
                    'asc: !sort.direction, ' +
                    'desc: sort.direction ' +
                '}"><div ng-transclude></div></a>',
            link: function(scope, element, attrs) {
                scope.thSortable = attrs.thSortable;

                // console.log(attrs.thSortable);
            }
        };
    });




