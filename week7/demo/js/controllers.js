'use strict';

var appControllers = angular.module('appControllers', []);

appControllers.controller('PhoneTypesCtrl', ['$scope', 'phoneTypesProvider', function($scope, phoneTypesProvider) {
    
    $scope.phoneTypes = {};
    
    phoneTypesProvider.getPhoneTypes().success(function(response) {
         $scope.phoneTypes = response.data;
    }).error(function (response, status) {
       console.log(response);
    });
    
    
}])
.controller('PhonesCtrl', ['$scope', 'phonesProvider', 'phoneTypesProvider',
    function($scope, phonesProvider, phoneTypesProvider) {
    
        $scope.phones = {};
        $scope.phoneTypes = {};
        
        
        phonesProvider.getPhones().success(function(response) {
             $scope.phones = response.data;              
        }).error(function (response, status) {
           console.log(response);
        });  
        
        
        phoneTypesProvider.getPhoneTypes().success(function(response) {
            $scope.phoneTypes = response.data;
        }).error(function (response, status) {
           console.log(response);
        });
    
}]);




