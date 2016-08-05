

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
	  	url: "http://localhost/moprosoft/index.php/Estudiantes/validarUsername",
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
	  	url: "http://localhost/moprosoft/index.php/Estudiantes/validarUsernameActualizar",
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
	$("#id_est_elim").val(id);
	console.log(id);
	$("#modal_elim_usr").modal();
});

$(document).on('click','#btn_acept_elim_est',function(){
	var id = $("#id_est_elim").val();
	
	window.location.href = "http://localhost/moprosoft/index.php/Estudiantes/eliminar/"+id;

});

/*actualizar equipo*/
$(document).on('click','.btn_act_name_equipo',function(){
	var id = $(this).attr('id');
	$("#id_equipo_act").val(id);
	//console.log(id);
	$.ajax({
	 	method: "POST",
	  	url: "http://localhost/moprosoft/index.php/Equipos/getEquipoById",
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
/*
$(document).on('click','#btn_acept_act_equipo',function(){
	var id = $("#id_equipo_act").val();
	var nuevo_nombre = $("#nombre_equipo").val();

	$.ajax({
	 	method: "POST",
	  	url: "http://localhost/moprosoft/index.php/Equipos/actualizar",
	  	data: { id:id,nombre:nuevo_nombre},
	  	success : showAlert
	})

});*/
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
	  	url: "http://localhost/moprosoft/index.php/Estudiantes/getEstudiantesByEquipo",
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
		toastr.info('Un equipo con integrantes so se pude eliminar !!');
	}else{
		$("#modal_elim_equipo").modal();	
	}
	
}

$(document).on('click','#btn_acept_elim_equipo',function(){
	var id = $("#id_equipo_elim").val();
	console.log("se eliminara",id);
	window.location.href = "http://localhost/moprosoft/index.php/Equipos/eliminar/"+id;

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
	  	url: "http://localhost/moprosoft/index.php/Estudiantes/getEstudiantesByEquipo",
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
	  	url: "http://localhost/moprosoft/index.php/Estudiantes/getEstudiantesByEquipo",
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