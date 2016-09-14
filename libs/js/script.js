var extra;
var extra2;
var host = "localhost";
$(document).ready(function(){
	$('[rel="popover"]').popover({
        container: 'body',
        html: true,
        content: function () {
            var clone = $($(this).data('popover-content')).clone(true).removeClass('hide');
            return clone;
        }
    }).click(function(e) {
        e.preventDefault();
    });

    [].slice.call( document.querySelectorAll( '.tabs' ) ).forEach( function( el ) {
		new CBPFWTabs( el );
	});
    
});

$( "#form_nuevo_estudiante" ).submit(function( event ) {
  var equipo = $("#equipo").val();
  var numOpciones = $("#equipo").length;
  var username = $("#username").val();

  if(numOpciones == 0){
  		toastr.info('No se puede dar de alta un estudiante porque no hay equipos');
  		event.preventDefault();
  		return;
  }

 
  if(equipo==null){
  	toastr.info('Seleccione un equipo !')
  	//alert("No se puede dar de alta un estudiante porque no hay equipos")
  	event.preventDefault();
  	return;
  }

   $.ajax({
	 	method: "POST",
	 	async:false,
	  	url: "http://"+host+"/moprosoft/index.php/Estudiantes/validarUsername",
	  	data: { username: username }
	}).done(function( msg ) {
		console.log(msg);
		if(msg === "FALSE"){
			toastr.info('username ocupado, escoja otro');
			event.preventDefault();
		}
   });

	
   


  
});


$("#form_actualizar_estudiante").submit(function(event){
	var username = $("#username").val();
	var id = $("#id_estudiante_act").val();
	$.ajax({
	 	method: "POST",
	 	async:false,
	  	url: "http://"+host+"/moprosoft/index.php/Estudiantes/validarUsernameActualizar",
	  	data: { username: username, id:id}
	}).done(function( msg ) {
		console.log(msg);
		if(msg === "FALSE"){
			toastr.info('username ocupado, escoja otro');
			event.preventDefault();
		}
		
   });
   
});

$(document).on('click','.eliminarUsuario',function(){
	var id = $(this).attr('id');
	var rol = $(this).parent().attr('id');
	$("#id_est_elim").val(id);
	if(rol == 2){
		toastr.info('El estudiante no se puede eliminar por que es jefe de equipo');
	}else{
		
		$("#modal_elim_usr").modal();
	}
	
	
	
});

$(document).on('click','#btn_acept_elim_est',function(){
	var id = $("#id_est_elim").val();
	
	window.location.href = "http://"+host+"/moprosoft/index.php/Estudiantes/eliminar/"+id;

});

/*actualizar equipo*/
$(document).on('click','.btn_act_name_equipo',function(){
	var id = $(this).attr('id');
	$("#id_equipo_act").val(id);
	//console.log(id);
	$.ajax({
	 	method: "POST",
	  	url: "http://"+host+"/moprosoft/index.php/Equipos/getEquipoById",
	  	data: { id:id},
	  	success : showModalUpdateNameTeam
	})
	
});

var showModalUpdateNameTeam = function(data){
	var equipo = JSON.parse(data);
	//console.log(equipo);

	$("#nombre_equipo").val(equipo.name);
	$("#modal_act_equipo").modal();
	$("#nombre_equipo").focus();
}

$( "#form_modal_act_equipo" ).submit(function( event ) {
	var nombre  = $("#nombre_equipo").val();

	if(nombre === ''){
		toastr.info('el nombre no puede ser vacio');
		event.preventDefault()
	}
	
});


/*Eliminar equipo*/

$(document).on('click','.btn_elim_equipo',function(){
	var id = $(this).attr('id');
	$("#id_equipo_elim").val(id);
	console.log(id);
	$.ajax({
	 	method: "POST",
	  	url: "http://"+host+"/moprosoft/index.php/Estudiantes/getEstudiantesByEquipo",
	  	data: { id:id},
	  	success : showModalDeleteTeam
	})


});

var showModalDeleteTeam = function(data){
	var estudiantes = JSON.parse(data)
	toastr.options = {
	  "positionClass": "toast-top-center"
	}
	if(estudiantes.length != 0){
		toastr.info('Un equipo con integrantes no se pude eliminar !!');
	}else{
		$("#modal_elim_equipo").modal();	
	}
	
}

