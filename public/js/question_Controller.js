var app = angular.module('question', ['ui.bootstrap']);
var url="http://localhost/moprosoft/index.php/";
app.controller('question_Controller', function($scope, $http) {

  $scope.questions=[];
  $scope.bandera=false;

  /*$scope.filteredTodos={};
  $scope.currentPage=0;
  $scope.numPerPage=0;
  $scope.maxSize=0;*/


    $scope.filteredTodos = {}
    ,$scope.currentPage = 1
    ,$scope.numPerPage = 5
    //Numero de botonoes a mostrar
    ,$scope.maxSize = 10;

  $scope.index = function(){
    $http.get(url+"question_Controller/index").success(function(response){
      if (response.length>0) {
          $scope.questions=response;
          $scope.bandera=true;
          //$scope.makeTodos();
          /*$scope.currentPage = 1;
          $scope.numPerPage = 2;
          $scope.maxSize = 10;*/
      }
    }
    );
  }

  /*$scope.$watch('currentPage + numPerPage', function() {
   var begin = (($scope.currentPage - 1) * $scope.numPerPage)
   , end = begin + $scope.numPerPage;

   console.log("Esto son las preguntas:"+JSON.stringify($scope.questions));

    $scope.filteredTodos = $scope.questions.slice(begin, end);

   console.log("Esto son los datos ya filtrados:"+JSON.stringify($scope.filteredTodos));
 });*/


  $scope.makeTodos = function() {
    console.log("SOy makeTodos:"+JSON.stringify($scope.questions));
    $scope.todos = [];
    for (i=1;i<=20;i++) {
      $scope.todos.push({ text:'todo '+i});
    }
  }

  $scope.makeTodos();


  $scope.$watch('currentPage + numPerPage', function() {
   var begin = (($scope.currentPage - 1) * $scope.numPerPage)
   , end = begin + $scope.numPerPage;

   console.log("Cuando cambio el dato de una variable");
    console.log("datos:"+JSON.stringify($scope.todos));
   $scope.filteredTodos = $scope.todos.slice(begin, end);
   //$scope.filteredTodos = $scope.todos.slice(begin, end);
   console.log("Esto son los datos ya filtrados:"+JSON.stringify($scope.filteredTodos));
  });


});
