<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en" ng-app="verseguimiento">
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
	<script src="<?php echo base_url(); ?>public/js/verSeguimiento_Controller.js"></script>
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
	<style type="text/css">

		.cuadro{
			border-radius: 5px;
			width: 20px;
    	height: 15px;
		}

		.urgente,
		.urgente div,
		.urgente span {
		 background-color: red; /* background color */
		 border-color: white;     /* border color */
		 color: white;           /* text color */
		}

		.pasado,
		.pasado div,
		.pasado span {
		 background-color: gray; /* background color */
		 border-color: white;     /* border color */
		 color: white;           /* text color */
		}

		.marcha,
		.marcha div,
		.marcha span {
		 background-color: green; /* background color */
		 border-color: white;     /* border color */
		 color: white;           /* text color */
		}

		.futuro,
		.futuro div,
		.futuro span {
		 background-color: #33B5FF; /* background color */
		 border-color: white;     /* border color */
		 color: white;           /* text color */
		}

	</style>

</head>
<body ng-controller="vercalendario_Controller" ng-init="index()">
	<div class="wrapper">
				<div id="myModal" class="modal fade">
					<div class="modal-dialog">
							<div class="modal-content">
									<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h4 class="modal-title">Editar Fecha</h4>
									</div>
									<div class="modal-body" id="modalupdate">
										<form  ng-submit="updateDate()">
												<div class="row">
														<div class="col-md-12">
																<p>Terminar antes o extender la fecha establecida de la actividad, se reflejará al termino
																	del seguimiento como puntos buenos o puntos malos.
																</p>
																<br><br>
														</div>
														<div class="col-md-12">
																<p>Terminar antes o extender la fecha establecida de la actividad, se reflejará al termino
																	del seguimiento como puntos buenos o puntos malos.
																</p>
																<br><br>
														</div>

														<div class="col-md-12">
																<p>Seleccione la nueva fecha final.
																</p>

														</div>

														<div class="col-md-6">
										            <div class="form-group">
										                <label>Fecha Inicial:</label>
										                <input readonly type="text" name="from" ng-model="activity_start" class="form-control border-input" >
										            </div>
										        </div>
														<div class="col-md-6">
										            <div class="form-group">
										                <label>Fecha Final:</label>
										                <input type="text" id="to" name="to" ng-model="dataUpdateDate" class="form-control border-input">
										            </div>
										        </div>
												</div>
												<div class="modal-footer">
														<button type="button" class="btn btn-default btn-wd" data-dismiss="modal">Cancelar</button>
														<input type="submit"  class="btn btn-info btn-fill btn-wd" name="submit" value="Aceptar" />
												</div>
										</form>
									</div>
							</div>
					</div>
			</div>
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
								<div id="avisos">
								</div>
								<div class="row">
									<div class="col-md-12 col-xl-12">
										<div class="card">
											<div class="header">
													<h4 class="title">Actividades</h4>
                          <!--p class="category">En n dias termina el Plan de acción.</p-->
											</div>
											<div class="content">
												<?php
												$cadena = date("Y")."-".date("m")."-".date("d");
												echo $cadena;
												 ?>
												<input type="hidden" name="tracing" id="tracing" value="<?=$tracing ?>">
												<input type="hidden" name="phase" id="phase" value="<?=$phase ?>">
												<div class="row">
													<div class="col-md-12">
														<div class="col-md-6">
															<div style="text-align:left">
																<h3>Fecha Inicial:</h3>
		                            <h5><?php echo $fi ?></h5>
															</div>
														</div>
														<div class="col-md-6">
															<div style="text-align:right">
																<h3>Fecha Final:</h3>
		                            <h5><?php echo $ff ?></h5>
															</div>
														</div>
                          </div>

                          <div class="col-md-12">
														<div class="col-md-4"></div>
														<div class="col-md-6">
															<table>
																<tr>
																	<td align="center" style="padding-right: 20px; ">Anterior<div class="cuadro pasado "></div> </td>
																	<td align="center" style="padding-right: 20px;">Actual<div class="cuadro marcha "></div> </td>
																	<td align="center" style="padding-right: 20px;">Próximo<div class="cuadro futuro "></div> </td>
																	<td align="center" style="padding-right: 20px;">Por terminar<div class="cuadro urgente "></div> </td>
																</tr>
															</table>
														</div>
														<div class="col-md-2"></div>
														<br><br>
														<div class="alert-info calAlert" ng-show="alertMessage != undefined && alertMessage != '' ">
											        Actividad: {{alertMessage}}
															<a style="color:black" ng-show='bandera' href="#" data-toggle="modal" data-target="#myModal" >| Editar</a>
											      </div>
											      <br>
											      <div class="calendar" ng-model="eventSources" calendar="myCalendar1" ui-calendar="uiConfig.calendar"></div>
                          </div>
												</div>
                        <br><br>
                        <a href="<?php echo base_url() ?>index.php/Modelos/resultado" class="btn btn-defaul btn-wd">Atrás</a></button>
                        <br><br>
											</div>
										</div>
									</div>
								</div>


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

<!--  Notifications Plugin    -->
<script src="<?php echo base_url(); ?>public/js/bootstrap-notify.js"></script>

<!--  Google Maps Plugin    -->
<!--script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script-->

<!-- Paper Dashboard Core javascript and methods for Demo purpose -->
<script src="<?php echo base_url(); ?>public/js/paper-dashboard.js"></script>

<!-- Paper Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url(); ?>public/js/demo.js"></script>

</html>