$(document).on('click','#btn_acept_elim_equipo',function(){
	var id = $("#id_equipo_elim").val();
	console.log("se eliminara",id);
	window.location.href = "http://"+host+"/moprosoft/index.php/Equipos/eliminar/"+id;

});

/*nuevo equipo*/

$( "#form_nuevo_equipo" ).submit(function( event ) {
	var nombre  = $("#nombre_nuevo_equipo").val();
	//console.log(nombre);
	
	if(nombre.trim() === ''){
		toastr.info('el nombre no puede ser vacio');
		event.preventDefault()
	}


	
	
});


/* cambio de responsable*/

$(document).on('click','.btn_cambiar_res',function(){
	var id = $(this).attr('id');
	
	$.ajax({
	 	method: "POST",
	  	url: "http://"+host+"/moprosoft/index.php/Estudiantes/getEstudiantesByEquipo",
	  	data: { id:id},
	  	success : showModalChangeResponsable
	})
	
	//$("#modal_act_resp").modal();
});

var showModalChangeResponsable = function(data){
	var estudiantes = JSON.parse(data);
	
	if(estudiantes.length == 1){
		toastr.info('No se puede cambiar de jefe de equipo, porque no hay mas integrantes');
		return;
	}
	
	$("#area_modal_est").empty();
    for (var i = 0; i < estudiantes.length; i++) {
    	if(estudiantes[i].rol_id != 2){
    		var nodo = "<div class='form-group'>";
    		nodo+= "<div class='well'>";
    		nodo+= "<label><input type='radio' required='' class='radio-modal' name='id_usuario' value="+estudiantes[i].id+">  "+estudiantes[i].name +"</label>";
    		nodo+= "</div>";
    		nodo+= "</div>";
    		
    		$("#area_modal_est").append(nodo);
    	}else{
    		$("#id_jefe_ant").val(estudiantes[i].id)
    	}
    }
    $("#modal_act_resp").modal();

}


/*seleccion de  jefe de equipo*/

$(document).on('click','.btn_select_jefe',function(){
	var id = $(this).attr('id');
	
	$.ajax({
	 	method: "POST",
	  	url: "http://"+host+"/moprosoft/index.php/Estudiantes/getEstudiantesByEquipo",
	  	data: { id:id},
	  	success : showModalChooseResponsable
	})
	
	//$("#modal_act_resp").modal();
});


var showModalChooseResponsable = function(data){
	var estudiantes = JSON.parse(data);
	
	
	
	$("#area_modal_select_jefe_equipo").empty();
    for (var i = 0; i < estudiantes.length; i++) {
		var nodo = "<div class='form-group'>";
		nodo+= "<div class='well'>";
		nodo+= "<label><input type='radio' required='' class='radio-modal' name='id_usuario' value="+estudiantes[i].id+">  "+estudiantes[i].name +"</label>";
		nodo+= "</div>";
		nodo+= "</div>";
		
		$("#area_modal_select_jefe_equipo").append(nodo);
	
		$("#id_jefe_ant").val(estudiantes[i].id)
    	
    }
    $("#modal_select_resp").modal();

}

/**
 *
 * *****************************************************************************************
 * codigo para el modulo de elegir cuestionario                                            *
 *                                                                                         *
 * *****************************************************************************************
 */
///cambio de el select de modelos
$(document).on('change','#select_modelo',function(){
	var idModelo = $(this).val();
	var txt = $("#select_modelo option:selected").text();
	if(txt === "Seleccione un modelo"){
		toastr.info('Seleccione un modelo por favor');
	}else{
		$.ajax({
		 	method: "POST",
		  	url: "http://"+host+"/moprosoft/index.php/process_Controller/getProcessByProject",
		  	data: { id:idModelo},
		  	success : setValueSelectProcess
		})
	}
	
});

var setValueSelectProcess = function(data){
	var procesos = JSON.parse(data);
	if(procesos.length == 0){
		$("#select_proceso").empty();	
		$("#select_proceso").append("<option selected>Sin Procesos</option>");
		$("#select_fase").empty();	
		$("#select_fase").append("<option selected>Sin Fases</option>");
		$("#select_cuestionario").empty();	
		$("#select_cuestionario").append("<option selected>Sin Cuestionarios</option>");
		return;
	}
	$("#select_proceso").empty();	
	$("#select_proceso").append("<option selected>Seleccione un proceso</option>");
	for (var i = 0; i < procesos.length; i++) {
		$("#select_proceso").append("<option value='"+procesos[i].id+"'>"+procesos[i].name+"</option>");

	}	
}

