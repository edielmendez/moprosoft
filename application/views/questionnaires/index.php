<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en" ng-app="questionary">
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
	<script src="<?php echo base_url(); ?>public/js/questionary_Controller.js"></script>

  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>

	<!--link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/style.css">
	<script type='text/javascript' src="<?php echo base_url(); ?>public/js/jquery.min.js"></script-->
	<!-- -->


</head>
<body ng-controller="questionary_Controller" ng-init="index()">
	<div class="wrapper">
				<div id="myModal" class="modal fade">
					<div class="modal-dialog">
							<div class="modal-content">
									<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h4 class="modal-title">Nuevo Cuestionario</h4>
									</div>
									<div class="modal-body">
                    <form action="<?php echo base_url() ?>index.php/questionary_Controller/save" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input required id="new_nombre" name="new_nombre"  ng-model="new_nombre" type="text" class="form-control border-input" placeholder="Nombre" >
                                </div>
																<div class="form-group">
                                    <label>Fase/Objetivo</label>
																		<select class="form-control" id="new_fase" name="new_fase">
																			<?php foreach($phases as $phase){
																				echo '<option value='.$phase['id'].'>'.$phase['name'].'</option>';
																				}
																			?>
																		</select>
                                </div>
                            </div>
                        </div>
												<div class="modal-footer">
														<button type="button" class="btn btn-default btn-wd" data-dismiss="modal">Cancelar</button>
														<input type="submit"  class="btn btn-info btn-fill btn-wd" name="submit" value="Guardar" />
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
	                    Moprosoft
	                </a>
	            </div>

	            <ul class="nav">
	                <!--li>
	                    <a href="<?php echo base_url(); ?>index.php/Modelos/abrir_modelo">
	                        <i class="ti-star"></i>
	                        <p>Modelos</p>
	                    </a>
	                </li-->
									<li >
											<a href="<?php echo base_url(); ?>index.php/Modelos/actividad">
													<i class="ti-world"></i>
													<p>Actividad</p>
											</a>
									</li>
									<li>
											<a href="<?php echo base_url(); ?>index.php/Modelos/resultado">
													<i class="ti-check"></i>
													<p>Resultados</p>
											</a>
									</li>
									<li>
											<p><hr/></p>
									</li>
	                <li>
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
									<li   class="active">
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
											<a class="navbar-brand" href="<?php echo base_url(); ?>index.php/Modelos/abrir_modelo"><?php  print_r($_SESSION['modelsessioname']) ?></a> <p class="navbar-brand" >/</p> <a class="navbar-brand" href="<?php echo base_url() ?>index.php/questionary_Controller/index">Cuestionarios</a>
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
								<?php
								//Si existen las sesiones flasdata que se muestren
										if($this->session->flashdata('correcto'))
											echo '<div class="alert alert-success"><button type="button" aria-hidden="true" class="close" data-dismiss="alert">×</button><span><b> Bien - </b>'.$this->session->flashdata('correcto').'</span></div>';

										if($this->session->flashdata('incorrecto'))
											echo '<div class="alert alert-danger"><button type="button" aria-hidden="true" class="close" data-dismiss="alert">×</button><span><b> Error - </b>'.$this->session->flashdata('incorrecto').'</span></div>';
								?>
                <div class="row">
                  <div class="col-md-12">
                      <div class="card">
                          <div class="header">
                              <h4 class="title">Buscar</h4>
                          </div>
                          <div class="content">
                                  <div class="row">
																			<div class="col-md-12">
																					<div class="form-group">
																							<label>Nombre</label>
																							<input type="text" ng-model="buscar" name="buscar" id="buscar" class="form-control border-input" placeholder="Nombre" >
																					</div>
																			</div>
                                      <div class="col-md-12">
                                          <div class="form-group">
                                            <label>Proceso</label>
																							<select class="form-control" id="proceso" name="proceso" ng-model="proceso"   ng-change="cargarPhases()" >
																								<option value="Todos" selected>Todos</option>
																								<option ng-repeat="proceso in process" value="{{proceso.id}}">{{proceso.name}}</option>
																							</select>

                                          </div>
                                      </div>
                                  </div>
																	<br><br>
																	<!--button  type="button" class="btn btn-info btn-fill btn-wd" data-toggle="modal" data-target="#myModal" data-title="Nuevo Cuestionario">Nuevo</button><br><br-->
                          </div>
                      </div>
                  </div>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-sm-6" ng-repeat="cuestionario in cuestionarios | filter:buscar">
                        <div class="card">
                            <div class="content">
                                <div class="row">
                                  <div class="col-xs-2">
                                    <img src="<?php echo base_url() ?>public/img/cuestionario.png" style="width:50px; height:60px" alt="Procesos" /><br>
																		<span ng-if='cuestionario.status==1'><br><br></span>
                                  </div>
                                  <div class="col-xs-10">
                                    <p ng-bind="cuestionario.name" ></p>
                                  </div>
                                  <div ng-if='cuestionario.status==0' class="col-xs-12" style="text-align: right;">
                                    <br><br>
                                  </div>
																	<div class="col-xs-12" style="text-align: left;">
																		<div ng-if='cuestionario.status==1'>
																			<img src="<?php echo base_url() ?>public/img/liberado.png" style="width:15px; height:20px" alt="Liberado" />
																		</div>
																		<div ng-if='cuestionario.status==0'>
																			<img src="<?php echo base_url() ?>public/img/sinliberar.png" style="width:20px; height:20px" alt="Sin Liberar" />
																		</div>

                                  </div>
                                </div>
                                <div class="footer">
                                    <hr/>
                                    <div class="stats">
                                        <i class="ti-eye"></i><a href="<?php echo base_url() ?>index.php/Question_Controller/Preguntas/{{cuestionario.id}}">Preguntas</a>
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
<script src="<?php echo base_url(); ?>public/js/jquery-1.10.2.js" type="text/javascript"></script>
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

<script type="text/javascript">
	$(document).ready(function(){

			//demo.initChartist();

				$("#myModal").on('show.bs.modal', function(event){
        	var button = $(event.relatedTarget);  // Button that triggered the modal
        	var titleData = button.data('title'); // Extract value from data-* attributes
        	$(this).find('.modal-title').text(titleData);
    		});
	});
</script>


</html>
