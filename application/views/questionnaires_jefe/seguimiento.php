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
  <!--link href="<?php echo base_url(); ?>public/css/bootstrap-datetimepicker.css" rel="stylesheet" /-->
  <script src="<?php echo base_url(); ?>public/js/jquery-1.10.2.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>public/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>public/js/angular.min.js"></script>
	<script src="<?php echo base_url(); ?>public/js/seguimiento_Controller.js"></script>
  <script src="<?php echo base_url(); ?>public/js/jquery-ui.js"></script>
  <!--script src="<?php echo base_url(); ?>public/js/moment-with-locales.js"></script>
  <script src="<?php echo base_url(); ?>public/js/bootstrap-datetimepicker.js"></script-->


  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>

	<!--link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/style.css">
	<script type='text/javascript' src="<?php echo base_url(); ?>public/js/jquery.min.js"></script-->
	<!-- -->

</head>
<body ng-controller="seguimiento_Controller" >
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
                <!-- ///////////////////////////////////////////////////////////////////////////////7 -->
                <?php
                  //la fase aun no es finalizada por el administrador
                  if ($valor==1) {
                  ?>

                  <!-- Variables que se van a necesitar-->
                  <input type="hidden" name="phase" id="phase" value="<?php echo $Phase ?>">
                  <div class="row">
                    <div class="col-md-12 col-xl-12" >
                      <h1>Plan de Acción</h1>
                      <div class="card">
                        <div class="header" id="cabezera">
                            <h4 class="title">Oops !!!</h4>
                        </div>
                        <div class="content">
                            <div class="row">
                                <br>
                                <div class="col-md-12">
                                  <p>
                                    El cuestionario aún se encuentra en revisión, para mayor información contacte con el Administrador.
                                  </p>
                                </div>
                            </div>
                          <br><br>
                          <a href="<?php echo base_url() ?>index.php/Modelos/resultado" class="btn btn-defaul btn-wd">Atrás</a></button>
                          </div>
                        </div>
                      </div>
                    </div>

                  <?php
                  }
                  ?>


                  <!-- ///////////////////////////////////////////////////////////////////////////////7 -->
                  <?php
                  //Si la fase ya fue finalizada por el administrador
                  if ($valor==0) {
                  ?>
                  <!-- Variables que se van a necesitar-->
                  <input type="hidden" name="phase" id="phase" value="<?php echo $Phase ?>">
                  <div class="row">
                    <div class="col-md-12 col-xl-12" >
                      <h1>Plan de Acción</h1>
                      <div class="card">
                        <div class="header" id="cabezera">
                            <h4 class="title">Actividades</h4>
                            <p class="category">Seleccione las actividades con mayor prioridad.</p>
                        </div>
                        <div class="content" id="contenido">
                          <div id="validacion">

                          </div>
                          <table class="table">
                            <thead>
                              <tr>
                                <th>Actividad</th>
                                <th class="pnl_terminar">Priorizar</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                foreach($actividades as $act){
                              ?>
                              <tr id="o<?php echo $act['id'] ?>">
                                <td><?php echo $act['question'] ?></td>
                                <td class="pnl_terminar">
                                  <input  type="hidden" id="<?php echo $act['id'] ?>" value="<?php echo $act['question'] ?>"/>
                                  <input  type="checkbox" id="m<?php echo $act['id'] ?>" name="checkPriorizada" value="<?php echo $act['id'] ?>"/>
                                </td>
                              </tr>
                              <?php } ?>
                            </tbody>
                          </table>

                            <div id="valFechas">

                            </div>

                            <div class="row" ng-if='btn_terminar'>
                              <script>

                                $(function() {
                                  $("#from").datepicker({
                                    onClose: function (selectedDate) {
                                      if (selectedDate=="") {
                                          var f= new Date();
																					f.setDate(f.getDate()+1);
                                          selectedDate=(f.getMonth()+1)+"/"+f.getDate()+"/"+f.getFullYear();
                                        }else {
                                          f = new Date(selectedDate);
                                          f.setDate(f.getDate()+1);
                                          selectedDate=(f.getMonth()+1)+"/"+f.getDate()+"/"+f.getFullYear();
                                        }
                                      $("#to").datepicker("option", "minDate", selectedDate);
                                    }, minDate: "0",changeMonth: true
                                  });

                                  $("#to").datepicker({
                                    onClose: function (selectedDate) {
                                      if (selectedDate!="") {
                                        f = new Date(selectedDate);
                                        f.setDate(f.getDate()-1);
                                        selectedDate=(f.getMonth()+1)+"/"+f.getDate()+"/"+f.getFullYear();
                                      }
                                    $("#from").datepicker("option", "maxDate",selectedDate);
                                    }, minDate: "0" , changeMonth: true
                                  });
                                });

                              </script>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Fecha Inicial:</label>
                                        <input type="text" id="from" name="from" class="form-control border-input" placeholder="Fecha Inicial">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Fecha Final:</label>
                                        <input type="text" id="to" name="to" class="form-control border-input" placeholder="Fecha Final">
                                    </div>
                                </div>
                            </div>
                            <br>
                          <a href="<?php echo base_url() ?>index.php/Modelos/resultado" class="btn btn-defaul btn-wd">Atrás</a></button>
                          <span ng-if='btn_terminar'><button  type="button" class="btn btn-info btn-fill btn-wd" ng-click="terminar()" >Terminar</button><br><br></span>
                          <span ng-if='!btn_terminar'><button  type="button" class="btn btn-info btn-fill btn-wd" ng-click="siguiente()" >Siguiente</button><br><br></span>
                          </div>
                        </div>
                      </div>
                    </div>

                  <?php
                  }
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