//código para el evento de cambio del select de procesos
//
$(document).on('change','#select_proceso',function(){
	var idProceso = $(this).val();
	var txt = $("#select_proceso option:selected").text();
	//console.log("id : ",idProceso,"txt : ",txt)
	if(txt === "Seleccione un proceso"){
		toastr.info('Seleccione un proceso por favor');
	}else{
		$.ajax({
		 	method: "POST",
		  	url: "http://"+host+"/moprosoft/index.php/SelectCuestionario/getFaseByProcessId",
		  	data: { id:idProceso},
		  	success : setValueSelectFases
		})
	}
	
});

var setValueSelectFases = function(data){
	var fases = JSON.parse(data);
	console.log(fases);
	
	if(fases.length == 0){
		
		$("#select_fase").empty();	
		$("#select_fase").append("<option selected>Sin fases</option>");
		$("#select_cuestionario").empty();	
		$("#select_cuestionario").append("<option selected>Sin Cuestionarios</option>");
		return;
	}
	$("#select_fase").empty();	
	$("#select_fase").append("<option selected>Seleccione un fase</option>");
	for (var i = 0; i < fases.length; i++) {
		$("#select_fase").append("<option value='"+fases[i].id+"'>"+fases[i].name+"</option>");

	}
	
}


/**
 * SELECT FASES
 */

$(document).on('change','#select_fase',function(){
	var idFase = $(this).val();
	var txt = $("#select_fase option:selected").text();
	//console.log("id : ",idFase,"txt : ",txt)
	if(txt === "Seleccione un fase"){
		toastr.info('Seleccione un fase por favor');
	}else{
		$.ajax({
		 	method: "POST",
		  	url: "http://"+host+"/moprosoft/index.php/SelectCuestionario/getCuestionariosByFaseId",
		  	data: { id:idFase},
		  	success : setValueSelectCuestionarios
		})
	}
	
});

var setValueSelectCuestionarios = function(data){
	var cuestionarios = JSON.parse(data);
	console.log(cuestionarios);
	
	if(cuestionarios.length == 0){
		
		$("#select_cuestionario").empty();	
		$("#select_cuestionario").append("<option selected>Sin cuestionarios</option>");
		return;
	}
	$("#select_cuestionario").empty();	
	$("#select_cuestionario").append("<option selected>Seleccione un cuestionario</option>");
	for (var i = 0; i < cuestionarios.length; i++) {
		$("#select_cuestionario").append("<option value='"+cuestionarios[i].id+"'>"+cuestionarios[i].name+"</option>");

	}
	
}

/**
 * SELECT CUESTIONARIOS
 */

$(document).on('change','#select_cuestionario',function(){
	var idCuestionario = $(this).val();
	var txt = $("#select_cuestionario option:selected").text();
	//console.log("id : ",idCuestionario,"txt : ",txt)
	if(txt === "Seleccione un cuestionario"){
		$("#titulo_cuestionario").empty()
		$("#num_preguntas").empty();
		toastr.info('Seleccione un cuestionario por favor');

	}else{
		$.ajax({
		 	method: "POST",
		  	url: "http://"+host+"/moprosoft/index.php/SelectCuestionario/getDatosByCuestionarioId",
		  	data: { id:idCuestionario},
		  	success : setValueCardCuestionario
		})
	}
	
});

var setValueCardCuestionario = function(data){
	var datos = JSON.parse(data);
	console.log(datos);
	$("#titulo_cuestionario").prepend(datos.cuestionario.name)
	$("#num_preguntas").prepend(datos.preguntas.length);
	/*
	if(datos.length == 0){
		
		$("#select_cuestionario").empty();	
		$("#select_cuestionario").append("<option selected>Sin datos</option>");
		return;
	}
	$("#select_cuestionario").empty();	
	$("#select_cuestionario").append("<option selected>Seleccione un cuestionario</option>");
	for (var i = 0; i < datos.length; i++) {
		$("#select_cuestionario").append("<option value='"+datos[i].id+"'>"+datos[i].name+"</option>");

	}*/
	
}






/**
 *
 * *****************************************************************************************
 * fin de los selects                                                                      *
 * *****************************************************************************************
 */


