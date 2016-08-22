<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>CAMBIAR DE EQUIPO</title>
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
	<style type="text/css">
	input[type="radio"]{
		width: 20px;
		height: 20px;
	}
	</style>


</head>
<body>
	
	<div class="wrapper">
	    <div class="sidebar" data-background-color="white" data-active-color="danger">

	   

	    	<div class="sidebar-wrapper">
	            <div class="logo">
	                <a href="#" class="simple-text">
	                    EQUIPOS
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
	                    <a class="navbar-brand" href="#">CAMBIO DE EQUIPO</a>
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
	        	<a href="<?php echo base_url() ?>index.php/Equipos" class='btn btn-danger'><i class="ti-arrow-left"></i>  Cancelar</a><br><br><br><hr>
	        	<div class="row ">
	        		<div class="col-md-6 col-md-offset-3">
	        			<div class="card card-user">
                            
                            <div class="content">
                                <div class="author">
                                  <img class="avatar border-white" src="<?php echo base_url(); ?>/public/img/usuario.png" alt="Usuario"/>
                                  <h4 class="title"><?php echo $estudiante['username'] ?><br />
                                     <a href="#"><small><?php echo $estudiante['email'] ?></small></a>
                                  </h4>
                                </div>
                                <p class="description text-center">
                                    <b><?php echo $estudiante['name'] ?></b>
                                </p>
                            </div>
                            <hr>
                            <div class="text-center">
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        <h5><?php echo $estudiante['grupo'] ?><br /><small>Grupo</small></h5>
                                    </div>
                                    <div class="col-md-6">
                                    	<?php 
                                    	foreach ($equipos as $equipo){
                                    		if($equipo['id']===$estudiante['team_id']){
                                    			echo "<h5>".$equipo['name']."<br /><small>Equipo</small></h5>";
                                    		}
                                    	}
                                    	 ?>
                                    		
                                    	
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

	        		</div>
	        	</div>
	        	<?php //print_r($equipos) ; ?>
	        	<br>
	        	<br>
				<?php //print_r($estudiante);?>
				<?php 
				echo "<div class='row'>";
				foreach ($equipos as $equipo) {
					if($equipo['id']!=$estudiante['team_id']){
            			
            		
				
				 ?>
				
					<div class='col-md-6'>
					<?php echo form_open('Estudiantes/cambiar_equipo',array('id'=>'form_cambiar_equ_est')); ?>
						<div class="panel panel-info">
						  <div class="panel-heading">
						    <h3 class="panel-title"><?php echo $equipo['name']?></h3>
						  </div>
						  <div class="panel-body">
						  	
							  
							
						    
						    	<input  type='hidden' name='id_equipo'  value="<?php echo $equipo['id']?>" />
						    	<input  type='hidden' name='id_usuario'  value="<?php echo $estudiante['id']?>" />
							  <label><input type="radio" required="" name="optradio" class='radio_btn' >elegir</label>
							
						  </div>
						  <div class="panel-footer"><input type='submit' value='Cambiar' class='btn btn-primary'></div>
						</div>
						</form>
					</div>
					
				
				<?php 
					}
				}	
				?>
				</div>
	        </div>	

	
	        

	    </div>
	</div>
</body>

<!--   Core JS Files   -->
<script src="<?php echo base_url("libs/js/jquery-3.1.0.min.js"); ?>" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>public/js/bootstrap.min.js" type="text/javascript"></script>




<!--  Charts Plugin -->
<script src="<?php echo base_url(); ?>public/js/chartist.min.js"></script>

<!--  Notifications Plugin    -->
<script src="<?php echo base_url(); ?>public/js/bootstrap-notify.js"></script>

<!--  Google Maps Plugin    -->
<!--script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script-->

<!-- Paper Dashboard Core javascript and methods for Demo purpose -->
<script src="<?php echo base_url(); ?>public/js/paper-dashboard.js"></script>



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
