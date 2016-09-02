var app = angular.module('verseguimiento', ['ngRoute','ui.calendar','ui.bootstrap']);
var url="http://localhost/moprosoft/index.php/";

app.controller('vercalendario_Controller', ['$scope', '$http','$compile','$timeout' ,function ($scope, $http,$compile,$timeout,uiCalendarConfig) {

    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

     $scope.events = [];

     $scope.eventsF = function (start, end, timezone, callback) {
       var s = new Date(start).getTime() / 1000;
       var e = new Date(end).getTime() / 1000;
       var m = new Date(start).getMonth();
       var events = [{title: 'Feed Me ' + m,start: s + (50000),end: s + (100000),allDay: false, className: ['customFeed']}];
       callback(events);
     };


     /* alert on eventClick */
     $scope.alertOnEventClick = function( date, jsEvent, view){
         $scope.alertMessage = (date.title);
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

     $scope.index = function () {
       $http.get(url+"Modelos/getActividades/"+$("#tracing").val() ).success(function(response){
         if (response) {
           ///////////////////////////////////////////////////////////////////////
           //otra clase customFeed
           console.log(response);
           var newEvents = [];
           angular.forEach(response,function(event){
              var inicio = new Date(event.fi);
              inicio.setDate(inicio.getDate()+1);
              var fin = new Date(event.ff);
              fin.setDate(fin.getDate()+1);

              var clase=ActividadExistente(event.fi,event.ff);

              console.log(clase);
              newEvents.push( {'title': event.activity,'start':inicio,'end': fin,'className': [clase]});
            });
            angular.copy(newEvents, $scope.events);

          ///////////////////////////////////////////////////////////////////////
         }
       });
     }

     var ActividadExistente = function (fi,ff) {
       var hoy = new Date();
       var empezo= new Date(fi);
       var final = new Date(ff);
       console.log("Convertir fi:"+empezo);
       console.log("Convertir ff:"+final);
       if (hoy<=final && hoy>=empezo) {
        $scope.fechaInicio=fi;
        $scope.fechaFinal=ff;
        var aux = new Date();
        aux.setDate(aux.getDate()+1);
        console.log("hoy:"+aux);
        console.log("final:"+final);
        if (aux==final) {
          console.log("entro en urgente");
          return "urgente";
        }
        console.log("No entro");
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
