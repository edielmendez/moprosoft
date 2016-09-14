var app = angular.module('verseguimiento', ['ngRoute','ui.calendar','ui.bootstrap']);
var url="http://localhost/moprosoft/index.php/";

app.controller('vercalendario_Controller', ['$scope', '$http','$compile','$timeout' ,function ($scope, $http,$compile,$timeout,uiCalendarConfig) {

     var date = new Date();
     var d = date.getDate();
     var m = date.getMonth();
     var y = date.getFullYear();

     $scope.events = [];
     $scope.dataUpdateDate=0;

     $scope.eventsF = function (start, end, timezone, callback) {
       var s = new Date(start).getTime() / 1000;
       var e = new Date(end).getTime() / 1000;
       var m = new Date(start).getMonth();
       var events = [{title: 'Feed Me ' + m,start: s + (50000),end: s + (100000),allDay: false, className: ['customFeed']}];
       callback(events);
     };


     $scope.updateDate = function () {
       //Configuracion de fechas
       var comienzo= new Date($scope.activity_start);
       var final= new Date($scope.activity_end);
       var nuevofinal= new Date($scope.dataUpdateDate);

       final.setHours(0,0,0,0);
       comienzo.setHours(0,0,0,0);
       nuevofinal.setHours(0,0,0,0);
       ////////////////////////////
       var x = $scope.activity_start.split("/");
       var y = $scope.activity_end.split("/");
       var z = $scope.dataUpdateDate.split("/");

       var bandera="nada";
       var numero=0;
       var fechaEstimadaFinal= y[1]+"/"+y[0]+"/"+y[2];
       var fechaNueva=z[1]+"/"+z[0]+"/"+z[2];
       //numero=restaFechas(fechaEstimadaFinal,fechaNueva);

       if (nuevofinal>final) {
         bandera="suma";
       }else if (nuevofinal<final) {
         bandera="resta";
       }
       //console.log("Dias a SUMAR/RESTAR:"+numero);

       var referencia;

       angular.forEach($scope.dateOriginal,function(event){
         //var tem1=event.fi.split("/");
         //var tem2=event.ff.split("/");
         if ($scope.activity_id==event.id) {
           event.ff=z[2]+"/"+z[0]+"/"+z[1];
         }else {

           var trozo1=event.fi.split("-");
           var trozo2=event.ff.split("-");
           console.log("EStos son mis trosos1:"+trozo1);
           console.log("EStos son mis trosos2:"+trozo2);

           var longitud=restaFechas(trozo1[2]+"/"+trozo1[1]+"/"+trozo1[0] , trozo2[2]+"/"+trozo2[1]+"/"+trozo2[0] )
           console.log("esta es mi longitud:"+longitud);


           event.fi=suma1dia(referencia);
           var tem1=event.fi.split("/");
           console.log("Esta es mi referencia y fecha event.fi:"+event.fi);

           event.ff=sumaDias(tem1[1]+"/"+tem1[2]+"/"+tem1[0],longitud,encuentraSabDom(trozo1[1]+"/"+trozo1[2]+"/"+trozo1[0],longitud),"yy/mm/dd");
         }
         var temx= event.ff.split("/");
         referencia=temx[1]+"/"+temx[2]+"/"+temx[0];
       });
       guardarDB();
     }

     var encuentraSabDom = function(fecha,dias) {
       // formato  mm/dd/aaaa
       var f = new Date(fecha);
       f.setHours(0,0,0,0);
       var sabdom=0;

       for (var i = 0; i < dias; i++) {
           if (f.getDay()==6 || f.getDay()==0) {
            sabdom++;
           }
           f.setDate(f.getDate()+1);
       }
       console.log("Funcion encuentraSabDom() Num de sabados y domingos:"+sabdom);
       return sabdom;
     }

     var direccionar = function () {
       window.location.href= url+'Modelos/VerSeguimiento/'+$("#phase").val();
     }

     var guardarDB=function() {
        var updateFollow= {'id':$("#tracing").val(),'follow':$scope.dateOriginal };

        $http.post(url+"Modelos/updateFollow", updateFollow ).success(function(data){
          //console.log("Se insertaron las preguntas priorizadas de forma correcta:"+data);
          console.log("Lo que me llego:"+data);
          $("#avisos").empty();
          $("#avisos").append('<div class="alert alert-success fade in" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a><strong>Bien!</strong>La actualización de fechas de realizo de manera exitosa.</div>');
          $('#myModal').modal('hide');
          setTimeout(function(){
            window.location.href= url+'Modelos/VerSeguimiento/'+$("#phase").val();
          },4000);
        }).error(function(data){
          console.log(data);
        });
        //console.log("RESULTADO:"+JSON.stringify($scope.dateOriginal));
     }

     var sumaDiasAviles= function (fecha,dias) {
       //formato fecha mm/dd/yyyy
       var f = new Date(fecha);

       for (var i = 0; i < dias; i++) {
         f.setDate(f.getDate()+1);
         if (f.getDay()==6 || f.getDay()==0) {
          dias+=1;
         }
       }
       return f;

     }

     var suma1dia= function (fecha) {
       //formato fecha mm/dd/yyyy
       var f = new Date(fecha);
       var indice=0;
       while (indice<1) {
         f.setDate(f.getDate()+1);
         if (f.getDay()!=6 && f.getDay()!=0) {
          indice++;
         }
       }
       var mes=f.getMonth()+1;
       var dia=f.getDate();
       if (dia<10) {
         dia="0"+dia;
       }

       if (mes<10) {
         mes="0"+mes;
       }

       return f.getFullYear()+"/"+mes+"/"+dia;

     }

     var sumaDias = function (fecha,dias,sabdom,tipo) {
       // formato  mm/dd/aaaa
       var f = new Date(fecha);
       f.setHours(0,0,0,0);

       console.log("Funcion sumaDias() Num Sabado y domingos:"+sabdom);
       var numVueltas=dias-sabdom;
       console.log("Funcion sumaDias() Num Vueltas:"+numVueltas);
       var indice=0;

       do {
         f.setDate(f.getDate()+1);
         if (f.getDay()!=6 && f.getDay()!=0) {
          indice++;
         }
       } while (indice<numVueltas);

       console.log("Funcion sumaDias() fecha a retornar:"+f);
       if (tipo==undefined || tipo=="") {
         return f;
       }

       var mes=f.getMonth()+1;
       var dia=f.getDate();
       if (dia<10) {
         dia="0"+dia;
       }

       if (mes<10) {
         mes="0"+mes;
       }

       if (tipo=="yy/mm/dd") {
         return f.getFullYear()+"/"+mes+"/"+dia;
       }

       if (tipo=="mm/dd/yy") {
         return mes+"/"+dia+"/"+f.getFullYear();
       }
       return f;

     }

     var restaFechas = function(f1,f2){
       //f1 f2 en formato dd/mm/aaaa.
       var aFecha1 = f1.split('/');
       var aFecha2 = f2.split('/');
       var fFecha1 = Date.UTC(aFecha1[2],aFecha1[1]-1,aFecha1[0]);
       var fFecha2 = Date.UTC(aFecha2[2],aFecha2[1]-1,aFecha2[0]);
       var dif = fFecha2 - fFecha1;
       var dias = Math.floor(dif / (1000 * 60 * 60 * 24));
       console.log("Dias de Diferencia:"+dias);
       return dias;
      }

     /* alert on eventClick */
     $scope.alertOnEventClick = function( date, jsEvent, view){
         var inicio = new Date(date.start);
         var final = new Date(date.end);
         valido(inicio,final);
         $scope.alertMessage = (date.title);
         $scope.activity_id = (date.id);

         var dia=inicio.getDate();
         var mes=inicio.getMonth()+1;
         if (dia<10) {
           dia="0"+dia;
         }

         if (mes<10) {
           mes="0"+mes;
         }
         $scope.activity_start = mes +"/"+dia+"/"+inicio.getFullYear();

         dia=final.getDate();
         mes=final.getMonth()+1;
         if (dia<10) {
           dia="0"+dia;
         }

         if (mes<10) {
           mes="0"+mes;
         }
         $scope.activity_end = mes+"/"+dia+"/"+final.getFullYear();
         $scope.dataUpdateDate=mes+"/"+dia+"/"+final.getFullYear();
         var max= new Date(sumaDiasAviles(mes+"/"+dia+"/"+final.getFullYear(),5));


         //Configuracion calemndario

         $(function() {
            $("#to").datepicker({
              beforeShowDay: $.datepicker.noWeekends,
              minDate:new Date(),
              changeMonth: true
            });


         });

     };

     var valido = function (fi,ff) {
       var inicio = new Date(fi);
       var final = new Date(ff);
       var hoy = new Date();
       inicio.setHours(0,0,0,0)
       final.setHours(0,0,0,0)
       hoy.setHours(0,0,0,0)

       if (hoy<=final && hoy>=inicio) {
          $scope.bandera=true;
       }else {
         $scope.bandera=false;
       }

     }

     /* Render Tooltip */
    $scope.eventRender = function( event, element, view ) {
        element.attr({'tooltip': event.title,
                     'tooltip-append-to-body': true});
        $compile(element)($scope);
    };
     /* config object */
     $scope.uiConfig = {
       calendar:{
         lang: 'es',
         height: 450,
         editable: true,
         header:{
           left: 'title',
           center: '',
           right: 'today prev,next'
         },
         eventClick: $scope.alertOnEventClick
         //eventclick:$scope.alertOnEventClickdb,
         /*eventDrop: $scope.alertOnDrop,
         eventResize: $scope.alertOnResize,
         eventRender: $scope.eventRender*/
       }
     };

     $scope.index = function () {
       $http.get(url+"Modelos/getActividades/"+$("#tracing").val() ).success(function(response){
         if (response) {
           $scope.dateOriginal=response;
           console.log(JSON.stringify($scope.dateOriginal) );
           console.log("tracing:"+$("#tracing").val());
           ///////////////////////////////////////////////////////////////////////
           //otra clase customFeed
           var newEvents = [];
           angular.forEach(response,function(event){

              var inicio = new Date(event.fi);
              inicio.setDate(inicio.getDate()+1);
              inicio.setHours(8,0,0,0);
              var fin = new Date(event.ff);
              fin.setDate(fin.getDate()+1);
              fin.setHours(19,0,0,0);
              var clase=ActividadExistente(event.fi,event.ff);

              newEvents.push( {'id':event.id, 'title': event.activity,'start':inicio,'end': fin,'className': [clase] });
            });
            angular.copy(newEvents, $scope.events);
            $scope.respaldo=$scope.events;
            //console.log(JSON.stringify($scope.events) );
          ///////////////////////////////////////////////////////////////////////
         }
       });
     }

     var ActividadExistente = function (fi,ff) {
       //variables
       var hoy = new Date();
       var empezo= new Date(fi);
       empezo.setDate(empezo.getDate()+1);
       var final = new Date(ff);
       final.setDate(final.getDate()+1);
       empezo.setHours(0,0,0,0);
       final.setHours(0,0,0,0);
       hoy.setHours(0,0,0,0);
       //Condiciones
       if (hoy<=final && hoy>=empezo) {
          var aux = new Date();
          aux.setDate(aux.getDate()+1);
          aux.setHours(0,0,0,0);

          if (aux.getTime()==final.getTime() || hoy.getTime()==final.getTime()) {
            return "urgente";
          }
          return "marcha";

       }

       if (hoy>final ) {
         return "pasado";
       }

       if (empezo>hoy) {
         return "futuro";
       }
       return "openSesame";
     }

     $scope.eventSources = [$scope.events,$scope.eventsF];

}]);
