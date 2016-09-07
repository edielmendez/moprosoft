<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>DETALLES</title>
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
	
	<!--<link href="<?php echo base_url(); ?>libs/css/normalize.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>libs/css/demo.css" rel="stylesheet" />-->
	<link href="<?php echo base_url(); ?>libs/css/tabs.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>libs/css/tabstyles.css" rel="stylesheet" />
	
  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>


	

	<style type="text/css">
	table,
    thead,
    tr,
    tbody,
    th,
	td {
        text-align: center;
    }

    .punto_fuerte{
		background: #bbdefb;
    }

    .punto_debil{
		background: #ffcdd2;
    }

    .indeterminado{
		background: #80cbc4 ;
    }


	

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
	                    DETALLES
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
							<i class="ti-settings"></i>
	                		<p>Detalles de evaluación</p>
	                	</a>
	                </li>
	                
	            </ul>
	    	</div>
	    </div>

	    <div class="main-panel" >
	    	
	    	
	        <nav class="navbar navbar-default">
	            <div class="container-fluid">

	                <div class="navbar-header">
	                    <button type="button" class="navbar-toggle">
	                        <span class="sr-only">Toggle navigation</span>
	                        <span class="icon-bar bar1"></span>
	                        <span class="icon-bar bar2"></span>
	                        <span class="icon-bar bar3"></span>
	                    </button>
	                    <a class="navbar-brand" href="#">DETALLES DE EVALUACIÓN DEL EQUIPO <?php echo $equipo['name'] ?></a>
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
			<?php //echo $mostrar_kiviat ?>
	        <div class="content container" id="contenedor_principal">
	        	<!--<a href="<?php echo base_url() ?>index.php/Equipos" class='btn btn-danger'><i class="ti-arrow-left"></i>  Regresar</a><hr>-->
				<div class="row">
					<div class="col-lg-12 col-md-12">
                        <div class="card card-user">
                            <div class="image">
                                
                            </div>
                            <div class="content">
                                <div class="author">
                                  <img class="avatar border-white" src="<?php echo base_url(); ?>libs/images/team.jpg"  alt="..."/>
                                  <h4 class="title"><?php echo $equipo['name'] ?><br />
                                     
                                  </h4>
                                </div>
                                
                            </div>
                            <hr>
                            <div class="text-center">
                                <div class="row">
									<ul class="nav nav-pills nav-justified">
									    <li class="active"><a data-toggle="pill" href="#fases_asig">CUESTIONARIOS ASIGNADOS</a></li>
									    <li><a data-toggle="pill" href="#fases_term">CUESTIONARIOS TERMINADOS</a></li>
									    
									</ul>
                                </div>
                                
                            </div>
                        </div>
                    </div>
				</div><!--aaa-->
				
				<div class="row">
					<div class="panel panel-success" >
					    <div class="panel-body">
					     	<div class="tab-content">
							    <div id="fases_asig" class="tab-pane fade in active">
							      	<?php if (count($fases) == 0): ?>
							    		<h3>SIN CUESTIONARIOS ASIGNADOS</h3>
							    	<?php else: ?>
							    		<h3>CUESTIONARIOS ASIGNADOS</h3>		
							    	<?php endif ?>
							        <!---->
							        <div class="container">
									  <div class="panel-group" id="accordion">
									    
									    <?php foreach ($fases as $fase): ?>
									    <div class="panel panel-default">
									      <div class="panel-heading">
									        <h4 class="panel-title">
									          <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $fase['id'];?>"><?php echo $fase['name']; ?>   <b> Proceso : <?php echo $fase['proceso']; ?> </b></a>
									        </h4>
									      </div>
									      <div id="collapse<?php echo $fase['id'];?>" class="panel-collapse collapse">
									      	<p>Avance del fase por equipo :</p>	
											<progress max="100" value="<?php echo $fase['avance_por_equipo'];?>" ></progress>
											<label><?php echo $fase['avance_por_equipo']; ?>  %</label>
											<p>Integrantes  :</p>

									        <div class="panel-body">
									        	<div class="table-responsive">
												  <table class="table">
												    <thead>
												      <tr>
												        <th>Nombre</th>
												        <th>Preguntas contestadas</th>
												        <th>Avance</th>
												      </tr>
												    </thead>
												    <tbody>
												      	<?php foreach ($fase['integrantes'] as $integrante): ?>
											        		<tr>
													            <td><?php echo $integrante['name'] ?></td>
													            <td><?php echo $integrante['preguntas_contestadas'] ?> / <?php echo $fase['total_preguntas'] ?> </td>
													            <td><progress max="100" value="<?php echo $integrante['porcentaje'] ?>" ></progress>  <label><?php echo $integrante['porcentaje'] ?> %</label></td>
													          </tr>
											        	<?php endforeach ?>
												    </tbody>
												  </table>
												</div>
									        </div>
									      </div>
									    </div>
									    <?php endforeach ?>

									  </div>
									</div>
							      <!--fin del collapse-->
							    </div>

							    <div id="fases_term" class="tab-pane fade">
							    	<?php if (count($fases_terminadas) == 0): ?>
							    		<h3>SIN CUESTIONARIOS</h3>
							    	<?php else: ?>
							    		<h3>CUESTIONARIOS TERMINADOS</h3>		
							    	<?php endif ?>
							      
									<div class="container">
									  <div class="panel-group" id="accordion">
									    
									    <?php foreach ($fases_terminadas as $fase): ?>
									    <div class="panel panel-default">
									      <div class="panel-heading">
									        <h4 class="panel-title">
									          <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $fase['id'];?>x"><?php echo $fase['name']; ?>   proceso :  <?php echo $fase['nombre_proceso']; ?></a>
									        </h4>
									      </div>
									      
									      <div id="collapse<?php echo $fase['id'];?>x" class="panel-collapse collapse">
									      		<input type="hidden" name="x" value="<?php echo $fase['show_kiviat'] ?>" id="show_kiviat_<?php echo $fase['id'] ?>">

									      		<?php if (strcmp($fase['show_results'],"TRUE") == 0): ?>

									      			<div class="row">
									      				<div class="col-sm-6 col-md-6">
												            <div class="alert alert-success">
												                
												               <span class="glyphicon glyphicon-ok"></span> <strong>Fase Evaluada</strong>
												                <hr class="message-inner-separator">
												                <p><strong><a href="#" class="btnVerResultados" id="<?php echo $fase['id'];?>-<?php echo $equipo['id'] ?>-<?php echo $fase['process_id'] ?>"> <i class="ti-stats-up"></i>   Ver Resultados</a></strong></p>
												            </div>
												        </div>
									      			</div>

									      			
									      		<?php else: ?>
									      			<div class="row">
									      				<div class="col-sm-6 col-md-6">

												            <div class="alert alert-warning">
												               
												                <span class="glyphicon glyphicon-record"></span> <strong>Fase Terminada y Evaluada </strong>
												                <hr class="message-inner-separator">
												                <p>La fase contiene preguntas que estan indeterminadas <a href="<?php echo base_url()?>index.php/Evaluacion/edit_question/<?php echo $fase['id']."/".$equipo['id']; ?>"><strong>click aqui para corregirlo</strong></a></p>
												            </div>
												        </div>
									      			</div>
									      			<!--<h3>cuestionario terminado y evaluado pero :</h3>
									      			<div class="alert alert-success" role="alert">Hay algunas preguntas que estan indeterminadas  <a href="#"><strong>click aqui para corregirla</strong></a></div>-->
									      		<?php endif ?>
									      		
									      		

											
						
									        
									      </div>
									    </div>
									    <?php endforeach ?>

									  </div>
									</div>
							      
							    </div>
						    </div>
					    </div>
					</div>
				</div>

				
	            
	        </div>

	        <div class="container" style="display: none;" id="contenedor_secundario"><!--Inicio del segundo container-->
	        	<a href="#"  class='btn btn-danger btnBack'><i class="ti-arrow-left"></i>  Regresar</a><hr>
	        	<div class="row">
	        		<div class="col-md-9">
	        			<h3 id="titulo_tabla"></h3>		
	        		</div>
	        		
	        		<div class="col-md-3">
	        			
	        			<a href="#" class="btn btn-default btn-block btn-lg" id="btn_ver_graficas">
	        				<i class="ti-bar-chart"></i> Graficas
					      	
					    </a>	
	        		</div>
	        		
	        	</div>
	        	<div class="row">
	        		<div class="col-md-4 col-md-offset-4">
	        			<div class="btn-group btn-group-justified" role="group" aria-label="...">
						  <div class="btn-group" role="group"> 
						    <button type="button" class="btn btn-default" style="background: #b2dfdb;">Fortaleza</button>
						  </div>
						  <div class="btn-group" role="group">
						    <button type="button" class="btn btn-default" style="background: #ffcdd2;">Debilidad</button>
						  </div>
						</div>
	        		</div>
	        	</div>

				<p>Análisis de respuestas</p>
				<table class="table table-bordered table-centered table-responsive">
				    <thead> 
				      <tr>
				        <th>Pregunta</th>
				        <th>S</th>
				        <th>U</th>
				        <th>A</th>
				        <th>R</th>
				        <th>N</th>
				        <th>Cobertura por pregunta</th>
				        <th>Media</th>
				        <th class="text-center">Desviación tipica</th>
				      </tr>
				    </thead>
				    <tbody id="body_table">
				      <tr>
				        <td><b>Total</b></td>
				        <td></td>
				        <td></td>
				        <td></td>
				        <td></td>
				        <td></td>
				        <td id="total_cobertura"></td>
				        <td></td>
				        <td></td>
				      </tr>
				      
				    </tbody>
				</table>
	        </div><!--fin del segundo container-->

	        <div class="container" style="display: none;" id="tercer_contenedor"><!--inicio de el tercer container-->
	        	<a href="#"  class='btn btn-danger btnBack'><i class="ti-arrow-left"></i>  Regresar</a><hr>
	        	<div class="row">
	        		<div class="col-md-8">
	        					
	        		</div>
	      
        			<div class="col-md-2">
	        			<a href="#" class="btn btn-md" id="btn_ver_resultados">
	        				<i class="ti-stats-up"></i> Tabla de resultados</a>	
	        		</div>

	        		<div class="col-md-2" style="display:none" id="btnVerGraficaKiviat">
	        			<a href="#" class="btn btn-md" id="btn_ver_grafica_kiviat" type="<?php echo $equipo['id'] ?>">
	        				<i class="ti-stats-up"></i> Grafica Kiviat
					    </a>	
	        		</div>
	        		
	        		
	        	</div>
	        	<br>
	        	<br>
	        	<div class="row" style="overflow: scroll;" style="max-width: 900px">
	        		<div class="col-md-12" id="grafica">
	        			
	        		</div>
	        		
				</div>
	        	<button id="export2pdf">Exportar a PDF</button>
	        </div><!-- fin del tercer container-->

	        <div class="container" style="display: none;" id="cuarto_contenedor"><!--inicio del cuarto container-->
	        	<div class="row">
	        		<div class="col-md-8">
	        					
	        		</div>
	        		<div class="col-md-4">
	        			
	        			<a href="#" class="btn btn-default btn-block " id="btn_ver_resultados">
	        				<i class="ti-stats-up"></i> Tabla de resultados
					      	
					    </a>	
	        		</div>

	        		
	        	</div>
				<br>
				<br>
	        	<div class="row">
	        		<div class="col-md-9" id="grafica_kiviat">
	        			
	        		</div>
	        		
				</div>

	        </div><!--fin del cuarto container-->

	       

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

<script src="<?php echo base_url("libs/js/datatables.min.js"); ?>"></script>
<script src="<?php echo base_url("libs/js/toastr.min.js"); ?>"></script>
<script src="<?php echo base_url("libs/js/highcharts.js"); ?>"></script>
<script src="<?php echo base_url("libs/js/data.js"); ?>"></script>
<script src="<?php echo base_url("libs/js/drilldown.js"); ?>"></script>
<script src="<?php echo base_url("libs/js/exporting.js"); ?>"></script>
<script src="<?php echo base_url("libs/js/highcharts-more.js"); ?>"></script>
<!--<script src="<?php echo base_url("libs/js/offline-exporting.js"); ?>"></script>-->
<script src="<?php echo base_url("libs/js/graficas.js"); ?>"></script>
<script src="<?php echo base_url("libs/js/script.js"); ?>" type="text/javascript"></script>


<script type="text/javascript">
	$(document).ready(function(){
		$('#myTabs a').click(function (e) {
		  e.preventDefault()
		  $(this).tab('show')
		})
	});
</script>


</html>
