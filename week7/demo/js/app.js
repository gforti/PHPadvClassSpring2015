 'use strict';

var myApp = angular.module('myApp', [
  'ngRoute',
  'appControllers',
  'appServices',
  'appFilters'
]);

myApp.constant('config', {
    "endpoints": {
       "phones" : 'http://localhost/PHPadvClassSpring2015/week5/demo/api/v1/phones/',
       "phonetypes" : 'http://localhost/PHPadvClassSpring2015/week5/demo/api/v1/phonetypes/'
    },
    "models" : {
        "phonetype" : {
            "phonetype" : '',
            "active" : ''
        },
        "phone" : {
            "phone" : '',
            "phonetypeid" : '',
            "active" : ''
        }   
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
  
  
  myApp.config(['$httpProvider',
  function($httpProvider) {
    // Use x-www-form-urlencoded Content-Type
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
    
    $httpProvider.defaults.transformRequest = function(data){
        if (data === undefined) {
            return data;
        }
        var str = [];
        for(var key in data) {
          if (data.hasOwnProperty(key)) {
            var val = data[key];
            str.push(encodeURIComponent(key) + "=" + encodeURIComponent(val));
          }
        }
        return str.join("&");
    };
    
}]);