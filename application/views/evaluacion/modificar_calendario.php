<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>MODIFICAR CALENDARIO</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta name="viewport" content="width=device-width" />

	<!-- Se importo los estilos adecuados-->
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url(); ?>/img/favicon.png">

  <link href="<?php echo base_url(); ?>libs/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>public/css/jquery-ui.css" rel="stylesheet"/>
  <link href="<?php echo base_url(); ?>public/css/animate.min.css" rel="stylesheet"/>
  <link href="<?php echo base_url(); ?>public/css/paper-dashboard.css" rel="stylesheet"/>
  <link href="<?php echo base_url(); ?>public/css/demo.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>public/css/themify-icons.css" rel="stylesheet">
	<link href="<?php echo base_url("libs/css/datatables.min.css"); ?>" rel="stylesheet">
	<link href="<?php echo base_url("libs/css/toastr.min.css"); ?>" rel="stylesheet">
	<link href="<?php echo base_url(); ?>libs/checkbox/style.css" rel="stylesheet" />
	<!--<link href="<?php echo base_url(); ?>libs/css/normalize.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>libs/css/demo.css" rel="stylesheet" />-->
	<link href="<?php echo base_url(); ?>libs/css/tabs.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>libs/css/tabstyles.css" rel="stylesheet" />
	
  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>


	

	<style type="text/css">
	
	

	</style>

