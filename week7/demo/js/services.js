'use strict';
  
var appServices = angular.module('appServices', []);
 
appServices.factory('phoneTypesProvider', ['$http', 'config', function($http, config) {

    var url = config.endpoints.phonetypes;

    return {
        "getPhoneTypes": function () {
            return $http.get(url);
        }
    };
}]);


appServices.factory('phonesProvider', ['$http', 'config', function($http, config) {

    var url = config.endpoints.phones;

    return {
        "getPhones": function () {
            return $http.get(url);
        }
    };
}]);