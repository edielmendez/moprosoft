<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en" ng-app="jefe">
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
  <script src="<?php echo base_url(); ?>public/js/angular.min.js"></script>
  <script src="<?php echo base_url(); ?>public/js/jefe_Controller.js"></script>

  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>

	<!--link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/style.css">
	<script type='text/javascript' src="<?php echo base_url(); ?>public/js/jquery.min.js"></script-->
	<!-- -->


</head>
<body ng-Controller="jefe_Controller"  ng-init="index()">
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
	                <li class="active">
	                    <a href="<?php echo base_url(); ?>index.php/Modelos/actividad">
	                        <i class="ti-world"></i>
	                        <p>Actividad</p>
	                    </a>
	                </li>
									<li>
											<a href="<?php echo base_url(); ?>index.php/Modelos/actividad">
													<i class="ti-check"></i>
													<p>Resultados</p>
											</a>
									</li>
									<li>
											<p><hr/></p>
	                </li>
	                <li >
	                    <a href="<?php echo base_url() ?>index.php/process_Controller/index">
	                        <i class="ti-direction-alt"></i>
	                        <p>Procesos</p>
	                    </a>
	                </li>
	                <li>
	                    <a href="<?php echo base_url() ?>index.php/phase_Controller/index">
	                        <i class="ti-view-list-alt"></i>
	                        <p>Fases/Objetivos</p>
	                    </a>
	                </li>
									<li>
	                    <a href="<?php echo base_url() ?>index.php/questionary_Controller/index">
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
                      <?php
                        foreach($cuestionario as $c){
                          echo "<p class=navbar-brand>Cuestionario: $c[name]</p>";
                          echo '<input type="hidden" ng-model="cuestionario_id" name="cuestionario_id" id="cuestionario_id" value="'.$c['id'].'">';
                        }
                      ?>
	                    <a class="navbar-brand" href="<?php echo base_url() ?>index.php/Home/index">Inicio</a>
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
	                                <!--li><a href="#">Perfil</a></li-->
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
                    <div class="col-md-12" >
                        <div class="card">
                            <div class="content">
                                <div class="row">
                                  <div id="aviso">
                                  </div>
                                  <div class="col-xs-12">
                                    <div class="progress progress-striped">
                                      <div class="progress-bar progress-bar-info" role="progressbar"
                                           aria-valuenow="{{porcentaje}}" aria-valuemin="0" aria-valuemax="100"
                                           style="width: {{porcentaje}}%">
                                        <span class="sr-only">{{porcentaje}} completado</span>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-xs-12">
                                    <span id="ultimavalidacion"></span>
                                    <ul class="nav nav-tabs">
                                      <li class="active"><a data-toggle="tab" id="tabMostrar1" ng-click="secciones(1)" href="#menu1" data-seccion="1">Seccion 1</a></li>
                                      <?php
                                      for ($i = 1; $i <$numpreguntas; $i++) {
                                          $var=$i+1;
                                          echo "<li><a data-toggle=tab id=tabMostrar$var ng-click=secciones($var) href=#menu1 data-seccion=$var>Seccion $var</a></li>";
                                      }
                                      ?>
                                    </ul>

                                    <div class="tab-content">

                                      <div id="menu1" class="tab-pane fade in active">
                                          <br>
                                          <div class="col-xs-12">
                                              <div class="row">
                                                  <div class="col-xs-9">
                                                    <span id="pre1"></span>
                                                    <div id="pregunta1">
                                                      <p><span ng-bind='numPregunta1'></span> ¿ <span ng-bind='preguntasFiltradas[0].question'></span> ?</p>
                                                    </div>
                                                  </div>
                                                  <div class="col-xs-3" id="respuestas1">
                                                      <label><input type="radio" name="respuesta1" value="1">Siempre</label><br>
                                                      <label><input type="radio" name="respuesta1" value="2">Usualmente</label><br>
                                                      <label><input type="radio" name="respuesta1" value="3">Algunas Veces</label><br>
                                                      <label><input type="radio" name="respuesta1" value="4">Rara Vez</label><br>
                                                      <label><input type="radio" name="respuesta1" value="5">Nunca</label><br>
                                                  </div>
                                              </div>
                                              <hr/>
                                              <div class="row" id="ContenedorPregunta2">
                                                  <div class="col-xs-9">
                                                    <span id="pre2"></span>
                                                    <div id="pregunta1">
                                                        <p><span ng-bind='numPregunta2'></span> ¿ <span ng-bind='preguntasFiltradas[1].question'></span> ?</p>
                                                    </div>
                                                  </div>
                                                  <div class="col-xs-3" id="respuestas2">
                                                    <label><input type="radio" name="respuesta2" value="1">Siempre</label><br>
                                                    <label><input type="radio" name="respuesta2" value="2">Usualmente</label><br>
                                                    <label><input type="radio" name="respuesta2" value="3">Algunas Veces</label><br>
                                                    <label><input type="radio" name="respuesta2" value="4">Rara Vez</label><br>
                                                    <label><input type="radio" name="respuesta2" value="5">Nunca</label><br>
                                                  </div>
                                              </div>

                                              <div class="row">
                                                <br>
                                                <div class="col-xs-12" id="botones">
                                                  <button id="atras" ng-click="atras()" type="button"  class="btn btn-default btn-wd">Atrás</button>
                                                  <span ng-if='terminar!=1'><button ng-click="siguiente()"  type="button"  class="btn btn-info btn-wd" >Siguiente</button></span>
                                                  <span ng-if='terminar==1'><button ng-click="terminarEncuesta()" type="button" class="btn btn-info btn-wd">Terminar</button></span>
                                                </div>
                                              </div>
                                            </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
	            </div>
	        </div>


	        <footer class="footer">
	            <div class="container-fluid">
	            </div>
	        </footer>

	    </div>
	</div>
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

</html>
