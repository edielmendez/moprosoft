var app = angular.module('question', []);
var url="http://localhost/moprosoft/index.php/";
app.controller('question_Controller', function($scope, $http) {

  $scope.questions;
  $scope.bandera=false;

  $scope.index = function(){
    $http.get(url+"question_Controller/index").success(function(response){
      if (response.length>0) {
          $scope.questions=response;
          $scope.bandera=true;
      }
      }
    );
  }

});
