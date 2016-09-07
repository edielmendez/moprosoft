<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ACTUALIZAR ESTUDIANTE</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta name="viewport" content="width=device-width" />

	<!-- Se importo los estilos adecuados-->
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url(); ?>/img/favicon.png">

  <link href="<?php echo base_url(); ?>public/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>public/css/animate.min.css" rel="stylesheet"/>
  <link href="<?php echo base_url(); ?>public/css/paper-dashboard.css" rel="stylesheet"/>
  <link href="<?php echo base_url(); ?>public/css/demo.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>public/css/themify-icons.css" rel="stylesheet">
	<link href="<?php echo base_url("libs/css/datatables.min.css"); ?>" rel="stylesheet">
	<link href="<?php echo base_url("libs/css/toastr.min.css"); ?>" rel="stylesheet">

  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>

	<!--link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/style.css">
	<script type='text/javascript' src="<?php echo base_url(); ?>public/js/jquery.min.js"></script-->
	<!-- -->


</head>
<body>
	
	<div class="wrapper">
	    <div class="sidebar" data-background-color="white" data-active-color="danger">

	   

	    	<div class="sidebar-wrapper">
	            <div class="logo">
	                <a href="http://www.creative-tim.com" class="simple-text">
	                    ESTUDIANTES
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
	                <!--<li >
	                    <a href="">
	                        <i class="ti-panel"></i>
	                        <p>Reportes de avance</p>
	                    </a>
	                </li>
	                
	                <li>
	                    <a href="">
	                        <i class="ti-view-list-alt"></i>
	                        <p>Enviar Correos</p>
	                    </a>
	                </li>-->
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
	                    <a class="navbar-brand" href="#">ACTUALIZAR ESTUDIANTE</a>
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
	                                <li><a href="#">Perfil</a></li>
	                                <li><a href="<?php echo base_url() ?>index.php/Home/logout">Logout</a></li>
	                              </ul>
	                        </li>
	                    </ul>

	                </div>
	            </div>
	        </nav>

	        <div class="content container">
	        	<a href="<?php echo base_url() ?>index.php/Home" class='btn btn-info'><i class="ti-arrow-left"></i>  Regresar</a><br><br><br><hr>
	        	<div class="card">
		            <div class="content">
	                    <?php echo form_open('Estudiantes/actualizar',array('id'=>'form_actualizar_estudiante')); ?>
	                        <div class="row">
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                	<input type="hidden" name="id" id="id_estudiante_act" value="<?php echo $estudiante['id'] ?>" >
	                                    <label>Nombre Completo</label>
	                                    <input type="text" class="form-control border-input"  placeholder="nombre completo" name="nombre" value="<?php echo $estudiante['name'] ?>" required="" >
	                                </div>
	                            </div>
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                    <label>Username</label>
	                                    <input type="text" class="form-control border-input" id="username" placeholder="username" name="username" value="<?php echo $estudiante['username'] ?>" required="">
	                                </div>
	                            </div>
	                            <!--<div class="col-md-4">
	                                <div class="form-group">
	                                    <label for="exampleInputEmail1">Password</label>
	                                    <input type="password" class="form-control border-input" placeholder="password" name="password" value="<?php echo $estudiante['password'] ?>" required="">
	                                </div>
	                            </div>-->
	                        </div>

	                        <div class="row">
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                    <label>Email</label>
	                                    <input type="email" class="form-control border-input" placeholder="email" name="email" value="<?php echo $estudiante['email'] ?>" required="">
	                                </div>
	                            </div>
	                            <div class="col-md-6">
	                                <div class="form-group">
	                                    <label>Grupo</label>
	                                    <input type="text" class="form-control border-input" placeholder="grupo" name="grupo"  value="<?php echo $estudiante['grupo'] ?>" required="">
	                                </div>
	                            </div>
	                            
	                            <!--<div class="col-md-4">
	                                <div class="form-group">
	                                    <label>Equipo</label>

	                                    <select name="equipo" id="equipo" value='2'>
	                                    	<option selected="" disabled=""  >Selecciona un equipo</option>
	                                    	<?php
	                                    	foreach ($equipos as $equipo) {
	                                    		if($equipo['id'] == $estudiante['team_id'] ){
	                                    			echo "<option value='".$equipo['id']."' selected>".$equipo['name']."</option>";
	                                    		}else{
	                                    			echo "<option value='".$equipo['id']."'>".$equipo['name']."</option>";	
	                                    		}
	                                    		
	                                    	}
	                                    	 ?>
	                                    </select>
	                                </div>
	                            </div>-->
	                        </div>

	                        

	                        

	                        
	                        <div class="text-center">
	                            <button type="submit" class="btn btn-info btn-fill btn-wd">Actualizar</button>
	                        </div>
	                        <div class="clearfix"></div>
	                    </form>
	                </div>
                <div>
	        </div>


	        

	    </div>
	</div>
</body>

<!--   Core JS Files   -->
<script src="<?php echo base_url("libs/js/jquery-3.1.0.min.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>public/js/bootstrap.min.js" type="text/javascript"></script>


<!--  Checkbox, Radio & Switch Plugins -->
<script src="<?php echo base_url(); ?>public/js/bootstrap-checkbox-radio.js"></script>

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

<script type="text/javascript">
	$(document).ready(function(){
			$('#tabla_estudiantes').DataTable();
			$('.collapse').collapse()
			
	});
</script>


</html>
