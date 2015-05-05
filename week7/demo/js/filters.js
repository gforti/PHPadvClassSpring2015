'use strict';

var appFilters = angular.module('appFilters', []);

appFilters.filter('activeString', function() {
    return function(active) {        
        return ( !!active ? 'Yes' : 'No');
    };
});