$( "#form_start_cuestionario" ).submit(function( event ) {
	var cuestionario = $("#select_cuestionario").val();
	if (cuestionario === "Seleccione un cuestionario") {
		toastr.info('Seleccione un cuestionario para empezar');
		event.preventDefault();
	}
	
	
});

/**
 ****************************************************************************
 * FUNCION PARA ESCOJER LOS EQUIPOS A LOS CUALES SE VAN EVALUAR LOS PROCESOS*
 * **************************************************************************
 */


$(document).on('click','.btn_apli_eva',function(){
	var id = $(this).attr('id');
	var ids = id.split('-')
	id_proceso = ids[0];
	id_equipo = ids[1];

	//console.log("proceso : ",id_proceso,"equipo : ",id_equipo)
	//return;
	$("#id_proceso").val(id_proceso);

	$.ajax({
	 	method: "POST",
	  	url: "http://"+host+"/moprosoft/index.php/Evaluacion/getTeamsOnlyApplyForThisQuestionary",
	  	data: { id_proceso:id_proceso,id_equipo:id_equipo},
	  	success : showModalChooseTeamsApplyEvaluation
	})
	
	//console.log(id_cuestionario,id_equipo)
	
});


var showModalChooseTeamsApplyEvaluation = function(data){
	var equipos = JSON.parse(data)
	//console.log(data);
	//return;
	$("#form_equipos_apl_cuest").empty();
	if (equipos.length == 0 ){
		$("#form_equipos_apl_cuest").append("<h3><b>No hay equipos disponibles</b></h3>");
		$("#modal_elegir_equipos_eva").modal();
		return;
	}

	for (var i = 0; i < equipos.length; i++) {
		
		var cad = "<div class='row'>";
      		cad += "<div class='col-md-3'>";
                cad += "<div class='form-group'>";
                    cad += "<input type='checkbox' class='css-checkbox' id='checkbox"+i+"' name='equipo_eva[]' value='"+equipos[i].id+"'/>";
					cad += "<label for='checkbox"+i+"' name='checkbox10_lbl' class='css-label mac-style'>"+equipos[i].name+"</label>";
                cad += "</div>";
            cad += "</div>";
      	cad += "</div>";
      	cad += "<hr>";
		$("#form_equipos_apl_cuest").append(cad);      	
		
	}

	$("#modal_elegir_equipos_eva").modal();

}



/**
 **************************************************************************************
 * ************************************************************************************
 */

/**
 * ***************************************************************************************************
 * Código para los radio buttons del cambio de equipo
 * **************************************************************************************************
 */

$(document).on('click','.radio_btn',function(){
	

	$(".radio_btn").prop("checked",false)
	$(this).prop("checked",true)
	

});

/**
 ***************************************************************************************************
 * Código para ver detalles de un cuestionario terminado                                           *
 * *************************************************************************************************
 */

$(document).one('click','.btnVerResultados',function(){
	var id = $(this).attr('id');

	var ids = id.split('-')
	id_fase = ids[0];
	extra = id_fase;
	id_equipo = ids[1];
	extra2 = ids[2];
	$("#contenedor_principal").hide("slow");
	var id_show_kiviat = "#show_kiviat_"+id_fase
	var show_kiviat = $(id_show_kiviat).val();
	console.log("id: ",id_show_kiviat,"valor : ",show_kiviat);
	if(show_kiviat === "TRUE"){
		$("#btnVerGraficaKiviat").show();
	}

	$.ajax({
	 	method: "POST",
	  	url: "http://"+host+"/moprosoft/index.php/Evaluacion/getResultadosEvaluation",
	  	data: { id_fase:id_fase,id_equipo:id_equipo},
	  	success : showResults
	})
});

