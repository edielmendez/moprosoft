var app = angular.module('seguimiento', ['ngRoute','ui.calendar','ui.bootstrap']);
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

    .when('/nuevo-evento', {
      templateUrl : url_htmls+'public/js/nuevo-evento.html',
      controller  : 'nuevo_evento_Controller'
    })

});

app.service('serveData', [function () {
  var validarFechaMayorAHoy=function(fi,ff ) {
    var valuesInicio=fi.split("/");
    var valuesFinal=ff.split("/");
    var hoy = new Date();
    var inicio=new Date(valuesInicio[2],valuesInicio[0],valuesInicio[1]);
    var final=new Date(valuesFinal[2],valuesFinal[0],valuesFinal[1]);
    if (inicio>=hoy && final>hoy) {
      console.log("no estan alteradas");
      return 1;
    }else {
      $('#valFechas').empty();
      $('#valFechas').append('<p style="color:red">Las fechas están alteradas.</p>');
      return 0;
    }
  };

  this.preguntas = {};
  this.priorizadas = {'p':[]};
  this.fi ='';
  this.fi ='';
  this.validarFecha= function(fi,ff) {
    var ExpReg = /^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/;
    var val1 = ExpReg.test(fi)
    var val2 = ExpReg.test(ff)

    if (fi!="" && ff!="")  {
      if (val1 && val2) {
        var res=validarFechaMayorAHoy(fi,ff);
        if (res==0) {
          return 0;
        }
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

  };


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

    if (typeof(Storage) !== "undefined") {
      if (localStorage.getItem('phase')!=undefined) {
        localStorage.removeItem('phase');
      }
      localStorage.setItem("phase",phase);
    } else {
        console.log("No se pudo guardar las preguntas.");
    }
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
     if (serveData.validarFecha( $('#from').val(),$('#to').val() )==1) {
       var contenido=$("#preOrdenadas").html();
       buscaOrden(contenido);
       guardarFechas($('#from').val(),$('#to').val());
       borrarAvanze();
       window.location.href ='#/calendario';
     }
   }

   var borrarAvanze = function() {
     if (localStorage.getItem('UltFechaAct')!=undefined) {
       localStorage.removeItem('UltFechaAct');
     }
   }

   var guardarFechas=function (fi,ff) {

     var valuesInicio=fi.split("/");
     var valuesFinal=ff.split("/");
     var fechafi=valuesInicio[2]+"/"+valuesInicio[0]+"/"+valuesInicio[1];
     var fechaff=valuesFinal[2]+"/"+valuesFinal[0]+"/"+valuesFinal[1];
     if (typeof(Storage) !== "undefined") {
       if (localStorage.getItem('fi')!=undefined) {
         localStorage.removeItem('fi');
       }
       if (localStorage.getItem('ff')!=undefined) {
         localStorage.removeItem('ff');
       }
       //Se guardan en variables
       serveData.fi=fechafi;
       serveData.ff=fechafi;
       //Se guardan en memorias
       localStorage.setItem("fi",fechafi);
       localStorage.setItem("ff",fechaff);
     } else {
         console.log("No se pudo guardar las preguntas.");
     }
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
     $.each($scope.orden, function(i, item) {
       item.num=i+1;
      });

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
            $scope.orden.push({'id':item.id,'num':0,'question':item.question,'fi':'','ff':''});
          }
      });
   }



}]);

