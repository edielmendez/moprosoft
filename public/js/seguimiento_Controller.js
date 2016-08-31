var app = angular.module('seguimiento', ['ngRoute','ui.calendar']);
var url="http://localhost/moprosoft/index.php/";
var url_htmls="http://localhost/moprosoft/";
// configure our routes
app.config(function($routeProvider) {
  $routeProvider

    .when('/', {
      templateUrl : url_htmls+'public/js/mostrar-preguntas.html',
      controller  : 'seguimiento_Controller'
    })

    .when('/preguntas-priorizadas', {
      templateUrl : url_htmls+'public/js/preguntas-priorizadas.html',
      controller  : 'priorizadas_Controller'
    })

    .when('/calendario', {
      templateUrl : url_htmls+'public/js/calendario.html',
      controller  : 'calendario_Controller'
    })

});

app.service('serveData', [function () {
  this.preguntas = {};
  this.priorizadas = {'p':[]};
}])

app.controller('inicio_Controller', ['$scope', 'serveData', '$http' ,function ($scope, serveData,$http) {
  //Se obtienen todas las actividades debiles de la base de datso
  $scope.getPreguntas = function (phase) {
    $http.get(url+"Modelos/getSeguimiento/"+phase).success(function(response){
      if (response.length>0) {
        //guardamos los las actividades en memoria
        if (typeof(Storage) !== "undefined") {
          if (localStorage.getItem('preguntas')!=undefined) {
            localStorage.removeItem('preguntas');
          }
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

 $scope.atras='http://localhost/moprosoft/index.php/Modelos/resultado'
 //Extraemos las actividades guardadas en memoria
 if (localStorage.getItem("preguntas")!=null) {
    serveData.preguntas=JSON.parse( localStorage.getItem("preguntas") );
    $scope.preguntas=JSON.parse( localStorage.getItem("preguntas") );
  }

  $scope.siguiente = function(){
    if (validar()){
      window.location.href='#/preguntas-priorizadas'
    }
  }

  $scope.atras = function(){
    window.location.href='http://localhost/moprosoft/index.php/Modelos/resultado'
  }

  //funcion que revisa que almenos una actividad ha sido priorizada para ponerlo el el plan de trabajo
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

  //funcion que obtiene los valores de los checbox seleccionados
  var getInformacion = function () {
    //recorremos los checkbox seleccionados
    serveData.priorizadas.p=[];
    $('input[name="checkPriorizada"]:checked').each(function() {
      var id=$(this).val();
      serveData.priorizadas.p.push( {'id':id,'question':$('#'+id).val()} );
    });
    //guardamos las actividades priorizadas en memoria
    if (typeof(Storage) !== "undefined") {
      if (localStorage.getItem('priorizadas')!=undefined) {
        localStorage.removeItem('priorizadas');
      }
      localStorage.setItem("priorizadas",JSON.stringify(serveData.priorizadas.p));
    } else {
        console.log("No se pudo guardar las preguntas.");
    }
  }

}]);

app.controller('priorizadas_Controller', ['$scope', 'serveData', '$http' ,function ($scope, serveData,$http) {

  $scope.orden=[];
  //Extraemos las preguntas priorizadas guardados en memoria
  if (localStorage.getItem("priorizadas")!=null) {
      $scope.priorizadas = JSON.parse( localStorage.getItem("priorizadas") );
      console.log( $scope.priorizadas );
   }

   //funcion obtiene el contenido html y lo pasa a la funcion buscaOrden para poder ser procesada
   $scope.siguiente = function () {
     var contenido=$("#preOrdenadas").html();
     buscaOrden(contenido);
     window.location.href ='#/calendario';
   }

   //funcion recursiva que recorre toda la tabla para poder dar un nuevo orden a las actividades
   var buscaOrden = function (cadena) {
     var indice = cadena.indexOf("ordenPreguntas");
     if (indice==-1) {
       guardarNuevoOrden();
       console.log(JSON.stringify($scope.orden) );
       return 0;
     }
     var final=indiceFinal(indice+14,cadena);
     nuevoOrden(cadena.substring(indice+14, final));
     buscaOrden(cadena.substring(final+1,cadena.length) );
   }
   //Gurdamos el nuevo orden para no perderlo
   var guardarNuevoOrden=function () {
     if (typeof(Storage) !== "undefined") {
       if (localStorage.getItem('nuevoOrden')!=undefined) {
         localStorage.removeItem('nuevoOrden');
       }
       localStorage.setItem("nuevoOrden",JSON.stringify($scope.orden));
     } else {
         console.log("No se pudo guardar las preguntas.");
     }
   }

   //funcion que retorna el indice final, para poder extraer un dato en particilar
   var indiceFinal = function (posicion,cadena) {
     var final=0;
     for (var i = posicion; i < cadena.length; i++) {
       if (cadena[i]=='\"') {
          final=i;
          i=cadena.length+100;
       }
     }
     return final;
   }

   //funcion que agrega nuevos elemenos ordenados
   var nuevoOrden= function (cadena) {
     var id = parseInt(cadena)
     $.each($scope.priorizadas, function(i, item) {
          if (item.id==id) {
            $scope.orden.push({'id':item.id,'question':item.question});
          }
      });
   }



}]);

app.controller('calendario_Controller', ['$scope', 'serveData', '$http' ,function ($scope, serveData,$http) {

      /*var date = new Date();
      var d = date.getDate();
      var m = date.getMonth();
      var y = date.getFullYear();

      $scope.changeTo = 'Hungarian';
      // event source that pulls from google.com
      $scope.eventSource = {
              url: "http://www.google.com/calendar/feeds/usa__en%40holiday.calendar.google.com/public/basic",
              className: 'gcal-event',           // an option!
              currentTimezone: 'America/Chicago' // an option!
      };
      // event source that contains custom events on the scope
      $scope.events = [
        {title: 'All Day Event',start: new Date(y, m, 1)},
        {title: 'Long Event',start: new Date(y, m, d - 5),end: new Date(y, m, d - 2)},
        {id: 999,title: 'Repeating Event',start: new Date(y, m, d - 3, 16, 0),allDay: false},
        {id: 999,title: 'Repeating Event',start: new Date(y, m, d + 4, 16, 0),allDay: false},
        {title: 'Birthday Party',start: new Date(y, m, d + 1, 19, 0),end: new Date(y, m, d + 1, 22, 30),allDay: false},
        {title: 'Click for Google',start: new Date(y, m, 28),end: new Date(y, m, 29),url: 'http://google.com/'}
      ];
      // event source that calls a function on every view switch
      $scope.eventsF = function (start, end, timezone, callback) {
        var s = new Date(start).getTime() / 1000;
        var e = new Date(end).getTime() / 1000;
        var m = new Date(start).getMonth();
        var events = [{title: 'Feed Me ' + m,start: s + (50000),end: s + (100000),allDay: false, className: ['customFeed']}];
        callback(events);
      };

      $scope.calEventsExt = {
         color: '#f00',
         textColor: 'yellow',
         events: [
            {type:'party',title: 'Lunch',start: new Date(y, m, d, 12, 0),end: new Date(y, m, d, 14, 0),allDay: false},
            {type:'party',title: 'Lunch 2',start: new Date(y, m, d, 12, 0),end: new Date(y, m, d, 14, 0),allDay: false},
            {type:'party',title: 'Click for Google',start: new Date(y, m, 28),end: new Date(y, m, 29),url: 'http://google.com/'}
          ]
      };
      // alert on eventClick
      $scope.alertOnEventClick = function( date, jsEvent, view){
          $scope.alertMessage = (date.title + ' was clicked ');
      };
      // alert on Drop
       $scope.alertOnDrop = function(event, delta, revertFunc, jsEvent, ui, view){
         $scope.alertMessage = ('Event Droped to make dayDelta ' + delta);
      };
      // alert on Resize
      $scope.alertOnResize = function(event, delta, revertFunc, jsEvent, ui, view ){
         $scope.alertMessage = ('Event Resized to make dayDelta ' + delta);
      };
      // add and removes an event source of choice
      $scope.addRemoveEventSource = function(sources,source) {
        var canAdd = 0;
        angular.forEach(sources,function(value, key){
          if(sources[key] === source){
            sources.splice(key,1);
            canAdd = 1;
          }
        });
        if(canAdd === 0){
          sources.push(source);
        }
      };
      // add custom event
      $scope.addEvent = function() {
        $scope.events.push({
          title: 'Open Sesame',
          start: new Date(y, m, 28),
          end: new Date(y, m, 29),
          className: ['openSesame']
        });
      };
      // remove event
      $scope.remove = function(index) {
        $scope.events.splice(index,1);
      };
      // Change View
      $scope.changeView = function(view,calendar) {
        uiCalendarConfig.calendars[calendar].fullCalendar('changeView',view);
      };
      // Change View
      $scope.renderCalender = function(calendar) {
        if(uiCalendarConfig.calendars[calendar]){
          uiCalendarConfig.calendars[calendar].fullCalendar('render');
        }
      };
       // Render Tooltip
      $scope.eventRender = function( event, element, view ) {
          element.attr({'tooltip': event.title,
                       'tooltip-append-to-body': true});
          $compile(element)($scope);
      };
      // config object
      $scope.uiConfig = {
        calendar:{
          height: 450,
          editable: true,
          header:{
            left: 'title',
            center: '',
            right: 'today prev,next'
          },
          eventClick: $scope.alertOnEventClick,
          eventDrop: $scope.alertOnDrop,
          eventResize: $scope.alertOnResize,
          eventRender: $scope.eventRender
        }
      };

      $scope.changeLang = function() {
        if($scope.changeTo === 'Hungarian'){
          $scope.uiConfig.calendar.dayNames = ["Vasárnap", "Hétfő", "Kedd", "Szerda", "Csütörtök", "Péntek", "Szombat"];
          $scope.uiConfig.calendar.dayNamesShort = ["Vas", "Hét", "Kedd", "Sze", "Csüt", "Pén", "Szo"];
          $scope.changeTo= 'English';
        } else {
          $scope.uiConfig.calendar.dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
          $scope.uiConfig.calendar.dayNamesShort = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
          $scope.changeTo = 'Hungarian';
        }
      };
      // event sources array
      $scope.eventSources = [$scope.events, $scope.eventSource, $scope.eventsF];
      $scope.eventSources2 = [$scope.calEventsExt, $scope.eventsF, $scope.events];*/


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
