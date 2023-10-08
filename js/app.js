;(function(window, angular) {

  'use strict';

  // Application module
  angular.module('app', [
    'ui.router', 
    'app.common',
    'app.language', 
    'app.form'
  ])

  // Application config
  .config([
    '$stateProvider', 
    '$urlRouterProvider', 
    ($stateProvider, $urlRouterProvider) => {

      $stateProvider
        .state('home', {
          url: '/',
          templateUrl: './html/home.html',
          controller: 'homeController'
        })
        .state('page1', {
          url: '/page1',
          templateUrl: './html/page1.html',
          controller: 'page1Controller'
        })
        .state('page2', {
          url: '/page2',
          templateUrl: './html/page2.html',
          controller: 'page2Controller'
        })
        .state('page3', {
          url: '/page3',
          templateUrl: './html/page3.html',
          controller: 'page3Controller'
        })
        .state('login', {
          url: '/login',
          templateUrl: './html/user.html',
					controller: 'userController'
        })
        .state('register', {
          url: '/register',
          templateUrl: './html/user.html',
					controller: 'userController'
        })
        .state('profile', {
          url: '/profile',
          templateUrl: './html/user.html',
					controller: 'userController'
        })
        .state('email', {
          url: '/email',
          templateUrl: './html/user.html',
					controller: 'userController'
        })
        .state('password', {
          url: '/password',
          templateUrl: './html/user.html',
					controller: 'userController'
        });
      
      $urlRouterProvider.otherwise('/');
    }
  ])

  
  // Application run
  .run([
    'trans',
    'lang',
    (trans, lang) => {

      // Transaction events
			trans.events('home,page1,page2');

      // Initialize language 
      lang.init();
    }
  ])

  // Home controller
  .controller('homeController', [
    '$rootScope',
    function($rootScope) {

      console.log($rootScope.state.id);
    }
  ])

  // Page1 controller
  .controller('page1Controller', [
    '$rootScope',
    function($rootScope) {

      console.log($rootScope.state.id);
    }
  ])

  // Page2 controller
  .controller('page2Controller', [
    '$rootScope',
    function($rootScope) {

      console.log($rootScope.state.id);
    }
  ])

  // Page3 controller
  .controller('page3Controller', [
    '$rootScope',
    function($rootScope) {

      console.log($rootScope.state.id);
    }
  ]);

})(window, angular);