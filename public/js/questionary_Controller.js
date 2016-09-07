var app = angular.module('questionary', []);
var url="http://localhost/moprosoft/index.php/";
app.controller('questionary_Controller', function($scope, $http) {

  $scope.phases;
  $scope.process;
  $scope.cuestionarios;
  $scope.bandera='Por el momento no existe ningún Cuestionario';

  $scope.index = function(){
    $http.get(url+"questionary_Controller/getProcess").success(function(response){
      if (response) {
        $scope.process=response;
      }
      }
    );
    //Obteniendo los Cuestionarios de manera general
    $http.get(url+"questionary_Controller/getQuestionary").success(function(response){
      if (response.length>0) {
        $scope.cuestionarios=response;
        $scope.bandera='';
      }
      //console.log("Cuestionarios:"+JSON.stringify(response));
      //console.log(response.length);
      //console.log("Bandera:"+$scope.bandera);
      }
    );

  }
  //Funcion que cargar las Fases/Objetivos de manera dinamica
  $scope.cargarPhases = function(){
    if ($scope.proceso=="Todos") {
      $http.get(url+"questionary_Controller/getQuestionary").success(function(response){
        $scope.cuestionarios=response;
        $scope.phases=[];
        }
      );
    }else{
      //Obtenemos las Fases/Objetivos de un Proceso en especifico
      $http.get(url+"phase_Controller/getPhase_ProcessId/"+$scope.proceso).success(function(response){
          $scope.phases=response;
          $scope.cuestionarios=response;
        }
      );
      console.log("Especifico");
    }
  }

  $scope.cargarCuestionarios = function(){
      //Obtenemos los cuestionarios de una fase en especifico
    if ($scope.fase) {
      $http.get(url+"questionary_Controller/getCuestionary_PhaseId/"+$scope.fase).success(function(response){
        $scope.cuestionarios=response;
        console.log("CUESTIONARIOS:"+JSON.stringify(response));
        }
      );
    }
  }

});
