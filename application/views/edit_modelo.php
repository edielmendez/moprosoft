<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
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

  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>

	<!--link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/style.css">
	<script type='text/javascript' src="<?php echo base_url(); ?>public/js/jquery.min.js"></script-->
	<!-- -->

	<script type="text/javascript">
		function Eliminar() {
			var id = $("#id_model").val();
			$.ajax({
		    url : '<?php echo base_url(); ?>index.php/Modelos/Eliminar/'+id,
		    type : 'POST',
		    dataType : 'json',
		    success : function(json) {
					//alert("Bien")
					window.location.href= '<?php echo base_url(); ?>index.php/Home/index';
		    },
		    error : function(xhr, status) {
		      //alert('Disculpe, existió un problema');
					window.location.href= '<?php echo base_url(); ?>index.php/Home/index';
		    }
			});
		}
	</script>
</head>
<body>
	<div class="wrapper">
		<div id="myModal" class="modal fade">
			<div class="modal-dialog">
					<div class="modal-content">
							<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title">Cuidado !!</h4>
							</div>
							<div class="modal-body">

								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<p>Al eliminar el modelo se <b>eliminarán</b> todos los <b>Procesos ,Fases/Objetivos y Cuestionarios</b> relacionados con este modelo.</p>
										</div>
									</div>
								</div>
								<!--form action="<?php echo base_url() ?>index.php/Modelos/save" method="post"-->
								<div class="modal-footer">
										<button type="button" class="btn btn-default btn-wd" data-dismiss="modal">Cancelar</button>
										<button onclick="Eliminar()" type="button" class="btn btn-danger btn-fill btn-wd" data-dismiss="modal">Eliminar</button>
										<!--input type="submit"  class="btn btn-danger btn-fill btn-wd" name="submit" value="Eliminar" /-->
									</div>
							</div>
					</div>
			</div>
	</div>
	    <div class="sidebar" data-background-color="white" data-active-color="danger">
	    <!--
			Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
			Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
		-->
	    	<div class="sidebar-wrapper2">
	            <div class="logo">
	                <a href="#" class="simple-text">
	                    Moprosoft
	                </a>
	            </div>

	            <ul class="nav">
	                <li class="active">
	                    <a href="dashboard.html">
	                        <i class="ti-panel"></i>
	                        <p>Modelos</p>
	                    </a>
	                </li>
	                <li >
	                    <a href="user.html">
	                        <i class="ti-user"></i>
	                        <p>Procesos</p>
	                    </a>
	                </li>
	                <li>
	                    <a href="table.html">
	                        <i class="ti-view-list-alt"></i>
	                        <p>Fases/Objetivos</p>
	                    </a>
	                </li>
	            </ul>
	    	</div>
	    </div>

	    <div class="main-panel2">
	        <nav class="navbar navbar-default">
	            <div class="container-fluid">
	                <div class="navbar-header">
	                    <button type="button" class="navbar-toggle">
	                        <span class="sr-only">Toggle navigation</span>
	                        <span class="icon-bar bar1"></span>
	                        <span class="icon-bar bar2"></span>
	                        <span class="icon-bar bar3"></span>
	                    </button>
	                    <a class="navbar-brand" href="#">Modelos</a>
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

	        <div class="content">
	            <div class="container-fluid">
								<!--a  data-toggle="modal" data-target="#myModal" data-title="Contact Us" href="<?php echo base_url() ?>index.php/Modelos/nuevo" class='btn btn-info btn-fill btn-wd'>Nuevo Modelo</a><br><br-->
	              <!--button type="submit" class="btn btn-info btn-fill btn-wd">Nuevo Proceso</button><br><br-->
	                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <!--h4 class="title">Editar Modelo</h4-->
																<h4 >Editar Modelo</h4>
                            </div>
                            <div class="content">
                              <form action="" method="POST" >
																<?php foreach ($mod as $modelo){ ?>
																<div class="row">
																		<div class="col-md-12">
																				<div class="form-group">
																						<label>Nombre</label>
																						<input required="true" name="nombre" id="nombre" type="text" class="form-control border-input" placeholder="Nombre" value="<?php echo $modelo->name ?>">
																						<input type="hidden" name="id_model" id="id_model" value="<?php echo $modelo->id ?>">
																				</div>
																		</div>
																</div>

																<div class="row">
																		<div class="col-md-6">
																				<div class="form-group">
																						<label>Versión</label>
																						<input required="true" name="version" id="version" type="text" class="form-control border-input" placeholder="Version" value="<?php echo $modelo->version ?>">
																				</div>
																		</div>
																		<div class="col-md-6">
																			<label>Nivel</label>
																			<select class="form-control" name="nivel" id="nivel" >
																				<option value="0">0</option>
																				<option value="1">1</option>
																				<option value="2">2</option>
																				<option value="3">3</option>
																				<option value="4">4</option>
																				<option value="5">5</option>
																			</select>
																		</div>
																</div>

																<div class="row">
																		<div class="col-md-12">
																				<div class="form-group">
																						<label>Se trabajará con <b>Fases</b> o <b>Objetivos</b></label>
																						<input required="true" name="trabajara" id="trabajara" type="text" class="form-control border-input" placeholder="Fases/Objetivos" value="<?php echo $modelo->phase_objetive ?>" >
																						<!--select class="form-control" name="trabajara" id="trabajara">
																							<option value="Fases">Fases</option>
																							<option value="Objetivos">Objetivos</option>
																						</select-->
																				</div>
																		</div>
																</div>
																<?php } ?>
																<br><br><br>
                                <div>
                                	<a class="btn btn-dafault btn-wd" href="<?php echo base_url() ?>index.php/Home/index">Cancelar</a>
																	<input type="submit"  class="btn btn-info btn-fill btn-wd" name="submit" value="Guardar" />
																	<button  type="button" class="btn btn-danger btn-fill btn-wd" data-toggle="modal" data-target="#myModal" data-title="Cuidado !!!" >Eliminar</button><br><br>
																	<!--a class="btn btn-danger btn-fill btn-wd" href="<?php echo base_url(); ?>index.php/Modelos/Eliminar/<?php echo $modelo->id ?>">Eliminar</a-->

																	<!--button type="button" class="btn btn-danger btn-fill btn-wd">Eliminar</button><br><br-->

																		<!--a href="<?=base_url("usuarios_controller/mod/$fila->id_usuario")?>">Modificar</a>
													 					<a href="<?=base_url("usuarios_controller/eliminar/$fila->id_usuario")?>">Eliminar</a>
																		<?php echo base_url() ?>index.php/Modelos/save
																	-->
                                  </div>
                              </form>
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

				$('#nivel option[value="<?php echo $modelo->level ?>"]').attr("selected", "selected");
				//$('#trabajara option[value="<?php echo $modelo->phase_objetive ?>"]').attr("selected", "selected");

	});
</script>


</html>
