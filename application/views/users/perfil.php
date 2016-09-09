<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>MI PERFIL</title>
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
	                    MI PERFIL
	                </a>
	            </div>

	            <ul class="nav">
	            	<li class="active">
	                    <a href="#">
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
	                    <a class="navbar-brand" href="#"><?php echo $this->session->userdata('logged_in')['name'] ?></a>
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
	                                <li><a href="<?php echo base_url() ?>index.php/Estudiantes/perfil">Perfil</a></li>
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
	        	<div class="row">
	        		<div class="col-md-12 col-xl-12">
	        			<div class="card">
                            <div class="header">
                                <h4 class="title">Editar mi perfil</h4>
                            </div>
                            <div class="content">
                                <?php echo form_open('Home/update_perfil'); ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>username</label>
                                                <input type="hidden" name="id" value="<?php echo $this->session->userdata('logged_in')['id'] ?>">
                                                <input type="text" class="form-control border-input" name="username"  placeholder="username" required="" value="<?php echo $this->session->userdata('logged_in')['username'] ?>"/>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>password</label>
                                                <input type="password" name="password" class="form-control border-input"  placeholder="password" value="">
                                                <span>Para cambiar la contraseña, introduzca la nueva contraseña en este campo. Si desea mantener la actual, deje vacío el campo.</span>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>email</label>
                                                <input type="email" name="email" class="form-control border-input"  placeholder="email" value="<?php echo $this->session->userdata('logged_in')['email'] ?>">
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <br>
                                    <br>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-info btn-fill btn-wd">Actualizar Perfil</button>
                                        <a href="<?php echo base_url() ?>index.php/Home" class="btn btn-danger btn-fill btn-wd">Cancelar</a>
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
	        		</div>
	        	</div>
	        </div>


	        

	    </div>
	</div>

	<!-- Modales-->
	<div class="modal fade" tabindex="-1" role="dialog" id="modal_elim_usr">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	        <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Eliminar Estudiante</h4>
	        </div>
	      <div class="modal-body">
	        <p>Esta seguro de eliminar el estudiante ?</p>
	        <input type="hidden" name="" id="id_est_elim" value="">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
	        <button type="button" class="btn btn-danger" data-dismiss="modal" id="btn_acept_elim_est">Eliminar</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
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

<script src="<?php echo base_url("libs/js/datatables.min.js"); ?>"></script>
<script src="<?php echo base_url("libs/js/toastr.min.js"); ?>"></script>
<script src="<?php echo base_url("libs/js/script.js"); ?>" type="text/javascript"></script>

<script type="text/javascript">
	$(document).ready(function(){
			$('#tabla_estudiantes').DataTable();
	});
</script>


</html>
