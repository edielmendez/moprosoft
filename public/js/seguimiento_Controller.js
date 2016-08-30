var app = angular.module('seguimiento', ['ngRoute']);
var url="http://localhost/moprosoft/index.php/";
var url_htmls="http://localhost/moprosoft/";
// configure our routes
app.config(function($routeProvider) {
  $routeProvider

    .when('/', {
      templateUrl : url_htmls+'public/js/mostrar-preguntas.html',
      controller  : 'seguimiento_Controller'
    })

    .when('/preguntas_priorizadas', {
      templateUrl : url_htmls+'public/js/mostrar-preguntas.html',
      controller  : 'priorizadas_Controller'
    })

});

app.service('serveData', [function () {
  this.preguntas = {};
  this.priorizadas = [];
  this.btn_atras_index = function () {
    window.location.href = url+'Modelos/resultado';
  };

}])

app.controller('inicio_Controller', ['$scope', 'serveData', '$http' ,function ($scope, serveData,$http) {
  $scope.getPreguntas = function (phase) {
    $http.get(url+"Modelos/getSeguimiento/"+phase).success(function(response){
      if (response.length>0) {
        if (typeof(Storage) !== "undefined") {
            localStorage.setItem("preguntas",JSON.stringify(response));
        } else {
            console.log("No se pudo guardar las preguntas.");
        }
        window.location.href = url+"Modelos/Seguimiento/"+phase;
      }
    });

  }
}]);

app.controller('seguimiento_Controller', ['$scope', 'serveData', '$http' ,function ($scope, serveData,$http) {

 if (localStorage.getItem("preguntas")!=null) {
    serveData.preguntas=JSON.parse( localStorage.getItem("preguntas") );
    $scope.preguntas=JSON.parse( localStorage.getItem("preguntas") );
    console.log(serveData.preguntas);
  }

  $scope.siguiente = function(){
    if (validar()){
      window.location.href='#preguntas_priorizadas'
    }
  }

  var validar = function() {
    if ($('input[name="checkPriorizada"]:checked').length>0) {
      getInformacion();
      $("#validacion").empty();
      return 1;
    }
    $("#validacion").empty();
    $("#validacion").append('<p style="color:red">Priorize al menos una Actividad.</p>');
    return 0;
  }

  var getInformacion = function () {
    $('input[name="checkPriorizada"]:checked').each(function() {
      var id=$(this).val();
      serveData.priorizadas.push(new Array(id,$('#'+id).val()));
      //$scope.priorizadas.push(new Array(id,$('#'+id).val()));
    });
  }

}]);

app.controller('priorizadas_Controller', ['$scope', 'serveData', '$http' ,function ($scope, serveData,$http) {
  $scope.priorizadas = serveData.priorizadas;
}]);

/*

$scope.btn_terminar=false;
$scope.tiempo=5;
$scope.bandera=false;


$scope.subir = function(id){
  console.log("lo que me llego:"+id);
  var posicion=buscarElemento(id);
  //$('#o'+id).empty();
  cambiOrdenPreguntas(posicion,posicion-1)
  console.log($scope.priorizadas);
}

$scope.bajar = function(id){
  console.log(buscarElemento(id));
}

var buscarElemento = function(valor) {
  for (var i = 0; i < $scope.priorizadas.length; i++) {
    if ($scope.priorizadas[i][0]==valor) {
          return i;
    }
  }
}

var cambiOrdenPreguntas =function(posicion,nueva_posicion) {
  var respaldo=new Array($scope.priorizadas[nueva_posicion][0],$scope.priorizadas[nueva_posicion][1]);
  CambioTexto($scope.priorizadas[posicion][0],$scope.priorizadas[nueva_posicion][1],$scope.priorizadas[nueva_posicion][0],$scope.priorizadas[posicion][1]);
  $scope.priorizadas[nueva_posicion]= new Array($scope.priorizadas[posicion][0],$scope.priorizadas[posicion][1]);
  $scope.priorizadas[posicion]=respaldo;
}

var CambioTexto = function(id,text,id2,text2) {
  var respaldo=$('#o'+id).html();
  $('#o'+id).html($('#o'+id2).html());
  $('#o'+id2).html(respaldo);

}


function tiempoContador() {
  $scope.tiempo--;
  $("#tiempoSpan").empty();
  $("#tiempoSpan").append($scope.tiempo);
  if ($scope.tiempo==0) {
      window.location.href = url+'Modelos/resultado';
  }
}

$scope.terminar = function(){

  if ( validarFecha($("#from").val(),$("#to").val()) ) {
    var asignacion = {'phase': $("#phase").val(),'fi':$("#from").val(),'ff':$("#to").val()};
    $http.post(url+"Modelos/terminarSeguimiento", asignacion ).success(function(data){
      console.log("Se creo el seguimiento de forma correcta:"+data);
      //Se inserta las preguntas priorizadas
      var pre={ 'id':data, 'preguntas':[] };
      for (var i = 0; i < $scope.priorizadas.length; i++) {
        pre.preguntas.push({'id':$scope.priorizadas[i][0],'activity':$scope.priorizadas[i][1]});
      }
      $http.post(url+"Modelos/SeguimientoPreguntasPriorizadas", pre ).success(function(data){
        console.log("Se insertaron las preguntas priorizadas de forma correcta:"+data);
        $("#contenido").empty();
        $("#cabezera").empty();
        $("#contenido").append('<div class="text-center" id="aviso_en_preguntas"><br><br><br><h1>Seguimiento Realizado</h1><h3>Tu plan de acción se puso en marcha.</h3><h4>Redireccionar en <span id="tiempoSpan">5</span></h4></div>');
        setInterval(tiempoContador, 1000);
      }).error(function(data){
        console.log(data);
      });

    }).error(function(data){
      console.log(data);
    });

  }
}

var validarFechaMayorAHoy=function(fi,ff ) {
  var valuesInicio=fi.split("/");
  var valuesFinal=ff.split("/");
  console.log("Despues del split fi:"+valuesInicio);
  console.log("Despues del split ff:"+valuesFinal);
  var hoy = new Date();
  var inicio=new Date(valuesInicio[2],valuesInicio[0],valuesInicio[1]);
  var final=new Date(valuesFinal[2],valuesFinal[0],valuesFinal[1]);
  console.log("hoy:"+hoy);
  console.log("inicio:"+hoy);
  console.log("final:"+hoy);
  if (inicio>=hoy && final>hoy) {
    console.log("no estan alteradas");
    return 1;
  }else {
    $('#valFechas').empty();
    $('#valFechas').append('<p style="color:red">Las fechas están alteradas.</p>');
    console.log("estan alteradas");
    return 0;
  }
}

var validarFecha = function(fi,ff) {

  var ExpReg = /^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/;
  var val1 = ExpReg.test(fi)
  var val2 = ExpReg.test(ff)

  var res=validarFechaMayorAHoy(fi,ff);
  if (res==0) {
    return 0;
  }

  if (fi!="" && ff!="")  {
    if (val1 && val2) {
      $('#valFechas').empty();
      return 1;
    }else {
      $('#valFechas').empty();
      $('#valFechas').append('<p style="color:red">Fechas no válidas.</p>')
      return 0;
    }

  }else {
    $('#valFechas').empty();
    $('#valFechas').append('<p style="color:red">Fechas vacias.</p>');
    return 0;
  }

}




*/
