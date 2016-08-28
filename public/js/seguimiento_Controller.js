var app = angular.module('seguimiento', []);
var url="http://localhost/moprosoft/index.php/";
app.controller('seguimiento_Controller', function($scope, $http) {

  $scope.priorizadas=[];
  $scope.btn_terminar=false;
  $scope.tiempo=5;

  $scope.siguiente = function(){
    if (validar()){
      $scope.btn_terminar=true;
      $('.pnl_terminar').empty();
    }
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
    var hoy = new Date();
    var inicio=new Date(valuesInicio[2],valuesInicio[1],valuesInicio[0]);
    var final=new Date(valuesFinal[2],valuesFinal[1],valuesFinal[0]);

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
      $scope.priorizadas.push(new Array(id,$('#'+id).val()));
    });
    //console.log(JSON.stringify($scope.priorizadas));
    $('input[name="checkPriorizada"]').each(function() {
      if ( !$('#m'+$(this).val()).prop('checked') ) {
        $('#o'+$(this).val()).empty();
      }
    });

    console.log($scope.priorizadas);
  }


});
