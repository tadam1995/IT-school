;(function(window, angular) {

  'use strict';

  // Application module
  angular.module('app', [
    'ui.router', 
    'app.common',
    'app.language',
    'app.user', 
    'app.form'
  ])

  // Application config
  .config([
    '$stateProvider', 
    '$urlRouterProvider', 
    ($stateProvider, $urlRouterProvider) => {

      // Set arguments for user states
			let args = {
				subFolder: 'html',
				isContent: true,
				isMinimize: true
			};

      $stateProvider
        .state('root', {
			  	abstract: true,
			  	views: {
			  		'@': {
			  			templateUrl: './html/root.html'
			  		},
			  		'header@root': {
			  			templateUrl: './html/navigate.html'
			  		},
			  		'footer@root': {
			  			templateUrl: './html/footer.html'
			  		}
			  	}
        })
        .state('home', {
          url: '/',
          parent: 'root',
          templateUrl: './html/home.html',
          controller: 'homeController'
        })
        .state('introduction', {
          url: '/introduction',
          parent: 'root',
          templateUrl: './html/introduction.html',
          controller: 'introductionController'
        })
        .state('courses', {
          url: '/courses',
          parent: 'root',
          templateUrl: './html/courses.html',
          controller: 'coursesController'
        })
        .state('community', {
          url: '/community',
          parent: 'root',
          templateUrl: './html/community.html',
          controller: 'communityController'
        })
        .state('contact', {
          url: '/contact',
          parent: 'root',
          templateUrl: './html/contact.html',
          controller: 'contactController'
        })
        .state('kepzesek', {
          url: '/kepzesek',
          parent: 'root',
          templateUrl: './html/kepzesek.html',
          controller: 'kepzesekController',
          params: {
            course: null
          }
        })
        .state('login', {
          url: '/login',
          parent: 'root',
          group: 'user',
          templateProvider: ['file', file => file.get('login.html', args)],
          controller: 'userController'
        })
        .state('register', {
          url: '/register',
          parent: 'root',
          group: 'user',
          templateProvider: ['file', file => file.get('register.html', args)],
          controller: 'userController'
        })
        .state('profile', {
          url: '/profile',
          parent: 'root',
          group: 'user',
          templateProvider: ['file', file => file.get('profile.html', args)],
          controller: 'userController'
        })
        .state('password_frogot', {
          url: '/password_frogot',
          parent: 'root',
          group: 'user',
          templateProvider: ['file', file => file.get('password_frogot.html', args)],
          controller: 'userController'
        })
        .state('password_change', {
          url: '/password_change',
          parent: 'root',
          group: 'user',
          templateProvider: ['file', file => file.get('password_change.html', args)],
          controller: 'userController'
        })
        .state('email_change', {
          url: '/email_change',
          parent: 'root',
          group: 'user',
          templateProvider: ['file', file => file.get('email_change.html', args)],
          controller: 'userController'
        })
        .state('email_confirm', {
          url: '/email_confirm?e&i&l',
          parent: 'root',
          templateProvider: ['file', file => file.get('email_confirm.html', args)],
          controller: 'emailConfirmController'
        });
      
      $urlRouterProvider.otherwise('/');
    }
  ])

  // Application run
  .run([
    '$rootScope',
    'trans',
    'lang',
    'user',
    ($rootScope, trans, lang, user) => {

      // Transaction events
			trans.events({group:'user'});

      // Initialize language 
      lang.init();

      // Initialize user
      user.init();

      // Get current date
      $rootScope.currentDay = new Date();
    }
  ])

  // Home controller
  .controller('homeController', [
    '$scope',
    'http',
    function($scope, http) {

      // Http request
      http.request('./php/carousel.php')
      .then(response => {
        $scope.carousel = response;
        $scope.$applyAsync();
      })
      .catch(e => console.log(e));
    }
  ])

   // Introduction controller
   .controller('introductionController', [
    '$scope',
    'http',
    function($scope, http) {

      // Http request
      http.request('./php/carousel.php')
      .then(response => {
        $scope.carousel = response;
        $scope.$applyAsync();
      })
      .catch(e => console.log(e));
    }
  ])

  // Community controller
  .controller('communityController', [
    '$scope',
    'http',
    function($scope, http) {

      $scope.teacherData = (event) => {
        let element = event.currentTarget;
        $scope.teacherImg = element.dataset.img;
        $scope.teacherContent = element.dataset.content;
        $scope.teacherFull_name = element.dataset.full_name;
        $scope.$applyAsync();
      }
      // Http request
      http.request('./php/teachers.php')
      .then(response => {
        $scope.teachers = response;
        $scope.$applyAsync();
      })
      .catch(e => console.log(e));
    }
  ])

  // Kepzes controller
  .controller('kepzes1Controller', [
    '$scope',
    'http',
    function($scope, http) {

      // Http request
      http.request('./php/subjects.php')
      .then(response => {
        $scope.subjects = response;
        $scope.$applyAsync();
      })
      .catch(e => console.log(e));
    }
  ])

  // Courses controller
  .controller('coursesController', [
    '$scope',
    'http',
    function($scope, http) {

      // Http request
      http.request('./php/courses.php')
      .then(response => {
        $scope.courses = response;
        $scope.$applyAsync();
      })
      .catch(e => console.log(e));
    }
  ])

  // Kepzesek controller
  .controller('kepzesekController', [
    '$rootScope',
    '$scope',
    '$state',
    '$stateParams',
    'http',
    function($rootScope, $scope, $state, $stateParams, http) {

      // Get/Check parameters
      $scope.course = $stateParams.course;
      if (!$scope.course) {
        $state.go('home');
        return;
      }

      // Http request get courses begin dates
      http.request({
        url: './php/course_dates.php',
        data: {id: $scope.course.course_id}
      })
      .then(response => {
        $scope.courseDates = response;
        $scope.$applyAsync();
      })
      .catch(e => console.log(e));

      console.log($scope.course);

      // 

      $scope.isCheckboxChecked = false; 
      
      $scope.send = (course) => {
        console.log(course, $scope.date)

        http.request({
          url: './php/students.php',
          data: {
            courseId: course.course_id,
            beg: $scope.date,
            userId: $rootScope.user.id
          }
        })
        .then(response => {
          if(response.affectedRows === 1){
            alert("sikeres jelentkezés")
          }
          $scope.$applyAsync();
        })
        .catch(e => console.log(e));

        
      };
    }
  ])

  .controller("contactController", [
    '$rootScope',
    '$scope', 
    'http', 
    function ($rootScope, $scope, http) {

      //
      $scope.formData = {
          subject: '',
          email: '',
          message: ''
      };
      
      // process the form
      $scope.processForm = function () {

        // Http request
        http.request({
          method: 'POST',
          url : `./php/contact.php`,
          data: {
            lang: {
              id: $rootScope.lang.id,
              type: $rootScope.lang.type
            },
            params: $scope.formData
          }
        })
        .then(response => {
          console.log(response);
        })
        .catch(e => {console.log(e);});
      }
    } 
  ]);

})(window, angular);