<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>EVALUACIÓN</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta name="viewport" content="width=device-width" />

	<!-- Se importo los estilos adecuados-->
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url(); ?>/img/favicon.png">

  <link href="<?php echo base_url(); ?>libs/css/bootstrap.min.css" rel="stylesheet" />
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
	                <li class="active">
	                    <a href="">
	                        <i class="ti-settings"></i>
	                        <p>Evaluación</p>
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
	                    <a class="navbar-brand" href="#">EVALUACIÓN</a>
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

	        <div class="content container">
	        	
	        	
	        	<section>
					<div class="tabs tabs-style-underline">
						<nav>
							<ul>
								<li><a href="#section-bar-1" class="icon icon-home"><span>CUESTIONARIOS DISPONIBLES</span></a></li>
								<!--<li><a href="#section-bar-2" class="icon icon-tools"><span>ESTADISTICAS</span></a></li>-->
							</ul>
						</nav>
						<div class="content-wrap">
							<section id="section-bar-1">
								
								<div class="row">
					        		<?php foreach ($cuestionarios as $cuestionario): ?>
				        			<div class="col-md-4">
					        			<div class="panel panel-info">
										    <div class="panel-heading">

										        <h1 class="panel-title"><?php echo $cuestionario['datos']['name'] ?></h1>
										    </div>
											<div class="panel-body">
											    <img src="<?php echo base_url() ?>/libs/images/cuestionario.png">

											</div>
										    <div class="panel-footer"> 
										  		<button type="button" class="btn btn-default btn_apli_eva" aria-label="Left Align" id="<?php echo $cuestionario['datos']['id'] ?>-<?php echo $cuestionario['equipo']['id'] ?>">
												 	Aplicar
												</button>
												
												<a href="#" rel="popover" data-popover-content="#myPopover<?php echo $cuestionario['datos']['id']  ?>" >Detalles</a>
												<div id="myPopover<?php echo $cuestionario['datos']['id']  ?>" class="hide">
													<?php 
														if(strcmp($cuestionario['modelo']['phase_objetive'],"Fases")==0){
															echo "<h6>Fase : </h6>";
														}else{
															echo "<h6>Objetivo : </h6>";
														}	
													 ?>
													
													<?php echo $cuestionario['fase']['name'] ?>

													<h6>proceso</h6><?php echo $cuestionario['proceso']['name'] ?>
													<h6>modelo</h6><?php echo $cuestionario['modelo']['name'] ?>
													<h6>equipo</h6><?php echo $cuestionario['equipo']['name'] ?>
												</div>
										  </div>
										</div>
					        		</div>
					        		<?php endforeach ?>
					        	</div>
							</section>
							<!--Seccion de seguimiento de los cuestionarios-->
							<!--<section id="section-bar-2">
								
							</section>-->
							
						</div><!-- /content -->
					</div><!-- /tabs -->
				</section>
	        	<?php //print_r($cuestionarios) ?>
	        	

	        	
	        	

			    
	            
	        </div>


	        <footer class="footer">
	            <!--<div class="container-fluid">
	                <nav class="pull-left">
	                    <ul>

	                        <li>
	                            <a href="http://www.creative-tim.com">
	                                Creative Tim
	                            </a>
	                        </li>
	                        <li>
	                            <a href="http://blog.creative-tim.com">
	                               Blog
	                            </a>
	                        </li>
	                        <li>
	                            <a href="http://www.creative-tim.com/license">
	                                Licenses
	                            </a>
	                        </li>
	                    </ul>
	                </nav>
	                <div class="copyright pull-right">
	                    &copy; <script>document.write(new Date().getFullYear())</script>, made with <i class="fa fa-heart heart"></i> by <a href="http://www.creative-tim.com">Creative Tim</a>
	                </div>
	            </div>-->
	        </footer>

	    </div>
	</div>

	<!-- Modales-->
	<div class="modal fade" tabindex="-1" role="dialog" id="modal_elegir_equipos_eva">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<?php echo form_open('Evaluacion/setCuestionarios'); ?>
	        <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Aplicar Cuestionario</h4>
	        </div>
	      <div class="modal-body">
	        <h3>Selecciona los equipos a los que se aplicara este cuestionario</h3>
	        <hr>
	        <div id="form_equipos_apl_cuest">
	        	
	        </div>
	        
	        <input type="hidden" name="id_cuestionario" value="" id="id_cuestionario">
	  
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <input type="submit" class="btn btn-info" name="" value="Aplicar">
	      </div>
	      </form><!-- /.end form -->
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</body>

<!--   Core JS Files   -->
<script src="<?php echo base_url(); ?>public/js/jquery-1.10.2.js" type="text/javascript"></script>
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
			/*
			demo.initChartist();
			$.notify({
					icon: 'ti-gift',
					message: "Bienvenido <b>ediel</b> , usted a iniciado sessión."

				},{
						type: 'success',
						timer: 4000
				});
				*/
	});
</script>


</html>
