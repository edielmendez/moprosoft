var app = angular.module('student', []);
var url="http://localhost/moprosoft/index.php/";
app.controller('student_Controller', function($scope, $http) {

  $scope.preguntas;
  $scope.preguntasFiltradas;

  $scope.numPregunta1=1;
  $scope.numPregunta2=2;

  $scope.Pregunta1='';
  $scope.Pregunta2='';

  $scope.startt=0;
  $scope.end=2;
  $scope.longitud=0;
  $scope.porcentaje=0;


  $scope.index = function(){
    $http.get(url+"student_Controller/getQuestions/"+$("#cuestionario_id").val()).success(function(response){
      $scope.preguntas=response;
      $scope.preguntasFiltradas=response.slice($scope.startt,$scope.end);
      //$scope.startt=$scope.startt+2;
      //$scope.end=$scope.end+2;
      $scope.longitud=response.length;
      console.log("que"+JSON.stringify($scope.preguntasFiltradas[0]));
      console.log("Enserio"+$scope.preguntasFiltradas);
      console.log("Numero:"+  $scope.longitud);
      }
    );
  }

  $scope.atras = function(){
    if (validacion()) {
      console.log("Indices antes de ATRAS:star - "+$scope.startt+"  end -  "+$scope.end);
      $scope.porcentaje=($scope.startt*100)/$scope.longitud;

      if ($scope.startt-2>=0) {
        $scope.startt-=2;
        $scope.numPregunta1-=2;
      }
      if($scope.end-2>0){
        $scope.end-=2;
        $scope.numPregunta2-=2;
      }

      if ($scope.startt>=0 && $scope.end<=$scope.longitud) {
          $scope.preguntasFiltradas=$scope.preguntas.slice($scope.startt,$scope.end);
      }

      console.log("Indices despues de ATRAS:star - "+$scope.startt+"  end -  "+$scope.end);
    }else {
      console.log("Responda todas las preguntas");
    }
  }

  $scope.siguiente = function(){
    if (validacion()) {
          $('#p1').attr('checked', false);
          //$('input[name=respuesta2]').attr('checked', false);
          //$( "#p1" ).prop( "checked", false );
          //$scope.check = false;
          //$('input:radio[name=respuesta1]:checked').attr('checked', false);
          //$('input:radio[name=respuesta2]:checked').attr('checked', false);
          //$(this).prop('checked', false);
          console.log("Indices antes de SIGUIENTE:star - "+$scope.startt+"  end -  "+$scope.end);

          if ($scope.startt+2<$scope.longitud) {
            $scope.startt+=2;
              $scope.numPregunta1+=2;
          }
          if ($scope.end+2<=$scope.longitud) {
            $scope.end+=2;
            $scope.numPregunta2+=2;
          }

          $scope.porcentaje=($scope.end*100)/$scope.longitud;

          if ($scope.startt>=0 && $scope.end<=$scope.longitud) {
              $scope.preguntasFiltradas=$scope.preguntas.slice($scope.startt,$scope.end);
          }

          console.log("Indices despues de SIGUIENTE:star - "+$scope.startt+"  end -  "+$scope.end);
    }else {
      console.log("Responda todas las preguntas");
    }
  }

  $scope.terminar =function () {
    alert("Que onda, ya terminaste");
  }

  $scope.$watch('startt', function() {
    if ($scope.startt==0) {
      $('#atras').attr("disabled", true);
    }else if($scope.startt==2){
      $('#atras').attr("disabled", false);
    }
  });

  function validacion() {
    var p1=$('input:radio[name=respuesta1]:checked').val();
    var p2=$('input:radio[name=respuesta2]:checked').val();
    if (p1!=undefined && p2!=undefined) {
        return true;
    }else {
      return false;
    }

  }

});