app.controller('calendario_Controller', ['$scope', '$http','$compile','$timeout','serveData' ,function ($scope, $http,$compile,$timeout,serveData,uiCalendarConfig) {
  //Extraemos las preguntas priorizadas guardados en memoria
  $scope.bandera=false;
  $scope.tiempo=5;
  if (localStorage.getItem("nuevoOrden")!=null) {
      $scope.nuevoOrden = JSON.parse( localStorage.getItem("nuevoOrden") );
      $.each($scope.nuevoOrden, function(i, item) {
        if (item.fi==''){
          $scope.bandera=true;
        }
       });
   }

   //var dias = ["Domingo","Lunes","Martes","Jueves","Viernes","Sábado"];
   //var meses = [""]
   if (localStorage.getItem("fi")!=null) {
       $scope.FechaInicio =localStorage.getItem("fi") ;
    }

    if (localStorage.getItem("ff")!=null) {
        $scope.FechaFinal =localStorage.getItem("ff") ;
     }

     var date = new Date();
     var d = date.getDate();
     var m = date.getMonth();
     var y = date.getFullYear();

     console.log( JSON.stringify($scope.nuevoOrden) );
     $scope.finalizar=function () {
       var phase= localStorage.getItem("phase");
       if (!$scope.bandera) {
         //Proceso para guardar la información
         console.log( JSON.stringify($scope.nuevoOrden) );
         guaradarEnDB(phase,$scope.FechaInicio,$scope.FechaFinal);
       }else {
         $("#validacion").empty();
         $("#validacion").append('<p style="color:red">No ha terminado de asignarle el tiempo a todas las Actividades.</p>');
       }
     };

     function tiempoContador() {
       $scope.tiempo--;
       $("#tiempoSpan").empty();
       $("#tiempoSpan").append($scope.tiempo);
       if ($scope.tiempo==0) {
           window.location.href = url+'Modelos/resultado';
       }
     }

     var guaradarEnDB = function (phase,fi,ff) {
       var asignacion = {'phase':phase,'fi':fi,'ff':ff };
       $http.post(url+"Modelos/terminarSeguimiento", asignacion ).success(function(data){
         console.log("Se creo el seguimiento de forma correcta:"+data);
         //Se inserta las preguntas priorizadas
         var pre={ 'id':data, 'preguntas':[] };
         $.each($scope.nuevoOrden,function (i,item) {
           pre.preguntas.push( {'id': item.id, 'activity': item.question, 'orden': item.num, 'fi': item.fi, 'ff': item.ff} );
         });

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
     /* event source that pulls from google.com */

     /* event source that contains custom events on the scope */
     $scope.events = [];

     /* add custom event*/
     $scope.addEvent = function(titulo,fi,ff) {
       var x = new Date(ff);
       x.setDate(x.getDate()+1);
       x.setHours(8,0,0,0);
       var y=new Date(fi);
       y.setHours(8,0,0,0);
       $scope.events.push({
         'title': titulo,
         'start': y,
         'end': x,
         'className': ['openSesame']
       });
     };

     if (localStorage.getItem('nuevoOrden')!=undefined) {
       $.each($scope.nuevoOrden,function (i,item) {
         if (item.fi!='') {
           $scope.addEvent(item.question,item.fi,item.ff);
         }
       });
     }

     /* event source that calls a function on every view switch */
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
     /* alert on eventClick */
     $scope.alertOnEventClick = function( date, jsEvent, view){
         $scope.alertMessage = (date.title);
     };
     /* alert on Drop */
      $scope.alertOnDrop = function(event, delta, revertFunc, jsEvent, ui, view){
        $scope.alertMessage = ('Event Droped to make dayDelta ' + delta);
     };
     /* alert on Resize */
     $scope.alertOnResize = function(event, delta, revertFunc, jsEvent, ui, view ){
        $scope.alertMessage = ('Event Resized to make dayDelta ' + delta);
     };
     /* add and removes an event source of choice */
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

     /* remove event */
     $scope.remove = function(index) {
       $scope.events.splice(index,1);
     };
     /* Change View */
     $scope.changeView = function(view,calendar) {
       uiCalendarConfig.calendars[calendar].fullCalendar('changeView',view);
     };
     /* Change View */
     $scope.renderCalender = function(calendar) {
       if(uiCalendarConfig.calendars[calendar]){
         uiCalendarConfig.calendars[calendar].fullCalendar('render');
       }
     };
      /* Render Tooltip */
     $scope.eventRender = function( event, element, view ) {
         element.attr({'tooltip': event.title,
                      'tooltip-append-to-body': true});
         $compile(element)($scope);
     };
     /* config object */
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
     /* event sources array*/
     $scope.eventSources = [$scope.events, $scope.eventsF];
     //$scope.eventSources = [$scope.calEventsExt, $scope.eventsF, $scope.events];

}]);

app.controller('nuevo_evento_Controller', ['$scope', 'serveData', '$http' ,function ($scope, serveData,$http) {

  $scope.bandera=false;
  $scope.ultimo=0;
  if (localStorage.getItem("nuevoOrden")!=null) {
      $scope.nuevoOrden = JSON.parse( localStorage.getItem("nuevoOrden") );
      $.each($scope.nuevoOrden, function(i, item) {
        if (item.fi==''){
          $scope.vista={'id':item.id,'num':item.num,'question':item.question,'fi':item.fi,'ff':item.ff};
          $scope.bandera=true;
          $scope.ultimo =i+1;
          return false;
        }
       });
   };

   if (!$scope.bandera) {
     $('#nuevoEvento').hide();
     var cadena = '<table class=\"table\"><thead><tr><th>N</th><th>Actividad</th><th>Empieza</th><th>Termina</th></tr></thead><tbody>';
     $.each($scope.nuevoOrden,function (i,item) {
       cadena+='<tr><td>'+item.num+'</td><td>'+item.question+'</td><td>'+item.fi+'</td><td>'+item.ff+'</td></tr>';
     });
     cadena+='</tbody></table>';
     $('#eventostodos').append(cadena);

   }

   if (localStorage.getItem("UltFechaAct")!=null) {
     $scope.FechaInicio =localStorage.getItem("UltFechaAct");
   }else {
     $scope.FechaInicio =localStorage.getItem("fi") ;
   }

   var aux = $scope.FechaInicio.split("/");
   $scope.fi=aux[1]+"/"+aux[2]+"/"+aux[0];

   $scope.FechaFinal =localStorage.getItem("ff") ;
   $scope.Empieza =localStorage.getItem("fi") ;

   var validarFinal= function (ff) {
     if (ff=="") {
       $('#valFechas').empty();
       $('#valFechas').append('<p style="color:red">Fechas vacias.</p>');
       return 0;
     }
     var valuesFinal=ff.split("/");
     var final=new Date(valuesFinal[2],valuesFinal[0]-1,valuesFinal[1]);
     var empieza = new Date($scope.Empieza);
     var termina = new Date($scope.FechaFinal);
     if (final>empieza && final<=termina) {
       console.log("no estan alteradas");
       return 1;
     }else {
       $('#valFechas').empty();
       $('#valFechas').append('<p style="color:red">Las fechas están alteradas.</p>');
       return 0;
     }
   }

   $scope.guardar= function () {
    if (validarFinal($scope.vista.ff )==1) {
      var valuesFinal=$scope.vista.ff.split("/");
      var fechaff=valuesFinal[2]+"/"+valuesFinal[0]+"/"+valuesFinal[1];
      guardar_inicio(sumDias(fechaff));
       $.each($scope.nuevoOrden, function(i, item) {
         if (item.fi==''){
           item.fi=$scope.FechaInicio;
           item.ff=fechaff;
           return false;
         }
        });
        guardar_en_memoria();
        window.location.href ='#/calendario';
     }
   };

   var sumDias = function (fechaff) {
     var aux=new Date(fechaff);
     if (aux.getDay()==5) {
       aux.setDate(aux.getDate()+3);
     }else {
       aux.setDate(aux.getDate()+1);
     }

     var dia=aux.getDate();
     var mes=aux.getMonth()+1;
     if (aux.getDate()<10) {
       dia="0"+aux.getDate();
     }
     if (aux.getMonth()<10) {
       mes="0"+(aux.getMonth()+1);
     }

     return aux.getFullYear()+"/"+mes+"/"+dia;

   }

   var guardar_inicio = function (fi) {
     if (typeof(Storage) !== "undefined") {
       if (localStorage.getItem('UltFechaAct')!=undefined) {
         localStorage.removeItem('UltFechaAct');
       }
       localStorage.setItem("UltFechaAct",fi );
     } else {
         console.log("No se pudo guardar las preguntas.");
     }
   }

   var guardar_en_memoria = function () {
     if (typeof(Storage) !== "undefined") {
       if (localStorage.getItem('nuevoOrden')!=undefined) {
         localStorage.removeItem('nuevoOrden');
       }
       localStorage.setItem("nuevoOrden",JSON.stringify($scope.nuevoOrden) );
     } else {
         console.log("No se pudo guardar las preguntas.");
     }

   };

   var y = new Date($scope.FechaInicio);
   y.setDate(y.getDate()+1);
   var d = y.getDate();
   var m = y.getMonth()+1;
   var y = y.getFullYear();

   $(function() {

      if ($scope.nuevoOrden.length==$scope.ultimo) {
        var x=$scope.FechaFinal.split("/");
        $scope.vista.ff=x[1]+"/"+x[2]+"/"+x[0];
        $("#to").prop('readonly',true);
      }else {
        $("#to").datepicker({
          beforeShowDay: $.datepicker.noWeekends,
          minDate: new Date(m+'/'+d+'/'+y) ,
          maxDate: new Date($scope.FechaFinal),
          changeMonth: true
        });
        console.log("No debes entrar aqui");
      }

   });

}]);