</head>
<body>
	
	<div class="wrapper">
	    <div class="sidebar" data-background-color="white" data-active-color="danger">

	    <!--
			Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
			Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
		-->

	    	<div class="sidebar-wrapper">
	            <div class="logo">
	                <a class="simple-text">
	                    EVALUACIÓN
	                </a>
	            </div>

	            <ul class="nav">
	            	<li >
	                    <a href="<?php echo base_url() ?>index.php/Home/">
	                        <i class="ti-user"></i>
	                        <p>Estudiantes</p>
	                    </a>
	                </li>
	                <li >
	                    <a href="<?php echo base_url() ?>index.php/Equipos/">
	                        <i class="ti-eye"></i>
	                        <p>Equipos</p>
	                    </a>
	                </li>
	                <li >
	                    <a href="<?php echo base_url() ?>index.php/Evaluacion/">
	                        <i class="ti-pencil-alt"></i>
	                        <p>ASIGNAR CUESTIONARIOS</p>
	                    </a>
	                </li>
	                <li class="active">
	                    <a >
	                        <i class="ti-calendar"></i>
	                        <p>CALENDARIO</p>
	                    </a>
	                </li>
	                
	            </ul>
	    	</div>
	    </div>

	    <div class="main-panel">
	    	
	    	
	        <nav class="navbar navbar-default">
	            <div class="container-fluid">

	                <div class="navbar-header">
	                    <button type="button" class="navbar-toggle">
	                        <span class="sr-only">Toggle navigation</span>
	                        <span class="icon-bar bar1"></span>
	                        <span class="icon-bar bar2"></span>
	                        <span class="icon-bar bar3"></span>
	                    </button>
	                    <a class="navbar-brand" href="#">MODIFICAR FECHAS      /    Equipo : <?php echo $equipo['name'] ?></a>

	                </div>
	                <div class="collapse navbar-collapse">
	                    <ul class="nav navbar-nav navbar-right">
	                        <li class="dropdown">
	                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	                                    <i class="ti-user"></i>
	                                    <!--p class="notification">5</p-->
																			<p><?php print_r($this->session->userdata('logged_in')['username'] );?></p>
																			<b class="caret"></b>
	                              </a>
	                              <ul class="dropdown-menu">
	                                <li><a href="<?php echo base_url() ?>index.php/Home/perfil">Perfil</a></li>
	                                <li><a href="<?php echo base_url() ?>index.php/Home/logout">Logout</a></li>
	                              </ul>
	                        </li>
	                    </ul>

	                </div>
	            </div>
	        </nav>

	        <div class="row">
	    		<div class="col-md-6 col-md-offset-3">
	    			<?php 
	    			
	    			echo $this->session->flashdata('message');
	    			 ?>
	    			
	                
	    		</div>
	    	</div>

	    	<?php //print_r($fases); ?>

	        <div class="content container">
	        	<!--<a href="<?php echo base_url() ?>index.php/Equipos" class='btn btn-info btn-fill btn-wd'>Regresar</a><br><br>-->
	        	<?php if (count($fases)!=0): ?>
	        		<div class="content table-responsive table-full-width">

	                    <table class="table table-striped" id="tabla_estudiantes">
	                        <thead>
	                            <th>PROCESO</th>
	                        	<th>FASE</th>
	                        	<th>FECHA INICIAL</th>
	                        	<th>FECHA FINAL</th>
	                        	<th></th>
	                        	
	                        </thead>
	                        <tbody>
	                        <?php
	                        for ($i=0; $i < count($fases) ; $i++) { 
	                        	# code...
	                        	echo "<tr>";
	                        		echo "<td>".$fases[$i]['proceso']."</td>";
	                        		echo "<td>".$fases[$i]['fase_objetivo']."</td>";
	                        		echo "<td>".$fases[$i]['fecha_inicio']."</td>";
	                        		echo "<td>".$fases[$i]['fecha_final']."</td>";
	                        		echo "<td><a class='btn btn-primary changeFechaFinal' id='".$fases[$i]['id']."' href='#'>Actualizar Fecha</a></td>";
	                        		
	                        	echo "</tr>";
	                        }
	                        
	                        ?>
	                        	
	                            
	                            
	                        </tbody>
	                    </table>

	                </div>
	        	<?php else: ?>
	        		<h3>NO HAY ACTIVIDADES EN SEGUIMIENTO</h3>
	        		<br><br>
	        		<a href="<?php echo base_url() ?>index.php/Equipos" class='btn btn-info btn-fill btn-wd'>Regresar</a>
	        		
	        	<?php endif ?>
	            
	            
	        </div>


	        

	    </div>
	</div>

	<!-- Modales-->
	<div class="modal fade" tabindex="-1" role="dialog" id="modalChangeDate">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<?php echo form_open('Calendario/changeFechaFinal'); ?>
	        <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Cambiar Fecha</h4>
	        </div>
	      <div class="modal-body">
	        <h4 id="nombre_fase"></h4>
	        <hr>
	        <div class="row">
	        	<div class="col-md-6">
	        		<p>Fecha Inicial<input type="text" id="fecha_inicio" disabled=""></p>
	        	</div>
	        	<div class="col-md-6">
	        		<p>Fecha Final<input type="text" name="fecha_final" id="fecha_final" required=""></p>
	        	</div>
	        </div>
	        <input type="hidden" id="id_equipo_hidden" name="id_equipo_hidden" value="<?php echo $equipo['id'] ?>">
	        <input type="hidden" name="id_tracing" value="" id="id_tracing">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <input type="submit" class="btn btn-info" name="" value="Cambiar">
	      </div>
	      </form><!-- /.end form -->
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</body>

<!--   Core JS Files   -->
<script src="<?php echo base_url(); ?>public/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>public/js/jquery-ui.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>public/js/bootstrap.min.js" type="text/javascript"></script>



<!--  Charts Plugin -->
<script src="<?php echo base_url(); ?>public/js/chartist.min.js"></script>

<!--  Notifications Plugin    -->
<script src="<?php echo base_url(); ?>public/js/bootstrap-notify.js"></script>

<!--  Google Maps Plugin    -->
<!--script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script-->

<!-- Paper Dashboard Core javascript and methods for Demo purpose -->
<script src="<?php echo base_url(); ?>public/js/paper-dashboard.js"></script>

<!-- Paper Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url(); ?>public/js/demo.js"></script>

<script src="<?php echo base_url("libs/js/datatables.min.js"); ?>"></script>
<script src="<?php echo base_url("libs/js/toastr.min.js"); ?>"></script>
<script src="<?php echo base_url("libs/js/script.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url("libs/js/cbpFWTabs.js"); ?>" type="text/javascript"></script>


<script type="text/javascript">
	$(document).ready(function(){
			$('#tabla_estudiantes').DataTable();
			/*$( "#fecha_final" ).datepicker({
				dateFormat: "yy-mm-dd",
				beforeShowDay: $.datepicker.noWeekends
			});*/
			
	});
</script>


</html>