var showResults = function (data){
	createChart(data);
	var resultados = JSON.parse(data);
	console.log(resultados)
	var suma=0;
	for (var i = 0; i < resultados.resultados.length; i++) {
		suma+= parseInt(resultados.resultados[i].nivel_cobertura)
		if (resultados.resultados[i].valor === "fuerte") {
			var html = "<tr class='punto_fuerte'>";
			//console.log("1-> :",resultados.resultados[i].nivel_cobertura )
		}else{
			var html = "<tr class='punto_debil'>";
			
		}
		
			html += "<td>P"+(resultados.resultados.length-i)+"</td><td>"+resultados.resultados[i].S+"</td>";
			html += "<td>"+resultados.resultados[i].U+"</td><td>"+resultados.resultados[i].A+"</td>";
			html += "<td>"+resultados.resultados[i].R+"</td><td>"+resultados.resultados[i].N+"</td>";
			html += "<td>"+resultados.resultados[i].nivel_cobertura+"  % </td><td>"+resultados.resultados[i].media+"</td><td>"+resultados.resultados[i].desviacion+"</td>";
			html += "</tr>";
		$("#body_table").prepend(html);
		
	}
	console.log(suma);
	$("#total_cobertura").append("<b>"+Math.round((suma/resultados.resultados.length)) + " % </b>");
	$("#titulo_tabla").append("<strong>Fase :</strong>"+resultados.name + "<br><strong>Proceso : </strong>" + resultados.proceso.name)
	$("#contenedor_secundario").show("slow");

	console.log(resultados);
}


var createChart = function(data){
	var cuestionario = JSON.parse(data);
	preguntas = []
	media_desviacion = [];
	var color;
	for (var i = 0; i < cuestionario.resultados.length; i++) {
		if (cuestionario.resultados[i].valor === "fuerte") {
			color = "#42a5f5";
		}else{
		
			color = "#ef5350";
		}
		var pre = {
			name:"P"+(i+1),
			color:color,
			y: parseFloat(cuestionario.resultados[i].nivel_cobertura),
			drilldown:"media_desviacion"+i
		}
		//console.log("normal : ",cuestionario.resultados[i].nivel_cobertura,"  con parseFloat : ",parseFloat(cuestionario.resultados[i].nivel_cobertura))

		preguntas.push(pre);

		var m = {
            name: "P"+(i+1),
            id: "media_desviacion"+i,
            data: [
                [
                    'MEDIA',
                    parseFloat(cuestionario.resultados[i].media)
                ],
                [
                    'DESVIACIÓN ESTANDAR',
                    parseFloat(cuestionario.resultados[i].desviacion)
                ],
            ]
        }

        media_desviacion.push(m);
        	
	}

	$('#grafica').highcharts({
        chart: {
            type: 'column',
            events: {
	            drilldown: function(e) {
	                
	                this.yAxis[0].update({
			            title:{
			                text:"Media y desviacion estandar"
			            }
			        });
	            },
	            drillup: function(e) {
	                this.yAxis[0].update({
			            title:{
			                text:"Porcentaje del nivel de cobertura"
			            }
			        });
	            }
	        }
        },
        title: {
            text: 'Porcentaje del nivel de cobertura de la Fase : '+cuestionario.name 
        },
        subtitle: {
            text: 'Click par ver su media y desviacion'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
        	max:100,
            title: {
                text: 'Porcentaje del nivel de cobertura'
            }

        },
        exporting: {
            enabled: true
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}%'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> del total<br/>'
        },

        series: [{
            name: 'Nivel de cobertura',
            colorByPoint: true,
            data: preguntas
        }],
        drilldown: {
        	
            series: media_desviacion
        }
    });
    
}

/**
 ***************************************************************************************************************
 * Código pára ver las graficas de los resultados de un cuestionario                                           *
 * *************************************************************************************************************
 */

$(document).on('click','#btn_ver_graficas',function(){
	$("#contenedor_secundario").hide("slow");
	$("#tercer_contenedor").show("slow");
});

$(document).on('click','#btn_ver_resultados',function(){
	$("#tercer_contenedor").slideUp("slow");
	$("#cuarto_contenedor").hide("slow");
	$("#contenedor_secundario").show("slow");
});

$("#btn_ver_grafica_kiviat").click(function(){
	$("#tercer_contenedor").hide("slow");
	id_equipo = $(this).attr('type');
	
	console.log(extra2);

	$.ajax({

		method: "POST",
	  	url: "http://"+host+"/moprosoft/index.php/Evaluacion/getPorcentajePorProceso",
	  	data: { id_equipo:id_equipo,id_fase:extra,id_proceso:extra2},
	    beforeSend: function(){
	     	console.log("Enviando......")
	    },
	    success:drawChartKiviat
	   // ......
	});
	
	
})


/**
 *************************************************
 *FUNCION QUE DIBUJA LA GRAFICA KIVIAT           *
 * ***********************************************
 */

