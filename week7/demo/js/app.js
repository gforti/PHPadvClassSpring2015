 'use strict';

var myApp = angular.module('myApp', [
  'ngRoute',
  'appControllers',
  'appServices',
  'appFilters'
]);

myApp.constant('config', {
    "endpoints": {
       "phones" : 'http://localhost/PHPadvClassSpring2015/week5/demo/api/v1/phones',
       "phonetypes" : 'http://localhost/PHPadvClassSpring2015/week5/demo/api/v1/phonetypes'
    }
});

myApp.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
        when('/', {
            templateUrl: 'partials/phonetypes.html',
            controller: 'PhoneTypesCtrl'
        }).
        when('/phones', {
            templateUrl: 'partials/phones.html',
            controller: 'PhonesCtrl'
        }).
        otherwise({
          redirectTo: '/'
        });
  }]);