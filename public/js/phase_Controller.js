var app = angular.module('phase', []);
var url="http://localhost/moprosoft/index.php/";
app.controller('phase_Controller', function($scope, $http) {

  $scope.phases;
  $scope.process;

  $scope.banderaphases=false;
  $scope.banderaprocess=false;

  $scope.index = function(){
    //Ontenemos todas las Fases/Objetivos
    $http.get(url+"phase_Controller/getindex").success(function(response){
      $scope.phases=response;
      $scope.banderaphases=true;  
      console.log(response);
      console.log(response.length);
      }
    );
    //Ontenemos todas los procesos
    $http.get(url+"phase_Controller/getProcess").success(function(response){
      if (response) {
        $scope.process=response;
        $scope.banderaprocess=true;
      }
      console.log(response);
      console.log(response.length);
      }
    );

  }

  //Funcion que cargar las Fases/Objetivos de manera dinamica
  $scope.cargarProcess = function(){
    if ($scope.proceso=="Todos") {
      //Obtenemos todos las Fases/Objetivos
      $http.get(url+"phase_Controller/getindex").success(function(response){
          $scope.phases=response;
        }
      );
    }else{
      //Obtenemos las Fases/Objetivos de un Proceso en especifico
      $http.get(url+"phase_Controller/getPhase_ProcessId/"+$scope.proceso).success(function(response){
          $scope.phases=response;
        }
      );
    }
  }

  //$scope.$watch($scope.cargarProcess);
});
