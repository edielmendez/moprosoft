<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en" ng-app="seguimiento">
<head>
	<meta charset="UTF-8">
	<title>Jefe</title>
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
  <link href="<?php echo base_url(); ?>public/css/jquery-ui.css" rel="stylesheet" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/css/fullcalendar.css"/>

  <script src="<?php echo base_url(); ?>public/js/jquery-1.10.2.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>public/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>public/js/angular.min.js"></script>
	<script src="<?php echo base_url(); ?>public/js/jquery-ui.js"></script>
	<script src="<?php echo base_url(); ?>public/js/angular-route.js"></script>
	<script src="<?php echo base_url(); ?>public/js/seguimiento_Controller.js"></script>
	<script src="<?php echo base_url(); ?>public/js/ui-bootstrap-tpls-2.1.3.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/js/moment.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/js/calendar.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/js/fullcalendar.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/js/gcal.js"></script>


  <!--link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'-->

	<!--link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/style.css">
	<script type='text/javascript' src="<?php echo base_url(); ?>public/js/jquery.min.js"></script-->
	<!-- -->


</head>
<body ng-controller="inicio_Controller">
	<div class="wrapper">
	    <div class="sidebar" data-background-color="white" data-active-color="danger">
	    <!--
			Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
			Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
		-->
	    	<div class="sidebar-wrapper">
	            <div class="logo">
	                <a href="<?php echo base_url(); ?>index.php/Modelos/abrir_modelo" class="simple-text">
										<!--Nombre del Modelo-->
	                    <?php  print_r($_SESSION['modelsessioname']) ?>
	                </a>
	            </div>

	            <ul class="nav">
	                <li >
	                    <a href="<?php echo base_url(); ?>index.php/Modelos/actividad">
	                        <i class="ti-world"></i>
	                        <p>Actividad</p>
	                    </a>
	                </li>
									<li class="active">
											<a href="<?php echo base_url(); ?>index.php/Modelos/resultado">
													<i class="ti-check"></i>
													<p>Resultados</p>
											</a>
									</li>
									<li>
											<p><hr/></p>
	                </li>
	                <li >
	                    <a href="<?php echo base_url() ?>index.php/Process_Controller/index">
	                        <i class="ti-direction-alt"></i>
	                        <p>Procesos</p>
	                    </a>
	                </li>
	                <li>
	                    <a href="<?php echo base_url() ?>index.php/Phase_Controller/index">
	                        <i class="ti-view-list-alt"></i>
	                        <p>Fases/Objetivos</p>
	                    </a>
	                </li>
									<li>
	                    <a href="<?php echo base_url() ?>index.php/Questionary_Controller/index">
	                        <i class="ti-book"></i>
	                        <p>Cuestionarios</p>
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
											<a class="navbar-brand" href="<?php echo base_url(); ?>index.php/Modelos/abrir_modelo"><?php  print_r($_SESSION['modelsessioname']) ?></a><p class="navbar-brand" >/</p><a class="navbar-brand" href="<?php echo base_url() ?>index.php/Modelos/resultado">Resultado</a>
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
																	<li><a href="<?php echo base_url(); ?>index.php/Modelos/perfil2">Perfil</a></li>
	                                <li><a href="<?php echo base_url() ?>index.php/Home/logout">Logout</a></li>
	                              </ul>
	                        </li>
	                    </ul>

	                </div>
	            </div>
	        </nav>

	        <div class="content">
	            <div class="container-fluid">
								<div class="row">
									<div class="col-md-12 col-xl-12">
										<div class="card">
											<div class="header">
												<h4>Historial</h4>
                        <p class="category">Fecha Inicial:<?=$fi;?>.</p>
                        <p class="category">Fecha Final:<?=$ff;?>.</p>
											</div>
											<div class="content">
												<div class="row">
                          <div class="col-md-12">
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th>Actividad</th>
                                  <th>Prioridad</th>
                                  <th>Fecha Inicial</th>
                                  <th>Fecha Final</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
    														foreach ($activity as $a) {
    														?>
                                <tr>
                                  <td width=70% ><?=$a['activity']; ?></td>
                                  <td><?=$a['orden'] ; ?></td>
                                  <td><?=$a['date_start']; ?></td>
                                  <td><?=$a['date_end']; ?></td>
                                </tr>
                                <?php
                                  }
                                 ?>
                              </tbody>
                            </table>
                            <br><br>
                            <a href="<?php echo base_url(); ?>index.php/Modelos/resultado" class="btn btn-primary btn-fill btn-wd" >Atrás</a>
                          </div>
												</div>
											</div>
										</div>
									</div>
								</div>



								<?php
									//foreach($cuestionarios as $q){
								?>
								<!--div class="row">
									<div class="col-md-12 col-xl-12">
										<div class="card">
											<div class="header">
													<h4 class="title">Nivel de Cobertura obtenida por Fase/Objetivo:
													<?php
														/*echo $q[2];
														if ($q[2]>$q[5]) {
															echo "<img src=\"".base_url()."public/img/mal.png\" style=\"width:15px; height:25px\" alt=\"Bien\" />";
														}else {
															echo "<img src=\"".base_url()."public/img/bien.png\" style=\"width:15px; height:25px\" alt=\"Mal\" />";
														}*/
													?>
												  </h4>
											</div>
											<div class="content">
												<div class="row">
													<div class="col-md-5">
														<p>Modelo: <b><?=$q[3]; ?></b> </p>
														<p>Proceso: <b> <?=$q[4]; ?></b></p>
														<p>Fase/Objetivo:<?=$q[0]; ?></p>
														<p>Integrantes:
															<?php
															//foreach ($equipos as $value) {
															//	echo $value['username']." ";
															//}
															?>
														</p>
	                        </div>
													<div class="col-md-5">
														<p>Nivel de Cobertura Requirida:<?php echo $q[5]; ?>%</p>
														<br><br><br>
														<?php
														 /*if ($q[6]>0) {
														 		echo "<a class=\"btn btn-info btn-fill btn-wd\" href=\"".base_url()."index.php/Modelos/VerSeguimiento/$q[1]\">Ver Seguimiento</a>";
														 }else {
														 		echo "<a class=\"btn btn-primary btn-fill btn-wd\" href=\"#\" ng-click=\"getPreguntas($q[1])\">Dar Seguimiento</a>";
														 }*/
														?>
	                        </div>
												</div>
											</div>
										</div>
									</div>
								</div-->
								<?php
									//}
								?>

								</div>
							</div>

	        <footer class="footer">
	            <div class="container-fluid">
	                <!--nav class="pull-left">
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
	                </div-->
	            </div>
	        </footer>

	    </div>
	</div>
</body>

<!--   Core JS Files   -->


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

</html>
