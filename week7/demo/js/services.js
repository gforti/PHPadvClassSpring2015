'use strict';
  
var appServices = angular.module('appServices', []);
 
appServices.factory('phoneTypesProvider', ['$http', 'config', function($http, config) {

    var url = config.endpoints.phonetypes;
    var model = config.models.phonetype;
    
    return {
        "getPhoneTypes": function () {
            return $http.get(url);
        },
        "postPhoneType": function (phonetype, active) {
            model.phonetype = phonetype;
            model.active = active;
            return $http.post(url, model);
        },
        "deletePhoneType" : function (phonetypeid) {
            var _url = url + phonetypeid;
            return $http.delete(_url);
        },
        "updatePhoneType" : function (phonetypeid, phonetype, active) {  
            var _url = url + phonetypeid;
            model.phonetype = phonetype;
            model.active = active;
            return $http.put(_url, model);
        }
    };
}]);


appServices.factory('phonesProvider', ['$http', 'config', function($http, config) {

    var url = config.endpoints.phones;
    var model = config.models.phone;
    
    return {
        "getPhones": function () {
            return $http.get(url);
        },
        "postPhone": function (phone, phonetypeid, active) {
            model.phone = phone;
            model.phonetypeid = phonetypeid;
            model.active = active;
            return $http.post(url, model);
        },
        "deletePhone" : function (phoneid) {
            var _url = url + phoneid;
            return $http.delete(_url);
        },
         "updatePhone" : function (phoneid, phonetype, phonetypeid, active) {  
            var _url = url + phoneid;
            model.phone = phonetype;
            model.phonetypeid = phonetypeid;
            model.active = active;
            return $http.put(_url, model);
        }
    };
}]);


