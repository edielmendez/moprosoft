var app = angular.module('verseguimiento', ['ngRoute','ui.calendar','ui.bootstrap']);
var url="http://localhost/moprosoft/index.php/";

app.controller('vercalendario_Controller', ['$scope', '$http','$compile','$timeout' ,function ($scope, $http,$compile,$timeout,uiCalendarConfig) {

    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    var date2 = new Date();
    date2.setDate(date2.getDate() +4);

     $scope.events = [];

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
       /*$http.get(url+"Modelos/getActividades/"+$("#tracing").val() ).success(function(response){
         if (response) {
           ///////////////////////////////////////////////////////////////////////
           //otra clase customFeed
           var newEvents = [];
           angular.forEach(response,function(event){
              var clase=ActividadExistente(event.fi,event.ff);
              console.log(clase);
              newEvents.push( {'title': event.activity,'start': new Date(event.fi),'end': new Date(event.ff),'className': [clase]});
            });
            angular.copy(newEvents, $scope.events);

          ///////////////////////////////////////////////////////////////////////
         }
       });*/
     }

     var ActividadExistente = function (fi,ff) {
       //{title: 'Feed Me ' + m,start: s + (50000),end: s + (100000),allDay: false, className: ['customFeed']}
       var hoy = new Date();
       var empezo= new Date(fi);
       var final = new Date(ff);
       if (hoy<=final && hoy>=empezo) {
         $scope.fechaInicio=fi;
         $scope.fechaFinal=ff;
         console.log("Entro aki");
         return "customFeed";
       }
       console.log("Todo normal");
       return "openSesame";
     }

     $scope.eventSources = [$scope.events, $scope.eventsF];

}]);
