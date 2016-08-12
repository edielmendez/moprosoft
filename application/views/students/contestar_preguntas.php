<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en" ng-app="student">
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
	<script src="<?php echo base_url(); ?>public/js/student_Controller.js"></script>


  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>

	<!--link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/style.css">
	<script type='text/javascript' src="<?php echo base_url(); ?>public/js/jquery.min.js"></script-->
	<!-- -->

</head>
<body ng-Controller="student_Controller"  ng-init="index()">
	<div class="wrapper">
				<div id="myModal" class="modal fade">
					<div class="modal-dialog">
							<div class="modal-content">
									<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											<h4 class="modal-title"></h4>
									</div>
									<div class="modal-body">
                    <form action="<?php echo base_url() ?>index.php/question_Controller/save" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Pregunta</label>
                                    <input name="pregunta"  id="pregunta" required type="text" class="form-control border-input" placeholder="La pregunta sera sin signos de interrogación" >
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
	                    <a href="<?php echo base_url() ?>index.php/process_Controller/index">
	                        <i class="ti-direction-alt"></i>
	                        <p>Cuestionarios</p>
	                    </a>
	                </li>
	                <li>
	                    <a href="<?php echo base_url() ?>index.php/phase_Controller/index">
	                        <i class="ti-view-list-alt"></i>
	                        <p>Fases/Objetivos</p>
	                    </a>
	                </li-->
									<li   class="active">
											<a href="<?php echo base_url() ?>index.php/student_Controller/index">
													<i class="ti-book"></i>
													<p>Cuestionarios</p>
											</a>
									</li>
                  <!--li>
                      <a href="<?php echo base_url() ?>index.php/phase_Controller/index">
                          <i class="ti-view-list-alt"></i>
                          <p>Historial</p>
                      </a>
                  </li-->
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
								<?php
								//Si existen las sesiones flasdata que se muestren
										if($this->session->flashdata('correcto'))
											echo '<div class="alert alert-success"><button type="button" aria-hidden="true" class="close" data-dismiss="alert">×</button><span><b> Bien - </b>'.$this->session->flashdata('correcto').'</span></div>';

										if($this->session->flashdata('incorrecto'))
											echo '<div class="alert alert-danger"><button type="button" aria-hidden="true" class="close" data-dismiss="alert">×</button><span><b> Error - </b>'.$this->session->flashdata('incorrecto').'</span></div>';
								?>
                  <div class="row">
                    <div class="col-md-12" >
                        <div class="card">
                            <div class="content">
                                <div class="row">

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
                                    <ul class="nav nav-tabs">
                                      <li class="active"><a data-toggle="tab" href="#menu1">Seccion 1</a></li>
																			<?php
																			for ($i = 1; $i <$numpreguntas; $i++) {
																				  echo '<li><a data-toggle=tab href=#menu2>Seccion 2</a></li>';
																			}
																			?>
                                      <!--li><a data-toggle="tab" href="#menu2">Seccion 2</a></li>
                                      <li><a data-toggle="tab" href="#menu3">Seccion 3</a></li>
                                      <li><a data-toggle="tab" href="#menu4">Seccion 4</a></li>
                                      <li><a data-toggle="tab" href="#menu5">Seccion 5</a></li>
                                      <li><a data-toggle="tab" href="#menu6">Seccion 6</a></li>
                                      <li><a data-toggle="tab" href="#menu7">Seccion 7</a></li>
                                      <li><a data-toggle="tab" href="#menu8">Seccion 8</a></li>
                                      <li><a data-toggle="tab" href="#menu9">Seccion 9</a></li>
                                      <li><a data-toggle="tab" href="#menu10">Seccion 10</a></li-->

                                    </ul>

                                    <div class="tab-content">
                                      <div id="menu1" class="tab-pane fade in active">
																					<br>
																					<div class="col-xs-12">
																							<div class="row">
																									<div class="col-xs-8">
																										<div id="pregunta1">
																											<p>{{numPregunta1}} ¿  {{preguntasFiltradas[0].question}}  ?</p>
																										</div>
																									</div>
																									<div class="col-xs-4">
																										<div class="radio">
																											<label><input type="radio" name="respuesta1" value="1">Siempre</label>
																										</div>
																										<div class="radio">
																											<label><input type="radio" name="respuesta1" value="2">Usualmente</label>
																										</div>
																										<div class="radio">
																											<label><input type="radio" name="respuesta1" value="3">Algunas Veces</label>
																										</div>
																										<div class="radio">
																											<label><input type="radio" name="respuesta1" value="4">Rara Vez</label>
																										</div>
																										<div class="radio">
																											<label><input type="radio" name="respuesta1" value="5">Nunca</label>
																										</div>
																										<div class="radio">
																											<label><input type="radio" name="respuesta1" value="6">No Sabe</label>
																										</div>
																										<div class="radio">
																											<label><input type="radio" name="respuesta1" value="7">No Aplica</label>
																										</div>
																									</div>
																							</div>
																							<hr/>
																							<div class="row" id="ContenedorPregunta2">
																									<div class="col-xs-8">
																										<?php //print_r($preguntas);print_r($numpreguntas);?>
																										<div id="pregunta1">
																												<p>{{numPregunta2}} ¿  {{preguntasFiltradas[1].question}}  ?</p>
																										</div>
																									</div>
																									<div class="col-xs-4">
																										<div class="radio">
																											<label><input type="radio" name="respuesta2" value="1" id="p1" >Siempre</label>
																										</div>
																										<div class="radio">
																											<label><input type="radio" name="respuesta2" value="2">Usualmente</label>
																										</div>
																										<div class="radio">
																											<label><input type="radio" name="respuesta2" value="3">Algunas Veces</label>
																										</div>
																										<div class="radio">
																											<label><input type="radio" name="respuesta2" value="4">Rara Vez</label>
																										</div>
																										<div class="radio">
																											<label><input type="radio" name="respuesta2" value="5">Nunca</label>
																										</div>
																										<div class="radio">
																											<label><input type="radio" name="respuesta2" value="6">No Sabe</label>
																										</div>
																										<div class="radio">
																											<label><input type="radio" name="respuesta2" value="7">No Aplica</label>
																										</div>
																									</div>
																							</div>

																							<div class="row">
																								<br>
																								<div class="col-xs-12" id="botones">
																									<button id="atras" ng-click="atras()" type="button"  class="btn btn-default btn-wd">Atrás</button>
																									<span ng-if='end!=10'><button ng-click="siguiente()"  type="button"  class="btn btn-info btn-wd" >Siguiente</button></span>
																									<span ng-if='end==10'><button ng-click="terminar()" id="btnsiguiente" type="button"  class="btn btn-info btn-wd" >Terminar</button></span>
																								</div>

																							</div>

																						</div>
																		  </div>
                                      <div id="menu2" class="tab-pane fade">
                                        <h3>Menu 2</h3>
                                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                                      </div>
                                      <div id="menu3" class="tab-pane fade">
                                        <h3>Menu 3</h3>
                                        <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                                      </div>
                                      <div id="menu4" class="tab-pane fade">
                                        <h3>Menu 4</h3>
                                        <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                                      </div>
                                      <div id="menu5" class="tab-pane fade">
                                        <h3>Menu 5</h3>
                                        <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                                      </div>
                                      <div id="menu6" class="tab-pane fade">
                                        <h3>Menu 6</h3>
                                        <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                                      </div>
                                      <div id="menu7" class="tab-pane fade">
                                        <h3>Menu 7</h3>
                                        <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                                      </div>
                                      <div id="menu8" class="tab-pane fade">
                                        <h3>Menu 8</h3>
                                        <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                                      </div>
                                      <div id="menu9" class="tab-pane fade">
                                        <h3>Menu 9</h3>
                                        <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                                      </div>
                                      <div id="menu10" class="tab-pane fade">
                                        <h3>Menu 10</h3>
                                        <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
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
<!--script src="<?php echo base_url(); ?>public/js/chartist.min.js"></script-->

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

		//	demo.initChartist();

				$("#myModal").on('show.bs.modal', function(event){
        	var button = $(event.relatedTarget);  // Button that triggered the modal
        	var titleData = button.data('title'); // Extract value from data-* attributes
					$(this).find('.modal-title').text(titleData);
    		});
	});
</script>


</html>
