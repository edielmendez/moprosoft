var app = angular.module('question', ['ui.bootstrap']);
var url="http://localhost/moprosoft/index.php/";
app.controller('question_Controller', function($scope, $http) {

  $scope.questions;
  $scope.bandera=false;

  $scope.filteredTodos;
  $scope.currentPage;
  $scope.numPerPage;
  $scope.maxSize;
  $scope.pregunta=2;

  $scope.index = function(){
    $http.get(url+"question_Controller/index").success(function(response){
      if (response.length>0) {
          $scope.questions=response;
          $scope.bandera=true;
          $scope.currentPage = 1;
          $scope.numPerPage = 2;
          $scope.maxSize = 10;
      }
    }
    );
  }

  $scope.$watch('currentPage + numPerPage', function() {
   var begin = (($scope.currentPage - 1) * $scope.numPerPage)
   , end = begin + $scope.numPerPage;
   console.log("Esto son las preguntas:"+JSON.stringify($scope.questions));
   if ($scope.questions!=undefined) {
    $scope.filteredTodos = $scope.questions.slice(begin, end); 
   }
   console.log("Esto son los datos ya filtrados:"+JSON.stringify($scope.filteredTodos));
  });


});