var drawChartKiviat = function(data){
	console.log(JSON.parse(data));
	var procesos = JSON.parse(data);
	var categorias = [];
	var datos = [];
	var nombre_modelo = procesos[0].modelo
	for (var i = 0; i < procesos.length; i++) {
		categorias.push(procesos[i].name);
		datos.push(parseFloat(procesos[i].nivel_cobertura));
	}
	$('#grafica_kiviat').highcharts({

        chart: {
            polar: true,
            type: 'line'
        },

        title: {
            text: 'Nivel de cobertura alcanzado por proceso del modelo  <b>'+nombre_modelo+'</b>'
        },

        pane: {
            size: '80%'
        },

        xAxis: {
            categories: categorias,
            tickmarkPlacement: 'on',
            lineWidth: 0
        },

        yAxis: {
            gridLineInterpolation: 'polygon',
            lineWidth: 0,
            min: 0
        },
        exporting: {
            enabled: true
        },

        tooltip: {
            shared: true,
            pointFormat: '<span style="color:{series.color}">{series.name}: <b>{point.y:,.0f} %</b><br/>'
        },

        legend: {
            align: 'right',
            verticalAlign: 'top',
            y: 70,
            layout: 'vertical'
        },

        series: [{
            name: 'Nivel de cobertura alcanzado',
            data: datos,
            pointPlacement: 'on'
        }]

    });
	

	


    $("#cuarto_contenedor").show("slow");
}


$("#export2pdf").click(function(){
	var chart = $('#grafica').highcharts();
	chart.exportChart({
	    type: 'application/pdf',
	    filename: 'grafia'
	});
});

/**
 * final
 */


$(document).on('click','.btnBack',function(){
	window.location.reload();
	
})

/**
 ****************************************************************************
 * ENVIAR CORREOS                                                           *
 * **************************************************************************
 */


$(document).on('click','.btnEnviarMails',function(){
	idUsuario = $(this).attr('id');
	console.log(idUsuario)
	
	$.ajax({
	 	method: "POST",
	  	url: "http://"+host+"/moprosoft/index.php/Estudiantes/getEstudiantesById",
	  	data: { id:idUsuario},
	  	success : showModalSendMail
	})
})


var showModalSendMail = function(data){
	var usuario = JSON.parse(data);
	console.log(usuario);
	$("#areaMensajeEnviarmail").val("");
	$("#nombreUsuarioEnviarMail").val(usuario.name);
	$("#mailUsuarioEnviarMail").val(usuario.email);
	$("#modalMail").modal();
}
/***************************************************************************
 ***************************************************************************
 */


/**
 *****************************************************************************
 *CÓDIGO PARA CAMBIAR LA FECHA FINAL DE UN SEGUIMIENTO 
 *****************************************************************************
 */

$(document).on('click','.changeFechaFinal',function(){
	var id = $(this).attr('id');
	$.ajax({
	 	method: "POST",
	  	url: "http://"+host+"/moprosoft/index.php/Calendario/getDataFaseInTableTracingById",
	  	data: { id:id},
	  	success : showModalChangeDate
	})
})

var showModalChangeDate = function(data){
	console.log(data);
	var fase = JSON.parse(data);
	console.log(fase)
	var fecha = new Date(fase.date_end.replace('-','/'));

	$("#id_tracing").val(fase.id)
	$("#fecha_inicio").val(fase.date_start);
	$("#fecha_final").val(fase.date_end);
	
	$( "#fecha_final" ).datepicker({
		minDate: new Date(fase.date_end.replace('-','/')),
		dateFormat: "yy-mm-dd",
		beforeShowDay: $.datepicker.noWeekends
	});
	$("#modalChangeDate").modal();
}

/**
 ***********************************************************************
 ***********************************************************************
 */


/**
 *
 * CÓDIGO PARA QUE SE PUEDA VOLVER A APLICAR UN PROCESO CON TODAS SUS FACES A UN EQUIPO
 * 
 * 
 */


$(document).on('click','.btn_again_aplicacion',function(){
	
	var id = $(this).attr('id');
	var ids = id.split('-')
	id_proceso = ids[1];
	id_equipo = ids[0];
	
	$("#id_equipo_again").val(id_equipo);
	$("#id_proceso_again").val(id_proceso);
	$("#modal_aviso").modal()
})


