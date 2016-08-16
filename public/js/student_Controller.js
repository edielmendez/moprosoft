var app = angular.module('student', []);
var url="http://localhost/moprosoft/index.php/";
app.controller('student_Controller', function($scope, $http) {

  $scope.preguntas;
  $scope.respuestas;
  $scope.preguntasFiltradas;

  $scope.numPregunta1=1;
  $scope.numPregunta2=2;

  $scope.Pregunta1='';
  $scope.Pregunta2='';

  $scope.startt=0;
  $scope.end=2;
  $scope.longitud=0;
  $scope.porcentaje=0;
  $scope.bandera=0;
  $scope.terminar=0;

  $scope.index = function(){
    $http.get(url+"Student_Controller/getQuestions/"+$("#cuestionario_id").val()).success(function(response){
      $scope.preguntas=response;
      $scope.longitud=response.length;
      console.log("Preguntas:"+$scope.longitud);
      console.log("PREGUNTAS:"+JSON.stringify(response));
      var inicio=0;
      for (var i=0; $scope.preguntas[i].res!=0; i++) {
        inicio=i;
      }

      if (inicio!=0) {
        $scope.startt=inicio-1;
        $scope.end=inicio+1;
        $scope.numPregunta1=inicio;
        $scope.numPregunta2=inicio+1;

      }
      PosicionarSection();
      $scope.preguntasFiltradas=response.slice($scope.startt,$scope.end);
      RecuperarRespuestas();
      }
    );
  }

  $scope.atras = function(){
      console.log("Indices antes de ATRAS:star - "+$scope.startt+"  end -  "+$scope.end);
      CambiarSectionAtras();
      $scope.terminar=0;
      if ($scope.bandera==1) {
        $scope.bandera=0;
        $("#ContenedorPregunta2").show();
        $scope.startt+=2;
        $scope.end+=2;
        $scope.numPregunta1=$scope.numPregunta2+1;
        $scope.numPregunta2+=2;
      }

      $scope.porcentaje=(calculoAvanze()*100)/$scope.longitud;
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
          RecuperarRespuestas();
      }

      console.log("Indices despues de ATRAS:star - "+$scope.startt+"  end -  "+$scope.end);
  }

  $scope.siguiente = function(){
    if (validacion()) {
          GuardarRespuestas();
          GuardarRespuestasBD();
          LimpiarRadioButton();
          console.log("Indices antes de SIGUIENTE:star - "+$scope.startt+"  end -  "+$scope.end);
          CambiarSectionSiguiente();
          if ($scope.startt+2<$scope.longitud) {
            if ( ($scope.startt+2)!=($scope.longitud-1) ) {
              $scope.startt+=2;
            }else {
                $scope.bandera=1;
            }
            $scope.numPregunta1+=2;
          }

          if ($scope.end+2<=$scope.longitud) {
            $scope.end+=2;
            $scope.numPregunta2+=2;
          }

          $scope.porcentaje=(calculoAvanze()*100)/$scope.longitud;

          if ($scope.startt>=0 && $scope.end<=$scope.longitud) {
            if ($scope.bandera==1) {
              $("#ContenedorPregunta2").hide();
              $scope.preguntasFiltradas[0]=$scope.preguntas[$scope.longitud-1];
              $scope.preguntasFiltradas[1]=[];
              $scope.terminar=1;
            }else {
              $scope.preguntasFiltradas=$scope.preguntas.slice($scope.startt,$scope.end);
            }

          }

          if ($scope.end==$scope.longitud) {
            $scope.terminar=1;
          }
          RecuperarRespuestas();
          console.log("Indices despues de SIGUIENTE:star - "+$scope.startt+"  end -  "+$scope.end);
    }else {
      console.log("Responda todas las preguntas");
    }
  }

  function calculoAvanze() {
    var sum=0;
    for (var i = 0; i < $scope.preguntas.length; i++) {
      if ($scope.preguntas[i].res!=0) {
        sum++;
      }
    }
    return sum;
  }

  $scope.terminarEncuesta =function () {
    if (validacion()) {
        var avanze = calculoAvanze();
        if ($scope.longitud % 2 == 0) {
          avanze+=2;
        }else {
          avanze+=1;
        }

        if ( avanze==$scope.longitud) {
          var asignacion = {'questionary_id1': $("#cuestionario_id").val()};

          if ($scope.longitud % 2 ==0) {
            asignacion['question_id1']=$scope.preguntas[$scope.startt].id;
            asignacion['answer_id1']=$("input[name='respuesta1']:checked").val();
            asignacion['question_id2']=$scope.preguntas[$scope.end-1].id;
            asignacion['answer_id2']=$("input[name='respuesta2']:checked").val();
          }else {
            asignacion['question_id1']=$scope.preguntas[$scope.startt].id;
            asignacion['answer_id1']=$("input[name='respuesta1']:checked").val();
          }

          $http.post(url+"Student_Controller/terminar", asignacion ).success(function(data){
            console.log("Peticion realizada exitosamente:"+data);
            window.location.href = url+'Student_Controller/index';
          }).error(function(data){
            console.log(data.error);
          });
        }else {

        }
    }else {
      console.log("Responda todas las preguntas");
    }

  }

  $scope.$watch('startt', function() {
    if ($scope.startt==0) {
      $('#atras').attr("disabled", true);
    }else{
      $('#atras').attr("disabled", false);
    }
  });

  $scope.$watch('end', function() {
    if ($scope.end<$scope.longitud) {
      $("#ContenedorPregunta2").show();
      $scope.terminar=0;
    }
  });

  function validacion() {
    var p1=$('input:radio[name=respuesta1]:checked').val();
    var p2=$('input:radio[name=respuesta2]:checked').val();

    if ($scope.bandera==1) {
      if (p1!=undefined) {
        return true;
      }else {
          $("#pre1").append('<p style="color:red">Seleccione una respuesta</p>');
          return false;
      }
    }

    if (p1!=undefined && p2!=undefined) {
          $("#pre1").empty();
          $("#pre2").empty();
        return true;
    }else {
      if (p1==undefined) {
        $("#pre1").append('<p style="color:red">Seleccione una respuesta</p>');
      }

      if (p2==undefined) {
        $("#pre2").append('<p style="color:red">Seleccione una respuesta</p>');
      }
      return false;
    }

  }

  function RecuperarRespuestas() {
      if ($scope.preguntasFiltradas[0].res!=undefined) {
        $('input[name=respuesta1][value='+parseInt($scope.preguntasFiltradas[0].res)+']').prop( "checked", true );
      }

      if ($scope.preguntasFiltradas[1].res!=undefined) {
        $('input[name=respuesta2][value='+parseInt($scope.preguntasFiltradas[1].res)+']').prop( "checked", true );
      }
  }

  $scope.secciones = function(n) {
      $scope.bandera=0;
      if (n!=undefined) {

        if (n==1) {
          $scope.numPregunta1=1;
          $scope.numPregunta2=2;
          $scope.startt=0;
          $scope.end=2;
        }else {
          $scope.numPregunta1=((n-1)*10)+1;
          $scope.numPregunta2=((n-1)*10)+2;
          $scope.startt=((n-1)*10);
          $scope.end=((n-1)*10)+2;
        }

        if ($scope.end>$scope.longitud) {
          $("#ContenedorPregunta2").hide();
          $scope.preguntasFiltradas[0]=$scope.preguntas[$scope.longitud-1];
          $scope.preguntasFiltradas[1]=[];
          $scope.terminar=1;
        }else {
          $scope.terminar=0;
          $scope.preguntasFiltradas=$scope.preguntas.slice($scope.startt,$scope.end);
          LimpiarRadioButton();
          $("#pre1").empty();
          $("#pre2").empty();
          RecuperarRespuestas();
        }

      }
  }

  function GuardarRespuestas() {
    $scope.preguntas[$scope.startt].res=$("input[name='respuesta1']:checked").val();
    $scope.preguntas[$scope.end-1].res=$("input[name='respuesta2']:checked").val() ;
  }

  function LimpiarRadioButton() {
      $('input[name=respuesta1]').prop( "checked", false );
      $('input[name=respuesta2]').prop( "checked", false );
  }

  function CambiarSectionSiguiente() {
    var array=[10,20,30,40,50,60,70,80,90,100];
    var status=0;

    for (var i=0; i < array.length; i++) {
      if (array[i]==$scope.end) {
        status=1;
      }
    }

    if ($scope.terminar==0 && status==1) {
      var seleccionar=($scope.end/10)+1;
      $('#tabMostrar'+seleccionar).click();
    }
  }

  function PosicionarSection() {

    var array=[10,20,30,40,50,60,70,80,90];
    var posicion=0;

    for (var i = 0; i < array.length; i++) {
      if ($scope.end>array[i]) {
          posicion=array[i];
      }
    }

    $('#tabMostrar'+( (posicion/10)+1)).click();
    console.log("startt:"+posicion);
  }

  function CambiarSectionAtras() {

    var array=[10,20,30,40,50,60,70,80,90];
    var status=0;

    for (var i=0; i < array.length; i++) {
      if (array[i]==$scope.startt) {
        status=1;
      }
    }

    if (status==1) {
      var seleccionar=$scope.startt/10;
      $('#tabMostrar'+seleccionar).click();
    }else if ($scope.bandera==1) {
      var seleccionar=($scope.startt+2)/10;
      $('#tabMostrar'+seleccionar).click();
    }
  }

  function GuardarRespuestasBD(){
    var asignacion = {'questionary_id1': $("#cuestionario_id").val(),
                      'question_id1':$scope.preguntas[$scope.startt].id,
                      'answer_id1':$("input[name='respuesta1']:checked").val(),
                      'question_id2':$scope.preguntas[$scope.end-1].id,
                      'answer_id2':$("input[name='respuesta2']:checked").val()
                     };

    $http.post(url+"Student_Controller/save", asignacion ).success(function(data){
      console.log("Peticion realizada exitosamente:"+data);
    }).error(function(data){
      console.log(data.error);
    });

  }

});
